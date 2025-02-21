@extends('template.admin_layout')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">MogoOhana/</span> Kategori</h4>

    <div class="card mb-4">
        <div class="card-header p-0">
          <div class="nav-align-top">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                <button type="button" class="nav-link waves-effect active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-profile" aria-controls="navs-top-profile" aria-selected="true">
                    Edit Data
                </button>
                </li>
            <span class="tab-slider" style="left: 91.1528px; width: 107.111px; bottom: 0px;"></span></ul>
          </div>
        </div>
        <div class="card-body">
          <div class="tab-content p-0">
            <div class="tab-pane fade active show" id="navs-top-profile" role="tabpanel">
                <form action="{{ route('kategori.update', $kategori->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-floating form-floating-outline mb-4">
                        <input type="text" class="form-control" id="basic-default-fullname" name="kategori" placeholder="Kategori" value="{{ $kategori->kategori }}" required/>
                        <label for="basic-default-fullname">Kategori</label>
                    </div>

                    <div class="mb-4">
                        <label for="basic-default-fullname">Banner kategori</label>
                        <input type="file" class="form-control" id="basic-default-fullname" name="foto" placeholder="Banner Kategori" />

                        @if($kategori->foto)
                        <div class="mt-3">
                            <label>Foto Saat Ini:</label>
                            <img src="{{ asset('storage/' . $kategori->foto) }}" alt="Kategori Image" width="200" class="img-thumbnail">
                        </div>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('kategori.index') }}" class="btn btn-danger">Cancel</a>
                </form>
            </div>
          </div>
        </div>
      </div>
</div>
  <!-- / Content -->
@endsection
