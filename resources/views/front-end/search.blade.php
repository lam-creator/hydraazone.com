@extends('front-end.layouts.master')

@section('seo')
    <title>Search Results for "{{ $search }}" - {{ $SeoData->meta_title }} | {{ $SeoData->company_name }}</title>

    <meta name="description" content="Search results for '{{ $search }}' - {{ $SeoData->meta_description }}" />
    <meta name="keywords" content="{{ $search }}, search, products, {{ $SeoData->meta_keywords }}" />

    <!-- Open Graph -->
    <meta property="og:title" content="Search Results for '{{ $search }}' - {{ $SeoData->meta_title }}">
    <meta property="og:description" content="Search results for '{{ $search }}'">
    <meta property="og:image" content="{{ asset('uploads/logo/' . $SeoData->logo) }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta name="HandheldFriendly" content="True" />
    <meta name="pinterest" content="nopin" />

    <script type="application/ld+json">
    {
        "@context":"http://schema.org",
        "@type":"SearchResultsPage",
        "name":"Search Results for {{ $search }}"
    }
    </script>
@endsection

@section('content')

<style>
.product-card{
    margin-bottom:20px;
    overflow:hidden;
    transition:transform .3s;
    height:100%;
    box-shadow:0 5px 15px rgba(0,0,0,.1);
}

.product-card:hover{
    transform:translateY(-5px);
    box-shadow:0 5px 15px rgba(0,0,0,.1);
}

.product-card img{
    width:100%;
    border-radius:6px;
}

.product-image{
    max-width:100%;
    height:auto;
    box-shadow:0 5px 15px rgba(0,0,0,.1);
}

.discount-tag{
    position:absolute;
    top:15px;
    left:15px;
    background:var(--primary-color);
    color:#fff;
    padding:5px 10px;
    font-weight:bold;
    font-size:14px;
    border-radius:0 15px 15px 0;
    z-index:1;
}

.product-details{
    padding:10px;
    text-align:center;
}

.product-title{
    font-size:14px;
    font-weight:500;
    height:45px;
    margin:10px 0;
}

.product-price{
    font-weight:bold;
    color:var(--primary-color);
}

.original-price{
    text-decoration:line-through;
    color:#999;
    font-size:14px;
}

.discounted-price{
    font-size:16px;
    color:var(--primary-color);
}
</style>

<section class="container mb-5">

    <div class="text-separator">
        <hr class="d-none d-md-block">
        <h2 class="separator-text">
            Search Results for
            <span class="text-primary">"{{ $search }}"</span>
        </h2>
        <hr class="d-none d-md-block">
    </div>

    @if($products->count())
        <p class="text-center mb-4">
            Found <strong>{{ $products->total() }}</strong> product(s)
        </p>

        <div class="row">

            @foreach($products as $CategoryProduct)

            <div class="col-6 col-md-4 col-lg-3 mb-2">
                <div class="product-card">

                    <div class="product-image">

                        @if($CategoryProduct->discount_price > 0)
                            <span class="discount-tag">
                                Special Discount
                            </span>
                        @endif

                        <a href="{{ route('product-details',[
                            'category'=>$CategoryProduct->category->category_slug,
                            'name'=>$CategoryProduct->product_slug,
                            'id'=>$CategoryProduct->id
                        ]) }}">

                            <img
                                src="/uploads/product/{{ $CategoryProduct->image }}"
                                alt="{{ $CategoryProduct->name }}"
                                class="img-fluid">

                        </a>

                    </div>

                    <div class="product-details">

                        <a href="{{ route('product-details',[
                            'category'=>$CategoryProduct->category->category_slug,
                            'name'=>$CategoryProduct->product_slug,
                            'id'=>$CategoryProduct->id
                        ]) }}">

                            <h3 class="product-title">
                                {{ $CategoryProduct->name }}
                            </h3>

                        </a>

                        <div class="product-price">

                            @if($CategoryProduct->status=='active')

                                @if($CategoryProduct->discount_price>0)

                                    <span class="original-price">
                                        Tk{{ $CategoryProduct->sale_price }}
                                    </span>

                                    <span class="discounted-price">
                                        Tk{{ $CategoryProduct->discount_price }}
                                    </span>

                                @else

                                    <span class="discounted-price">
                                        Tk{{ $CategoryProduct->sale_price }}
                                    </span>

                                @endif

                            @endif

                        </div>

                        <div class="product"
                             data-id="{{ $CategoryProduct->id }}">

                            <button
                                class="m-2 btn-theme add-to-cart btn-add-cart">

                                <i class="fa fa-shopping-cart hide-in-mobile"></i>

                                Add to Cart

                            </button>

                        </div>

                    </div>

                </div>

            </div>

                        @endforeach

        </div>

        <div class="view-all mt-4">
            {{ $products->appends(['search' => request('search')])->links('vendor.pagination.bootstrap-5') }}
        </div>

    @else

        <div class="text-center py-5">

            <img src="{{ asset('front-end/images/no-data.svg') }}"
                 alt="No Products"
                 style="max-width:200px;"
                 class="mb-4"
                 onerror="this.style.display='none'">

            <h3>No products found</h3>

            <p class="text-muted">
                Sorry! We couldn't find any products matching
                <strong>"{{ $search }}"</strong>.
            </p>

            <a href="{{ url('/') }}" class="btn btn-theme mt-3">
                Continue Shopping
            </a>

        </div>

    @endif

</section>

@endsection


@push('scripts')

<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
    crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

@if(session('message'))
<script>
document.addEventListener('DOMContentLoaded', function () {

    Swal.fire({
        title: '{{ session("message") }}',
        icon: '{{ session("alert-type") }}',
        timer:3000,
        timerProgressBar:true
    });

    toastr.error('{{ session("message") }}');

});
</script>
@endif


<script>

$(document).ready(function(){

    $('.add-to-cart').click(function(){

        var productId=$(this).closest('.product').data('id');

        $.ajax({

            url:'{{ route("cart.add") }}',

            method:'POST',

            data:{

                product_id:productId,

                _token:'{{ csrf_token() }}'

            },

            success:function(response){

                if(response.message){

                    toastr.warning(response.message);

                }else{

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


