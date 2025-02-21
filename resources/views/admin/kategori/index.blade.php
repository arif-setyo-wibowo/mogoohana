@extends('template.admin_layout')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">MogoOhana/</span> Category</h4>

    <div class="card mb-4">
        <div class="card-header p-0">
          <!-- Success Alert -->
            @if (session()->has('msg'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Success!',
                        text: '{{ session('msg') }}',
                        icon: 'success',
                        customClass: {
                            confirmButton: 'btn btn-primary waves-effect waves-light'
                        },
                        buttonsStyling: false
                    });
                });
            </script>
            @endif

            <!-- Error Alert -->
            @if (session()->has('error'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Error!',
                        text: '{{ session('error') }}',
                        icon: 'error',
                        customClass: {
                            confirmButton: 'btn btn-primary waves-effect waves-light'
                        },
                        buttonsStyling: false
                    });
                });
            </script>
            @endif

            <!-- Validation Errors Alert -->
            @if ($errors->any())
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Error!',
                        html: '{!! implode("<br>", $errors->all()) !!}',
                        icon: 'error',
                        customClass: {
                            confirmButton: 'btn btn-primary waves-effect waves-light'
                        },
                        buttonsStyling: false
                    });
                });
            </script>
            @endif

          <div class="nav-align-top">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link waves-effect active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-home" aria-controls="navs-top-home" aria-selected="false" tabindex="-1">
                     Category
                    </button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link waves-effect" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-profile" aria-controls="navs-top-profile" aria-selected="true">
                      Add New Data
                    </button>
                  </li>
            <span class="tab-slider" style="left: 91.1528px; width: 107.111px; bottom: 0px;"></span></ul>
          </div>
        </div>
        <div class="card-body">
          <div class="tab-content p-0">
            <div class="tab-pane fade active show" id="navs-top-home" role="tabpanel">
                <table id="example1" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Category</th>
                            <th>Banner</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kategori as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->kategori }}</td>
                            <td>
                                @if($item->foto)
                                <img src="{{ asset('storage/' . $item->foto) }}"
                                    style="cursor: pointer;"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalCenter-{{ $item->id }}"
                                    alt="Kategori Image"
                                    width="125">
                                @else
                                There is no image
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('kategori.edit', $item->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-pencil-alt"></i>
                                    Edit
                                </a>
                                <form action="{{ route('kategori.destroy', $item->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm delete-confirm">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal for each image -->
                        @if($item->foto)
                        <div class="modal fade" id="modalCenter-{{ $item->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Category Image: {{ $item->kategori }}</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col mb-4 mt-2">
                                                <div class="form-floating form-floating-outline">
                                                    <img src="{{ asset('storage/' . $item->foto) }}" alt="Kategori Image" width="100%">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade " id="navs-top-profile" role="tabpanel">
                <form action="{{ route('kategori.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-floating form-floating-outline mb-4">
                        <input type="text" class="form-control" id="basic-default-fullname" name="kategori" placeholder="Category" required/>
                        <label for="basic-default-fullname">Category</label>
                    </div>

                    <div class="mb-4">
                        <label for="basic-default-fullname">Banner Category</label>
                        <input type="file" class="form-control" id="basic-default-fullname" name="foto" placeholder="Banner Category" />
                    </div>
                    <button type="submit" class="btn btn-primary">Store</button>
                </form>
            </div>
          </div>
        </div>
      </div>


</div>
  <!-- / Content -->

  <!-- Modal -->
  <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title" id="modalCenterTitle">Gambar</h4>
        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <div class="row">
            <div class="col mb-4 mt-2">
            <div class="form-floating form-floating-outline">
                <img src="{{ asset('assets/imgs/banner/banner-menu.png') }}"
                    alt="Produk Image"
                    width="100%">
            </div>
            </div>
        </div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Close
        </button>
        </div>
    </div>
    </div>
</div>
@endsection
@section('js')
<script>
    // Delete confirmation for all delete buttons
    document.querySelectorAll('.delete-confirm').forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const form = this.closest('form');

            Swal.fire({
                title: 'Apakah Yakin ingin menghapus data?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
                    cancelButton: 'btn btn-outline-secondary waves-effect'
                },
                buttonsStyling: false
            }).then(function (result) {
                if (result.value) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection
