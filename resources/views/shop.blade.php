@extends('template.home_layout')

@section('content')
<!-- START SECTION BREADCRUMB -->
<div class="breadcrumb_section bg_gray page-title-mini">
    <div class="container"><!-- STRART CONTAINER -->
        <div class="row align-items-center">
        	<div class="col-md-6">
                <div class="page-title">
            		<h1>Shop</h1>
                </div>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb justify-content-md-end">
                    <li class="breadcrumb-item"><a href="{{ route('home.index')}}">Home</a></li>
                    <li class="breadcrumb-item active">Shop</li>
                </ol>
            </div>
        </div>
    </div><!-- END CONTAINER-->
</div>
<!-- END SECTION BREADCRUMB -->

<!-- START SECTION SHOP -->
<div class="section">
	<div class="container">
    	<div class="row">
			<div class="col-lg-9">
            	<div class="row align-items-center mb-4 pb-1">
                    <div class="col-12">
                        <div class="product_header">
                            <div class="product_header_left">
                                <div class="custom_select">
                                    <select class="form-control form-control-sm" id="sort-select" onchange="window.location.href=this.value">
                                        <option value="{{ route('shop.index', request()->except('sort')) }}" 
                                            {{ !request('sort') ? 'selected' : '' }}>Default sorting</option>
                                        <option value="{{ route('shop.index', array_merge(request()->except('sort'), ['sort' => 'newest'])) }}"
                                            {{ request('sort') == 'newest' ? 'selected' : '' }}>Sort by newness</option>
                                        <option value="{{ route('shop.index', array_merge(request()->except('sort'), ['sort' => 'price_asc'])) }}"
                                            {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Sort by price: low to high</option>
                                        <option value="{{ route('shop.index', array_merge(request()->except('sort'), ['sort' => 'price_desc'])) }}"
                                            {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Sort by price: high to low</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row shop_container product-grid">

                    <div class="totall-product">
                        @if(request('search'))
                        <p>
                            @if($products->total() > 0)
                            We found <strong class="text-brand">{{ $products->total() }}</strong> items matching
                            "{{ request('search') }}"
                            @else
                            <strong class="text-danger">No results found for "{{ request('search') }}"</strong>
                            @endif
                        </p>
                        @else
                        <p>We found <strong class="text-brand">{{ $products->total() }}</strong> items for you!</p>
                        @endif
                    </div>

                    @foreach($products as $product)
                    <div class="col-md-3 col-6">
                        <div class="product">
                            <div class="product_img">
                                <a href="{{ route('shop-detail.index', $product->slug) }}">
                                    <img class="default-img" src="{{ asset('storage/' . $product->foto) }}"
                                    alt="{{ $product->nama_produk }}">
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
                                <h6 class="product_title"><a href="{{ route('shop-detail.index', $product->slug) }}">{{ $product->nama_produk }}</a></h6>
                                <div class="product_price">
                                    <span class="price">$ {{ fmod($product->harga, 1) == 0 ? number_format($product->harga, 0, '.', '.') : number_format($product->harga, 2, '.', '.') }}</span>
                                        @if($product->harga_diskon > 0)
                                        <del class="old-price"><br>$ {{ fmod($product->harga_diskon, 1) == 0 ? number_format($product->harga_diskon, 0, '.', '.') : number_format($product->harga_diskon, 2, '.', '.') }}</del>
                                        @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
        		<div class="row">
                    <div class="col-12">
                        <ul class="pagination mt-3 justify-content-center pagination_style1">
                            {{ $products->links('vendor.pagination.custom') }}
                        </ul>
                    </div>
                </div>
        	</div>
            <div class="col-lg-3 order-lg-first mt-4 pt-2 mt-lg-0 pt-lg-0">
            	<div class="sidebar">
                	<div class="widget">
                        <h5 class="widget_title">Categories</h5>
                        <ul class="widget_categories">
                            <li>
                                <a href="{{ route('shop.index',
                                    array_merge(
                                        request()->except('category'),
                                        ['category' => 'all']
                                    )
                                ) }}"
                                    class="category-filter {{ request('category') == 'all' || !request('category') ? 'active' : '' }}">
                                    <span class="categories_name">
                                    All Category</span>
                                </a>
                            </li>
                            @foreach($categories as $category)
                            <li><a href="{{ route('shop.index',
                                array_merge(
                                    request()->except('category'),
                                    ['category' => $category->slug]
                                )
                            ) }}" class="category-filter {{ request('category') == $category->slug ? 'active' : '' }}">
                            <span class="categories_name">
                                {{ Str::limit($category->kategori, 20) }}</span><span class="categories_num">({{ $category->produks_count }})</span></a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="widget">
                    	<h5 class="widget_title">Filter</h5>
                        <div class="filter_price">
                            <div id="price_filter" 
                                data-min="0" 
                                data-max="{{ $maxPrice }}" 
                                data-min-value="{{ request('min_price', $minPrice) }}" 
                                data-max-value="{{ request('max_price', $maxPrice) }}" 
                                data-price-sign="$">
                            </div>
                            <div class="price_range">
                                <div class="d-flex justify-content-between">
                                    <span>From: <strong id="slider-range-value1" class="text-brand">
                                        ${{ number_format(request('min_price', $minPrice), 0, ',', '.') }}
                                    </strong></span>
                                    <span>To: <strong id="slider-range-value2" class="text-brand">
                                        ${{ number_format(request('max_price', $maxPrice), 0, ',', '.') }}
                                    </strong></span>
                                </div>
                                <input type="hidden" id="price_first" value="{{ request('min_price', $minPrice) }}">
                                <input type="hidden" id="price_second" value="{{ request('max_price', $maxPrice) }}">
                                <a href="#" id="apply-price-filter" class="btn btn-sm btn-fill-out mt-2">
                                    <i class="linearicons-funnel mr-5"></i> Filter
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END SECTION SHOP -->

@endsection

@section('scripts')
<script src="{{ asset('js/cart.js') }}"></script>
@endsection
