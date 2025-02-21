@extends('template.admin_layout')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">MogoOhana /</span> Edit Contact</h4>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Edit Kontak</h5>
                </div>
                <div class="card-body">
                    <!-- Pesan Error -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('contact-admin.update', $contact->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="link_wa" class="form-label">Link WhatsApp</label>
                            <input type="text" class="form-control" id="link_wa" name="link_wa" value="{{ old('link_wa', $contact->link_wa) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="link_instagram" class="form-label">Link Instagram</label>
                            <input type="text" class="form-control" id="link_instagram" name="link_instagram" value="{{ old('link_instagram', $contact->link_instagram) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="link_facebook" class="form-label">Link Facebook</label>
                            <input type="text" class="form-control" id="link_facebook" name="link_facebook" value="{{ old('link_facebook', $contact->link_facebook) }}" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('contact-admin.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
