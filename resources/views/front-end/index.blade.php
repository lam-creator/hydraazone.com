@extends('front-end.layouts.master')

@section('seo')
    <title>{{ $SeoData->meta_title }} | {{ $SeoData->company_name }}</title>
    <meta name="description" content="{{ $SeoData->meta_description }}" />
    <meta name="keywords" content="{{ $SeoData->meta_keywords }}" />

    <!-- Open Graph Meta Tags (for social media optimization) -->
    <meta property="og:title" content="{{ $SeoData->meta_title }}">
    <meta property="og:description" content="{{ $SeoData->meta_description }}">
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
        "name": "{{ $SeoData->meta_title }}",
        "description": "{{ $SeoData->meta_description }}"
        }
    </script>
@endsection

@section('content')


    @if($AllSlider->isNotEmpty())


    <style>
        .slider-background {
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: calc(100vh - 217px); /* Adjust this value based on your header/footer height */
            // min-height: 500px; /* Adjust this value as needed */
            // max-height: 100vh; /* Optional: Prevents the slider from exceeding the viewport height */
        }

        /* Tablet */
        @media (max-width: 991px) {
            .slider-background {
                min-height: 400px;
            }
        }

        /* Mobile */
        @media (max-width: 767px) {
            .slider-background {
                min-height: 300px;
                background-position: center center;
            }
        }

        /* Small Mobile */
        @media (max-width: 480px) {
            .slider-background {
                min-height: 250px;
            }

    </style>

    <!-- Hero Slider Section -->
    <section class="hero-section">
        <div id="mainHeroCarousel" class="carousel slide hero-carousel" data-bs-ride="carousel">

            <!-- Indicators -->
            <div class="carousel-indicators">
                @foreach ($AllSlider as $index => $slider)
                    <button type="button" data-bs-target="#mainHeroCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}" aria-current="{{ $index === 0 ? 'true' : 'false' }}" aria-label="Slide {{ $index + 1 }}"></button>
                @endforeach
            </div>

            <div class="carousel-inner">

                @if ($AllSlider->isNotEmpty())
                    @foreach ($AllSlider as $index => $slider)


                        <!-- Slide 1 -->
                        <div style="background-image: url('{{ asset('uploads/slider/' . $slider->image) }}') " class="slider-background carousel-item {{ $index === 0 ? 'active' : '' }}" data-bs-interval="5000">
                            <div class="container hero-carousel-item-inner">
                                <div class="row align-items-center flex-column-reverse flex-lg-row">
                                    <div class="col-lg-6 mt-4 mt-lg-0 sider-content-bg">
                                        <h1 class="hero-title serif-font">{{ $slider->title }}</h1>
                                        <p class="text-muted mb-4 fs-6 fs-lg-5">{{ $slider->slogan }}</p>
                                        <div class="d-flex gap-3 mb-4 mb-lg-5">
                                            <a href="{{ $slider->link }}" class="btn-theme">{{ $slider->button_text }} <i class="fa-solid fa-arrow-right ms-2"></i></a>
                                        </div>
                                    </div>
                                    {{-- <div class="col-lg-6 position-relative">
                                        <img src="{{ asset('uploads/slider/' . $slider->image) }}" alt="{{ $slider->title }}" class="hero-image shadow">
                                    </div> --}}
                                </div>
                            </div>
                        </div>

                    @endforeach
                @endif



            </div>
        </div>
    </section>

    @endif

    <!-- Shop by Collection -->
    <section class="container my-5">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-end mb-4 gap-2">
            <h3 class="fw-bold m-0">Shop by Collection</h3>
            {{-- <a href="#" class="text-primary-theme fw-medium">Browse All Categories <i class="fa-solid fa-arrow-right"></i></a> --}}
        </div>


        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4 justify-content-center">

            <style>

                .collection-card-text-area {
                    background-color: rgba(22, 18, 18, 0.742);
                    border-radius: 5px;
                    position: absolute;
                    bottom: 15px;
                    width: 100%;
                }
                .height-fix{
                    height: 80px;
                }
            </style>

            @foreach ($AllCategoryProduct as $category)
            @if ($category->products->isNotEmpty())

            <!-- Col -->
            <div class="col">
                <a href="{{ route('categorywise-product', ['name' => $category->category_slug, 'id' => $category->id]) }}">
                    <div class="collection-card">
                        <img src="{{ asset('uploads/category/' . $category->image) }}" alt="{{ $category->name }}">
                        <div class="d-flex align-items-center justify-content-center gap-2 collection-card-text-area height-fix">
                            <img src="{{ asset('uploads/category/icon/' . $category->icon) }}" style="width: 30px;height:30px; padding:3px;background-color: #fff;" alt="{{ $category->name }}">
                            <div class="text-start">
                                <div class="fw-bold text-white font-14">{{ $category->name }}</div>
                                <div class="text-white font-12">{{ $category->products->count() }} Product</div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            @endif
            @endforeach

        </div>

    </section>


    @if($AllBanner->isNotEmpty())

    <!-- Banner Section -->
    <section class="container my-5">
        <div class="row g-4">

            @if ($AllBanner->isNotEmpty())
                @foreach ($AllBanner as $Banner)

                    <div class="col-md-6">
                        <div class="banner-card banner-dark" style="background-image: linear-gradient(to right, #1a1a1a 60%, transparent), url('{{ asset('uploads/banner/' . $Banner->image) }}');">
                            <div class="w-75">
                                <h2 class="serif-font mb-3 fs-3">{{ $Banner->title }}</h2>
                                <p class="font-14 text-light mb-4">{{ $Banner->slogan }}</p>
                                <a href="{{ $Banner->link }}" class="btn btn-light fw-bold font-14 px-3 py-2">{{ $Banner->button_text }}<i class="fa-solid fa-arrow-right ms-2"></i></a>
                            </div>
                        </div>
                    </div>

                @endforeach
            @endif

        </div>
    </section>

    @endif

    @if($AllFeature->isNotEmpty())

    <!-- Features Bar -->
    <section class="container features-bar mb-5">
        <div class="row g-3">

            @if ($AllFeature->isNotEmpty())
                @foreach ($AllFeature as $Feature)

                    <div class="col-6 col-md-3 feature-item">
                        <img src="{{ asset('uploads/feature/' . $Feature->image) }}" alt="{{ $Feature->title }}" class="img-fluid">
                        <div>
                            <div class="fw-bold font-14">{{ $Feature->title }}</div>
                            <div class="text-muted font-12">{{ $Feature->slogan }}</div>
                        </div>
                    </div>
                @endforeach
            @endif

        </div>
    </section>

    @endif


    @if($AllFeaturedProduct->isNotEmpty())

    <!-- Popular Product Picks Section -->
    <section class="container my-5">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-end mb-4 gap-2">
            <h3 class="fw-bold m-0">Popular Picks For You</h3>
            <a href="{{ route('featured.products') }}" class="text-primary-theme fw-medium">View All Products <i class="fa-solid fa-arrow-right"></i></a>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4 justify-content-center">


            @if ($AllFeaturedProduct->isNotEmpty())
                @foreach ($AllFeaturedProduct as $FeaturedProduct)

                    <!-- Product 1 -->
                    <div class="col">
                        <div class="product-card">

                            <a href="{{ route('product-details', ['category' => $FeaturedProduct->category->category_slug, 'name' => $FeaturedProduct->product_slug, 'id' => $FeaturedProduct->id]) }}">

                                @php
                                    $totalDiscount = ($FeaturedProduct->discount_price - $FeaturedProduct->sale_price);
                                @endphp
                                @if ($FeaturedProduct->discount_price > 0)
                                    <span class="product-badge">{{ $totalDiscount }}</span>
                                @else
                                    {{-- <span class="product-badge">0</span> --}}
                                @endif

                            <img src="{{ asset('uploads/product/' . $FeaturedProduct->image) }}" alt="{{ $FeaturedProduct->name }}">
                            <div class="product-title">{{ Str::limit($FeaturedProduct->name, 50) }}</div>
                            </a>

                            <div class="d-flex justify-content-between align-items-center mt-3">

                                <div class="product-price">
                                    @if ($FeaturedProduct->status == 'active')
                                        @if ($FeaturedProduct->discount_price > 0)
                                            ৳ {{ $FeaturedProduct->discount_price }}
                                            <del>৳ {{ $FeaturedProduct->sale_price }}</del>
                                        @else
                                            ৳ {{ $FeaturedProduct->sale_price }}
                                        @endif
                                    @endif
                                </div>

                                <div class="product" data-id="{{ $FeaturedProduct->id }}">
                                        <button class="cart-btn-small add-to-cart btn-add-cart"><i class="fa-solid fa-cart-shopping"></i></button>
                                </div>

                            </div>
                        </div>
                    </div>

                @endforeach
            @endif





        </div>
    </section>

    @endif

    @if($AllTrust->isNotEmpty())

    <!-- Trust Banner -->
    <section class="trust-banner">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4 mb-4 mb-lg-0 text-center text-lg-start">
                    <h3 class="serif-font m-0 fs-2">Why Thousands Trust <span class="text-primary-theme">Us?</span></h3>
                </div>
                <div class="col-lg-8">
                    <div class="row text-white g-4 justify-content-center">

                        @if ($AllTrust->isNotEmpty())
                            @foreach ($AllTrust as $Trust)

                                <div class="col-sm-6 col-md-3 trust-item justify-content-center justify-content-lg-start">
                                    <img src="{{ asset('uploads/trust/' . $Trust->image) }}" alt="{{ $Trust->title }}" style="width: 32px; height: 32px;">
                                    <div>
                                        <div class="font-14 fw-bold">{{ $Trust->title }}</div>
                                        <div class="font-12 text-light">{{ $Trust->slogan }}</div>
                                    </div>
                                </div>

                            @endforeach
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </section>

    @endif


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

        // add to cart
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
                    // console.log(response);

                    // Show warning message and skip success if max quantity reached
                    if (response.message) {
                        toastr.warning(response.message);
                    } else {
                        toastr.success('Added to cart.');
                    }

                    // Update cart counts
                    $('#cart-count-1').text(response.cartCount);
                    $('#cart-count-2').text(response.cartCount);
                    $('#cart-count-3').text(response.cartCount);
                    // $('#floating-cart-count').text(response.total);
                    $('#floating-cart-count').text(response.total.toFixed(2));
                },
                error: function() {
                    toastr.error('Something went wrong. Please try again.');
                }
            });
        });
    });
</script>

@endpush
