<!doctype html>

<html
  lang="en"
  class="light-style layout-navbar-fixed layout-menu-fixed layout-compact"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{ asset('assets_admin/')}}/"
  data-template="vertical-menu-template">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{ $title }}</title>

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

    <link rel="stylesheet" href="{{ asset('assets_admin/')}}/vendor/libs/quill/editor.css" />
    <link rel="stylesheet" href="{{ asset('assets_admin/')}}/vendor/libs/bootstrap-select/bootstrap-select.css" />
    <link rel="stylesheet" href="{{ asset('assets_admin/')}}/vendor/libs/apex-charts/apex-charts.css" />
    <link rel="stylesheet" href="{{ asset('assets_admin/')}}/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="{{ asset('assets_admin/')}}/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="{{ asset('assets_admin/')}}/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css" />
    <link rel="stylesheet" href="{{ asset('assets_admin/')}}/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
    <link rel="stylesheet" href="{{ asset('assets_admin/')}}/vendor/libs/select2/select2.css " />
    <link rel="stylesheet" href="{{ asset('assets_admin/')}}/vendor/libs/quill/katex.css" />
    <link rel="stylesheet" href="{{ asset('assets_admin/')}}/vendor/libs/toastr/toastr.css" />
    <link rel="stylesheet" href="{{ asset('assets_admin/')}}/vendor/libs/sweetalert2/sweetalert2.css" />
    <!-- Page CSS -->
<!-- Row Group CSS -->
<link rel="stylesheet" href="{{ asset('assets_admin/')}}/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css" />
    <link rel="stylesheet" href="{{ asset('assets_admin/')}}/vendor/css/pages/app-logistics-dashboard.css" />

    <!-- Helpers -->
    <script src="{{ asset('assets_admin/')}}/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{ asset('assets_admin/')}}/vendor/js/template-customizer.js"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('assets_admin/')}}/js/config.js"></script>
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
            <div class="app-brand demo">
              <a href="{{ route('dashboard.index')}}" class="app-brand-link">
                <span class="app-brand-text demo menu-text fw-bold ms-2">MogoOhana</span>
              </a>
            </div>

            <div class="menu-inner-shadow"></div>

            <ul class="menu-inner py-1">
              <!-- Dashboards -->
              <!-- Apps & Pages -->
                  <li class="menu-item  {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
                      <a href="{{ route('dashboard.index')}}" class="menu-link">
                          <i class="menu-icon tf-icons mdi mdi-home-outline"></i>
                          <div>Dashboard</div>
                      </a>
                  </li>
                  <li class="menu-header fw-medium mt-4">
                      <span class="menu-header-text">Action Data</span>
                  </li>
                   <li class="menu-item  {{ request()->routeIs('kategori.index') ? 'active' : '' }}">
                      <a href="{{ route('kategori.index')}}" class="menu-link">
                          <i class="menu-icon tf-icons mdi mdi-shape"></i>
                          <div>Data Kategori</div>
                      </a>
                  </li>
                  <li class="menu-item {{ request()->routeIs('produk.index') ? 'active' : '' }}">
                      <a href="{{ route('produk.index')}}" class="menu-link">
                          <i class="menu-icon tf-icons mdi mdi-clipboard-outline"></i>
                          <div>Data Produk</div>
                      </a>
                  </li>

                  <li class="menu-item {{ request()->routeIs('pembelian.index') ? 'active' : '' }}">
                      <a href="{{ route('pembelian.index')}}" class="menu-link">
                          <i class="menu-icon tf-icons mdi mdi-calendar-edit"></i>
                          <div>Data Pembelian</div>
                      </a>
                  </li>

                  <li class="menu-item {{ request()->routeIs('user-admin.index') ? 'active' : '' }}">
                      <a href="{{ route('user-admin.index')}}" class="menu-link">
                          <i class="menu-icon tf-icons mdi mdi-account-group-outline"></i>
                          <div>Data User</div>
                      </a>
                  </li>
                  <li class="menu-item {{ request()->routeIs('admin.index') ? 'active' : '' }}">
                      <a href="{{ route('admin.index')}}" class="menu-link">
                          <i class="menu-icon tf-icons mdi mdi-calendar-account"></i>
                          <div>Data Admin</div>
                      </a>
                  </li>
                  <li class="menu-item {{ request()->routeIs('kupon.index') ? 'active' : '' }}">
                    <a href="{{ route('kupon.index')}}" class="menu-link">
                        <i class="menu-icon tf-icons mdi mdi-sale"></i>
                        <div>Data Kupon</div>
                    </a>
                </li>
                  <li class="menu-header fw-medium mt-4">
                      <span class="menu-header-text">Data Laporan</span>
                  </li>
                  <li class="menu-item {{ request()->routeIs('laporan.pembelian') ? 'active' : '' }}">
                      <a href="{{ route('laporan.pembelian')}}" class="menu-link">
                          <i class="menu-icon tf-icons mdi mdi-calendar-edit"></i>
                          <div>Laporan Pembelian</div>
                      </a>
                  </li>
                  <li class="menu-header fw-medium mt-4">
                      <span class="menu-header-text">Form Web</span>
                    </li>
                    <li class="menu-item {{ request()->routeIs('blog.index') ? 'active' : '' }}">
                        <a href="{{ route('blog.index')}}" class="menu-link">
                            <i class="menu-icon tf-icons mdi mdi-post"></i>
                            <div>Blog</div>
                        </a>
                    </li>
                  <li class="menu-item {{ request()->routeIs('faq.index') ? 'active' : '' }}">
                      <a href="{{ route('faq.index')}}" class="menu-link">
                          <i class="menu-icon tf-icons mdi mdi-frequently-asked-questions"></i>
                          <div>FAQ</div>
                      </a>
                  </li>
                  <li class="menu-item {{ request()->routeIs('contact-admin.index') ? 'active' : '' }}">
                      <a href="{{ route('contact-admin.index')}}" class="menu-link">
                          <i class="menu-icon tf-icons mdi mdi-phone"></i>
                          <div>Contact</div>
                      </a>
                  </li>
                  <li class="menu-item ">
                      <a href="{{ route('logoutadmin.index')}}" class="menu-link">
                          <i class="menu-icon tf-icons mdi mdi-logout"></i>
                          <div>Logout</div>
                      </a>
                  </li>


            </ul>
          </aside>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

          <nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar">
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="mdi mdi-menu mdi-24px"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">


              <ul class="navbar-nav flex-row align-items-center ms-auto">

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                      <img src="{{ asset('assets_admin/')}}/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="{{ route('logoutadmin.index')}}">
                        <i class="mdi mdi-logout me-2"></i>
                        <span class="align-middle">Log Out</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>

          </nav>

          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            @yield('content')

            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl">
                <div
                  class="footer-container d-flex align-items-center justify-content-between py-3 flex-md-row flex-column">
                  <div class="mb-2 mb-md-0">
                    ©
                    <script>
                      document.write(new Date().getFullYear());
                    </script>
                    , made with <span class="text-danger"><i class="tf-icons mdi mdi-heart"></i></span>
                    <a target="_blank" class="footer-link fw-medium"></a>
                  </div>

                </div>
              </div>
            </footer>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>

      <!-- Drag Target Area To SlideIn Menu On Small Screens -->
      <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets_admin/vendor/js/core.js -->
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
    <script src="{{ asset('assets_admin/')}}/vendor/libs/apex-charts/apexcharts.js"></script>
    <script src="{{ asset('assets_admin/')}}/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="{{ asset('assets_admin/')}}/vendor/libs/datatables-buttons/buttons.html5.js"></script>
    <script src="{{ asset('assets_admin/')}}/vendor/libs/jszip/jszip.js"></script>
    <script src="{{ asset('assets_admin/')}}/vendor/libs/select2/select2.js"></script>
    <script src="{{ asset('assets_admin/')}}/vendor/libs/bootstrap-select/bootstrap-select.js"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets_admin/')}}/js/main.js"></script>
    <script src="{{ asset('assets_admin')}}/vendor/libs/sweetalert2/sweetalert2.js"></script>
    <script src="{{ asset('assets_admin/')}}/js/ui-modals.js"></script>


    <script src="{{ asset('assets_admin/')}}/js/forms-selects.js"></script>
    <script src="{{ asset('assets_admin/')}}/vendor/libs/quill/katex.js"></script>
    <script src="{{ asset('assets_admin/')}}/vendor/libs/quill/quill.js"></script>
    <link rel="stylesheet" href="{{ asset('assets_admin/')}}/vendor/libs/toastr/toastr.js" />

    <script src="{{ asset('assets_admin/')}}/js/forms-editors.js"></script>

    <script src="{{ asset('assets_admin/')}}/js/tables-datatables-basic.js"></script>
    <script>
        $(document).ready(function() {
          // Tampilkan toast
          $('#toast-container').show();

          // Atur timeout untuk menutup toast setelah 2 detik (2000 ms)
          setTimeout(function() {
            $('#toast-container').fadeOut('slow', function() {
              $(this).remove();
            });
          }, 2000);
        });
      </script>
    @yield('js')
  </body>
</html>
