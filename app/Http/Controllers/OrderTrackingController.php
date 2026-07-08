<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;


class OrderTrackingController extends Controller
{

    public function index()
    {
        return view('front-end.track-order');
    }

    public function search(Request $request)
    {
        $request->validate([
            'order_id' => 'required',
            'mobile' => 'required',
        ]);

        // $order = Order::where('id', $request->order_id)->first();


        $order = Order::where('id', $request->order_id)
              ->where('mobile', $request->mobile)
              ->first();

        return view('front-end.track-order', compact('order'));
    }

}
