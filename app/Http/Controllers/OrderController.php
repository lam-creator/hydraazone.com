<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{

    public function index()
    {
        return view('front-end.order-confirm');
    }

    public function createOrder(Request $request)
    {
        // Validate request
        $request->validate([
            'name'           => 'required|string|min:3|max:80',
            'phone'          => 'required|string|min:11|max:14',
            'zone'           => 'required',
            'address'        => 'required|string|min:3|max:255',
            'order_note'     => 'nullable|string|max:200',
            'shipping_option' => 'required|in:inside_dhaka,outside_dhaka',
        ]);

        // Get shipping
        $shippingOption = $request->input('shipping_option', session('shipping_option', 'inside_dhaka'));
        $shipping = $shippingOption === 'outside_dhaka' ? 120 : 80;
        session([
            'shipping' => $shipping,
            'shipping_option' => $shippingOption,
        ]);

        // Get cart
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->back()->with([
                'errormesssage' => 'Cart is empty',
            ]);
        }

        // Validate cart structure
        foreach ($cart as $item) {
            if (!isset($item['id']) || !isset($item['quantity'])) {
                return redirect()->back()->with([
                    'errormesssage' => 'Invalid cart data',
                ]);
            }
        }

        /*
    |--------------------------------------------------------------------------
    | Calculate Subtotal From Database Products
    |--------------------------------------------------------------------------
    */

        $subtotal = 0;

        foreach ($cart as $item) {

            $product = Product::find($item['id']);

            // FIX: check product BEFORE using it
            if (!$product) {
                return redirect()->back()->with([
                    'errormesssage' => 'Product not found',
                ]);
            }

            // FIX: safe price selection
            $productPrice = ($product->discount_price && $product->discount_price > 0)
                ? $product->discount_price
                : $product->sale_price;

            $subtotal += ((float) $productPrice) * ((int) $item['quantity']);
        }

        // Coupon discount
        $discount = session('coupon.discount') ?? 0;
        $discount = is_numeric($discount) ? (float) $discount : 0;

        DB::beginTransaction();

        try {

            /*
        |--------------------------------------------------------------------------
        | User Check / Create
        |--------------------------------------------------------------------------
        */

            $user = auth()->user();

            // Guest checkout
            if (!$user) {

                // Find user only by id
                $user = User::where('email', 'guest@gmail.com')->first();


            }

            /*
        |--------------------------------------------------------------------------
        | Create Order
        |--------------------------------------------------------------------------
        */

            $totalAmount = max(0, ($subtotal + $shipping) - $discount);

            $order = new Order();

            $order->date = Carbon::now();
            $order->name = $request->name;
            $order->mobile = $request->phone;
            $order->zone = $request->zone;
            $order->address = $request->address;
            $order->order_note = $request->order_note;
            $order->user_id = $user->id;
            $order->total_amount = $totalAmount;
            $order->discount_amount = $discount;
            $order->shipping = $shipping;
            $order->status = 'processing';

            $order->save();

            /*
        |--------------------------------------------------------------------------
        | Create Order Items
        |--------------------------------------------------------------------------
        */

            foreach ($cart as $item) {

                $product = Product::find($item['id']);

                if (!$product) {
                    throw new \Exception('Product not found');
                }

                // FIX: recalculate price per item safely
                $productPrice = ($product->discount_price && $product->discount_price > 0)
                    ? $product->discount_price
                    : $product->sale_price;

                $orderItem = new OrderItem();

                $orderItem->order_id = $order->id;
                $orderItem->product_id = $product->id;
                $orderItem->quantity = (int) $item['quantity'];
                $orderItem->price = (float) $productPrice;
                $orderItem->variant_id = $item['variant_id'] ?? null;
                $orderItem->variant_label = $item['variant_label'] ?? null;

                $orderItem->total_price =
                    ((float) $productPrice) * ((int) $item['quantity']);

                $orderItem->save();
            }

            DB::commit();

            session()->forget('cart');
            session()->forget('coupon');

            return Redirect()
                ->route('order-confirm')
                ->with([
                    'message'  => 'Order placed successfully',
                    'order_id' => $order->id,
                ]);
        } catch (\Exception $e) {

            DB::rollBack();

            \Log::error('Order creation failed: ' . $e->getMessage());

            return Redirect()
                ->route('order-confirm')
                ->with([
                    'errormesssage' => 'Order creation failed. Please try again.',
                ]);
        }
    }


    // Order List
    public function OrderList()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Retrieve all orders for the authenticated user
        $orders = $user->orders; // This uses the relationship defined in the User model

        // Optionally, you can load order items for each order, if needed
        //$orders->load('items'); // Assuming you have a relationship defined in the Order model

        // Retrieve orders and eager load order items and product details
        $orders = $user->orders()->with('items.product')->orderBy('id', 'desc')->get(); // Eager load the product for each order item

        // return $orders;
        return view('front-end.my-orders', compact('orders'));
    }

    // Order Details
    public function OrderDetails(Order $order)
    {
        // Ensure that the order belongs to the authenticated user
        if ($order->user_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Eager load the order items and product relationships
        $order->load('items.product');

        // return $order;exit();

        // Return the view with the order details
        return view('front-end.order-detail', compact('order'));
    }


    // cancel order
    public function OrderCancel(Order $order)
    {
        // Ensure that the order belongs to the authenticated user
        if ($order->user_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        // Check if the order is already cancelled
        if ($order->status == 'cancelled') {
            return redirect()->back()->with('error', 'Order is already cancelled.');
        }
        // Update the order status to cancelled
        $order->status = 'cancelled';
        $order->save();
        // Send a notification to the user
        // $order->notify(new OrderCancelled($order));
        // Return a success message
        return redirect()->back()->with('success', 'Order cancelled successfully.');
    }



    // End
}