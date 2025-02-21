@extends('template.admin_layout')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="py-3 mb-4"><span class="text-muted fw-light">MogoOhana/</span> Dashboard</h4>

  <!-- Card Border Shadow -->
  <div class="row">
    <div class="col-sm-6 col-lg-3 mb-4">
      <div class="card card-border-shadow-primary h-100">
        <div class="card-body">
          <div class="d-flex align-items-center mb-2 pb-1">
            <div class="avatar me-2">
              <span class="avatar-initial rounded bg-label-primary">
                <i class="mdi mdi-shape-outline"></i>
              </span>
            </div>
            <h4 class="ms-1 mb-0">{{ $totalKategori }}</h4>
          </div>
          <p class="mb-1">Category Total </p>
          <p class="mb-0">
            <a href="{{ route('kategori.index') }}" class="text-muted">See More</a>
          </p>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-lg-3 mb-4">
      <div class="card card-border-shadow-info h-100">
        <div class="card-body">
          <div class="d-flex align-items-center mb-2 pb-1">
            <div class="avatar me-2">
              <span class="avatar-initial rounded bg-label-info">
                <i class="mdi mdi-archive-outline"></i>
              </span>
            </div>
            <h4 class="ms-1 mb-0">{{ $totalProduk }}</h4>
          </div>
          <p class="mb-1">Product Total</p>
          <p class="mb-0">
            <a href="{{ route('produk.index') }}" class="text-muted">See More</a>
          </p>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-lg-3 mb-4">
      <div class="card card-border-shadow-success h-100">
        <div class="card-body">
          <div class="d-flex align-items-center mb-2 pb-1">
            <div class="avatar me-2">
              <span class="avatar-initial rounded bg-label-success">
                <i class="mdi mdi-cart-outline"></i>
              </span>
            </div>
            <h4 class="ms-1 mb-0">{{ $totalPembelian }}</h4>
          </div>
          <p class="mb-1"> Purchase Total</p>
          <p class="mb-0">
            <a href="{{ route('pembelian.index') }}" class="text-muted">See More</a>
          </p>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-lg-3 mb-4">
      <div class="card card-border-shadow-warning h-100">
        <div class="card-body">
          <div class="d-flex align-items-center mb-2 pb-1">
            <div class="avatar me-2">
              <span class="avatar-initial rounded bg-label-warning">
                <i class="mdi mdi-account-outline"></i>
              </span>
            </div>
            <h4 class="ms-1 mb-0">{{ $totalUser }}</h4>
          </div>
          <p class="mb-1"> User Total</p>
          <p class="mb-0">
            <a href="{{ route('user-admin.index') }}" class="text-muted">See More</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- / Content -->
@endsection
