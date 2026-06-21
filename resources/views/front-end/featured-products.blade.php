@extends('front-end.layouts.master')

@section('seo')
    <title>Featured Products - {{ $SeoData->meta_title }} | {{ $SeoData->company_name }}</title>
    <meta name="description" content="Featured Products - {{ $SeoData->meta_description }}" />
    <meta name="keywords" content="featured products, featured product page, {{ $SeoData->meta_keywords }}" />

    <!-- Open Graph Meta Tags (for social media optimization) -->
    <meta property="og:title" content="Featured Products - {{ $SeoData->meta_title }}">
    <meta property="og:description" content="Featured Products - {{ $SeoData->meta_description }}">
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
        "name": "Featured Products - {{ $SeoData->meta_title }}",
        "description": "Featured Products - {{ $SeoData->meta_description }}"
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
            <h2 class="separator-text">Featured Products</h2>
            <hr class="d-none d-md-block">
        </div>

        <div class="row">

            @if ($AllFeaturedProductLink->isNotEmpty())
                @foreach ($AllFeaturedProductLink as $FeaturedProduct)
                    <!-- Product 1 -->
                    <div class="col-6 col-md-3">
                        <div class="product-card">
                            <div class="product-image">
                                @if ($FeaturedProduct->discount_price > 0)
                                    <span class="discount-tag">Special Discount</span>
                                @else
                                    <span></span>
                                @endif

                                {{-- <span class="discount-tag">Tk {{ $FeaturedProduct->sale_price - $FeaturedProduct->discount_price }}ছাড়</span> --}}
                                <a
                                    href="{{ route('product-details', ['category' => $FeaturedProduct->category->category_slug, 'name' => $FeaturedProduct->product_slug, 'id' => $FeaturedProduct->id]) }}"><img
                                        src="/uploads/product/{{ $FeaturedProduct->image }}"
                                        alt="{{ $FeaturedProduct->name }}" class="img-fluid"></a>
                            </div>
                            <div class="product-details">
                                <a
                                    href="{{ route('product-details', ['category' => $FeaturedProduct->category->category_slug, 'name' => $FeaturedProduct->product_slug, 'id' => $FeaturedProduct->id]) }}">
                                    <h3 class="product-title">{{ $FeaturedProduct->name }}</h3>
                                </a>
                                <div class="product-price">
                                    {{-- Price  --}}
                                    @if ($FeaturedProduct->status == 'active')
                                        @if ($FeaturedProduct->discount_price > 0)
                                            <span class="original-price">Tk{{ $FeaturedProduct->sale_price }}</span>
                                            <span class="discounted-price">Tk{{ $FeaturedProduct->discount_price }}</span>
                                        @else
                                            <span class="discounted-price">Tk{{ $FeaturedProduct->sale_price }}</span>
                                        @endif
                                    @endif
                                </div>

                                <div class="product" data-id="{{ $FeaturedProduct->id }}">
                                    <button class="m-2 text-white btn btn-warning add-to-cart btn-add-cart"><i
                                            class="fa fa-shopping-cart hide-in-mobile"></i> Add to Cart</button>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <h2 class="text-center">No product found</h2>
            @endif

        </div>
        <div class="view-all">
            {{ $AllFeaturedProductLink->links('vendor.pagination.bootstrap-5') }}
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

    <script>
        $(document).ready(function() {
            $('.add-to-cart').click(function() {

                var productId = $(this).closest('.product').data('id');

                $.ajax({
                    url: '{{ route('cart.add') }}',
                    method: 'POST',
                    data: {
                        product_id: productId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log(response);
                        toastr.success('Added to cart.');
                        $('#cart-count-1').text(response.cartCount);
                        $('#cart-count-2').text(response.cartCount);
                        $('#cart-count-3').text(response.cartCount);
                        $('#floating-cart-count').text(response.total);
                    }
                });
            });
        });
    </script>
@endpush
