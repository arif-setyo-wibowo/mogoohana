@extends('template.admin_layout')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">MogoOhana/</span> Faq</h4>

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
                     Faq
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
                            <th>Question</th>
                            <th>Answer</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($faq as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->pertanyaan }}</td>
                            <td>{{ $item->jawaban }}</td>

                            <td>
                                <a href="{{ route('faq.edit', $item->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-pencil-alt"></i>
                                    Edit
                                </a>
                                <form action="{{ route('faq.destroy', $item->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm delete-confirm">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade " id="navs-top-profile" role="tabpanel">
                <form action="{{ route('faq.store')}}" method="POST" >
                    @csrf
                    <div class="form-floating form-floating-outline mb-4">
                        <textarea type="text" class="form-control" id="basic-default-fullname" name="pertanyaan" placeholder="Question" required></textarea>
                        <label for="basic-default-fullname">Question</label>
                    </div>
                    <div class="form-floating form-floating-outline mb-4">
                        <textarea type="text" class="form-control" id="basic-default-fullname" name="jawaban" placeholder="Answer" required></textarea>
                        <label for="basic-default-fullname">Answer</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Store</button>
                </form>
            </div>
          </div>
        </div>
      </div>


</div>
  <!-- / Content -->

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
