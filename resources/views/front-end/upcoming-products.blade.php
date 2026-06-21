@extends('front-end.layouts.master')

@section('seo')
    <title>Upcoming products - {{ $SeoData->meta_title }} | {{ $SeoData->company_name }}</title>
    <meta name="description" content="Upcoming products - {{ $SeoData->meta_description }}" />
    <meta name="keywords" content="upcoming products, upcoming product page, {{ $SeoData->meta_keywords }}" />

    <!-- Open Graph Meta Tags (for social media optimization) -->
    <meta property="og:title" content="Upcoming products - {{ $SeoData->meta_title }}">
    <meta property="og:description" content="Upcoming products - {{ $SeoData->meta_description }}">
    <meta property="og:image" content="{{ asset('uploads/logo/' . $SeoData->logo) }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    <meta name="HandheldFriendly" content="True" />
    <meta name="pinterest" content="nopin" />

    <!-- Additional Structured Data (JSON-LD for schema.org markup) -->
    <script type="application/ld+json">
        {
        "@context": "http://schema.org",
        "@type": "WebPage",
        "name": "Upcoming products - {{ $SeoData->meta_title }}",
        "description": "Upcoming products - {{ $SeoData->meta_description }}"
        }
    </script>
@endsection

@section('content')
    <style>
        .cart-btn {
            border-radius: 35px;
        }
    </style>

    {{-- Code for Category wise product display  --}}
    <section class="container mb-5">

        <div class="text-separator">
            <hr class="d-none d-md-block">
            <h2 class="separator-text">Upcoming Products</h2>
            <hr class="d-none d-md-block">
        </div>

        <div class="row">

            @if ($AllUpcomingProductLink->isNotEmpty())
                @foreach ($AllUpcomingProductLink as $UpcomingProduct)
                    <!-- Product 1 -->
                    <div class="col-6 col-md-3">
                        <div class="product-card">
                            <div class="product-image">
                                <span class="discount-tag">Upcoming</span>
                                <a
                                    href="{{ route('product-details', ['category' => $UpcomingProduct->category->category_slug, 'name' => $UpcomingProduct->product_slug, 'id' => $UpcomingProduct->id]) }}"><img
                                        src="/uploads/product/{{ $UpcomingProduct->image }}"
                                        alt="{{ $UpcomingProduct->name }}" class="img-fluid"></a>
                            </div>
                            <div class="product-details">
                                <a
                                    href="{{ route('product-details', ['category' => $UpcomingProduct->category->category_slug, 'name' => $UpcomingProduct->product_slug, 'id' => $UpcomingProduct->id]) }}">
                                    <h3 class="product-title">{{ $UpcomingProduct->name }}</h3>
                                </a>
                                <div class="product-price">
                                    {{-- Price  --}}
                                    {{-- @if ($UpcomingProduct->status == 'active')
                                        @if ($UpcomingProduct->discount_price > 0)
                                            <span class="original-price">Tk{{ $UpcomingProduct->sale_price }}</span>
                                            <span class="discounted-price">Tk{{ $UpcomingProduct->discount_price }}</span>
                                        @else
                                            <span class="original-price">Tk{{ $UpcomingProduct->sale_price }}</span>
                                        @endif
                                    @endif --}}
                                </div>

                                {{-- <div class="product" data-id="{{ $UpcomingProduct->id }}">
                                    <button class="m-2 text-white btn btn-warning add-to-cart btn-add-cart"><i
                                            class="fa fa-shopping-cart"></i> Add to Cart</button>
                                </div> --}}

                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <h2 class="text-center">No product found</h2>
            @endif

        </div>
        <div class="view-all">
            {{ $AllUpcomingProductLink->links('vendor.pagination.bootstrap-5') }}
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
                    title: '{{ session('message') }}',
                    icon: '{{ session('alert-type') }}', // 'error', 'success', 'warning', 'info'
                    // confirmButtonText: 'OK',
                    timer: 3000, // Auto close after 5 seconds
                    timerProgressBar: true,
                });

                toastr.error('{{ session('message') }}');
            });
        </script>
    @endif

@endpush
