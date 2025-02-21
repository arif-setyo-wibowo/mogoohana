@extends('template.home_layout')
@section('content')
<!-- START SECTION BREADCRUMB -->
<div class="breadcrumb_section bg_gray page-title-mini">
    <div class="container"><!-- STRART CONTAINER -->
        <div class="row align-items-center">
        	<div class="col-md-6">
                <div class="page-title">
            		<h1>About Us</h1>
                </div>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb justify-content-md-end">
                    <li class="breadcrumb-item"><a href="{{ route('home.index')}}">Home</a></li>
                    <li class="breadcrumb-item active">About</li>
                </ol>
            </div>
        </div>
    </div><!-- END CONTAINER-->
</div>
<!-- END SECTION BREADCRUMB -->

<!-- STAT SECTION ABOUT -->
<div class="section">
	<div class="container">
    	<div class="row align-items-center">
        	<div class="col-lg-6">
            	<div class="about_img scene mb-4 mb-lg-0">
                    <img src="assets/images/About3.webp"  style="border-radius: 15px;" alt="about_img"/>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="heading_s1">
                    <h2>Welcome to MogoOhana Store: Elevating Your Gaming Experience</h2>
                </div>
                <p>At MogoOhana Store, we are passionate about enhancing your gaming experience by providing top-quality virtual products and unparalleled services. </p>
                <p>As avid gamers ourselves, we understand the importance of having the right tools and resources to excel in your favorite games. That's why we've made it our mission to offer a diverse range of virtual products and services designed to take your gaming to the next level.</p>
            </div>
        </div>
    </div>
</div>
<!-- END SECTION ABOUT -->


<!-- STAT SECTION ABOUT -->
<div class="section">
	<div class="container">
    	<div class="row align-items-center">
            <div class="col-lg-6">
                <div class="heading_s1">
                    <h2>Our Specialization</h2>
                </div>
                <p>We specialize in boosting dice and offering a wide array of star stickers to add an extra layer of excitement to your gaming adventures. </p>
                <p>Whether you're seeking 1-star stickers for a modest boost or 5-star stickers for the ultimate advantage, we have you covered. Additionally, our golden Blitz stickers are guaranteed to add a touch of prestige to your gaming arsenal.</p>

                <div class="heading_s1">
                    <h2>Partnership Events</h2>
                </div>
                <p>At MogoOhana Store, we believe in the power of collaboration. That's why we actively engage in partnership events with other gaming enthusiasts and industry leaders. These events provide us with the opportunity to connect with our community, share valuable insights, and explore new possibilities for enhancing the gaming experience.</p>
            </div>
        	<div class="col-lg-6">
            	<div class="about_img scene mb-4 mb-lg-0">
                    <img src="assets/images/About2.webp" style="border-radius: 15px;" alt="about_img"/>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END SECTION ABOUT -->

@endsection
