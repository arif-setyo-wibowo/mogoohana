@extends('template.home_layout')
@section('content')

<!-- START SECTION BREADCRUMB -->
<div class="breadcrumb_section bg_gray page-title-mini">
    <div class="container">
        <!-- STRART CONTAINER -->
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="page-title">
                    <h1>Checkout</h1>
                </div>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb justify-content-md-end">
                    <li class="breadcrumb-item"><a href="{{ route('home.index')}}">Home</a></li>
                    <li class="breadcrumb-item active">Checkout</li>
                </ol>
            </div>
        </div>
    </div><!-- END CONTAINER-->
</div>
<!-- END SECTION BREADCRUMB -->

<div class="section">
    <div class="container">
        <div class="row">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <div class="col-lg-6">
                @guest
                <div class="toggle_info">
                    <span><i class="fas fa-user"></i>Returning customer? <a href="{{ route('login.index')}}">Click
                            here
                            to login</a></span>
                </div>
                @endguest
            </div>
            <div class="col-lg-6">
                <div class="toggle_info">
                    <span><i class="fas fa-tag"></i>Have a coupon? <a href="#coupon" data-bs-toggle="collapse"
                            class="collapsed" aria-expanded="false">Click here to enter your code</a></span>
                </div>
                <div class="panel-collapse collapse coupon_form" id="coupon">
                    <div class="panel-body">
                        <p>If you have a coupon code, please apply it below.</p>
                        <form id="coupon-form" class="coupon field_form input-group">
                            <input type="text" value="" id="coupon-code" name="coupon_code" class="form-control"
                                placeholder="Enter Coupon Code..">
                            <input type="hidden" name="total_purchase" id="total-purchase-input"
                                value="{{ $total ?? 0 }}">
                            <div class="input-group-append">
                                <button class="btn btn-fill-out btn-sm" type="submit">Apply Coupon</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="medium_divider"></div>
                <div class="divider center_icon"><i class="linearicons-credit-card"></i></div>
                <div class="medium_divider"></div>
            </div>
        </div>
        <form method="POST" action="{{ route('checkout.process') }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="heading_s1">
                        <h4>Account Information</h4>
                    </div>

                    <div class="form-group mb-3">
                        <input type="text" required class="form-control" name="username"
                            placeholder="In Game username *">
                    </div>
                    <div class="form-group mb-3">
                        <input type="text" required class="form-control" name="facebook" placeholder="Facebook Name *">
                    </div>
                    <div class="form-group mb-3">
                        <input class="form-control" required type="text" name="link" placeholder="Link *">
                    </div>

                    <div class="heading_s1">
                        <h4>Billing Details</h4>
                    </div>

                    <div class="form-group mb-3">
                        <input type="text" required class="form-control" name="name" placeholder="Full Name *"
                            value="{{ Auth::check() ? Auth::user()->name : '' }}">
                    </div>
                    <div class="form-group mb-3">
                        <input type="email" required class="form-control" name="email" placeholder="Email *"
                            value="{{ Auth::check() ? Auth::user()->email : '' }}">
                    </div>

                    <div class="form-group mb-0">
                        <textarea rows="5" class="form-control" name="note" placeholder="Requests notes"></textarea>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="order_review">
                        @php
                        $total = 0;
                        @endphp
                        <div class="heading_s1">
                            <h4>Your Orders</h4>
                        </div>
                        <div class="table-responsive order_table">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cartItems as $item)
                                    <tr>
                                        <td>{{ $item->produk->nama_produk }} <span class="product-qty">x
                                                {{ $item->quantity }}</span></td>
                                        <td>${{ number_format($item->produk->harga * $item->quantity, 2) }}</td>
                                    </tr>
                                    @php
                                    $total += $item->produk->harga * $item->quantity;
                                    @endphp
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>SubTotal</th>
                                        <td class="product-subtotal">${{ number_format($total, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Discount</th>
                                        <td><span class="product-subtotal" id="discount">$0</span></td>
                                    </tr>
                                    <tr>
                                        <th>Total</th>
                                        <td class="product-subtotal" id="total">${{ number_format($total, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="mb-3">
                            <input type="hidden" name="coupon_code" id="applied_coupon_code">
                        </div>
                        <div class="payment_method">
                            <div class="heading_s1">
                                <h4>Payment</h4>
                            </div>
                            <div class="payment_option">
                                <div class="custome-radio">
                                    <input class="form-check-input" required="" type="radio" name="payment_option"
                                        id="exampleRadios3" value="PayPal" checked="">
                                    <label class="form-check-label" for="exampleRadios3">Paypal</label>
                                    <p data-method="PayPal" class="payment-text">Send payment to: <span
                                    class="text-success">josephex13@gmail.com</span> </p>
                                </div>
                                <div class="custome-radio">
                                    <input class="form-check-input" type="radio" name="payment_option"
                                        id="exampleRadios4" value="CashApp">
                                    <label class="form-check-label" for="exampleRadios4">CashApp</label>
                                    <p data-method="CashApp" class="payment-text">Send payment to: <span class="text-success">$mogoohana</span> <br> <a href="https://cash.app/app/QGC8QQM" target="_blank"
                                    class="btn btn-outline-primary btn-sm">CashApp Link</a></p>
                                </div>
                                <div class="custome-radio">
                                    <input class="form-check-input" type="radio" name="payment_option"
                                        id="exampleRadios5" value="Usdt">
                                    <label class="form-check-label" for="exampleRadios5">USDT</label>
                                    <p data-method="Usdt" class="payment-text">Send payment to Address : <span class="text-success">
                                             0xE608eFB646547fa0A2a4dB56aeE978670c7254C4
                                        </span> <br> Network : BEP20 <br><a href="  https://link.trustwallet.com/send?coin=20000714&address=0xE608eFB646547fa0A2a4dB56aeE978670c7254C4&token_id=0x55d398326f99059fF775485246999027B3197955 " target="_blank"
                                        class="btn btn-outline-primary btn-sm">Trust Wallet Link</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Upload Bukti Pembayaran</label>
                            <input type="file" required class="form-control" name="bukti_pembayaran">
                        </div>
                        <button type="submit" class="btn btn-fill-out btn-block">Checkout</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- END SECTION SHOP -->
@endsection

@section('scripts')
<script src="{{ asset('js/cart.js') }}"></script>
<script src="{{ asset('js/checkout.js') }}"></script>
@endsection
