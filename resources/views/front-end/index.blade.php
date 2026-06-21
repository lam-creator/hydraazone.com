<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hydraa - Premium Home Collection</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

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
            padding: 15px;
            text-align: center;
            border: 1px solid #eaeaea;
            transition: 0.3s;
            height: 100%;
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
        .product-title { font-size: 14px; font-weight: 500; margin-bottom: 5px; flex-grow: 1;}
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
</head>
<body>

    <!-- Header -->
    <header class="py-3 py-lg-4">
        <div class="container d-flex align-items-center justify-content-between">
            <!-- Logo -->
            <a href="#" class="d-flex align-items-center text-decoration-none">
                {{-- <h2 class="m-0 serif-font text-dark fw-bold fs-3 fs-lg-2">HYDRAA<span class="text-primary-theme">ZONE</span></h2> --}}
                <img src="https://placehold.co/150x60?text=HYDRAA-ZONE" alt="HYDRAA ZONE">
            </a>

            <!-- Search (Desktop) -->
            <div class="search-form d-none d-lg-flex mx-4">
                <select>
                    <option>All Categories</option>
                </select>
                <input type="text" placeholder="Search for products...">
                <button type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>

            <!-- User Actions -->
            <div class="d-flex gap-3 gap-lg-4 align-items-center">
                <div class="icon-box">
                    <i class="fa-regular fa-user"></i>
                    <div class="font-12 d-none d-lg-block">Login / Register</div>
                </div>
                <div class="icon-box">
                    <i class="fa-regular fa-heart"></i>
                    <span class="badge-count">0</span>
                    <div class="font-12 d-none d-lg-block">Wishlist</div>
                </div>
                <div class="icon-box">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span class="badge-count">0</span>
                    <div class="font-12 d-none d-lg-block">Cart</div>
                </div>

                <!-- Mobile Menu Toggler -->
                <button class="navbar-toggler d-lg-none border-0 bg-transparent fs-2 text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#mobileNavMenu">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
        </div>
    </header>

    <!-- Navigation -->
    <div class="nav-menu-wrapper mb-4 position-relative">
        <nav class="container navbar navbar-expand-lg py-0">
            <div class="d-flex w-100 align-items-center pb-2 pb-lg-3">

                <!-- Desktop "All Categories" Dropdown -->
                <div class="dropdown d-none d-lg-block me-4">
                    <button class="all-categories-btn border-0 d-flex align-items-center gap-2 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-bars"></i> All Categories
                    </button>
                    <ul class="dropdown-menu mt-2 shadow-sm border-0">
                        <li><a class="dropdown-item py-2" href="#">Dining Table Covers</a></li>
                        <li><a class="dropdown-item py-2" href="#">Table Runners</a></li>
                        <li><a class="dropdown-item py-2" href="#">Tea Table Covers</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item py-2" href="#">Home Appliances</a></li>
                        <li><a class="dropdown-item py-2" href="#">Kitchen Accessories</a></li>
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
                            <a href="#" class="nav-link active-link">Home</a>
                        </li>

                        <!-- Responsive Dropdown for Shop -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Shop
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">All Products</a></li>
                                <li><a class="dropdown-item" href="#">New Arrivals</a></li>
                                <li><a class="dropdown-item" href="#">Best Sellers</a></li>
                            </ul>
                        </li>

                        <li class="nav-item"><a href="#" class="nav-link">Dining Table Covers</a></li>
                        <li class="nav-item"><a href="#" class="nav-link">Table Runners</a></li>
                        <li class="nav-item"><a href="#" class="nav-link">Tea Table Covers</a></li>
                        <li class="nav-item"><a href="#" class="nav-link">Home Appliances</a></li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">Deals <span class="hot-badge">Hot</span></a>
                        </li>
                        <li class="nav-item"><a href="#" class="nav-link">Contact Us</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <!-- Hero Slider Section -->
    <section class="hero-section">
        <div id="mainHeroCarousel" class="carousel slide hero-carousel" data-bs-ride="carousel">

            <!-- Indicators -->
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#mainHeroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#mainHeroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#mainHeroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>

            <div class="carousel-inner">
                <!-- Slide 1 -->
                <div class="carousel-item active" data-bs-interval="5000">
                    <div class="container hero-carousel-item-inner">
                        <div class="row align-items-center flex-column-reverse flex-lg-row">
                            <div class="col-lg-6 mt-4 mt-lg-0">
                                <p class="text-primary-theme fw-bold mb-2 font-14">PREMIUM HOME COLLECTION</p>
                                <h1 class="hero-title serif-font">Beautiful Homes<br>Begin with <span class="text-primary-theme">Hydraa</span></h1>
                                <p class="text-muted mb-4 fs-6 fs-lg-5">From elegant table covers to smart home appliances, we bring quality and style to your everyday life.</p>
                                <div class="d-flex gap-3 mb-4 mb-lg-5">
                                    <button class="btn-theme">Shop Collection <i class="fa-solid fa-arrow-right ms-2"></i></button>
                                    <button class="btn-outline-theme">Explore Appliances</button>
                                </div>
                                <div class="d-flex gap-4 font-14 fw-medium text-dark flex-wrap">
                                    <span><i class="fa-solid fa-medal text-warning"></i> Premium Quality</span>
                                    <span><i class="fa-solid fa-pen-nib text-warning"></i> Elegant Designs</span>
                                    <span><i class="fa-solid fa-shield-halved text-warning"></i> 100% Authentic</span>
                                </div>
                            </div>
                            <div class="col-lg-6 position-relative">
                                <img src="https://placehold.co/800x550?text=Dining+Table+Setup" alt="Hero Image" class="hero-image shadow">
                                <div class="discount-badge">
                                    <div class="text-warning fw-bold mb-1 font-14">UP TO</div>
                                    <div class="fs-1 fw-bold lh-1 mb-2">30% <span class="fs-4">OFF</span></div>
                                    <div class="font-12 bg-warning text-dark px-2 py-1 rounded fw-bold">LIMITED TIME OFFER</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="carousel-item" data-bs-interval="5000">
                    <div class="container hero-carousel-item-inner">
                        <div class="row align-items-center flex-column-reverse flex-lg-row">
                            <div class="col-lg-6 mt-4 mt-lg-0">
                                <p class="text-primary-theme fw-bold mb-2 font-14">MODERN LIVING</p>
                                <h1 class="hero-title serif-font">Upgrade Your<br>Kitchen <span class="text-primary-theme">Today</span></h1>
                                <p class="text-muted mb-4 fs-6 fs-lg-5">Discover our latest range of smart appliances. Efficiency meets elegant design.</p>
                                <div class="d-flex gap-3 mb-4 mb-lg-5">
                                    <button class="btn-theme">Shop Appliances <i class="fa-solid fa-arrow-right ms-2"></i></button>
                                </div>
                                <div class="d-flex gap-4 font-14 fw-medium text-dark flex-wrap">
                                    <span><i class="fa-solid fa-bolt text-warning"></i> Energy Efficient</span>
                                    <span><i class="fa-solid fa-award text-warning"></i> 2 Years Warranty</span>
                                </div>
                            </div>
                            <div class="col-lg-6 position-relative">
                                <img src="https://placehold.co/800x550?text=Smart+Appliances" alt="Appliances" class="hero-image shadow">
                                <div class="discount-badge">
                                    <div class="text-warning fw-bold mb-1 font-14">SPECIAL DEAL</div>
                                    <div class="fs-1 fw-bold lh-1 mb-2">15% <span class="fs-4">OFF</span></div>
                                    <div class="font-12 bg-warning text-dark px-2 py-1 rounded fw-bold">ON ALL MICROWAVES</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slide 3 -->
                <div class="carousel-item" data-bs-interval="5000">
                    <div class="container hero-carousel-item-inner">
                        <div class="row align-items-center flex-column-reverse flex-lg-row">
                            <div class="col-lg-6 mt-4 mt-lg-0">
                                <p class="text-primary-theme fw-bold mb-2 font-14">NEW ARRIVALS</p>
                                <h1 class="hero-title serif-font">Elegant Details<br>For Every <span class="text-primary-theme">Occasion</span></h1>
                                <p class="text-muted mb-4 fs-6 fs-lg-5">Shop our exclusive new collection of table runners and intricate tea table covers.</p>
                                <div class="d-flex gap-3 mb-4 mb-lg-5">
                                    <button class="btn-theme">View Arrivals <i class="fa-solid fa-arrow-right ms-2"></i></button>
                                </div>
                                <div class="d-flex gap-4 font-14 fw-medium text-dark flex-wrap">
                                    <span><i class="fa-solid fa-leaf text-warning"></i> Eco-Friendly Materials</span>
                                    <span><i class="fa-solid fa-truck-fast text-warning"></i> Express Delivery</span>
                                </div>
                            </div>
                            <div class="col-lg-6 position-relative">
                                <img src="https://placehold.co/800x550?text=Luxury+Table+Runners" alt="Table Runners" class="hero-image shadow">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Shop by Collection -->
    <section class="container my-5">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-end mb-4 gap-2">
            <h3 class="fw-bold m-0">Shop by Collection</h3>
            <a href="#" class="text-primary-theme fw-medium">Browse All Categories <i class="fa-solid fa-arrow-right"></i></a>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4">
            <!-- Col 1 -->
            <div class="col">
                <div class="collection-card">
                    <img src="https://placehold.co/300x250?text=Dining+Table" alt="Category">
                    <div class="d-flex align-items-center justify-content-center gap-2">
                        <i class="fa-solid fa-table"></i>
                        <div class="text-start">
                            <div class="fw-bold font-14">Dining Table Covers</div>
                            <div class="text-muted font-12">50+ Products</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Col 2 -->
            <div class="col">
                <div class="collection-card">
                    <img src="https://placehold.co/300x250?text=Table+Runners" alt="Category">
                    <div class="d-flex align-items-center justify-content-center gap-2">
                        <i class="fa-solid fa-scroll"></i>
                        <div class="text-start">
                            <div class="fw-bold font-14">Table Runners</div>
                            <div class="text-muted font-12">30+ Products</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Col 3 -->
            <div class="col">
                <div class="collection-card">
                    <img src="https://placehold.co/300x250?text=Tea+Table" alt="Category">
                    <div class="d-flex align-items-center justify-content-center gap-2">
                        <i class="fa-solid fa-mug-saucer"></i>
                        <div class="text-start">
                            <div class="fw-bold font-14">Tea Table Covers</div>
                            <div class="text-muted font-12">40+ Products</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Col 4 -->
            <div class="col">
                <div class="collection-card">
                    <img src="https://placehold.co/300x250?text=Appliances" alt="Category">
                    <div class="d-flex align-items-center justify-content-center gap-2">
                        <i class="fa-solid fa-blender"></i>
                        <div class="text-start">
                            <div class="fw-bold font-14">Home Appliances</div>
                            <div class="text-muted font-12">100+ Products</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Col 5 Promo -->
            <div class="col">
                <div class="promo-card">
                    <div class="text-warning font-12 fw-bold mb-2">TODAY'S DEAL</div>
                    <h4 class="fw-bold mb-4 fs-5">Best Deals<br>You Can't Miss!</h4>
                    <button class="btn btn-warning fw-bold font-14" style="width: fit-content;">View Deals</button>
                    <img src="https://placehold.co/100x100?text=Gift" class="position-absolute bottom-0 end-0 m-2" style="width:60px" alt="">
                </div>
            </div>
        </div>
    </section>

    <!-- Banner Section -->
    <section class="container my-5">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="banner-card banner-dark" style="background-image: linear-gradient(to right, #1a1a1a 60%, transparent), url('https://placehold.co/600x300?text=Smart+Appliances');">
                    <div class="w-75">
                        <h2 class="serif-font mb-3 fs-3">Upgrade Your Home<br>With <span class="text-warning">Smart Appliances</span></h2>
                        <p class="font-14 text-light mb-4">High performance. Modern design. Trusted brands.</p>
                        <button class="btn btn-light fw-bold font-14 px-3 py-2">Shop Appliances <i class="fa-solid fa-arrow-right ms-2"></i></button>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="banner-card banner-light" style="background-image: linear-gradient(to right, #f4ece4 60%, transparent), url('https://placehold.co/600x300?text=Dining+Set');">
                    <div class="w-75">
                        <h2 class="serif-font mb-3 fs-3">Dining That<br>Feels <span class="text-primary-theme">Special</span></h2>
                        <p class="font-14 text-muted mb-4">Discover premium table covers for every occasion.</p>
                        <button class="btn btn-outline-dark fw-bold font-14 px-3 py-2">Shop Table Covers <i class="fa-solid fa-arrow-right ms-2"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Bar -->
    <section class="container features-bar mb-5">
        <div class="row g-3">
            <div class="col-6 col-md-3 feature-item">
                <img src="https://placehold.co/32x32" alt="image" class="img-fluid">
                <div>
                    <div class="fw-bold font-14">Cash on Delivery</div>
                    <div class="text-muted font-12">Pay when you receive</div>
                </div>
            </div>
            <div class="col-6 col-md-3 feature-item">
                <img src="https://placehold.co/32x32" alt="image" class="img-fluid">
                <div>
                    <div class="fw-bold font-14">Fast Delivery</div>
                    <div class="text-muted font-12">Across Bangladesh</div>
                </div>
            </div>
            <div class="col-6 col-md-3 feature-item">
                <img src="https://placehold.co/32x32" alt="image" class="img-fluid">
                <div>
                    <div class="fw-bold font-14">Easy Returns</div>
                    <div class="text-muted font-12">7-day return policy</div>
                </div>
            </div>
            <div class="col-6 col-md-3 feature-item">
                <img src="https://placehold.co/32x32" alt="image" class="img-fluid">
                <div>
                    <div class="fw-bold font-14">Trusted Support</div>
                    <div class="text-muted font-12">We're here to help</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Picks Section -->
    <section class="container my-5">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-end mb-4 gap-2">
            <h3 class="fw-bold m-0">Popular Picks For You</h3>
            <a href="#" class="text-primary-theme fw-medium">View All Products <i class="fa-solid fa-arrow-right"></i></a>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4">
            <!-- Product 1 -->
            <div class="col">
                <div class="product-card">
                    <span class="product-badge">-25%</span>
                    <img src="https://placehold.co/300x300?text=Dining+Cover" alt="Product">
                    <div class="product-title">Premium Dining Table Cover</div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="product-price">৳1,450 <del>৳1,950</del></div>
                        <button class="cart-btn-small"><i class="fa-solid fa-cart-shopping"></i></button>
                    </div>
                </div>
            </div>
            <!-- Product 2 -->
            <div class="col">
                <div class="product-card">
                    <span class="product-badge">-20%</span>
                    <img src="https://placehold.co/300x300?text=Table+Runner" alt="Product">
                    <div class="product-title">Elegant Table Runner</div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="product-price">৳650 <del>৳810</del></div>
                        <button class="cart-btn-small"><i class="fa-solid fa-cart-shopping"></i></button>
                    </div>
                </div>
            </div>
            <!-- Product 3 -->
            <div class="col">
                <div class="product-card">
                    <span class="product-badge">-23%</span>
                    <img src="https://placehold.co/300x300?text=Tea+Cover" alt="Product">
                    <div class="product-title">Luxury Tea Table Cover</div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="product-price">৳750 <del>৳970</del></div>
                        <button class="cart-btn-small"><i class="fa-solid fa-cart-shopping"></i></button>
                    </div>
                </div>
            </div>
            <!-- Product 4 -->
            <div class="col">
                <div class="product-card">
                    <span class="product-badge">-18%</span>
                    <img src="https://placehold.co/300x300?text=Kettle" alt="Product">
                    <div class="product-title">Electric Kettle 1.8L</div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="product-price">৳1,350 <del>৳1,650</del></div>
                        <button class="cart-btn-small"><i class="fa-solid fa-cart-shopping"></i></button>
                    </div>
                </div>
            </div>
            <!-- Product 5 -->
            <div class="col">
                <div class="product-card">
                    <span class="product-badge">-15%</span>
                    <img src="https://placehold.co/300x300?text=Microwave" alt="Product">
                    <div class="product-title">Microwave Oven 20L</div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="product-price">৳8,990 <del>৳10,590</del></div>
                        <button class="cart-btn-small"><i class="fa-solid fa-cart-shopping"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Trust Banner -->
    <section class="trust-banner">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4 mb-4 mb-lg-0 text-center text-lg-start">
                    <h3 class="serif-font m-0 fs-2">Why Trust <span class="text-primary-theme">Us?</span></h3>
                </div>
                <div class="col-lg-8">
                    <div class="row text-white g-4">
                        <div class="col-sm-6 col-md-3 trust-item justify-content-center justify-content-lg-start">
                            <i class="fa-solid fa-circle-check"></i>
                            <div>
                                <div class="font-14 fw-bold">100% Authentic</div>
                                <div class="font-12 text-light">Products</div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3 trust-item justify-content-center justify-content-lg-start">
                            <i class="fa-solid fa-award"></i>
                            <div>
                                <div class="font-14 fw-bold">Official Warranty</div>
                                <div class="font-12 text-light">On All Items</div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3 trust-item justify-content-center justify-content-lg-start">
                            <i class="fa-solid fa-lock"></i>
                            <div>
                                <div class="font-14 fw-bold">Secure Payments</div>
                                <div class="font-12 text-light">100% Safe</div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3 trust-item justify-content-center justify-content-lg-start">
                            <i class="fa-solid fa-headset"></i>
                            <div>
                                <div class="font-14 fw-bold">Dedicated Customer</div>
                                <div class="font-12 text-light">Support</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row mb-5 g-4">
                <!-- Brand Info -->
                <div class="col-lg-3 col-md-6 text-center text-md-start">
                    <h2 class="serif-font fw-bold mb-3">HY<span class="text-primary-theme">DRA</span></h2>
                    <p class="font-12 text-muted mb-4">Your trusted destination for premium table covers, runners, tea table covers and home appliances.</p>
                    <div class="social-icons justify-content-center justify-content-md-start d-flex">
                        <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#"><i class="fa-brands fa-youtube"></i></a>
                        <a href="#"><i class="fa-brands fa-tiktok"></i></a>
                    </div>
                </div>

                <!-- Newsletter -->
                <div class="col-lg-3 col-md-6 text-center text-md-start">
                    <div class="footer-heading">Newsletter</div>
                    <p class="font-12 text-muted">Subscribe to get special offers, free giveaways, and deals.</p>
                    <div class="d-flex mt-3 justify-content-center justify-content-md-start">
                        <input type="email" class="newsletter-input" placeholder="Email address">
                        <button class="newsletter-btn font-14">Subscribe</button>
                    </div>
                </div>

                <!-- Links -->
                <div class="col-lg-2 col-md-4 col-6">
                    <div class="footer-heading">Quick Links</div>
                    <ul class="footer-links">
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Shop</a></li>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">Track Order</a></li>
                    </ul>
                </div>

                <!-- Customer Service -->
                <div class="col-lg-2 col-md-4 col-6">
                    <div class="footer-heading">Customer Service</div>
                    <ul class="footer-links">
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">Returns & Refunds</a></li>
                        <li><a href="#">Shipping Policy</a></li>
                        <li><a href="#">Terms & Conditions</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div class="col-lg-2 col-md-4">
                    <div class="footer-heading">Contact Us</div>
                    <ul class="footer-links">
                        <li class="d-flex gap-2"><i class="fa-solid fa-phone mt-1"></i> 01312-345678</li>
                        <li class="d-flex gap-2"><i class="fa-solid fa-envelope mt-1"></i> support@hydraazone.com</li>
                        <li class="d-flex gap-2"><i class="fa-solid fa-location-dot mt-1"></i> House 12, Road 5, Dhaka, Bangladesh</li>
                    </ul>
                </div>
            </div>

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center pt-4 border-top text-center text-md-start">
                <p class="font-12 text-muted mb-0">&copy; 2024 Hydraa. All Rights Reserved.</p>
                <div class="d-flex gap-2 mt-3 mt-md-0">
                    <img src="https://placehold.co/40x25?text=Visa" alt="Visa" class="rounded">
                    <img src="https://placehold.co/40x25?text=MC" alt="MasterCard" class="rounded">
                    <img src="https://placehold.co/40x25?text=Amex" alt="Amex" class="rounded">
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
