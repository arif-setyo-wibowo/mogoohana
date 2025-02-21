<!doctype html>

<html
    lang="en"
    class="light-style layout-wide customizer-hide"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="{{ asset('assets_admin/')}}/"
    data-template="horizontal-menu-template">
<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>MogoOhana| Login Admin</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets_admin/')}}/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets_admin/')}}/vendor/fonts/materialdesignicons.css" />
    <link rel="stylesheet" href="{{ asset('assets_admin/')}}/vendor/fonts/flag-icons.css" />

    <!-- Menu waves for no-customizer fix -->
    <link rel="stylesheet" href="{{ asset('assets_admin/')}}/vendor/libs/node-waves/node-waves.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets_admin/')}}/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets_admin/')}}/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets_admin/')}}/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets_admin/')}}/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="{{ asset('assets_admin/')}}/vendor/libs/typeahead-js/typeahead.css" />
    <!-- Vendor -->
    <link rel="stylesheet" href="{{ asset('assets_admin/')}}/vendor/libs/@form-validation/form-validation.css" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets_admin/')}}/vendor/css/pages/page-auth.css" />

    <!-- Helpers -->
    <script src="{{ asset('assets_admin/')}}/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{ asset('assets_admin/')}}/vendor/js/template-customizer.js"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('assets_admin/')}}/js/config.js"></script>
</head>

<body>
<!-- Content -->

<div class="position-relative">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-4">
            <!-- Login -->
            <div class="card p-2">
                <div class="card-body mt-2">
                    <h4 class="mb-2">Welcome! 👋</h4>
                    <p class="mb-4">Log in with your user account to access the system</p>

                    <?php if (session()->has('msg')):?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert" id="autoDismissAlert" style="margin:5px;">
                            {{ session('msg') }}
                        </div>
                    <?php endif ?>

                    @if(Session::has('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="autoDismissAlert"style="margin:5px;">
                            {{ Session::get('error') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="autoDismissAlert"style="margin:5px;">
                            @foreach ($errors->all() as $error)
                            {{ $error }} </i><br>
                            @endforeach
                        </div>
                    @endif

                    <form  class="mb-3" action="{{ route('postlogin')}}" method="post">
                        @csrf
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" class="form-control" name="username" placeholder="Masukkan Username" required />
                            <label for="username">Username</label>
                        </div>
                        <div class="mb-3">
                            <div class="form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" required />
                                        <label for="password">Password</label>
                                    </div>
                                    <span class="input-group-text cursor-pointer"><i class="mdi mdi-eye-off-outline"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" type="submit">Login</button>
                        </div>
                    </form>

                </div>
            </div>
            <!-- /Login -->
            <img
            alt="mask"
            src="{{ asset('assets_admin/')}}/img/illustrations/auth-basic-login-mask-light.png"
            class="authentication-image d-none d-lg-block"
            data-app-light-img="illustrations/auth-basic-login-mask-light.png"
            data-app-dark-img="illustrations/auth-basic-login-mask-dark.png" />
        </div>
    </div>
</div>

    <!-- / Content -->

    <!-- Core JS -->
    <script src="{{ asset('assets_admin/')}}/vendor/libs/jquery/jquery.js"></script>
    <script src="{{ asset('assets_admin/')}}/vendor/libs/popper/popper.js"></script>
    <script src="{{ asset('assets_admin/')}}/vendor/js/bootstrap.js"></script>
    <script src="{{ asset('assets_admin/')}}/vendor/libs/node-waves/node-waves.js"></script>
    <script src="{{ asset('assets_admin/')}}/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="{{ asset('assets_admin/')}}/vendor/libs/hammer/hammer.js"></script>
    <script src="{{ asset('assets_admin/')}}/vendor/libs/i18n/i18n.js"></script>
    <script src="{{ asset('assets_admin/')}}/vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="{{ asset('assets_admin/')}}/vendor/js/menu.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('assets_admin/')}}/vendor/libs/@form-validation/popular.js"></script>
    <script src="{{ asset('assets_admin/')}}/vendor/libs/@form-validation/bootstrap5.js"></script>
    <script src="{{ asset('assets_admin/')}}/vendor/libs/@form-validation/auto-focus.js"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets_admin/')}}/js/main.js"></script>

    <!-- Page JS -->
    <script src="{{ asset('assets_admin/')}}/js/pages-auth.js"></script>
</body>

</html>

