@extends('template.admin_layout')

@section('css')
<!-- Quill CSS -->
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/typography.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/katex.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/editor.css') }}" />
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">MogoOhana/</span> Produk Update</h4>

    <div class="card mb-4">
        <div class="card-header p-0">
          <div class="nav-align-top">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                <button type="button" class="nav-link waves-effect active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-profile" aria-controls="navs-top-profile" aria-selected="true">
                    Edit Data
                </button>
                </li>
            </ul>
          </div>
        </div>
        <div class="card-body">
          <div class="tab-content p-0">
            <div class="tab-pane fade active show" id="navs-top-profile" role="tabpanel">
                <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-floating form-floating-outline mb-4">
                        <input type="text" class="form-control" id="nama_produk" name="nama_produk"
                               value="{{ old('nama_produk', $produk->nama_produk) }}" placeholder="Nama Produk" required/>
                        <label for="nama_produk">Nama Produk</label>
                    </div>
                    <div class="form-floating form-floating-outline mb-4">
                        <label>Kategori</label>
                        <select class="selectpicker w-100" data-style="btn-default" name="id_kategori"
                            data-live-search="true" required>
                            <option selected disabled value="">Pilih Kategori</option>
                            @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}"
                                {{ $produk->id_kategori == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->kategori }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-floating form-floating-outline mb-4">
                        <input type="number" class="form-control" id="stok" name="stok"
                               value="{{ old('stok', $produk->stok) }}" placeholder="Stok" required/>
                        <label for="stok">Stok</label>
                    </div>

                    <div class="form-floating form-floating-outline mb-4">
                        <input type="text" class="form-control" id="harga" name="harga"
                               value="{{ old('harga', number_format($produk->harga, 2, '.', '')) }}"
                               placeholder="Harga Jual" pattern="^\d+(\.\d{1,2})?$" required/>
                        <label for="harga">Harga Jual ( Ditampilkan hijau )</label>
                    </div>
                    <div class="form-floating form-floating-outline mb-4">
                        <input type="text" class="form-control" id="harga_diskon" name="harga_diskon"
                               value="{{ old('harga_diskon', number_format($produk->harga_diskon, 2, '.', '')) }}"
                               placeholder="Harga Asli" pattern="^\d+(\.\d{1,2})?$"/>
                        <label for="harga_diskon">Harga Awal ( Dicoret ) (opsional)</label>
                    </div>
                    <div class="mb-4">
                        <label for="foto">Foto Produk</label>
                        <input type="file" class="form-control" id="foto" name="foto" />
                        @if($produk->foto)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $produk->foto) }}"
                                 alt="Current Produk Image"
                                 style="max-width: 200px; max-height: 200px;">
                            <small class="d-block">Gambar saat ini</small>
                        </div>
                        @endif
                    </div>
                    <div class="mb-4">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <div id="snow-toolbar">
                            <span class="ql-formats">
                                <select class="ql-font"></select>
                                <select class="ql-size"></select>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-bold"></button>
                                <button class="ql-italic"></button>
                                <button class="ql-underline"></button>
                                <button class="ql-strike"></button>
                            </span>
                            <span class="ql-formats">
                                <select class="ql-color"></select>
                                <select class="ql-background"></select>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-list" value="ordered"></button>
                                <button class="ql-list" value="bullet"></button>
                            </span>
                        </div>
                        <div id="snow-editor" style="min-height: 150px;">{!! old('deskripsi', $produk->deskripsi) !!}</div>
                        <input type="hidden" name="deskripsi" id="deskripsi-input">
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('produk.index') }}" class="btn btn-danger">Cancel</a>
                </form>
            </div>
          </div>
        </div>
      </div>
</div>
@endsection

@section('js')
<!-- Quill JS -->
<script src="{{ asset('assets/vendor/libs/quill/katex.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/quill/quill.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var toolbarOptions = [
        ['bold', 'italic', 'underline', 'strike'],
        ['blockquote', 'code-block'],
        [{ 'header': 1 }, { 'header': 2 }],
        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
        [{ 'script': 'sub'}, { 'script': 'super' }],
        [{ 'indent': '-1'}, { 'indent': '+1' }],
        [{ 'direction': 'rtl' }],
        [{ 'size': ['small', false, 'large', 'huge'] }],
        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
        [{ 'color': [] }, { 'background': [] }],
        [{ 'font': [] }],
        [{ 'align': [] }],
        ['clean']
    ];

    var quill = new Quill('#snow-editor', {
        modules: {
            toolbar: '#snow-toolbar'
        },
        theme: 'snow'
    });

    // Update hidden input before form submission
    document.querySelector('form').addEventListener('submit', function() {
        document.getElementById('deskripsi-input').value = quill.root.innerHTML;
    });
});
</script>
@endsection
