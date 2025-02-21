@extends('template.home_layout')
@section('content')

<!-- START SECTION BREADCRUMB -->
<div class="breadcrumb_section bg_gray page-title-mini">
    <div class="container">
        <!-- STRART CONTAINER -->
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="page-title">
                    <h1>Reset Password</h1>
                </div>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb justify-content-md-end">
                    <li class="breadcrumb-item"><a href="{{ route('home.index')}}">Home</a></li>
                    <li class="breadcrumb-item active">Reset Password</li>
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
                            <h3>Reset Password</h3>
                        </div>
                        <p class="mb-30">Please enter your new password and confirm it.</p>
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="form-group mb-3">
                                <input type="email" required name="email" placeholder="Email *"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ $email ?? old('email') }}" />
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <input type="password" required name="password" placeholder="New Password *"
                                    class="form-control @error('password') is-invalid @enderror" />
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <input type="password" required name="password_confirmation" placeholder="Confirm New Password *"
                                    class="form-control @error('password_confirmation') is-invalid @enderror" />
                                @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <button type="submit" class="btn btn-fill-out btn-block" name="reset">Reset
                                password</button>
                            </div>
                        </form>
                                
                                
                                
                               
                                
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>
@endsection
