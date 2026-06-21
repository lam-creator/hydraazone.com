<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('seo')

    <!-- Bootstrap 5 CSS -->
    <link href="/front-end/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="/back-end/plugins/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="/front-end/css/style.css">
    <link rel="stylesheet" href="/front-end/css/responsive.css">

    @php
    $HeaderData = App\Models\WebsiteSettings::first();
    @endphp
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('uploads/logo/' . $HeaderData->logo) }}" />
    @stack('stylesheets')
</head>

<body>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container d-flex justify-content-between align-items-center">
            <div>
                <span>Support: <a href="tel:{{ $HeaderData->support_phone }}">{{ $HeaderData->support_phone }}</a>
                </span>
            </div>
            {{-- <div>
                <span>মাত্র ৩০০০ টাকার অর্ডারে</span>
            </div> --}}
            <div class="social-icons">
                <a href="{{ $HeaderData->facebook_url }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                <a href="{{ $HeaderData->youtube_url }}" target="_blank"><i class="fab fa-youtube"></i></a>
                <a href="{{ $HeaderData->instagram_url }}" target="_blank"><i class="fab fa-instagram"></i></a>
                <a href="{{ $HeaderData->twitter_url }}" target="_blank"><i class="fab fa-twitter"></i></a>

            </div>
        </div>
    </div>

    <!-- Navigation -->

    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <a class="navbar-brand" href="{{ route('home') }}">
                <!-- <img src="/api/placeholder/150/50" alt="Logo"> -->
                <img src="{{ asset('uploads/logo/' . $HeaderData->logo) }}" alt="{{ $HeaderData->company_name }}">
            </a>


            <!-- Move these outside the collapsing menu -->
            <div class="d-flex mobile-icons color-dark">

                @if (Auth::check())
                <a href="{{ route('user.dashboard') }}"><i class="fas fa-user"></i></a>
                <a href="{{ route('user.logout') }}"> <i class="fas fa-sign-out"></i></a>
                @else
                <!-- User is not logged in -->
                <a href="{{ route('user.login') }}"><i class="fas fa-user"></i></a>
                @endif

                <a href="{{ route('cart.view') }}"><i class="fas fa-shopping-cart"></i><span id="cart-count-1">
                        {{ count(session('cart', [])) }}</span></a>
            </div>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <!-- Your menu items -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}"><i class="fas fa-home"></i>Home</a>
                    </li>
                    <!-- Dropdown Menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="offersDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-gift"></i> Category
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="offersDropdown">
                            @php
                            $categories = App\Models\Category::where('status', 'active')->get();
                            @endphp

                            @if ($categories->isNotEmpty())
                            @foreach ($categories as $category)
                            <li><a class="dropdown-item"
                                    href="{{ route('categorywise-product', ['name' => $category->category_slug, 'id' => $category->id]) }}">{{ $category->name }}</a>
                            </li>
                            @endforeach
                            @endif
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.checkout') }}"><i class="fas fa-shopping-bag"></i>
                            Checkout</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}"><i class="fas fa-phone"></i> Contact</a>
                    </li>

                    @php
                        $PageLists = App\Models\Page::where('location', 'menu')->get();
                    @endphp
                    @foreach ($PageLists as $page)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ URL::to('/page') }}/{{ $page->slug }}/{{ $page->id }}"><i class="fas fa-file-alt"></i> {{ $page->title }}</a>
                        </li>
                    @endforeach

                </ul>
                <!-- Keep a copy for desktop if needed -->
                <div class="d-none d-lg-flex color-dark">

                    @if (Auth::check())
                    <a href="{{ route('user.dashboard') }}"><i class="fas fa-user"></i>
                        <!-- User is logged in -->
                        {{ Auth::user()->name }}
                    </a>
                    <a href="{{ route('user.logout') }}"> &nbsp; <i class="fas fa-lock"></i> Logout</a>
                    @else
                    <!-- User is not logged in -->
                    <a href="{{ route('user.login') }}"><i class="fas fa-user"></i> Login</a>
                    @endif

                    <a href="{{ route('cart.view') }}">&nbsp; <i class="fas fa-shopping-cart"></i>
                        <span id="cart-count-2"> {{ count(session('cart', [])) }}</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>
