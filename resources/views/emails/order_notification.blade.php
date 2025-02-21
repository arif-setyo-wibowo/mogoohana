<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation - MogoOhana</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #f4f4f4; padding: 10px; text-align: center; }
        .order-details { background-color: #fff; padding: 20px; border: 1px solid #ddd; }
        .product-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .product-table th, .product-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .total { text-align: right; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>MogoOhana - Order Confirmation</h1>
        </div>

        <div class="order-details">
            <h2>Order Details</h2>
            <p><strong>Order Number:</strong> {{ $order->nomer_order }}</p>
            <p><strong>Order Date:</strong> {{ $order->tanggal_order->format('d F Y H:i:s') }}</p>

            <h3>Customer Information</h3>
            <p><strong>Name:</strong> {{ $order->name }}</p>
            <p><strong>Email:</strong> {{ $order->email }}</p>

            <h3>Game Account Details</h3>
            <p><strong>Username:</strong> {{ $order->username }}</p>
            <p><strong>Facebook:</strong> {{ $order->facebook }}</p>
            <p><strong>Link:</strong> {{ $order->link }}</p>

            <h3>Order Items</h3>
            <table class="product-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orderDetails as $detail)
                    <tr>
                        <td>{{ $detail->produk->nama_produk }}</td>
                        <td>{{ $detail->jumlah }}</td>
                        <td>${{ number_format($detail->harga, 2) }}</td>
                        <td>${{ number_format($detail->jumlah * $detail->harga, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="total">Total:</td>
                        <td class="total">${{ number_format($order->total_harga, 2) }}</td>
                    </tr>
                </tfoot>
            </table>

            <h3>Payment Method</h3>
            <p>{{ $order->metode_pembayaran }}</p>

            @if($order->note)
            <h3>Additional Notes</h3>
            <p>{{ $order->note }}</p>
            @endif
        </div>

        <div class="footer" style="text-align: center; margin-top: 20px; font-size: 12px; color: #777;">
            <p>© {{ date('Y') }} MogoOhana. All rights reserved.</p>
            <p>Need help? Contact us</p>
        </div>
    </div>
</body>
</html>
