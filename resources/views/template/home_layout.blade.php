<!DOCTYPE html>
<html lang="en">
<head>
<!-- Meta -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="Anil z" name="author">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="description" content="Shopwise is Powerful features and You Can Use The Perfect Build this Template For Any eCommerce Website. The template is built for sell Fashion Products, Shoes, Bags, Cosmetics, Clothes, Sunglasses, Furniture, Kids Products, Electronics, Stationery Products and Sporting Goods.">
<meta name="keywords" content="ecommerce, electronics store, Fashion store, furniture store,  bootstrap 4, clean, minimal, modern, online store, responsive, retail, shopping, ecommerce store">

<!-- SITE TITLE -->
<title>Mogo Ohana Store - Buy Monopoly GO Items at the Best Prices! 🎲</title>
<!-- Favicon Icon -->
<link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/')}}/images/logo.png">
<!-- Animation CSS -->
<link rel="stylesheet" href="{{ asset('assets/')}}/css/animate.css">
<!-- Latest Bootstrap min CSS -->
<link rel="stylesheet" href="{{ asset('assets/')}}/bootstrap/css/bootstrap.min.css">
<!-- Google Font -->
<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
<!-- Icon Font CSS -->
<link rel="stylesheet" href="{{ asset('assets/')}}/css/all.min.css">
<link rel="stylesheet" href="{{ asset('assets/')}}/css/ionicons.min.css">
<link rel="stylesheet" href="{{ asset('assets/')}}/css/themify-icons.css">
<link rel="stylesheet" href="{{ asset('assets/')}}/css/linearicons.css">
<link rel="stylesheet" href="{{ asset('assets/')}}/css/flaticon.css">
<link rel="stylesheet" href="{{ asset('assets/')}}/css/simple-line-icons.css">
<!--- owl carousel CSS-->
<link rel="stylesheet" href="{{ asset('assets/')}}/owlcarousel/css/owl.carousel.min.css">
<link rel="stylesheet" href="{{ asset('assets/')}}/owlcarousel/css/owl.theme.css">
<link rel="stylesheet" href="{{ asset('assets/')}}/owlcarousel/css/owl.theme.default.min.css">
<!-- Magnific Popup CSS -->
<link rel="stylesheet" href="{{ asset('assets/')}}/css/magnific-popup.css">
<!-- jquery-ui CSS -->
<link rel="stylesheet" href="{{ asset('assets/')}}/css/jquery-ui.css">
<!-- Slick CSS -->
<link rel="stylesheet" href="{{ asset('assets/')}}/css/slick.css">
<link rel="stylesheet" href="{{ asset('assets/')}}/css/slick-theme.css">
<!-- Style CSS -->
<link rel="stylesheet" href="{{ asset('assets/')}}/css/style.css">
<link rel="stylesheet" href="{{ asset('assets/')}}/css/responsive.css">

</head>
<style>
    /* Video full screen */
    .video-container {
        position: relative;
        width: 100%;
        height: 100vh;
        overflow: hidden;
    }

    .video-background {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Overlay gelap untuk meningkatkan kontras */
    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.4); /* Overlay gelap */
    }

    /* Container teks agar lebih menonjol */
    .banner_content2 {
        position: relative;
        z-index: 2;
    }

    /* Background overlay untuk teks */
    .text-overlay {
        background: rgba(0, 0, 0, 0.6); /* Transparansi hitam untuk teks */
        padding: 20px;
        border-radius: 10px;
        display: inline-block;
    }

    /* Shadow pada teks */
    .text-overlay h6,
    .text-overlay h2,
    .text-overlay p,
    .text-overlay a {
        text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.8);
    }
    </style>
<body>

<!-- LOADER -->
{{-- <div class="preloader">
    <div class="lds-ellipsis">
        <span></span>
        <span></span>
        <span></span>
    </div>
</div> --}}
<!-- END LOADER -->


<!-- START HEADER -->
<header class="header_wrap fixed-top header_with_topbar">
	<div class="top-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                	<div class="d-flex align-items-center justify-content-center justify-content-md-start">
                        <ul class="contact_detail text-center text-lg-start">
                            <li><i class="ti-mobile"></i><span>123-456-7890</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                	<div class="text-center text-md-end">
                       	<ul class="header_list">
                        	<li><a href="{{ route('login.index')}}"><i class="ti-user"></i><span>Login</span></a></li>
						</ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom_header dark_skin main_menu_uppercase">
    	<div class="container">
            <nav class="navbar navbar-expand-lg">
                <a class="navbar-brand" href="{{ route('home.index')}}">
                    <img class="logo_light" src="{{ asset('assets/')}}/images/logo.png" alt="logo" />
                    <img class="logo_dark" src="{{ asset('assets/')}}/images/logo.png" width="150" alt="logo" />
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-expanded="false">
                    <span class="ion-android-menu"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <li>
                            <a class="nav-link {{ request()->routeIs('home.index') ? 'active' : '' }}" href="{{ route('home.index')}}">Home</a>
                        </li>
                        <li>
                            <a class="nav-link {{ request()->routeIs('about.index') ? 'active' : '' }}" href="{{ route('about.index')}}">About</a>
                        </li>
                        <li>
                            <a class="nav-link {{ request()->routeIs('shop.index') || request()->routeIs('shop-detail.index') ? 'active' : '' }}" href="{{ route('shop.index')}}">Shop </a>
                        </li>
                        <li>
                            <a class="nav-link {{ request()->routeIs('blog-a.index') ? 'active' : '' }}" href="{{ route('blog-a.index')}}">Blog</a>
                        </li>
                        <li>
                            <a class="nav-link {{ request()->routeIs('contact.index') ? 'active' : '' }}" href="{{ route('contact.index')}}">Contact</a>
                        </li>
                    </ul>
                </div>
                <ul class="navbar-nav attr-nav align-items-center">
                    <li><a href="javascript:void(0);" class="nav-link search_trigger"><i class="linearicons-magnifier"></i></a>
                        <div class="search_wrap">
                            <span class="close-search"><i class="ion-ios-close-empty"></i></span>
                            <form action="{{ route('shop.index') }}" method="GET" onsubmit="return validateSearch(event)">
                                <input type="text" placeholder="Search" name="search" class="form-control" id="search_input"  value="{{ request('search') }}">
                                <button type="submit" class="search_icon"><i class="ion-ios-search-strong"></i></button>
                            </form>
                        </div><div class="search_overlay"></div><div class="search_overlay"></div>
                    </li>
                    @php
                        $cartItemCount = \App\Models\Cart::when(Auth::check(), function($query) {
                            return $query->where('user_id', Auth::id());
                        })
                        ->when(!Auth::check(), function($query) {
                            return $query->where('session_id', Session::getId());
                        })
                        ->distinct('produk_id')
                        ->count('produk_id');
                    @endphp
                    <li class="dropdown cart_dropdown">
                        <a class="nav-link cart_trigger" href="{{ route('shop-cart.index') }}" data-bs-toggle="dropdown">
                            <i class="linearicons-cart"></i>
                            <span class="cart_count">{{ $cartItemCount }}</span>
                        </a>
                        <div class="cart_box dropdown-menu dropdown-menu-right cartku">
                            @php
                                $cartItems = \App\Models\Cart::with('produk')
                                    ->when(Auth::check(), function($query) {
                                        return $query->where('user_id', Auth::id());
                                    })
                                    ->when(!Auth::check(), function($query) {
                                        return $query->where('session_id', Session::getId());
                                    })
                                    ->get();

                                $cartTotal = $cartItems->sum(function($item) {
                                    return $item->produk->harga * $item->quantity;
                                });
                            @endphp

                            @if($cartItems->count() > 0)
                                <ul class="cart_list">

                                    @foreach($cartItems as $item)
                                    <li>
                                        <a href="{{ route('shop-detail.index', $item->produk->id) }}"><img alt="{{ $item->produk->nama_produk }}"
                                            src="{{ asset('storage/' . $item->produk->foto) }}">{{ Str::limit($item->produk->nama_produk, 18) }}</a>
                                        <span class="cart_quantity"> {{ $item->quantity }} x <span class="cart_amount"> <span class="price_symbole">$</span></span>{{ number_format($item->produk->harga, 0) }}</span>
                                    </li>
                                    @endforeach

                                </ul>
                                <div class="cart_footer">
                                    <p class="cart_total"><strong>Subtotal:</strong> <span class="cart_price"> <span class="price_symbole">$</span></span>{{ number_format($cartTotal, 0) }}</p>
                                    <p class="cart_buttons"><a href="{{ route('shop-cart.index') }}" class="btn btn-fill-line btn-radius view-cart">View Cart</a><a href="{{ route('shop-checkout.index') }}" class="btn btn-fill-out btn-radius checkout">Checkout</a></p>
                                </div>
                            @else
                                <div class="text-center">
                                    <p>Your cart is empty</p>
                                </div>
                            @endif
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>
<!-- END HEADER -->



<!-- END MAIN CONTENT -->
<div class="main_content">
    @yield('content')
    <!-- START SECTION FAQ -->
    <div class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="heading_s1 mb-3 mb-md-5">
                        <h3>General questions</h3>
                    </div>
                    <div id="accordion" class="accordion accordion_style1">
                        @foreach($faqs as $index => $faq)
                        <div class="card">
                            <div class="card-header" id="headingOne{{ $index }}">
                                <h6 class="mb-0"> <a class="collapsed" data-bs-toggle="collapse" href="#collapseOne{{ $index }}" aria-expanded="false" aria-controls="collapseOne">{{ $faq->pertanyaan }}</a> </h6>
                            </div>
                            <div id="collapseOne{{ $index }}" class="collapse" aria-labelledby="headingOne{{ $index }}" data-bs-parent="#accordion" style="">
                                <div class="card-body">
                                    <p>{!! $faq->jawaban !!}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END SECTION FAQ -->
</div>
<!-- END MAIN CONTENT -->

<!-- START FOOTER -->
<footer class="footer_dark">
	<div class="footer_top">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12">
                	<div class="widget">
                        <h6 class="widget_title">Contact info</h6>
                        <ul class="contact_info contact_info_light">
                            <li>
                                <i class="ti-location-pin"></i>
                                <p>Jakarta, Indonesia</p>
                            </li>
                            <li>
                                <i class="ti-mobile"></i>
                                <p>(+62) - 898 - 5288 - 600</p>
                            </li>
                        </ul>
                    </div>
                    <div class="widget">
                        <ul class="social_icons rounded_social">
                            <li><a href="{{ $contact_view->link_facebook ?? '#' }}"><i class="ion-social-facebook"></i></a></li>
                            <li><a href="{{ $contact_view->link_wa ?? '#' }}" ><i class="ion-social-whatsapp"></i></a></li>
                            <li><a href="{{ $contact_view->link_instagram ?? '#' }}"><i class="ion-social-instagram-outline"></i></a></li>
                        </ul>
                    </div>
        		</div>
                <div class="col-lg-2 col-md-3 col-sm-6">
                	<div class="widget">
                        <h6 class="widget_title">Useful Links</h6>
                        <ul class="widget_links">
                            <li><a href="{{ route('about.index')}}">About Us</a></li>
                            <li>FAQ</li>
                            <li><a href="{{ route('contact.index')}}">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6">
                	<div class="widget">
                        <h6 class="widget_title">Category</h6>
                        <ul class="widget_links">
                            @foreach($category as $index => $cat)
                            <li><a href="{{ route('shop.index', ['category' => $cat->slug]) }}">{{ $cat->kategori }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6">
                	<div class="widget">
                        <h6 class="widget_title">Policy</h6>
                        <ul class="widget_links">
                            <li><a href="{{ route('privacy.index')}}">Privacy Policy</a></li>
                            <li><a href="{{ route('terms.index')}}">Terms &amp; Conditions</a></li>
                            <li><a href="{{ route('refund.index')}}">Refund Policy</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6">
                	<div class="widget">
                        <h6 class="widget_title">My Account</h6>
                        <ul class="widget_links">
                            <li><a href="#">My Account</a></li>
                            <li><a href="#">View Cart</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom_footer border-top-tran">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-md-0 text-center text-md-start"> 2025 All Rights Reserved by Itboy</p>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- END FOOTER -->

<a href="#" class="scrollup" style="display: none;"><i class="ion-ios-arrow-up"></i></a>

<!-- Latest jQuery -->
<script src="{{ asset('assets/')}}/js/jquery-3.6.0.min.js"></script>
<!-- jquery-ui -->
<script src="{{ asset('assets/')}}/js/jquery-ui.js"></script>
<!-- popper min js -->
<script src="{{ asset('assets/')}}/js/popper.min.js"></script>
<!-- Latest compiled and minified Bootstrap -->
<script src="{{ asset('assets/')}}/bootstrap/js/bootstrap.min.js"></script>
<!-- owl-carousel min js  -->
<script src="{{ asset('assets/')}}/owlcarousel/js/owl.carousel.min.js"></script>
<!-- magnific-popup min js  -->
<script src="{{ asset('assets/')}}/js/magnific-popup.min.js"></script>
<!-- waypoints min js  -->
<script src="{{ asset('assets/')}}/js/waypoints.min.js"></script>
<!-- parallax js  -->
<script src="{{ asset('assets/')}}/js/parallax.js"></script>
<!-- countdown js  -->
<script src="{{ asset('assets/')}}/js/jquery.countdown.min.js"></script>
<!-- imagesloaded js -->
<script src="{{ asset('assets/')}}/js/imagesloaded.pkgd.min.js"></script>
<!-- isotope min js -->
<script src="{{ asset('assets/')}}/js/isotope.min.js"></script>
<!-- jquery.dd.min js -->
<script src="{{ asset('assets/')}}/js/jquery.dd.min.js"></script>
<!-- slick js -->
<script src="{{ asset('assets/')}}/js/slick.min.js"></script>
<!-- elevatezoom js -->
<script src="{{ asset('assets/')}}/js/jquery.elevatezoom.js"></script>
<!-- scripts js -->
@yield('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script src="{{ asset('js/price-filter.js') }}"></script>
<script src="{{ asset('js/cart.js') }}"></script>
@yield('scripts')
<script src="{{ asset('assets/')}}/js/scripts.js"></script>

</body>
</html>
