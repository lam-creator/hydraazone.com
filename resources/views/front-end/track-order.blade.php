@extends('front-end.layouts.master')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-6">

            <div class="card shadow">

                <div class="card-header">
                    <h3 class="text-center">Track Your Order</h3>
                </div>

                <div class="card-body">

                    <form action="{{ route('order.track.search') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label>Your Order ID</label>

                            <input
                                type="text"
                                name="order_id"
                                class="form-control"
                                placeholder="If Order ID was like ORD-123456, then enter only 123456"
                                value="{{ old('order_id') }}"
                                required>
                        </div>

                        <div class="mb-3">
                            <label>Order Mobile Number</label>

                            <input
                                type="tel"
                                name="mobile"
                                class="form-control"
                                placeholder="Enter Mobile Number"
                                value="{{ old('mobile') }}"
                                required>
                        </div>

                        <button class="btn  btn-theme w-100">
                            Track Order
                        </button>

                    </form>

                    @isset($order)

                        <hr>

                        <h4> <u>Order Information</u> </h4>

                        <table class="table table-bordered">

                            <tr>
                                <th>Order ID</th>
                                <td>ORD-{{ $order->id }}</td>
                            </tr>

                            <tr>
                                <th>Name</th>
                                <td>{{ $order->name }}</td>
                            </tr>

                            <tr>
                                <th>Status</th>
                                <td>

                                    @switch($order->status)

                                        @case('processing')
                                            <span class="badge bg-warning">Processing</span>
                                            @break

                                        @case('approved')
                                            <span class="badge bg-info">Approved</span>
                                            @break

                                        @case('delivered')
                                            <span class="badge bg-success">Delivered</span>
                                            @break

                                        @case('cancelled')
                                            <span class="badge bg-danger">Cancelled</span>
                                            @break

                                        @default
                                            <span class="badge bg-secondary">
                                                {{ $order->status }}
                                            </span>

                                    @endswitch

                                </td>
                            </tr>

                            <tr>
                                <th>Order Date</th>
                                <td>{{ $order->created_at->format('d M Y h:i A') }}</td>
                            </tr>

                            <tr>
                                <th>Total</th>
                                <td>{{ number_format($order->total_amount,2) }}</td>
                            </tr>

                        </table>

                    @endisset

                    @if(request()->isMethod('post') && !isset($order))
                        <div class="alert alert-danger mt-3">
                            Order not found.
                        </div>
                    @endif

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
