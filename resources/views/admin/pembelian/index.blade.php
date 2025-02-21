@extends('template.admin_layout')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">MogoOhana/</span> Purchase</h4>

    <div class="card mb-4">
        <div class="card-header p-0">
            <!-- Success Alert -->
            @if (session()->has('msg'))
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        title: 'Success!',
                        text: '{{ session("msg") }}',
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
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        title: 'Error!',
                        text: '{{ session('
                        error ') }}',
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
                document.addEventListener('DOMContentLoaded', function () {
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
                        <button type="button" class="nav-link waves-effect active" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-top-home" aria-controls="navs-top-home" aria-selected="false"
                            tabindex="-1">
                            Product
                        </button>
                    </li>
                    <span class="tab-slider" style="left: 91.1528px; width: 107.111px; bottom: 0px;"></span>
                </ul>
            </div>
        </div>
        <div class="card-body">
            <div class="tab-content p-0">
                <div class="tab-pane fade active show" id="navs-top-home" role="tabpanel">
                    <table id="example1" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Order Number</th>
                                <th>Email</th>
                                <th>Order Date</th>
                                <th>Total Price</th>
                                <th>Payment Proof</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pembelians as $index => $pembelian)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>#{{ $pembelian->nomer_order }}</td>
                                <td>{{ $pembelian->email }}</td>
                                <td>{{ \Carbon\Carbon::parse($pembelian->tanggal_order)->format('d F Y') }}</td>
                                <td>$ {{ number_format($pembelian->total_harga, 0, ',', '.') }}</td>
                                <td>
                                    @if($pembelian->bukti_transfer)
                                    <img src="{{ asset('storage/' . $pembelian->bukti_transfer) }}"
                                        style="cursor: pointer;" data-bs-toggle="modal"
                                        data-bs-target="#modalCenter{{ $pembelian->id }}" alt="Bukti Pembayaran"
                                        width="125">
                                    @else
                                    -
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-success btn-sm open-modal"
                                        data-bs-toggle="modal" data-bs-target="#modalProduk{{ $pembelian->id }}"
                                        alt="Produk">
                                        <i class="mdi mdi-information"></i>  Product Details
                                    </button>
                                    @if($pembelian->status == 'pending')
                                    <button type="button" class="btn btn-info btn-sm"
                                        data-bs-toggle="modal" data-bs-target="#modalKonfirmasi{{ $pembelian->id }}">
                                        <i class="mdi mdi-thumb-up"></i> Confirmation
                                    </button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @foreach($pembelians as $pembelian)
    <!-- Modal Bukti Pembayaran -->
    <div class="modal fade" id="modalCenter{{ $pembelian->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Payment Proof - Order #{{ $pembelian->nomer_order }}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-4 mt-2">
                            <img src="{{ asset('storage/' . $pembelian->bukti_transfer) }}" alt="Payment Proof"
                                width="100%">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Produk -->
    <div class="modal fade" id="modalProduk{{ $pembelian->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Purchased Product Details - Order #{{ $pembelian->nomer_order }}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h5>Order Information</h5>
                            <p><strong>Order Number:</strong> {{ $pembelian->nomer_order }}</p>
                            <p><strong>Order Date:</strong>
                                {{ \Carbon\Carbon::parse($pembelian->tanggal_order)->format('d F Y') }}</p>
                            <p><strong>Email:</strong> {{ $pembelian->email }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5>Payment Summary</h5>
                            <p><strong>Total Price:</strong> $ {{ number_format($pembelian->total_harga, 0, ',', '.') }}
                            </p>
                            <p><strong>Status:</strong> {{ $pembelian->status == 'pending' ? 'Pending' : 'Complete' }}
                            </p>
                            <p><strong>Payment Method:</strong> {{ $pembelian->metode_pembayaran }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5>Account Summary</h5>
                            <p><strong>Username:</strong> {{ $pembelian->username }}</p>
                            <p><strong>Facebook:</strong> {{ $pembelian->facebook }}</p>
                            <p><strong>Link:</strong><a href="{{ $pembelian->link }}">{{ $pembelian->link }}</a></p>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Total Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pembelian->details as $index => $detail)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $detail->produk->nama_produk }}</td>
                                    <td>{{ $detail->jumlah }}</td>
                                    <td>$ {{ number_format($detail->harga / $detail->jumlah, 0, ',', '.') }}</td>
                                    <td>$ {{ number_format($detail->harga, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi -->
    <div class="modal fade" id="modalKonfirmasi{{ $pembelian->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Purchase Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.pembelian.konfirmasi', $pembelian->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p>Are you sure you want to confirm this purchase?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Yes, Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

</div>

@endsection
