@extends('template.admin_layout')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">MogoOhana/</span> Kupon</h4>

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
                     Kupon
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
                            <th>Kode</th>
                            <th>Tipe</th>
                            <th>Nilai</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Berakhir</th>
                            <th>Jumlah Kupon</th>
                            <th>Sisa</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kupon as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->kode }}</td>
                            <td>{{ $item->tipe === 'persen' ? 'Persentase' : 'Nominal' }}</td>
                            <td>{{ $item->tipe === 'persen' ? $item->nilai . '%' : '$ ' . number_format($item->nilai, 2) }}</td>
                            <td>{{ $item->tanggal_mulai ? \Carbon\Carbon::parse($item->tanggal_mulai)->format('d F Y') : '-' }}</td>
                            <td>{{ $item->tanggal_berakhir ? \Carbon\Carbon::parse($item->tanggal_berakhir)->format('d F Y') : '-' }}</td>
                            <td>{{ $item->jumlah_kupon }}</td>
                            <td>{{ ($item->jumlah_kupon - $item->jumlah_terpakai) }}</td>
                            <td>
                                @if($item->status === 'aktif')
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-danger">Non-Aktif</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('kupon.edit', $item->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-pencil-alt"></i> Edit
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="navs-top-profile" role="tabpanel">
                <form action="{{ route('kupon.store')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="kode" name="kode" placeholder="Kode Kupon" required value="{{ old('kode') }}"/>
                                <label for="kode">Kode Kupon</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="form-floating form-floating-outline">
                                <select class="form-select" id="tipe" name="tipe" required>
                                    <option value="persen" {{ old('tipe') == 'persen' ? 'selected' : '' }}>Persentase</option>
                                    <option value="nominal" {{ old('tipe') == 'nominal' ? 'selected' : '' }}>Nominal</option>
                                </select>
                                <label for="tipe">Tipe Kupon</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="form-floating form-floating-outline">
                                <input type="number" step="0.01" class="form-control" id="nilai" name="nilai" placeholder="Nilai Kupon" required value="{{ old('nilai') }}"/>
                                <label for="nilai">Nilai Kupon</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="form-floating form-floating-outline">
                                <input type="number" step="0.01" class="form-control" id="minimal_belanja" name="minimal_belanja" placeholder="Minimal Belanja" value="{{ old('minimal_belanja', 0) }}"/>
                                <label for="minimal_belanja">Minimal Belanja</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="form-floating form-floating-outline">
                                <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}"/>
                                <label for="tanggal_mulai">Tanggal Mulai</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="form-floating form-floating-outline">
                                <input type="date" class="form-control" id="tanggal_berakhir" name="tanggal_berakhir" value="{{ old('tanggal_berakhir') }}"/>
                                <label for="tanggal_berakhir">Tanggal Berakhir</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="form-floating form-floating-outline">
                                <input type="number" class="form-control" id="jumlah_kupon" name="jumlah_kupon" placeholder="Jumlah Kupon" required value="{{ old('jumlah_kupon', 0) }}"/>
                                <label for="jumlah_kupon">Jumlah Kupon</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="form-floating form-floating-outline">
                                <select class="form-select" id="status" name="status" required>
                                    <option value="aktif" {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="non-aktif" {{ old('status') == 'non-aktif' ? 'selected' : '' }}>Non-Aktif</option>
                                </select>
                                <label for="status">Status</label>
                            </div>
                        </div>
                        <div class="col-12 mb-4">
                            <div class="form-floating form-floating-outline">
                                <textarea class="form-control" id="deskripsi" name="deskripsi" placeholder="Deskripsi Kupon" rows="3">{{ old('deskripsi') }}</textarea>
                                <label for="deskripsi">Deskripsi Kupon</label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Add New Kupon</button>
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
