@extends('front-end.layouts.master')

{{-- @section('seo')
    @php
        $WebsiteSettingData = App\Models\WebsiteSettings::first();
    @endphp
    <title>{{ $product->meta_title }} | {{ $WebsiteSettingData->company_name }}</title>
<meta name="description" content="{{ $product->meta_description }}" />
<meta name="keywords" content="{{ $product->meta_keywords }}" />

<!-- Open Graph Meta Tags (for social media optimization) -->
<meta property="og:title" content="{{ $product->meta_title }}">
<meta property="og:description" content="{{ $product->meta_description }}">
<meta property="og:image" content="{{ asset('uploads/product/' . $product->image) }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="website">

<meta name="HandheldFriendly" content="True" />
<meta name="pinterest" content="nopin" />

<!-- Additional Structured Data (JSON-LD for schema.org markup) -->
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "WebPage",
    "name": "{{ $product->meta_title }}",
    "description": "{{ $product->meta_description }}"
}
</script>
@endsection --}}

@section('content')

<!-- Products Section 1 -->
<section class="container mt-4 mb-5">
    <div class="row">

        <div class="col-md-3">
            <!-- user menu Section Start -->
            @include('front-end.layouts.account-panel')
            <!-- user menu Section End -->
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h2 class="pt-2 pb-2 mb-0 h5">My Orders</h2>
                </div>

                <div class="card-body">
                    <!-- Info -->
                    <div class="card card-sm">
                        <div class="mb-3 card-body bg-light">
                            <div class="row">
                                <div class="col-6 col-lg-3">
                                    <!-- Heading -->
                                    <h6 class="heading-xxxs text-muted">Order No:</h6>
                                    <!-- Text -->
                                    <p class="mb-lg-0 fs-sm fw-bold">
                                        ORD-{{ $order->id }}
                                    </p>
                                </div>
                                <div class="col-6 col-lg-3">
                                    <!-- Heading -->
                                    <h6 class="heading-xxxs text-muted">Order date:</h6>
                                    <!-- Text -->
                                    <p class="mb-lg-0 fs-sm fw-bold">
                                        <time datetime="{{ $order->created_at->format('M d, Y') }}">
                                            {{ $order->created_at->format('M d, Y') }}
                                        </time>
                                    </p>
                                </div>
                                <div class="col-6 col-lg-3">
                                    <!-- Heading -->
                                    <h6 class="heading-xxxs text-muted">Status:</h6>
                                    <!-- Text -->
                                    <p class="mb-0 fs-sm fw-bold">
                                        {{ $order->status }}
                                    </p>
                                </div>
                                <div class="col-6 col-lg-3">
                                    <!-- Heading -->
                                    <h6 class="heading-xxxs text-muted">Order Amount:</h6>
                                    <!-- Text -->
                                    <p class="mb-0 fs-sm fw-bold">
                                        Tk {{ number_format($order->total_amount, 2) }}
                                    </p>
                                </div>

                                <div class="col-12 col-lg-12 mt-4">
                                    <!-- Heading -->
                                    <h6 class="heading-xxxs text-muted">Delivery Address:</h6>
                                    <!-- Text -->
                                    <p class="mb-0 fs-sm fw-bold">
                                        {{ $order->address }}
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-3 card-footer">

                    <!-- Heading -->
                    <h6 class="mt-4 mb-7 h5">Order Items</h6>

                    <!-- Divider -->
                    <hr class="my-3">

                    <!-- List products -->

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($order->items as $item)
                                <tr>
                                    <td>
                                        {{ $item->product->name }}
                                    </td>
                                    <td>
                                        {{ $item->quantity }}
                                    </td>
                                    <td>
                                        {{ $item->price }}
                                    </td>
                                    <td>
                                        {{ $item->price * $item->quantity }}
                                    </td>
                                </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

            <div class="mt-3 mb-5 card card-lg">
                <div class="card-body">
                    <!-- Heading -->
                    <h6 class="mt-0 mb-3 h5">Order Total</h6>
                    <hr>

                    <!-- List group -->
                    <ul>
                        <li class="list-group-item d-flex">
                            <span>Subtotal</span>
                            <span class="ms-auto">
                                {{ number_format(($order->total_amount + $order->discount_amount - $order->shipping), 2) }}
                            </span>
                        </li>
                        <li class="list-group-item d-flex">
                            <span>Shipping</span>
                            <span class="ms-auto">{{ number_format($order->shipping, 2) }}</span>
                        </li>
                        <li class="list-group-item d-flex">
                            <span>Discount</span>
                            <span
                                class="ms-auto">(-) {{ $order->discount_amount > 0 ? intval($order->discount_amount) . '.00' : '0.00' }}

                            </span>
                        </li>
                        <hr>
                        <li class="list-group-item d-flex fs-lg fw-bold">
                            <span>Total</span>
                            <span class="ms-auto">Taka {{ number_format($order->total_amount, 2) }}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>


    </div>
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

    toastr.success('{{ session('
        message ') }}');
});
</script>
@endif


@endpush
