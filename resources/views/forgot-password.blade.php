@extends('template.home_layout')
@section('content')

<!-- START SECTION BREADCRUMB -->
<div class="breadcrumb_section bg_gray page-title-mini">
    <div class="container">
        <!-- STRART CONTAINER -->
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="page-title">
                    <h1>Forgot Password</h1>
                </div>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb justify-content-md-end">
                    <li class="breadcrumb-item"><a href="{{ route('home.index')}}">Home</a></li>
                    <li class="breadcrumb-item active">Forgot Password</li>
                </ol>
            </div>
        </div>
    </div><!-- END CONTAINER-->
</div>
<!-- END SECTION BREADCRUMB -->

<main class="login_register_wrap section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-md-10">
                <div class="login_wrap">
                    <div class="padding_eight_all bg-white">
                        <div class="heading_s1">
                            <h3>Forgot your password?</h3>
                        </div>
                        <p class="mb-30">Not to worry, we got you! Let’s get you a new password. Please enter
                            your email address.</p>
                        @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                        @endif
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="form-group mb-3">
                                <input type="email" required name="email" placeholder="Email *"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}" />
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <button type="submit" class="btn btn-fill-out btn-block" name="reset">Reset
                                password</button>
                            </div>
                        </form>
                        <div class="different_login">
                            <span> or</span>
                        </div>
                        <div class="form-note text-center">Don't Have an Account? <a
                                href="{{ route('register.index')}}">Sign up now</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>
@endsection
