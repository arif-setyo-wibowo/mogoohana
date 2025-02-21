@extends('template.home_layout')
@section('content')
<!-- START SECTION BREADCRUMB -->
<div class="breadcrumb_section bg_gray page-title-mini">
    <div class="container"><!-- STRART CONTAINER -->
        <div class="row align-items-center">
        	<div class="col-md-6">
                <div class="page-title">
            		<h1>Privacy Policy</h1>
                </div>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb justify-content-md-end">
                    <li class="breadcrumb-item"><a href="{{ route('home.index')}}">Home</a></li>
                    <li class="breadcrumb-item active">Privacy Policy</li>
                </ol>
            </div>
        </div>
    </div><!-- END CONTAINER-->
</div>
<!-- END SECTION BREADCRUMB -->


<!-- STAT SECTION FAQ -->
<div class="section">
	<div class="container">
    	<div class="row">
        	<div class="col-12">
            	<div class="term_conditions">
                    <h4>What we collect and store</h4>
                    <ol >
                        <li>
                            We will use your personal information:
                            <ol>
                                <li class="has-dot">Products you’ve viewed: we’ll use this to, for example, show you products you’ve recently viewed</li>
                                <li class="has-dot">
                                    Location, IP address and browser type: we’ll use this for purposes like estimating taxes and shipping
                                </li>
                                <li class="has-dot">
                                    Shipping address: we’ll ask you to enter this so we can, for instance, estimate shipping before you place an order, and send you the order!
                                </li>
                            </ol>
                        </li>
                    </ol>
                    <ol start="2">
                        <li>We’ll also use cookies to keep track of cart contents while you’re browsing our site.</li>
                    </ol>
                    <ol start="3">
                        <li>When you purchase from us, we’ll ask you to provide information including your name, billing address, shipping address, email address, phone number, credit card/payment details and optional account information like username and password. We’ll use this information for purposes, such as, to:</li>
                        <ol>
                            <li class="has-dot">Send you information about your account and order</li>
                            <li class="has-dot">
                                Respond to your requests, including refunds and complaints
                            </li>
                            <li class="has-dot">
                                Process payments and prevent fraud
                            </li>
                            <li class="has-dot">
                                Set up your account for our store
                            </li>
                            <li class="has-dot">
                                Comply with any legal obligations we have, such as calculating taxes
                            </li>
                            <li class="has-dot">
                                Improve our store offerings
                            </li>
                        </ol>
                    </ol>
                    <ol start="4">
                        <li>
                            If you create an account, we will store your name, address, email and phone number, which will be used to populate the checkout for future orders.
                        </li>
                    </ol>
                    <h4>Who on our team has access</h4>
                    <ol start="5">
                        <li>
                            Members of our team have access to the information you provide us. For example, both Administrators and Shop Managers can access:
                        </li>
                        <ol>
                            <li class="has-dot">Order information like what was purchased, when it was purchased and where it should be sent, and</li>
                            <li class="has-dot">
                                Customer information like your name, email address, and billing and shipping information.
                            </li>
                        </ol>
                        <p>Our team members have access to this information to help fulfill orders, process refunds and support you.</p>
                    </ol>
                    <h4>What we share with others</h4>
                    <ol start="6">
                        <li>We share information with third parties who help us provide our orders and store services to you; for example --</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END SECTION FAQ -->

@endsection
