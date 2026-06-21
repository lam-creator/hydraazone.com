<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\City;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Carbon;

class AdminOrderController extends Controller
{


    // showing processing orders page
    public function processingOrderindex()
    {
        return view('back-end.pages.order.order');
    }

    // showing approved orders page
    public function approvedOrderIndex()
    {
        return view('back-end.pages.order.approved-order');
    }

    // showing delivered orders page
    public function deliveredOrderIndex()
    {
        return view('back-end.pages.order.delivered-order');
    }

    // showing cancelled orders page
    public function cancelledOrderIndex()
    {
        return view('back-end.pages.order.cancelled-order');
    }


    // All processing order
    public function processingOrderData()
    {

        // all query in one
        $orders = Order::with(['city:id,name'])->where('status', 'processing')->orderBy('id', 'desc')->get();

        // $orders = Order::with([
        //     'city:id,name',
        //     'items:id,order_id,product_id,quantity,price,total_price',
        //     'items.product:id,name'
        // ])->orderBy('id', 'desc')->get();

        // return $orders;

        $this->i = 1;

        return DataTables::of($orders)  // Variable will change

            ->addColumn('zone', function ($data) {
                return $data->city ? $data->city->name : '';
            })
            ->addColumn('id', function ($data) {
                // return $this->i++;
                return $data->id;
            })
            // format date
            ->editColumn('date', function ($data) {
                return \Carbon\Carbon::parse($data->date)->format('Y-m-d');
            })

            ->addColumn('action', function ($data) {
                $htmlData = '';
                // $htmlData .= '<a href="javascript:void(0)" data-id="' . $data->id . '" class="btn btn-warning btn-sm tableDiscount"><i class="fa fa-percent"></i></a>'; // New Discount Button
                $htmlData .= '<a href="javascript:void(0)" data-id="' . $data->id . '" class="btn btn-info btn-sm tableDetails"><i class="fa fa-eye"></i></a>&nbsp;';
                $htmlData .= '<a href="javascript:void(0)" data-id="' . $data->id . '" class="btn btn-primary btn-sm tableApproved"><i class="fa fa-check"></i></a>';
                // $htmlData .= '<a href="javascript:void(0)" data-id="' . $data->id . '" class="btn btn-success btn-sm tableDelivered"><i class="fa fa-shipping-fast"></i></a>';
                $htmlData .= '<a href="javascript:void(0)" data-id="' . $data->id . '" class="btn btn-danger btn-sm tableCancelled"><i class="fa fa-window-close"></i></a>';
                return $htmlData;
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    // All approved order
    public function approvedOrderData()
    {

        // all query in one
        $orders = Order::with(['city:id,name'])->where('status', 'approved')->orderBy('id', 'desc')->get();

        // $orders = Order::with([
        //     'city:id,name',
        //     'items:id,order_id,product_id,quantity,price,total_price',
        //     'items.product:id,name'
        // ])->orderBy('id', 'desc')->get();

        // return $orders;

        $this->i = 1;

        return DataTables::of($orders)
            ->addColumn('zone', function ($data) {
                return $data->city ? $data->city->name : '';
            })
            ->addColumn('id', function ($data) {
                return $data->id;
            })
            // format date
            ->editColumn('date', function ($data) {
                return \Carbon\Carbon::parse($data->date)->format('Y-m-d');
            })

            ->addColumn('action', function ($data) {
                $htmlData = '';
                $htmlData .= '<a href="javascript:void(0)" data-id="' . $data->id . '" class="btn btn-info btn-sm tableDetails"><i class="fa fa-eye"></i></a>&nbsp;';
                $htmlData .= '<a href="javascript:void(0)" data-id="' . $data->id . '" class="btn btn-info btn-sm tableInvoice"><i class="fa fa-file-invoice"></i></a>&nbsp;';
                $htmlData .= '<a href="javascript:void(0)" data-id="' . $data->id . '" class="btn btn-success btn-sm tableDelivered"><i class="fa fa-shipping-fast"></i></a>';
                $htmlData .= '<a href="javascript:void(0)" data-id="' . $data->id . '" class="btn btn-danger btn-sm tableCancelled"><i class="fa fa-window-close"></i></a>';
                return $htmlData;
            })
            ->rawColumns(['action'])
            ->toJson();



    }

    // All delivered order
    public function deliveredOrderData()
    {

        // all query in one
        $orders = Order::with(['city:id,name'])->where('status', 'delivered')->orderBy('id', 'desc')->get();

        // $orders = Order::with([
        //     'city:id,name',
        //     'items:id,order_id,product_id,quantity,price,total_price',
        //     'items.product:id,name'
        // ])->orderBy('id', 'desc')->get();

        // return $orders;

        $this->i = 1;

        return DataTables::of($orders)  // Variable will change

            ->addColumn('zone', function ($data) {
                return $data->city ? $data->city->name : '';
            })
            ->addColumn('id', function ($data) {
                // return $this->i++;
                return $data->id;
            })
            // format date
            ->editColumn('date', function ($data) {
                return \Carbon\Carbon::parse($data->date)->format('Y-m-d');
            })

            ->addColumn('action', function ($data) {
                $htmlData = '';
                $htmlData .= '<a href="javascript:void(0)" data-id="' . $data->id . '" class="btn btn-info btn-sm tableDetails"><i class="fa fa-eye"></i></a>&nbsp;';
                // $htmlData .= '<a href="javascript:void(0)" data-id="' . $data->id . '" class="btn btn-primary btn-sm tableApproved"><i class="fa fa-check"></i></a>';
                // $htmlData .= '<a href="javascript:void(0)" data-id="' . $data->id . '" class="btn btn-success btn-sm tableDelivered"><i class="fa fa-shipping-fast"></i></a>';
                // $htmlData .= '<a href="javascript:void(0)" data-id="' . $data->id . '" class="btn btn-danger btn-sm tableCancelled"><i class="fa fa-window-close"></i></a>';
                return $htmlData;
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    // All cancelled order
    public function cancelledOrderData()
    {

        // all query in one
        $orders = Order::with(['city:id,name'])->where('status', 'cancelled')->orderBy('id', 'desc')->get();

        // $orders = Order::with([
        //     'city:id,name',
        //     'items:id,order_id,product_id,quantity,price,total_price',
        //     'items.product:id,name'
        // ])->orderBy('id', 'desc')->get();

        // return $orders;

        $this->i = 1;

        return DataTables::of($orders)  // Variable will change

            ->addColumn('zone', function ($data) {
                return $data->city ? $data->city->name : '';
            })
            ->addColumn('id', function ($data) {
                // return $this->i++;
                return $data->id;
            })
            // format date
            ->editColumn('date', function ($data) {
                return \Carbon\Carbon::parse($data->date)->format('Y-m-d');
            })

            ->addColumn('action', function ($data) {
                $htmlData = '';
                $htmlData .= '<a href="javascript:void(0)" data-id="' . $data->id . '" class="btn btn-info btn-sm tableDetails"><i class="fa fa-eye"></i></a>&nbsp;';
                $htmlData .='<a href="javascript:void(0)" data-id="'.$data->id.'" class="btn btn-danger btn-sm tableDelete"><i class="fa fa-trash"></i></a>';
                // $htmlData .= '<a href="javascript:void(0)" data-id="' . $data->id . '" class="btn btn-primary btn-sm tableApproved"><i class="fa fa-check"></i></a>';
                // $htmlData .= '<a href="javascript:void(0)" data-id="' . $data->id . '" class="btn btn-success btn-sm tableDelivered"><i class="fa fa-shipping-fast"></i></a>';
                // $htmlData .= '<a href="javascript:void(0)" data-id="' . $data->id . '" class="btn btn-danger btn-sm tableCancelled"><i class="fa fa-window-close"></i></a>';
                return $htmlData;
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    // order details
    public function OrderDetails(Request $request)
    {
        $query = Order::with([  // Model will change
            'city:id,name',
            'items:id,order_id,product_id,quantity,price,total_price',
            'items.product:id,name'
        ])->find($request->id);


        if (!$query) {
            return response()->json([
                'status' => "error",
                'message' => "Not Found, Please Try Again..."
            ], 422);
        }

        return response()->json([
            'status' => "success",
            'data' => $query,

        ]);
    }

    // update order approved status
    public function OrderApproved(Request $request)
    {
        // Get the order ID from the request
        $orderId = $request->input('orderApprovedId');  // Assuming 'delete' is the parameter from the JS

        // Find the order by ID
        $query = Order::find($orderId);

        if (!$query) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found, please try again...'
            ], 422);
        }

        // Update the order status to 'approved'
        $query->status = 'approved';
        $query->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Order approved successfully.'
        ]);
    }


    // update order delivered status
    public function OrderDelivered(Request $request)
    {
        // Get the order ID from the request
        $orderId = $request->input('orderDeliveredId');  // Assuming 'delete' is the parameter from the JS

        // Find the order by ID
        $query = Order::find($orderId);

        if (!$query) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found, please try again...'
            ], 422);
        }

        // Update the order status to 'delivered'
        $query->status = 'delivered';
        $query->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Order delivered successfully.'
        ]);
    }

    // update order cancelled status
    public function OrderCancelled(Request $request)
    {
        // Get the order ID from the request
        $orderId = $request->input('orderCancelId');  // Assuming 'orderCancelId' is the parameter from the JS

        // Find the order by ID
        $query = Order::find($orderId);

        if (!$query) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found, please try again...'
            ], 422);
        }

        // Update the order status to 'cancelled'
        $query->status = 'cancelled';
        $query->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Order cancelled successfully.'
        ]);
    }


    // Delete Order
    public function OrderDelete(Request $request)
    {

        if ($request->has('delete')) {
            $order = Order::find($request->delete);

            if ($order) {
                // First delete related order items
                OrderItem::where('order_id', $order->id)->delete();

                // Then delete the order
                $order->delete();

                $message = 'Order Deleted Successfully!';
                return response()->json([
                    'status' => "success",
                    'message' => $message,
                ]);
            } else {
                $message = 'Order Not Found!';
                return response()->json([
                    'status' => "error",
                    'message' => $message,
                ]);
            }
        } else {
            $message = 'Order Delete Failed!';
            return response()->json([
                'status' => "error",
                'message' => $message,
            ]);
        }
    }

    // Apply Discount
    public function applyDiscount(Request $request)
    {
        $request->validate([
            'orderId' => 'required|integer|exists:orders,id',
            'discountAmount' => 'required|numeric|min:0',
        ]);

        $orderId = $request->input('orderId');
        $discountAmount = $request->input('discountAmount');

        $order = Order::find($orderId);

        if ($discountAmount > $order->total_amount) {
            return response()->json(['status' => 'error', 'message' => 'Discount amount cannot exceed the total order amount.'], 422);
        }

        // $order->total_amount = max(0, $order->total_amount - $discountAmount);
        $order->discount_amount = $discountAmount;
        $order->save();

        return response()->json(['status' => 'success', 'message' => 'Discount applied successfully.']);
    }


    // end
}
