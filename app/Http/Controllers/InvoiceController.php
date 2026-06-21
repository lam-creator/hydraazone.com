<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\City;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class InvoiceController extends Controller
{

    public function generateInvoice($id)
    {
        $order = Order::with([  // Model will change
            'city:id,name',
            'items:id,order_id,product_id,quantity,price,total_price',
            'items.product:id,name'
        ])->find($id);

        return view('back-end.invoice', compact('order'));
    }



    public function generateInvoiceForDeliveryMan($id)
    {
        $order = Order::with([  // Model will change
            'city:id,name',
            'items:id,order_id,product_id,quantity,price,total_price',
            'items.product:id,name'
        ])->find($id);

        return view('back-end.delivery-man-invoice', compact('order'));
    }







    // End
}
