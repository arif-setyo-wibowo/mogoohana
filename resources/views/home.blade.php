@extends('template.home_layout')
@section('content')
<!-- START SECTION BANNER -->
<div class="banner_section slide_wrap shop_banner_slider staggered-animation-wrap">
    <div id="carouselExampleControls" class="carousel slide carousel-fade light_arrow" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="video-container">
                    <video autoplay loop muted playsinline class="video-background">
                        <source src="{{ asset('assets/video/homeBanner_enus.mp4') }}" type="video/mp4">
                    </video>
                    <div class="overlay"></div>
                </div>
                <div class="banner_slide_content banner_content_inner d-flex align-items-center justify-content-center text-center">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8 col-md-10 col-sm-10">
                                <div class="banner_content2 p-4">
                                    <div class="text-overlay ">
                                        <h2 class="text-white staggered-animation" data-animation="fadeInDown" data-animation-delay="0.3s">Monopoly GO!</h2>
                                        <h2 class="text-white staggered-animation" data-animation="fadeInDown" data-animation-delay="0.3s">Store</h2>
                                        <a class="text-white btn btn-border-fill btn-radius staggered-animation text-uppercase" style="color: white !primary" href="{{ route('shop.index')}}" data-animation="fadeInUp" data-animation-delay="0.5s">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <ol class="carousel-indicators indicators_style2">
            <li data-bs-target="#carouselExampleControls" data-bs-slide-to="0" class="active"></li>
        </ol>
    </div>
</div>
<!-- END SECTION BANNER -->

<!-- START SECTION BANNER -->
<div class="section pb_20 small_pt">
    <div class="container">
        <div class="heading_s1">
            <h2 class="mb-4">Our Categories</h2>
        </div>
        <div class="row">
            @foreach($categories as $category)
            <div class="col-md-3 col-6">
                <div class="sale-banner mb-3 mb-md-4">
                    <a class="hover_effect1" href="{{ route('shop.index', ['category' => $category->slug]) }}">
                        <img src="{{ asset('storage/' . $category->foto) }}" alt="{{ $category->kategori }}">
                        <div class="banner_text text-center mt-2">
                            <h6>{{ $category->kategori }}</h6>
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<!-- END SECTION BANNER -->


<!-- START SECTION SHOP -->
<div class="section small_pb">
	<div class="container">
		<div class="row">
			<div class="col-12">
            	<div class="heading_tab_header">
                    <div class="heading_s2">
                        <h2>Products</h2>
                    </div>
                </div>
            </div>
		</div>
        <div class="row">
        	<div class="col-12">
                <div class="tab_slider">
                    <div class="tab-pane fade show active" id="category" role="tabpanel" aria-labelledby="arrival-tab">
                        @foreach($categories as $category)
                        <div class="heading_s2 mb-3">
                            <h4>{{ $category->kategori }}</h4>
                        </div>
                        <div class="product_slider carousel_slider owl-carousel owl-theme nav_style1 mb-4" 
                             data-loop="true" 
                             data-dots="false" 
                             data-nav="true" 
                             data-margin="20" 
                             data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "1199":{"items": "4"}}'>
                            @php
                                $categoryProducts = $products->where('id_kategori', $category->id)->take(5);
                            @endphp

                            @foreach($categoryProducts as $product)
                            <div class="item">
                                <div class="product">
                                    <div class="product_img">
                                        <a href="{{ route('shop-detail.index', ['slug' => $product->slug]) }}">
                                            <img src="{{ asset('storage/' . $product->foto) }}"
                                            alt="{{ $product->nama_produk }}"
                                            style="width: 100%; height: 250px; object-fit: cover; aspect-ratio: 1/1;">
                                        </a>
                                        <div class="product_action_box">
                                            <ul class="list_none pr_action_btn">
                                                <li class="add-to-cart">
                                                    <a href="javascript:void(0);" class="add add-to-cart-link" 
                                                        data-produk_id="{{ $product->id }}" 
                                                        data-quantity="1">
                                                        <i class="icon-basket-loaded"></i> Add To Cart
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product_info">
                                        <h6 class="product_title"><a href="{{ route('shop-detail.index', ['slug' => $product->slug]) }}">{{ $product->nama_produk }}</a></h6>
                                        <div class="product_price">
                                            <span class="price">$ {{ fmod($product->harga, 1) == 0 ? number_format($product->harga, 0, '.', '.') : number_format($product->harga, 2, '.', '.') }}</span>
                                            @if($product->harga_diskon > 0)
                                                <del>$ {{ fmod($product->harga_diskon, 1) == 0 ? number_format($product->harga_diskon, 0, '.', '.') : number_format($product->harga_diskon, 2, '.', '.') }}</del>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END SECTION SHOP -->

<!-- START SECTION BANNER -->
<div class="section bg_light_blue2 pb_70">
	<div class="container">
    	<div class="row justify-content-center">
        	<div class="col-lg-6 col-md-8">
            	<div class="heading_s1 text-center">
                	<h2>Why Choose Us?</h2>
                </div>
                <p class="text-center leads">At Mogo Ohana, we are committed to providing top-notch quality, cutting-edge innovation, and exceptional service to ensure your satisfaction. Here's why we're the best choice for you:</p>
            </div>
        </div>
        <div class="row justify-content-center">
        	<div class="col-lg-3 col-sm-6">
            	<div class="icon_box icon_box_style4 box_shadow1">
                	<div class="icon">
                    	<i class="ti-thumb-up"></i>
                    </div>
                    <div class="icon_box_content">
                    	<h5>Quality Service</h5>
                        <p>Our commitment to excellence has earned us the trust of clients.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
            	<div class="icon_box icon_box_style4 box_shadow1">
                	<div class="icon">
                    	<i class="ti-shield"></i>
                    </div>
                    <div class="icon_box_content">
                    	<h5>100% Safe</h5>
                        <p>We prioritize your security and ensure every transaction is protected.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
            	<div class="icon_box icon_box_style4 box_shadow1">
                	<div class="icon">
                    	<i class="ti-money"></i>
                    </div>
                    <div class="icon_box_content">
                    	<h5>Best Price</h5>
                        <p>We offer competitive pricing without compromising on quality.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
            	<div class="icon_box icon_box_style4 box_shadow1">
                	<div class="icon">
                    	<i class="ti-exchange-vertical"></i>
                    </div>
                    <div class="icon_box_content">
                    	<h5>Fast Refunds</h5>
                        <p>We provide hassle-free refunds for a seamless customer experience.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END SECTION BANNER -->



@endsection

@section('scripts')
<script src="{{ asset('js/cart.js') }}"></script>
@endsection
