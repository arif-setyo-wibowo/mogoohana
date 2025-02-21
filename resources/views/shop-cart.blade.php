@extends('template.home_layout')
@section('content')


<!-- START SECTION BREADCRUMB -->
<div class="breadcrumb_section bg_gray page-title-mini">
    <div class="container"><!-- STRART CONTAINER -->
        <div class="row align-items-center">
        	<div class="col-md-6">
                <div class="page-title">
            		<h1>Shopping Cart</h1>
                </div>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb justify-content-md-end">
                    <li class="breadcrumb-item"><a href="{{route('home.index')}}">Home</a></li>
                    <li class="breadcrumb-item active">Shopping Cart</li>
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
            <div class="col-12">
                <div class="table-responsive shop_cart_table">
                	<table class="table">
                    	<thead>
                        	<tr>
                            	<th class="product-thumbnail">&nbsp;</th>
                                <th class="product-name">Product</th>
                                <th class="product-price">Price</th>
                                <th class="product-quantity">Quantity</th>
                                <th class="product-subtotal">Total</th>
                                <th class="product-remove">Remove</th>
                            </tr>
                        </thead>
                        <tbody>

                        @forelse($cartItems as $item)
                        	<tr data-cart-id="{{ $item->id }}">
                            	<td class="product-thumbnail"><img src="{{ asset('storage/' . $item->produk->foto) }}" alt="{{ $item->produk->nama_produk }}"></td>
                                <td class="product-name" data-title="Product"><a href="#"> {{ $item->produk->nama_produk }}</a></td>
                                <td class="product-price" data-title="Price">${{ number_format($item->produk->harga, 2) }}</td>
                                <td class="product-quantity" data-title="Quantity"><div class="quantity">
                                <input type="button" value="-" class="minus">
                                <input type="text" name="quantity"
                                                value="{{ $item->quantity }}"
                                                title="Qty"
                                                min="1"
                                                max="{{ $item->produk->stok }}"
                                                readonly class="qty" size="4">
                                <input type="button" value="+" class="plus">
                              </div></td>
                              	<td class="product-subtotal" data-title="Total">${{ number_format($item->produk->harga * $item->quantity, 2) }}</td>
                                <td class="product-remove" data-title="Remove"><a href="#" onclick="event.preventDefault(); removeCartItem(this);"><i class="ti-close"></i></a></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    <p class="my-5">Your cart is empty</p>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                        <tfoot>
                        	<tr>
                            	<td colspan="6" class="px-0">
                                	<div class="row g-0 align-items-center">

                                    	<div class="col-lg-4 col-md-6 mb-3 mb-md-0">
                                    	</div>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
            	<div class="medium_divider"></div>
            	<div class="divider center_icon"><i class="ti-shopping-cart-full"></i></div>
            	<div class="medium_divider"></div>
            </div>
        </div>
        <div class="row">
        	<div class="col-md-6">
            </div>
            <div class="col-md-6">
            	<div class="border p-3 p-md-4">
                    <div class="heading_s1 mb-3">
                        <h6>Cart Totals</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td class="cart_total_label">Total</td>
                                    <td class="cart_total_amount"><strong> ${{ number_format($cartItems->sum(function($item) { return $item->produk->harga * $item->quantity; }), 0) }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    @if($cartItems->count() > 0)
                        <a href="{{ route('shop-checkout.index')}}" class="btn btn-fill-out">Proceed To CheckOut</a>
                    @endif
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
