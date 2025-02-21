@extends('template.admin_layout')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">MogoOhana/</span> List Contact</h4>

    <!-- Pesan Sukses -->
    @if (session()->has('msg'))
        <div class="alert alert-success">{{ session('msg') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5>Kontak</h5>
        </div>
        <div class="card-body">
            <table id="example1" class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>WhatsApp</th>
                        <th>Instagram</th>
                        <th>Facebook</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contacts as $key => $contact)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $contact->link_discord }}</td>
                            <td>{{ $contact->link_wa }}</td>
                            <td>{{ $contact->link_instagram }}</td>
                            <td>{{ $contact->link_facebook }}</td>
                            <td>
                                <a href="{{ route('contact-admin.edit', $contact->id) }}" class="btn btn-info btn-sm">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
