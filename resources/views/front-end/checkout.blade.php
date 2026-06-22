@extends('front-end.layouts.master')

@section('seo')
@php
    $WebsiteSettingData = App\Models\WebsiteSettings::first();
@endphp
<title>Checkout - {{ $WebsiteSettingData->meta_title }} | {{ $WebsiteSettingData->company_name }}</title>
<meta name="description" content="Checkout - {{ $WebsiteSettingData->meta_description }}" />
<meta name="keywords" content="checkout, Checkout page, {{ $WebsiteSettingData->meta_keywords }}" />

<!-- Open Graph Meta Tags (for social media optimization) -->
<meta property="og:title" content="Checkout - {{ $WebsiteSettingData->meta_title }}">
<meta property="og:description" content="Checkout - {{ $WebsiteSettingData->meta_description }}">
    <meta property="og:image" content="{{ asset('uploads/logo/' . $WebsiteSettingData->logo) }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="website">

<meta name="HandheldFriendly" content="True" />
<meta name="pinterest" content="nopin" />

<!-- Additional Structured Data (JSON-LD for schema.org markup) -->
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "WebPage",
    "name": "Checkout - {{ $WebsiteSettingData->meta_title }}",
    "description": "Checkout - {{ $WebsiteSettingData->meta_description }}"
}
</script>
@endsection

@section('content')

<!-- Products Section 1 -->
<section class="container mt-4 mb-5">
    <form action="{{ route('user.order') }}" method="post">
        @csrf

        <div class="row">

            <div class="col-md-7">
                <div class="sub-title">
                    <h2>Shipping Address</h2>
                </div>
                <div class="border-0 shadow-lg card">
                    <div class="card-body checkout-form">
                        <div class="row">

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <input type="text" name="name" id="name" value="{{ $user->name ?? '' }}"
                                        class="form-control" placeholder="Full Name">
                                    @error('name')
                                    <div style="color: red">{{ $message }}</div><br>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <input type="text" name="phone" id="phone" value="{{ $user->phone ?? '' }}"
                                        class="form-control" placeholder="Phone No">
                                    @error('phone')
                                    <div style="color: red">{{ $message }}</div><br>
                                    @enderror
                                </div>
                            </div>

                            {{-- email --}}

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <input type="email" name="email" id="email" value="{{ $user->email ?? '' }}"
                                        class="form-control" placeholder="Email">
                                    @error('email')
                                    <div style="color: red">{{ $message }}</div><br>
                                    @enderror
                                </div>
                            </div>




                            <div class="col-md-12">
                                <div class="mb-3">
                                    <select name="zone" id="zone" class="form-control">
                                        <option value="">Select a zone</option>

                                        @foreach ($zones as $zone)
                                            <option value="{{ $zone->id }}"
                                                {{ old('zone', $user->zone ?? '') == $zone->id ? 'selected' : '' }}>
                                                {{ $zone->name }}
                                            </option>
                                        @endforeach

                                    </select>

                                    @error('zone')
                                    <div style="color: red">{{ $message }}</div><br>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <textarea name="address" id="address" cols="30" rows="3" placeholder="Address"
                                        class="form-control">{{ $user->address ?? '' }}</textarea>
                                    @error('address')
                                    <div style="color: red">{{ $message }}</div><br>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <textarea name="order_note" id="order_note" cols="30" rows="2"
                                        placeholder="Order Notes (optional)" class="form-control"></textarea>
                                    @error('order_note')
                                    <div style="color: red">{{ $message }}</div><br>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="sub-title">
                    <h2>Order Summery</h3>
                </div>
                <div class="border-0 shadow-lg card cart-summery">
                    <div class="card-body">



                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>

                        @if (count($cart) > 0)
                        @foreach ($cart as $productId => $item)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>৳ {{ $item['price'] * $item['quantity'] }}</td>
                        </tr>
                        @endforeach
                        @endif

                            </tbody>

                        </table>

                        <hr>
                        <div class="d-flex justify-content-between summery-end">
                            <div class="h6"><strong>Subtotal</strong></div>
                            <div class="h6"><strong>৳ {{ number_format($subtotal, 2) }}</strong></div>
                        </div>
                        <div class="mt-2 d-flex justify-content-between">
                            <div class="h6"><strong>Shipping</strong></div>
                            <div class="h6"><strong>৳ {{ number_format($shipping, 2) }}</strong></div>
                        </div>
                        @if($discount > 0)
                        <div class="mt-2 d-flex justify-content-between">
                            <div class="h6"><strong>Discount</strong></div>
                            <div class="h6"><strong style="color: green;">-৳ {{ number_format($discount, 2) }}</strong></div>
                        </div>
                        @endif
                        <hr>
                        <div class="mt-2 d-flex justify-content-between summery-end">
                            <div class="h5"><strong>Total</strong></div>
                            <div class="h5"><strong>৳ {{ number_format($total, 2) }}</strong></div>
                        </div>

                    </div>
                </div>

                <div class="mt-4 p-4 card payment-form">
                    <div class="p-0 card-body">
                        <div class="text-left">
                            <h5 class="mb-3">Payment Method</h5>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod"
                                    checked>
                                <label class="form-check-label" for="cod">
                                    Cash on Delivery
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 card payment-form">
                        <div class="p-0 card-body">
                            <div class="text-center">
                                <button type="submit" class="btn btn-color-orange btn-block w-100">Order Now</button>
                            </div>
                        </div>
                    </div>

                </div>


            </div>

    </form>
</section>
@endsection

{{-- push custom js before end of body tag --}}
@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
@if (session('message'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        title: '{{ session('
        message ') }}',
        icon: '{{ session('
        alert - type ') }}', // 'error', 'success', 'warning', 'info'
        // confirmButtonText: 'OK',
        timer: 3000, // Auto close after 5 seconds
        timerProgressBar: true,
    });

    toastr.error('{{ session('
        message ') }}');
});
</script>
@endif

@endpush
