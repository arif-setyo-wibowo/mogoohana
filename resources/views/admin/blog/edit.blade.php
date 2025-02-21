@extends('template.admin_layout')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">MogoOhana /</span> Blog Edit</h4>

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
                <form action="{{ route('blog.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-floating form-floating-outline mb-4">
                        <input type="text" class="form-control" id="basic-default-fullname" name="judul" placeholder="Title" value="{{ $blog->judul }}" required/>
                        <label for="basic-default-fullname">Title</label>
                    </div>

                    <div class="mb-4">
                        <label for="basic-default-fullname">Banner</label>
                        <input type="file" class="form-control" id="basic-default-fullname" name="foto" placeholder="Banner" />

                        @if($blog->foto)
                        <div class="mt-3">
                            <label>Current Photo :</label>
                            <img src="{{ asset('storage/' . $blog->foto) }}" alt="Blog Image" width="200" class="img-thumbnail">
                        </div>
                        @endif
                    </div>
                    <div class="mb-4">
                        <label for="deskripsi" class="form-label">Description</label>
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
                        <div id="snow-editor" style="min-height: 150px;">{!! old('deskripsi', $blog->deskripsi) !!}</div>
                        <input type="hidden" name="deskripsi" id="deskripsi-input">
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('blog.index') }}" class="btn btn-danger">Cancel</a>
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
