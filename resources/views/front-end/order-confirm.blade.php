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
    <style>
        .cart-btn {
            border-radius: 35px;
        }

        #account-panel li a {
            color: #fff;
            margin-bottom: 10px;
            background: #001d3d;
        }
    </style>


    <!-- Products Section 1 -->
    <section class="container mt-4 mb-5">
        <div class="row">

            <div class="text-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor"
                    class="mb-4 bi bi-check-circle text-success" viewBox="0 0 16 16">
                    <path
                        d="M15.854 8.354a.5.5 0 0 1 0-.708L10.707 2.5a.5.5 0 0 1 .708-.708l5.146 5.146a.5.5 0 0 1 0 .708l-5.146 5.146a.5.5 0 1 1-.708-.708l4.146-4.146zm-13.708 0a.5.5 0 0 1 .708-.708L7.5 10.793l3.646-3.647a.5.5 0 0 1 .708.708L7.5 12.207 2.146 6.854z" />
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                </svg>

                {{-- Display the success message --}}
                @if (session('message'))
                    <h1 class="display-5 fw-bold">{{ session('message') }}</h1>
                    <p class="lead">Thank you for your order! Your order has been successfully placed.</p>
                    <p class="text-muted">Order Number: <strong>ORD-{{ session('order_id') }}</strong></p>
                @endif

                @if (session('errormesssage'))
                    <h1 class="display-5 fw-bold">{{ session('errormesssage') }}</h1>
                    <p class="lead">{{ session('error') }}</p>
                @endif

                <br>
                <a href="/" class="mt-3 btn btn-primary">Continue Shopping</a>
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
                    title: '{{ session('message') }}',
                    icon: '{{ session('alert-type') }}', // 'error', 'success', 'warning', 'info'
                    // confirmButtonText: 'OK',
                    timer: 3000, // Auto close after 5 seconds
                    timerProgressBar: true,
                });

                toastr.success('{{ session('message') }}');
            });
        </script>
    @endif


@endpush
