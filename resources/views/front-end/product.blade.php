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
        .product-card {
            /* border: 1px solid #eee;
        border-radius: 5px; */
            margin-bottom: 20px;
            overflow: hidden;
            transition: transform 0.3s;
            height: 100%;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .product-card img {
            width: 100%;
            border-radius: 6px;
        }
        .product-image {
            max-width: 100%;
            height: auto;
            /* border-radius: 10px; */
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        .discount-tag {
            position: absolute;
            top: 15px;
            left: 15px;
            background-color: var(--primary-color);
            color: white;
            padding: 5px 10px;
            font-weight: bold;
            font-size: 14px;
            z-index: 1;
            border-radius: 0 15px 15px 0;
        }
        .product-details {
            padding: 10px;
            text-align: center;
        }
        .product-title {
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 5px;
        flex-grow: 1;
        height: 45px;
        margin: 10px 0;
        }
        .product-price {
            font-weight: bold;
            color: var(--primary-color);
        }
        .original-price {
            text-decoration: line-through;
            color: #999;
            margin-right: 5px;
            font-size: 14px;
        }
        .discounted-price {
            font-size: 16px;
            color: var(--primary-color);
        }

        .variant-options {
            gap: 10px;
        }

        .variant-option {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 14px;
            border: 2px solid #e0e0e0;
            border-radius: 999px;
            background: #fff;
            color: #333;
            font-weight: 600;
            transition: all 0.25s ease;
            box-shadow: 0 2px 6px rgba(0,0,0,0.06);
            cursor: pointer;
        }

        .variant-option:hover {
            transform: translateY(-2px);
            border-color: #f38b00;
            box-shadow: 0 6px 14px rgba(243, 139, 0, 0.18);
        }

        .variant-option.active {
            background: #f38b00;
            color: #fff;
            border-color: #f38b00;
            box-shadow: 0 8px 18px rgba(243, 139, 0, 0.28);
        }

        .variant-option small {
            opacity: 0.9;
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
        <div class="col-md-6 offset-md-1">
            <h2 class="product-details-title mt-4">{{ $product->name }}</h2>
            {{-- <p class="text-muted">Category: CHEESE200</p> --}}

            @if ($product->variants->isNotEmpty())
                <div class="mt-3">
                    <h6 class="mb-2">Available Variants</h6>
                    <div class="variant-options d-flex flex-wrap gap-2">
                        @foreach ($product->variants as $index => $variant)
                            <label class="variant-option badge rounded-pill px-3 py-2 border {{ $index === 0 ? 'active' : '' }}"
                                   data-variant-id="{{ $variant->id }}"
                                   data-variant-type="{{ $variant->type }}"
                                   data-variant-value="{{ $variant->value }}"
                                   data-price-adjustment="{{ $variant->price_adjustment }}"
                                   style="cursor:pointer;">
                                <input type="radio" name="selected_variant" value="{{ $variant->id }}" class="d-none" {{ $index === 0 ? 'checked' : '' }}>
                                <span>{{ $variant->type }}: {{ $variant->value }}</span>
                                @if ($variant->price_adjustment != 0)
                                    <small class="ms-1">
                                        @if ($variant->price_adjustment > 0)
                                            (+Tk {{ number_format($variant->price_adjustment, 2) }})
                                        @else
                                            (Tk {{ number_format($variant->price_adjustment, 2) }})
                                        @endif
                                    </small>
                                @endif
                            </label>
                        @endforeach
                    </div>
                </div>
            @endif

            @if ($product->show_as == 'upcoming')
            <p class="text-danger">Upcoming Product</p>
            @else
            <p class="price mt-3">

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
                    <button class="btn btn-theme me-2 btn-buy add-to-cart"><i class="fa fa-shopping-cart"></i> Add
                        to
                        Cart</button>
                </div>
                <a href="{{ route('cart.view') }}" class="btn-theme btn-buy">View Cart</a>
            </div>
            @endif

            <p class="mt-3 mb-3">{!! $product->short_description !!}</p>

        </div>


        <style>
        .carousel-control-prev-icon,.carousel-control-next-icon {
            background-color: black;
        }
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
                    <div class="col-12 col-md-3">
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
        $('.variant-option').on('click', function() {
            $('.variant-option').removeClass('active').css('border-color', '#dee2e6');
            $(this).addClass('active').css('border-color', '#0d6efd');
            $(this).find('input[type="radio"]').prop('checked', true);
        });

		$('.add-to-cart').click(function() {
			var productId = $(this).closest('.product').data('id');
            var selectedVariantId = $('input[name="selected_variant"]:checked').val();

			$.ajax({
				url: '{{ route('cart.add') }}',
				method: 'POST',
				data: {
					product_id: productId,
					variant_id: selectedVariantId,
					_token: '{{ csrf_token() }}'
				},
				success: function(response) {
					console.log(response);

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
