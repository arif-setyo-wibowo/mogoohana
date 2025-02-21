@extends('template.admin_layout')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">MogoOhana/</span> Edit Coupon</h4>

    <div class="card mb-4">
        <div class="card-header p-0">
          <div class="nav-align-top">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                <button type="button" class="nav-link waves-effect active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-profile" aria-controls="navs-top-profile" aria-selected="true">
                    Edit Kupon
                </button>
                </li>
            </ul>
          </div>
        </div>
        <div class="card-body">
          <div class="tab-content p-0">
            <div class="tab-pane fade active show" id="navs-top-profile" role="tabpanel">
                <form action="{{ route('kupon.update', $kupon->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="kode" name="kode" placeholder="Kode Kupon" required value="{{ old('kode', $kupon->kode) }}"/>
                                <label for="kode">Kode Kupon</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="form-floating form-floating-outline">
                                <select class="form-select" id="tipe" name="tipe" required>
                                    <option value="persen" {{ old('tipe', $kupon->tipe) == 'persen' ? 'selected' : '' }}>Persentase</option>
                                    <option value="nominal" {{ old('tipe', $kupon->tipe) == 'nominal' ? 'selected' : '' }}>Nominal</option>
                                </select>
                                <label for="tipe">Tipe Kupon</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="form-floating form-floating-outline">
                                <input type="number" step="0.01" class="form-control" id="nilai" name="nilai" placeholder="Nilai Kupon" required value="{{ old('nilai', $kupon->nilai) }}"/>
                                <label for="nilai">Nilai Kupon</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="form-floating form-floating-outline">
                                <input type="number" step="0.01" class="form-control" id="minimal_belanja" name="minimal_belanja" placeholder="Minimal Belanja" value="{{ old('minimal_belanja', $kupon->minimal_belanja) }}"/>
                                <label for="minimal_belanja">Minimal Belanja</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="form-floating form-floating-outline">
                                <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai', $kupon->tanggal_mulai ? $kupon->tanggal_mulai->format('Y-m-d') : '') }}"/>
                                <label for="tanggal_mulai">Tanggal Mulai</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="form-floating form-floating-outline">
                                <input type="date" class="form-control" id="tanggal_berakhir" name="tanggal_berakhir" value="{{ old('tanggal_berakhir', $kupon->tanggal_berakhir ? $kupon->tanggal_berakhir->format('Y-m-d') : '') }}"/>
                                <label for="tanggal_berakhir">Tanggal Berakhir</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="form-floating form-floating-outline">
                                <input type="number" class="form-control" id="jumlah_kupon" name="jumlah_kupon" placeholder="Jumlah Kupon" required value="{{ old('jumlah_kupon', $kupon->jumlah_kupon) }}"/>
                                <label for="jumlah_kupon">Jumlah Kupon</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="form-floating form-floating-outline">
                                <select class="form-select" id="status" name="status" required>
                                    <option value="aktif" {{ old('status', $kupon->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="non-aktif" {{ old('status', $kupon->status) == 'non-aktif' ? 'selected' : '' }}>Non-Aktif</option>
                                </select>
                                <label for="status">Status</label>
                            </div>
                        </div>
                        <div class="col-12 mb-4">
                            <div class="form-floating form-floating-outline">
                                <textarea class="form-control" id="deskripsi" name="deskripsi" placeholder="Deskripsi Kupon" rows="3">{{ old('deskripsi', $kupon->deskripsi) }}</textarea>
                                <label for="deskripsi">Deskripsi Kupon</label>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('kupon.index') }}" class="btn btn-danger">Cancel</a>
                    </div>
                </form>
            </div>
          </div>
        </div>
      </div>
</div>
@endsection
