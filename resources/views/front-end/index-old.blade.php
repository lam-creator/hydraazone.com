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
    <style>
        .cart-btn {
            border-radius: 35px;
        }
    </style>


    <style>
        .main-slider {
            margin: 10px 0;
        }
    </style>
    <!-- Slider  -->
    <section class="main-slider">
        <div class="container">
            <div id="imageSlider" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">

                    @if ($AllSlider->isNotEmpty())
                        @foreach ($AllSlider as $index => $slider)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <a href="{{ $slider->link }}">
                                    <img src="/uploads/slider/{{ $slider->image }}" class="d-block w-100"
                                    alt="{{ $slider->title }}">
                                </a>
                            </div>
                        @endforeach
                    @endif

                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#imageSlider" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#imageSlider" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>


    {{-- Code for Category wise product display  --}}

    <!-- Featured Products Section -->
    {{-- if uppcoming in empty then do not show section --}}

    @if($AllFeaturedProduct->isNotEmpty())

        <section class="container mb-5">

            <div class="text-separator">
                <hr class="d-none d-md-block">
                <h2 class="separator-text">Featured Product</h2>
                <hr class="d-none d-md-block">
            </div>

            <div class="row">

                @if ($AllFeaturedProduct->isNotEmpty())
                    @foreach ($AllFeaturedProduct as $FeaturedProduct)
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
                                                class="fa hide-in-mobile fa-shopping-cart"></i> Add to Cart</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>
            <div class="view-all">
                <a href="{{ route('featured.products') }}">View All <i class="fas fa-arrow-right"></i></a>
            </div>
        </section>
    @endif




    {{-- Code for Category wise product display  --}}

    @foreach ($AllCategoryProduct as $category)
        @if ($category->products->isNotEmpty())
            <!-- Category Products Section -->
            <section class="container mb-5">

                <div class="text-separator">
                    <hr class="d-none d-md-block">
                    <h2 class="separator-text">{{ $category->name }}</h2>
                    <hr class="d-none d-md-block">
                </div>

                <div class="row">

                    @foreach ($category->products as $product)
                        <!-- Product 1 -->
                        <div class="col-6 col-md-3">
                            <div class="product-card">
                                <div class="product-image">

                                    @if ($product->discount_price > 0)
                                        <span class="discount-tag">Special Discount</span>
                                    @else
                                        <span></span>
                                    @endif

                                    {{-- <span class="discount-tag">১০% ছাড়</span> --}}
                                    <a
                                        href="{{ route('product-details', ['category' => $product->category->category_slug, 'name' => $product->product_slug, 'id' => $product->id]) }}">
                                        <img src="/uploads/product/{{ $product->image }}" alt="{{ $product->name }}"
                                            class="img-fluid"></a>
                                </div>
                                <div class="product-details">
                                    <a
                                        href="{{ route('product-details', ['category' => $product->category->category_slug, 'name' => $product->product_slug, 'id' => $product->id]) }}">
                                        <h3 class="product-title">{{ $product->name }}</h3>
                                    </a>
                                    <div class="product-price">

                                        {{-- Price  --}}
                                        @if ($product->status == 'active')
                                            @if ($product->discount_price > 0)
                                                <span class="original-price">Tk{{ $product->sale_price }}</span>
                                                <span class="discounted-price">Tk{{ $product->discount_price }}</span>
                                            @else
                                                <span class="discounted-price">Tk{{ $product->sale_price }}</span>
                                            @endif
                                        @endif

                                    </div>

                                    <div class="product" data-id="{{ $product->id }}">
                                        <button class="m-2 text-white btn btn-warning add-to-cart btn-add-cart"><i
                                                class="fa fa-shopping-cart hide-in-mobile"></i> Add to Cart</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
                <div class="view-all">
                    <a
                        href="{{ route('categorywise-product', ['name' => $category->category_slug, 'id' => $category->id]) }}">View
                        All <i class="fas fa-arrow-right"></i></a>
                </div>
            </section>
        @endif
    @endforeach


    {{-- Code for Upcoming product display  --}}

    <!-- Upcoming Products Section -->
    {{-- if uppcoming in empty then do not show section --}}

    @if($AllUpcomingProduct->isNotEmpty())
        <section class="container mb-5">

        <div class="text-separator">
            <hr class="d-none d-md-block">
            <h2 class="separator-text">Upcoming Product</h2>
            <hr class="d-none d-md-block">
        </div>

        <div class="row">
            @if ($AllUpcomingProduct->isNotEmpty())
                @foreach ($AllUpcomingProduct as $UpcomingProduct)
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

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

        </div>
        <div class="view-all">
            <a href="{{ route('upcoming.products') }}">View All <i class="fas fa-arrow-right"></i></a>
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
