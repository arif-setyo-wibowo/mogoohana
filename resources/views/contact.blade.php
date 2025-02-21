@extends('template.home_layout')
@section('content')


<!-- START SECTION BREADCRUMB -->
<div class="breadcrumb_section bg_gray page-title-mini">
    <div class="container"><!-- STRART CONTAINER -->
        <div class="row align-items-center">
        	<div class="col-md-6">
                <div class="page-title">
            		<h1>Contact</h1>
                </div>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb justify-content-md-end">
                    <li class="breadcrumb-item"><a href="{{ route('home.index')}}">Home</a></li>
                    <li class="breadcrumb-item active">Contact</li>
                </ol>
            </div>
        </div>
    </div><!-- END CONTAINER-->
</div>
<!-- END SECTION BREADCRUMB -->


<!-- START SECTION CONTACT -->
<div class="section pb_70">
	<div class="container">
        <div class="row">
            <div class="col-xl-4 col-md-6">
            	<div class="contact_wrap contact_style3">

                    <a href="{{ $contact_view->link_facebook ?? '#' }}">
                        <div class="contact_icon">
                            <i class="ion-social-facebook"></i>
                        </div>
                    </a>
                    <div class="contact_text">
                        <span>Facebook</span>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
            	<div class="contact_wrap contact_style3">

                    <a href="{{ $contact_view->link_wa ?? '#' }}">
                        <div class="contact_icon">
                            <i class="ion-social-whatsapp"></i>
                        </div>
                    </a>
                    <div class="contact_text">
                        <span>Whatsapp</span>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
            	<div class="contact_wrap contact_style3">

                    <a href="{{ $contact_view->link_instagram ?? '#' }}">
                        <div class="contact_icon">
                            <i class="ion-social-instagram-outline"></i>
                        </div>
                    </a>
                    <div class="contact_text">
                        <span>Instagram</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END SECTION CONTACT -->


<!-- START SECTION CONTACT -->
<div class="section pt-0">
	<div class="container">
    	<div class="row">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        	<div class="col-lg-12">
            	<div class="heading_s1">
                	<h2>Get In touch</h2>
                </div>
                <p class="leads">Your email address will not be published. Required fields are marked *</p>
                <div class="field_form">
                    <form action="{{ route('contact.send') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6 mb-3">
                                <input required placeholder="Enter Name *" id="first-name" class="form-control" name="name" type="text">
                             </div>
                            <div class="form-group col-md-6 mb-3">
                                <input required placeholder="Enter Email *" id="email" class="form-control" name="email" type="email">
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <input required placeholder="Enter Phone No. *" id="phone" class="form-control" name="tel">
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <input placeholder="Enter Subject" id="subject" class="form-control" name="subject">
                            </div>
                            <div class="form-group col-md-12 mb-3">
                                <textarea required placeholder="Message *" id="description" class="form-control" name="message" rows="4"></textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <button type="submit" class="btn btn-fill-out" >Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END SECTION CONTACT -->

@endsection
