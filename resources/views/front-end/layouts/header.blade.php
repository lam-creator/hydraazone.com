<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Seo data -->
    @yield('seo')

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="/back-end/plugins/sweetalert2/sweetalert2.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    @php
    $HeaderData = App\Models\WebsiteSettings::first();
    @endphp
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('uploads/logo/' . $HeaderData->logo) }}" />

    <style>
        /* CSS Variables */
        :root {
            --primary-color: #f38b00;
            --primary-hover: #d67a00;
            --text-dark: #1a1a1a;
            --text-light: #666666;
            --bg-light: #f9f9f9;
        }

        /* Base Typography */
        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-dark);
            background-color: #ffffff;
            overflow-x: hidden;
        }
        h1, h2, .serif-font {
            font-family: 'Playfair Display', serif;
        }
        a {
            text-decoration: none;
            color: inherit;
        }
        a:hover {
            color: var(--primary-color);
        }

        /* Utilities */
        .text-primary-theme { color: var(--primary-color) !important; }
        .bg-primary-theme { background-color: var(--primary-color); }
        .bg-light-theme { background-color: var(--bg-light); }
        .font-12 { font-size: 12px; }
        .font-14 { font-size: 14px; }

        .btn-theme {
            background-color: var(--primary-color);
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 10px 24px;
            font-weight: 500;
            white-space: nowrap;
        }
        .btn-theme:hover { background-color: var(--primary-hover); color: #fff; }
        .btn-outline-theme {
            border: 1px solid #ccc;
            background: #fff;
            padding: 10px 24px;
            border-radius: 4px;
            font-weight: 500;
            white-space: nowrap;
        }
        .btn-outline-theme:hover { background: var(--bg-light); }

        /* Top Bar */
        .top-bar {
            background-color: #1a1a1a;
            color: #ccc;
            font-size: 12px;
            padding: 8px 0;
        }
        .top-bar i { color: var(--primary-color); margin-right: 5px; }

        /* Main Header */
        .search-form {
            display: flex;
            border: 2px solid #eaeaea;
            border-radius: 6px;
            overflow: hidden;
            width: 100%;
            max-width: 600px;
        }
        .search-form select {
            border: none;
            background: #f4f4f4;
            padding: 0 15px;
            outline: none;
            border-right: 1px solid #ddd;
        }
        .search-form input {
            border: none;
            padding: 10px 15px;
            width: 100%;
            outline: none;
        }
        .search-form button {
            background: var(--primary-color);
            border: none;
            color: white;
            padding: 0 20px;
        }
        .icon-box { position: relative; text-align: center; font-size: 14px; cursor: pointer;}
        .icon-box i { font-size: 20px; margin-bottom: 2px;}
        .badge-count {
            position: absolute;
            top: -8px;
            right: -5px;
            background: var(--primary-color);
            color: white;
            font-size: 10px;
            border-radius: 50%;
            padding: 2px 5px;
            line-height: 1;
        }

        /* Navbar Menu & Dropdowns */
        .nav-menu-wrapper { border-bottom: 1px solid #eaeaea; }
        .all-categories-btn {
            background: var(--primary-color);
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
            font-weight: 500;
            white-space: nowrap;
        }
        .all-categories-btn::after {
            display: none; /* Hide default bootstrap dropdown arrow on this specific button */
        }
        .main-nav .nav-link {
            font-weight: 500;
            color: var(--text-dark);
            padding: 10px 15px;
            transition: color 0.3s;
        }
        .main-nav .nav-link:hover, .main-nav .nav-link:focus { color: var(--primary-color); }
        .active-link {
            color: var(--primary-color) !important;
            border-bottom: 2px solid #ffc107;
        }
        .dropdown-item:active {
            background-color: var(--primary-color);
        }
        .dropdown-item:hover {
            color: var(--primary-color);
            background-color: #fff9f0;
        }
        .hot-badge {
            background: red;
            color: white;
            font-size: 10px;
            padding: 2px 5px;
            border-radius: 3px;
            position: relative;
            top: -10px;
            left: -5px;
        }

        /* Desktop Nav Styles */
        @media (min-width: 992px) {
            .main-nav .nav-link { padding: 5px 12px; }
            /* Hover dropdowns for desktop (optional, Bootstrap defaults to click) */
            .dropdown:hover > .dropdown-menu {
                display: block;
                margin-top: 0;
            }
        }

        /* Mobile Nav Styles */
        @media (max-width: 991px) {
            .navbar-collapse {
                background: #fff;
                padding: 15px;
                border-radius: 8px;
                box-shadow: 0 10px 20px rgba(0,0,0,0.05);
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                z-index: 1000;
            }
            .main-nav .nav-link { border-bottom: 1px solid #eee; padding: 12px 15px;}
            .main-nav .nav-item:last-child .nav-link { border-bottom: none; }
            .active-link { border-bottom: none; border-left: 3px solid #ffc107; padding-left: 12px; }
            .dropdown-menu { border: none; background-color: #f9f9f9; padding-left: 15px; margin-top: 0; box-shadow: inset 0 3px 5px rgba(0,0,0,0.02);}
            .search-form { max-width: 100%; margin-top: 15px; }
        }

        /* Hero Carousel Section */
        .hero-section {
            background-color: #faf7f2;
            position: relative;
            overflow: hidden;
        }
        .hero-carousel-item-inner {
            padding: 40px 0 60px 0;
        }
        .hero-title { font-size: 3.5rem; line-height: 1.2; margin-bottom: 20px;}
        .hero-image { width: 100%; height: auto; border-radius: 8px; object-fit: cover; }
        .discount-badge {
            position: absolute;
            bottom: 30px;
            right: 30px;
            background: #111;
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            z-index: 2;
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }

        /* Custom Carousel Indicators */
        .hero-carousel .carousel-indicators {
            bottom: 10px;
            margin-bottom: 0;
        }
        .hero-carousel .carousel-indicators [data-bs-target] {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #d1c8b8;
            margin: 0 6px;
            border: none;
            opacity: 1;
            transition: all 0.3s ease;
        }
        .hero-carousel .carousel-indicators .active {
            background-color: var(--primary-color);
            transform: scale(1.2);
        }

        /* Categories / Products Grid */
        .collection-card {
            background: #fff;
            border-radius: 8px;
            padding: 0;
            text-align: center;
            transition: 0.3s;
            height: 100%;
            position: relative;
        }
        .collection-card:hover { box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        .collection-card img { width: 100%; border-radius: 6px; margin-bottom: 15px; }

        .promo-card {
            background: #111;
            color: white;
            border-radius: 8px;
            padding: 20px;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .banner-card {
            border-radius: 8px;
            padding: 40px;
            background-size: cover;
            background-position: center;
            height: 300px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .banner-dark { background-color: #1a1a1a; color: white; }
        .banner-light { background-color: #f4ece4; color: var(--text-dark); }

        /* Features Bar */
        .features-bar { border-top: 1px solid #eee; border-bottom: 1px solid #eee; padding: 20px 0; }
        .feature-item { display: flex; align-items: center; gap: 15px; }
        .feature-item i { font-size: 30px; color: var(--primary-color); }

        /* Product Cards */
        .product-card {
            border: 1px solid #eaeaea;
            border-radius: 8px;
            padding: 15px;
            position: relative;
            background: #fff;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .product-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: var(--primary-color);
            color: white;
            font-size: 12px;
            padding: 3px 8px;
            border-radius: 4px;
            z-index: 2;
        }
        .product-card img { width: 100%; border-radius: 6px; margin-bottom: 15px;}
        .product-title { font-size: 14px; font-weight: 500; margin-bottom: 5px; flex-grow: 1; height:45px;}
        .product-price { font-weight: 600; font-size: 16px; }
        .product-price del { color: #999; font-size: 13px; font-weight: 400; margin-left: 5px;}
        .cart-btn-small {
            background: none;
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
            border-radius: 50%;
            width: 35px;
            height: 35px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: 0.2s;
        }
        .cart-btn-small:hover { background: var(--primary-color); color: #fff;}

        /* Trust Banner */
        .trust-banner {
            background-color: #1a1a1a;
            color: white;
            padding: 40px 0;
        }
        .trust-item { display: flex; align-items: center; gap: 15px;}
        .trust-item i { font-size: 30px; color: var(--primary-color); }

        /* Footer */
        footer { background-color: #ffffff; padding: 50px 0 20px; border-top: 1px solid #eee;}
        .footer-heading { font-weight: 600; margin-bottom: 20px; font-size: 16px;}
        .footer-links { list-style: none; padding: 0;}
        .footer-links li { margin-bottom: 10px; font-size: 14px; color: var(--text-light);}
        .footer-links li a:hover { color: var(--primary-color); }
        .social-icons a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 35px; height: 35px;
            background: #eee;
            border-radius: 50%;
            color: #333;
            margin-right: 10px;
            transition: 0.3s;
        }
        .social-icons a:hover { background: var(--primary-color); color: #fff; }
        .newsletter-input {
            border: 1px solid #ddd;
            padding: 10px;
            width: calc(100% - 100px);
            border-radius: 4px 0 0 4px;
            outline: none;
        }
        .newsletter-btn {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 10px;
            border-radius: 0 4px 4px 0;
            width: 100px;
        }

        /* --- Additional Mobile Responsiveness Adjustments --- */
        @media (max-width: 991px) {
            .hero-title { font-size: 2.5rem; }
            .hero-carousel-item-inner { padding: 30px 0 50px 0; }
            .banner-card { padding: 30px 20px; height: auto; min-height: 250px; }
            .banner-card > .w-75 { width: 100% !important; }
        }
        @media (max-width: 767px) {
            .hero-title { font-size: 2rem; }
            .hero-section .d-flex.gap-4.font-14 { flex-direction: column; gap: 10px !important; }
            .discount-badge { bottom: 15px; right: 15px; padding: 15px; }
            .discount-badge .fs-1 { font-size: 1.8rem !important; }
            .feature-item { margin-bottom: 20px; flex-direction: column; text-align: center; }
            .feature-item div { text-align: center; }
        }
        @media (max-width: 575px) {
            .hero-section .d-flex.gap-3 { flex-direction: column; width: 100%; }
            .hero-section .btn-theme, .hero-section .btn-outline-theme { width: 100%; }
            .discount-badge { display: none; }
        }
    </style>

    @stack('stylesheets')

</head>
<body>

    <!-- Header -->
    <header class="py-3 py-lg-4">
        <div class="container d-flex align-items-center justify-content-between">
            <!-- Logo -->


            {{-- if logo is null show company_name else show logo--}}
            @if ($HeaderData->logo == null)
                <a href="{{ route('home') }}" class="d-flex align-items-center text-decoration-none" >
                    <h2 class="m-0 serif-font text-dark fw-bold fs-3 fs-lg-2">{{ $HeaderData->company_name }}</h2>
                </a>
            @else
                <a href="{{ route('home') }}" class="d-flex align-items-center text-decoration-none">
                    <img src="/uploads/logo/{{ $HeaderData->logo }}" alt="{{ $HeaderData->company_name }}" >
                </a>
            @endif

            <!-- Search (Desktop) -->
            <div class="search-form d-none d-lg-flex mx-4">
                <input type="text" placeholder="Search for products...">
                <button type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>

            <!-- User Actions -->
            <div class="d-flex gap-3 gap-lg-4 align-items-center">

                <div class="icon-box">

                    @if (Auth::check())

                    <a href="{{ route('user.dashboard') }}">
                        <i class="fa-regular fa-user"></i>
                        <div class="font-12 d-none d-lg-block">Dashboard</div>
                    </a>

                    @else

                    <!-- User is not logged in -->
                    <a href="{{ route('user.login') }}">
                        <i class="fa-regular fa-user"></i>
                        <div class="font-12 d-none d-lg-block">Login / Register</div>
                    </a>

                    @endif

                </div>

                @if (Auth::check())

                <div class="icon-box">
                    <a href="{{ route('user.logout') }}">
                        <i class="fa fa-sign-out"></i>
                        <div class="font-12 d-none d-lg-block">Logout</div>
                    </a>
                </div>

                @endif

                <div class="icon-box">
                    <a href="{{ route('cart.view') }}">
                        <i class="fa-solid fa-cart-shopping"></i>
                        {{-- <span class="badge-count">0</span> --}}
                        <span class="badge-count" id="cart-count-1">{{ count(session('cart', [])) }}</span>
                        <div class="font-12 d-none d-lg-block">Cart</div>
                    </a>
                </div>

                <!-- Mobile Menu Toggler -->
                <button class="navbar-toggler d-lg-none border-0 bg-transparent fs-2 text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#mobileNavMenu">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
        </div>
    </header>

    <!-- Navigation -->
    <div class="nav-menu-wrapper mb-2 position-relative">
        <nav class="container navbar navbar-expand-lg py-0">
            <div class="d-flex w-100 align-items-center pb-2 pb-lg-3">

                <!-- Desktop "All Categories" Dropdown -->
                <div class="dropdown d-none d-lg-block me-4">
                    <button class="all-categories-btn border-0 d-flex align-items-center gap-2 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-bars"></i> All Categories
                    </button>
                    <ul class="dropdown-menu shadow-sm border-0">

                        @php
                        $categories = App\Models\Category::where('status', 'active')->get();
                        @endphp

                        @if ($categories->isNotEmpty())
                        @foreach ($categories as $category)
                        <li><a class="dropdown-item py-2" href="{{ route('categorywise-product', ['name' => $category->category_slug, 'id' => $category->id]) }}">{{ $category->name }}</a>
                        </li>
                        @endforeach
                        @endif

                    </ul>
                </div>

                <div class="collapse navbar-collapse" id="mobileNavMenu">
                    <!-- Mobile Search (Visible only on small screens) -->
                    <div class="search-form d-flex d-lg-none mb-3">
                        <input type="text" placeholder="Search for products...">
                        <button type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>

                    <!-- Main Navigation Links (Responsive) -->
                    <ul class="navbar-nav main-nav flex-grow-1 justify-content-lg-between w-100">
                        <li class="nav-item">
                            <a href="{{ route('home') }}" class="nav-link">Home</a>
                        </li>

                        <!-- Responsive Dropdown for Categories -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Categories
                            </a>
                            <ul class="dropdown-menu">

                                @if ($categories->isNotEmpty())
                                @foreach ($categories as $category)
                                <li><a class="dropdown-item" href="{{ route('categorywise-product', ['name' => $category->category_slug, 'id' => $category->id]) }}">{{ $category->name }}</a>
                                </li>
                                @endforeach
                                @endif

                            </ul>
                        </li>

                        @php
                            $MenuLinks = App\Models\Link::where('location', 'menu')->get();
                        @endphp

                        @foreach ($MenuLinks as $menuLink)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ $menuLink->link }}" target="_blank">{{ $menuLink->title }}</a>
                            </li>
                        @endforeach

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.checkout') }}">Checkout</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                        </li>

                        @php
                            $PageLists = App\Models\Page::where('location', 'menu')->get();
                        @endphp
                        @foreach ($PageLists as $page)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ URL::to('/page') }}/{{ $page->slug }}/{{ $page->id }}">{{ $page->title }}</a>
                            </li>
                        @endforeach

                    </ul>
                </div>
            </div>
        </nav>
    </div>
