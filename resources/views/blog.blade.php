@extends('template.home_layout')
@section('content')

<!-- START SECTION BREADCRUMB -->
<div class="breadcrumb_section bg_gray page-title-mini">
    <div class="container"><!-- STRART CONTAINER -->
        <div class="row align-items-center">
        	<div class="col-md-6">
                <div class="page-title">
            		<h1>Blog</h1>
                </div>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb justify-content-md-end">
                    <li class="breadcrumb-item"><a href="{{ route('home.index')}}">Home</a></li>
                    <li class="breadcrumb-item active">Blog</li>
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
            @foreach($blogs as $blog)
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="blog_post blog_style2 box_shadow1">
                    <div class="blog_img">
                        <a href="{{ route('blog-detail.index', $blog->slug) }}">
                            <img class="default-img" src="{{ asset('storage/' . $blog->foto) }}"
                            alt="{{ $blog->judul }}">
                        </a>
                    </div>
                    <div class="blog_content bg-white">
                        <div class="blog_text">
                            <h6 class="blog_title"><a href="{{ route('blog-detail.index', $blog->slug) }}">{{ $blog->judul}}</a></h6>
                            <ul class="list_none blog_meta">
                                <li><a href="#"><i class="ti-calendar"></i> {{ $blog->created_at->format('F d, Y') }}</a></li>
                            </ul>
                            <p>{!! html_entity_decode(\Illuminate\Support\Str::words($blog->deskripsi, 20, '...')) !!}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="blog_post blog_style2 box_shadow1">
                    <div class="blog_img">
                        <a href="{{ route('blog-detail.index', $blog->slug) }}">
                            <img class="default-img" src="{{ asset('storage/' . $blog->foto) }}"
                            alt="{{ $blog->judul }}">
                        </a>
                    </div>
                    <div class="blog_content bg-white">
                        <div class="blog_text">
                            <h6 class="blog_title"><a href="{{ route('blog-detail.index', $blog->slug) }}">{{ $blog->judul}}</a></h6>
                            <ul class="list_none blog_meta">
                                <li><a href="#"><i class="ti-calendar"></i> {{ $blog->created_at->format('F d, Y') }}</a></li>
                            </ul>
                            <p>{!! html_entity_decode(\Illuminate\Support\Str::words($blog->deskripsi, 20, '...')) !!}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="blog_post blog_style2 box_shadow1">
                    <div class="blog_img">
                        <a href="{{ route('blog-detail.index', $blog->slug) }}">
                            <img class="default-img" src="{{ asset('storage/' . $blog->foto) }}"
                            alt="{{ $blog->judul }}">
                        </a>
                    </div>
                    <div class="blog_content bg-white">
                        <div class="blog_text">
                            <h6 class="blog_title"><a href="{{ route('blog-detail.index', $blog->slug) }}">{{ $blog->judul}}</a></h6>
                            <ul class="list_none blog_meta">
                                <li><a href="#"><i class="ti-calendar"></i> {{ $blog->created_at->format('F d, Y') }}</a></li>
                            </ul>
                            <p>{!! html_entity_decode(\Illuminate\Support\Str::words($blog->deskripsi, 20, '...')) !!}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-12 mt-2 mt-md-4">
                <ul class="pagination pagination_style1 justify-content-center">
                    {{ $blogs->links('vendor.pagination.custom') }}
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- END SECTION BLOG -->


@endsection
