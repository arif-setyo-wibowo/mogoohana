@extends('template.home_layout')
@section('content')

<!-- START SECTION BREADCRUMB -->
<div class="breadcrumb_section bg_gray page-title-mini">
    <div class="container"><!-- STRART CONTAINER -->
        <div class="row align-items-center">
        	<div class="col-md-6">
                <div class="page-title">
            		<h1>Blog Detail</h1>
                </div>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb justify-content-md-end">
                    <li class="breadcrumb-item"><a href="{{ route('home.index')}}">Home</a></li>
                    <li class="breadcrumb-item active">Blog Detail</li>
                </ol>
            </div>
        </div>
    </div><!-- END CONTAINER-->
</div>
<!-- END SECTION BREADCRUMB -->


<!-- START SECTION BLOG -->
<div class="section">
	<div class="container">
    	<div class="row">
        	<div class="col-xl-9">
            	<div class="single_post">
                	<h2 class="blog_title">{{ $blog->judul }}</h2>
                    <ul class="list_none blog_meta">
                        <li><i class="ti-calendar"></i> {{ $blog->created_at->format('F d, Y') }}</li>
                    </ul>
                    <div class="blog_img">
                        <img src="{{ asset('storage/' . $blog->foto) }}" alt="{{ $blog->judul }}"
                        style="width: 100%; height: 500px; object-fit: cover; aspect-ratio: 1/1;">
                    </div>
                    <div class="blog_content">
                        <div class="blog_text">
                            <p>{!! html_entity_decode($blog->deskripsi) ?? 'There is no description.' !!}</p>
                        </div>
                    </div>
                    <div class="post_navigation bg_gray">
                        <div class="row align-items-center justify-content-between p-4">
                            <div class="col-5">
                                <a href="{{ route('blog-a.index')}}">
                                    <div class="post_nav post_nav_prev">
                                        <i class="ti-arrow-left"></i>
                                        <span>Blog Post</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END SECTION BLOG -->


@endsection
