@extends('template.home_layout')
@section('content')

<!-- START SECTION SHOP -->
<div class="section">
	<div class="container">
		<div class="row">
            <div class="col-lg-6 col-md-6 mb-4 mb-md-0">
              <div class="product-image">
                    <div class="product_img_box">
                        <img id="product_img" src="{{ asset('storage/' . $product->foto) }}"
                        alt="{{ $product->nama_produk }}"
                        style="width: 100%; height: 500px; object-fit: cover; aspect-ratio: 1/1;"  />
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="pr_detail">
                    <div class="product_description">
                        <h4 class="product_title">{{ $product->nama_produk }}</h4>
                        <div class="product_price">
                            <span class="price">$ {{ fmod($product->harga, 1) == 0 ? number_format($product->harga, 0, '.', '.') : number_format($product->harga, 2, '.', '.') }}</span>
                            @if($product->harga_diskon > 0)
                            <del>
                                $ {{ fmod($product->harga_diskon, 1) == 0 ? number_format($product->harga_diskon, 0, '.', '.') : number_format($product->harga_diskon, 2, '.', '.') }}
                            </del>
                            @endIf
                        </div>
                    </div>
                    <br>
                    <br>
                    <hr />
                    <div class="cart_extra">
                        <div class="cart-product-quantity">
                        </div>
                        <div class="cart_btn">
                            <button class="btn btn-fill-out btn-addtocart add-to-cart-link button-add-to-cart" type="submit" data-produk_id="{{ $product->id }}"
                                data-quantity="1"><i class="icon-basket-loaded"></i> Add to cart</button>
                        </div>
                    </div>
                    <hr />
                    <ul class="product-meta">
                        <li>Stock: {{ $product->stok }}</li>
                        <li>Category: {{ $product->kategori->kategori }}</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
        	<div class="col-12">
            	<div class="large_divider clearfix"></div>
            </div>
        </div>
        <div class="row">
        	<div class="col-12">
            	<div class="tab-style3">
					<ul class="nav nav-tabs" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="Description-tab" data-bs-toggle="tab" href="#Description" role="tab" aria-controls="Description" aria-selected="true">Description</a>
                      	</li>
                    </ul>
                	<div class="tab-content shop_info_tab">
                      	<div class="tab-pane fade show active" id="Description" role="tabpanel" aria-labelledby="Description-tab">
                             {!! html_entity_decode($product->deskripsi) ?? 'There is no detailed product description.' !!}
                      	</div>
                	</div>
                </div>
            </div>
        </div>
        <div class="row">
        	<div class="col-12">
            	<div class="small_divider"></div>
            	<div class="divider"></div>
                <div class="medium_divider"></div>
            </div>
        </div>
        @if($relatedProducts->count() > 0)
        <div class="row">
        	<div class="col-12">
            	<div class="heading_s1">
                	<h3>Releted Products</h3>
                </div>
            	<div class="releted_product_slider carousel_slider owl-carousel owl-theme" data-margin="20" data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "1199":{"items": "4"}}'>
                	@foreach($relatedProducts as $relatedProduct)
                    <div class="item">
                        <div class="product">
                            <div class="product_img">
                                <a href="{{ route('shop-detail.index', ['slug' => $relatedProduct->slug]) }}">
                                    <img src="{{ asset('storage/' . $relatedProduct->foto) }}"
                                        style="width: 100%; height: 250px; object-fit: cover;"
                                        alt="{{ $relatedProduct->nama_produk }}">
                                </a>
                            </div>
                            <div class="product_info">
                                <h6 class="product_title"><a href="{{ route('shop-detail.index', ['slug' => $relatedProduct->slug]) }}">{{ $relatedProduct->nama_produk }}</a></h6>
                                <div class="product_price">
                                    <span  class="price">$ {{ fmod($relatedProduct->harga, 1) == 0 ? number_format($relatedProduct->harga, 0, '.', '.') : number_format($relatedProduct->harga, 2, '.', '.') }}</span>
                                    @if($relatedProduct->harga_diskon > 0)
                                        <del>$ {{ fmod($relatedProduct->harga_diskon, 1) == 0 ? number_format($relatedProduct->harga_diskon, 0, '.', '.') : number_format($relatedProduct->harga_diskon, 2, '.', '.') }}</del>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
<!-- END SECTION SHOP -->
@endsection

@section('scripts')
<script src="{{ asset('js/cart.js') }}"></script>
@endsection
