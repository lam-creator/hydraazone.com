<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;


class CartController extends Controller
{


private function calculateCartTotals($cart)
    {
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        // $shipping = $subtotal >= 1000 ? 0 : (count($cart) > 0 ? 50 : 0); // Free shipping for orders above 1000, otherwise 50 if cart is not empty
        $shipping = 0; // Free shipping for all orders
        $discount = session('coupon.discount', 0);
        $total = $subtotal + $shipping - $discount;

        session([
            'total' => $total,
            'shipping' => $shipping,
            'subtotal' => $subtotal,
            'discount' => $discount
        ]);

        return [
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'discount' => $discount,
            'total' => $total
        ];
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $productId = $request->product_id;
        $quantity = $request->quantity ?? 1;

        $product = Product::find($productId);

        $productPrice = $product->discount_price > 0
            ? $product->discount_price
            : $product->sale_price;

        $cart = Session::get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {

            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $productPrice,
                'quantity' => $quantity,
            ];
        }

        Session::put('cart', $cart);

        $totals = $this->calculateCartTotals($cart);

        return response()->json([
            'success' => true,
            'cart' => $cart,
            'cartCount' => array_sum(array_column($cart, 'quantity')),
            'subtotal' => $totals['subtotal'],
            'shipping' => $totals['shipping'],
            'total' => $totals['total'],
        ]);
    }


    public function updateCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required|integer',
        ]);

        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        $cart = Session::get('cart', []);
        $message = null;

        if (isset($cart[$productId])) {

            if ($quantity <= 0) {

                unset($cart[$productId]);
                $message = 'Product removed from cart.';
            } else {

                $cart[$productId]['quantity'] = $quantity;
                $message = 'Cart updated successfully.';
            }

            Session::put('cart', $cart);
        }

        $totals = $this->calculateCartTotals($cart);

        return response()->json([
            'success' => true,
            'cart' => $cart,
            'cartCount' => array_sum(array_column($cart, 'quantity')),
            'subtotal' => $totals['subtotal'],
            'shipping' => $totals['shipping'],
            'total' => $totals['total'],
            'message' => $message
        ]);
    }


    public function deleteCart(Request $request)
    {
        $productId = $request->input('product_id');

        $cart = Session::get('cart', []);
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            Session::put('cart', $cart);
        }

        $totals = $this->calculateCartTotals($cart);

        return response()->json([
            'success' => true,
            'cart' => $cart,
            'cartCount' => count($cart),
            'subtotal' => $totals['subtotal'],
            'shipping' => $totals['shipping'],
            'total' => $totals['total']
        ]);
    }

    public function viewCart(Request $request)
    {
        $cart = Session::get('cart', []);
        $totals = $this->calculateCartTotals($cart);

        if ($request->ajax()) {
            return response()->json([
                'cart' => $cart,
                'subtotal' => $totals['subtotal'],
                'shipping' => $totals['shipping'],
                'discount' => $totals['discount'],
                'total' => $totals['total'],
                'cartCount' => count($cart),
            ]);
        }

        return view('front-end.cart', [
            'cart' => $cart,
            'subtotal' => $totals['subtotal'],
            'shipping' => $totals['shipping'],
            'discount' => $totals['discount'],
            'total' => $totals['total']
        ]);
    }

    public function Checkout(Request $request)
    {
        // Check if user is authenticated
        // if (!Auth::check()) {
        //     session(['url.intended' => route('user.checkout')]);
        //     session(['came_from_checkout' => true]);
        //     return redirect()->route('user.login');
        // }

        $cart = Session::get('cart', []);
        if (empty($cart)) {
            return redirect()->route('home')->with('message', 'Your cart is empty.');
        }

        $totals = $this->calculateCartTotals($cart);
        $zones = City::where('status', 'active')->orderBy('name', 'asc')->get();
        $user = auth()->user();

        if ($request->ajax()) {
            return response()->json([
                'cart' => $cart,
                'subtotal' => $totals['subtotal'],
                'shipping' => $totals['shipping'],
                'discount' => $totals['discount'],
                'total' => $totals['total'],
                'cartCount' => count($cart),
            ]);
        }

        return view('front-end.checkout', [
            'cart' => $cart,
            'subtotal' => $totals['subtotal'],
            'shipping' => $totals['shipping'],
            'discount' => $totals['discount'],
            'total' => $totals['total'],
            'zones' => $zones,
            'user' => $user
        ]);
    }



}
