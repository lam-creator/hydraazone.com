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
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('front-end/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('front-end/css/responsive.css') }}">
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

    {!! $HeaderData->custom_code_header !!}

    @stack('stylesheets')

</head>
<body>

    <!-- Header -->
    {{-- <header class="py-3 py-lg-4"> --}}
    <header class="sticky-top bg-white py-1 py-lg-1 shadow-sm">
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
            <form action="{{ route('products.search') }}" method="GET" class="search-form d-none d-lg-flex mx-4">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search for products..."
                >

                <button type="submit">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>

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
    <div class="nav-menu-wrapper mt-2 mb-2 position-relative">
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
                    <form action="{{ route('products.search') }}" method="GET" class="search-form d-flex d-lg-none mb-3">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search for products...">
                        <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </form>

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
                            <a class="nav-link" href="{{ route('order.track') }}">Track Order</a>
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
