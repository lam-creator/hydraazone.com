@extends('front-end.layouts.master')

@section('seo')
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
@endsection

@section('content')
<style>
.cart-btn {
    border-radius: 35px;
}
.carousel-control-prev-icon,.carousel-control-next-icon {
    background-color: black;
}
</style>


<!-- Products Section 1 -->
<section class="container mt-4 mb-5">

    <div class="row">
        <div class="col-md-4">
            <!-- Main Product Image -->
            <div class="mb-3">
                <img id="mainProductImage" src="/uploads/product/{{ $product->image }}" alt="{{ $product->product_slug }}" class="product-image img-fluid" style="width: 100%; max-height: 400px; border-radius: 8px;">
            </div>

            <!-- Product Gallery Thumbnails -->
            @php
                $galleryImages = App\Models\ProductImages::where('product_id', $product->id)->get();
            @endphp

            @if ($galleryImages->isNotEmpty())
            <div class="product-gallery-thumbnails">
                <div class="row justify-content-center g-2">
                    <!-- Main image thumbnail -->
                    <div class="col-2">
                        <img src="/uploads/product/{{ $product->image }}"
                             alt="Main Image"
                             class="gallery-thumbnail img-fluid rounded cursor-pointer active"
                             style="border: 2px solid #007bff; cursor: pointer; transition: all 0.3s;"
                             onclick="changeMainImage(this, '/uploads/product/{{ $product->image }}')">
                    </div>

                    <!-- Gallery images thumbnails -->
                    @foreach ($galleryImages as $galleryImage)
                    <div class="col-2">
                        <img src="/uploads/product-gallery/{{ $galleryImage->image }}"
                             alt="Gallery Image"
                             class="gallery-thumbnail img-fluid rounded cursor-pointer"
                             style="border: 2px solid #ddd; cursor: pointer; transition: all 0.3s;"
                             onclick="changeMainImage(this, '/uploads/product-gallery/{{ $galleryImage->image }}')">
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        <div class="col-md-5">
            <h2 class="product-details-title">{{ $product->name }}</h2>
            {{-- <p class="text-muted">Category: CHEESE200</p> --}}


            @if ($product->show_as == 'upcoming')
            <p class="text-danger">Upcoming Product</p>
            @else
            <p class="price">

                @if ($product->discount_price > 0)
                <span style="color:var(--tag-color)">MRP: Tk {{ $product->discount_price }}</span>  <span style="color:#999"><del>Tk {{ $product->sale_price }}</del></span>
                @else
                MRP: Tk {{ $product->sale_price }}
                @endif

            </p>
            @endif



            @if ($product->show_as == 'upcoming')
            <div class="gap-2 d-grid d-md-flex"></div>
            @else
            <div class="gap-2 d-flex">
            {{-- <div class="gap-2 d-grid d-md-flex"> --}}
                <div class="product" data-id="{{ $product->id }}">
                    <button class="btn btn-primary me-2 btn-buy add-to-cart"><i class="fa fa-shopping-cart"></i> Add
                        to
                        Cart</button>
                </div>
                <a href="{{ route('cart.view') }}" class="btn-buy">View Cart</a>
            </div>
            @endif

            <p class="mt-3">{!! $product->short_description !!}</p>

        </div>

        {{-- Other Products section start  --}}

        <div class="col-md-3 d-none d-lg-block">
            <div class="related-product-section">
                <div id="imageSlider" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @if ($OtherProducts->isNotEmpty())
                            @foreach ($OtherProducts as $index => $OtherProduct)

                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <div class="position-relative">
                                        <a href="{{ route('product-details', ['category' => $OtherProduct->category->category_slug, 'name' => $OtherProduct->product_slug, 'id' => $OtherProduct->id]) }}">
                                            <img src="/uploads/product/{{ $OtherProduct->image }}" class="d-block w-100" alt="{{ $OtherProduct->name }}">
                                            <div class="product-caption-overlay">{{ $OtherProduct->name }}</div>
                                        </a>
                                    </div>
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
        </div>

        <style>
        .product-caption-overlay {
            position: absolute;
            bottom: 0;
            width: 100%;
            background: rgba(0, 0, 0, 0.7); /* semi-transparent black */
            color: #fff;
            text-align: center;
            padding: 8px;
            font-size: 14px;
        }
        .related-product-section {
            border: 1px solid #ddd;
        }
        </style>

        {{-- Other Products section End  --}}


    </div>

    <div class="mt-5">
        <ul class="nav nav-tabs" id="productTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details"
                    type="button" role="tab" aria-controls="details" aria-selected="true">Product Details</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="sku-tab" data-bs-toggle="tab" data-bs-target="#sku" type="button"
                    role="tab" aria-controls="sku" aria-selected="false">Additional Info</button>
            </li>
            {{-- <li class="nav-item" role="presentation">
                    <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button"
                        role="tab" aria-controls="reviews" aria-selected="false">Reviews</button>
                </li> --}}
        </ul>
        <div class="p-4 border tab-content border-top-0" id="productTabContent">
            <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                <p>{!! $product->long_description !!}</p>
            </div>
            <div class="tab-pane fade" id="sku" role="tabpanel" aria-labelledby="sku-tab">
                <p>{!! $product->additional_info !!}</p>
            </div>
            {{-- <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                    <p>No reviews yet. Be the first to review this product!</p>
                </div> --}}
        </div>
    </div>


    <section class="container mb-5">

        <div class="text-separator">
            <hr class="d-none d-md-block">
            <h2 class="separator-text">Other Products </h2>
            <hr class="d-none d-md-block">
        </div>

        <div class="row">

            @if ($OtherProducts->isNotEmpty())
                @foreach ($OtherProducts as $OtherProduct)
                    <div class="col-6 col-md-3">
                        <div class="product-card">
                            <div class="product-image">

                                @if ($OtherProduct->discount_price > 0)
                                    <span class="discount-tag">Special Discount</span>
                                @else
                                    <span></span>
                                @endif

                                {{-- <span class="discount-tag">১০% ছাড়</span> --}}
                                <a
                                    href="{{ route('product-details', ['category' => $OtherProduct->category->category_slug, 'name' => $OtherProduct->product_slug, 'id' => $OtherProduct->id]) }}">
                                    <img src="/uploads/product/{{ $OtherProduct->image }}" alt="{{ $OtherProduct->name }}"
                                        class="img-fluid"></a>
                            </div>
                            <div class="product-details">
                                <a
                                    href="{{ route('product-details', ['category' => $OtherProduct->category->category_slug, 'name' => $OtherProduct->product_slug, 'id' => $OtherProduct->id]) }}">
                                    <h3 class="product-title">{{ $OtherProduct->name }}</h3>
                                </a>
                                <div class="product-price">

                                    {{-- Price  --}}
                                    @if ($OtherProduct->status == 'active')
                                        @if ($OtherProduct->discount_price > 0)
                                            <span class="original-price">Tk{{ $OtherProduct->sale_price }}</span>
                                            <span class="discounted-price">Tk{{ $OtherProduct->discount_price }}</span>
                                        @else
                                            <span class="discounted-price">Tk{{ $OtherProduct->sale_price }}</span>
                                        @endif
                                    @endif

                                </div>

                                <div class="product" data-id="{{ $OtherProduct->id }}">
                                    <button class="m-2 text-white btn btn-warning add-to-cart btn-add-cart"><i
                                            class="fa fa-shopping-cart hide-in-mobile"></i> Add to Cart</button>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

        </div>
    </section>




</section>
@endsection

{{-- push custom js before end of body tag --}}
@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<script>
    // Function to change main product image
    function changeMainImage(thumbnail, imageUrl) {
        // Update main image
        document.getElementById('mainProductImage').src = imageUrl;

        // Remove active class from all thumbnails
        const allThumbnails = document.querySelectorAll('.gallery-thumbnail');
        allThumbnails.forEach(img => {
            img.style.border = '2px solid #ddd';
        });

        // Add active class to clicked thumbnail
        thumbnail.style.border = '2px solid #007bff';
    }
</script>
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

                    // Show warning message and skip success if max quantity reached
                    if (response.message) {
                        toastr.warning(response.message);
                    } else {
                        toastr.success('Added to cart.');
                    }

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
