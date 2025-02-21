@extends('template.home_layout')
@section('content')

<main class="main pages">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ route('home.index')}}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a> <span></span> My Account
            </div>
        </div>
    </div>
    <div class="page-content pt-150 pb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 m-auto">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="dashboard-menu">
                                <ul class="nav flex-column" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="dashboard-tab" data-bs-toggle="tab" href="#dashboard" role="tab" aria-controls="dashboard" aria-selected="false"><i class="fi-rs-settings-sliders mr-10"></i>Dashboard</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="orders-tab" data-bs-toggle="tab" href="#orders" role="tab" aria-controls="orders" aria-selected="false"><i class="fi-rs-shopping-bag mr-10"></i>Orders</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="account-detail-tab" data-bs-toggle="tab" href="#account-detail" role="tab" aria-controls="account-detail" aria-selected="true"><i class="fi-rs-user mr-10"></i>Account details</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="change-password-tab" data-bs-toggle="tab" href="#change-password" role="tab" aria-controls="change-password" aria-selected="true"><i class="fi-rs-lock mr-10"></i>Change Password</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="tab-content account dashboard-content pl-50">
                                <div class="tab-pane fade active show" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="mb-0">Hello {{ Auth::user()->display_name }}</h3>
                                        </div>
                                        <div class="card-body">
                                            <p>
                                                Check your order history and change your account details
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="mb-0">Your Orders</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Order Number</th>
                                                            <th>Date</th>
                                                            <th>Status</th>
                                                            <th>Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($orders as $order)
                                                        <tr>
                                                            <td>{{ $order->nomer_order }}</td>
                                                            <td>{{ $order->tanggal_order->format('F d, Y') }}</td>
                                                            <td>
                                                                <span class=" 
                                                                    @switch($order->status)
                                                                        @case('pending') text-warning @break
                                                                        @case('diterima') text-success @break
                                                                    @endswitch
                                                                ">
                                                                    @if($order->status == 'diterima')
                                                                        Completed
                                                                    @else
                                                                        {{ ucfirst($order->status) }}
                                                                    @endif
                                                                </span>
                                                            </td>
                                                            <td>${{ number_format($order->total_harga, 2) }} 
                                                                ({{ $order->details->count() }} item{{ $order->details->count() != 1 ? 's' : '' }})
                                                            </td>
                                                        </tr>
                                                        @empty
                                                        <tr>
                                                            <td colspan="5" class="text-center">
                                                                <p>You have no orders yet.</p>
                                                            </td>
                                                        </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="account-detail" role="tabpanel" aria-labelledby="account-detail-tab">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Change account data</h5>
                                        </div>
                                        <div class="card-body">
                                            <form method="POST" action="{{ route('my-account.update-details') }}">
                                                @csrf
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label>Full Name</label>
                                                        <input required="" class="form-control" name="name" type="text" 
                                                               value="{{ Auth::user()->name }}" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Display Name <span class="required">*</span></label>
                                                        <input required="" class="form-control" name="display_name" type="text" 
                                                               value="{{ Auth::user()->display_name }}" />
                                                        <em>This will be how your name will be displayed in the account section</em>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Email Address <span class="required">*</span></label>
                                                        <input required="" class="form-control" name="email" type="email" 
                                                               value="{{ Auth::user()->email }}" />
                                                    </div>
                                                    <div class="col-md-12">
                                                        <button type="submit" class="btn btn-fill-out submit font-weight-bold">Save Changes</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="change-password" role="tabpanel" aria-labelledby="change-password-tab">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Change Password</h5>
                                        </div>
                                        <div class="card-body">
                                            <form id="change-password-form" method="POST" action="{{ route('my-account.change-password') }}">
                                                @csrf
                                                <div class="row">
                                                    <div class="form-group col-md-12">
                                                        <label>Current Password</label>
                                                        <input class="form-control" id="current_password" name="current_password" type="password" required />
                                                        <div class="invalid-feedback current-password-error"></div>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label>New Password</label>
                                                        <input class="form-control" id="new_password" name="new_password" type="password" required minlength="8" />
                                                        <div class="invalid-feedback new-password-error"></div>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label>Confirm New Password</label>
                                                        <input class="form-control" id="new_password_confirmation" name="new_password_confirmation" type="password" required minlength="8" />
                                                        <div class="invalid-feedback confirm-password-error"></div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <button type="submit" class="btn btn-fill-out submit font-weight-bold">Change Password</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success_message'))
            Swal.fire({
                icon: 'success',
                text: '{{ session('success_message') }}',
                toast: true,
                showConfirmButton: false,
                position: 'top-end',
                timer: 3000
            });
        @endif

        @if(session('error_message'))
            Swal.fire({
                icon: 'error',
                text: '{{ session('error_message') }}',
                toast: true,
                showConfirmButton: false
                position: 'top-end',
                timer: 3000
            });
        @endif

        @if($errors->any())
            Swal.fire({
                icon: 'error',
                html: `
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                `,
                position: 'top-end',
                toast: true,
                showConfirmButton: false,
                timer: 3000
            });
        @endif

        // Password Change Form Validation
        const passwordForm = document.getElementById('change-password-form');
        
        passwordForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Reset previous error states
            const inputs = passwordForm.querySelectorAll('input');
            inputs.forEach(input => {
                input.classList.remove('is-invalid');
            });
            
            const currentPassword = document.getElementById('current_password');
            const newPassword = document.getElementById('new_password');
            const confirmPassword = document.getElementById('new_password_confirmation');
            
            let isValid = true;
            
            // Current Password Validation
            if (!currentPassword.value.trim()) {
                currentPassword.classList.add('is-invalid');
                isValid = false;
            }
            
            // New Password Validation
            if (!newPassword.value.trim()) {
                newPassword.classList.add('is-invalid');
                isValid = false;
            } else if (newPassword.value.length < 8) {
                newPassword.classList.add('is-invalid');
                isValid = false;
            }
            
            // Confirm Password Validation
            if (!confirmPassword.value.trim()) {
                confirmPassword.classList.add('is-invalid');
                isValid = false;
            } else if (newPassword.value !== confirmPassword.value) {
                confirmPassword.classList.add('is-invalid');
                isValid = false;
            }
            
            // If validation fails, stop submission
            if (!isValid) {
                return;
            }
            
            // AJAX Form Submission
            fetch('{{ route('my-account.change-password') }}', {
                method: 'POST',
                body: new FormData(passwordForm),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        text: data.message,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    
                    // Reset form
                    passwordForm.reset();
                } else {
                    Swal.fire({
                        icon: 'error',
                        text: data.message,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    text: 'An unexpected error occurred. Please try again.',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
            });
        });
    });
</script>
@endsection
