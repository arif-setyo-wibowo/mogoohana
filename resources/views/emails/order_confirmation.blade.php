<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation - MogoOhana</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #4CAF50; color: white; text-align: center; padding: 10px; }
        .content { background-color: #f4f4f4; padding: 20px; }
        .footer { text-align: center; margin-top: 20px; font-size: 0.8em; color: #777; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 10px; text-align: left; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Order Confirmation</h1>
        </div>

        <div class="content">
            <h2>Order Details</h2>
            <p><strong>Order Number:</strong> #{{ $pembelian->nomer_order }}</p>
            <p><strong>Order Date:</strong> {{ \Carbon\Carbon::parse($pembelian->tanggal_order)->format('d F Y') }}</p>
            <p><strong>Email:</strong> {{ $pembelian->email }}</p>

            <h3>Purchased Products</h3>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pembelian->details as $detail)
                    <tr>
                        <td>{{ $detail->produk->nama_produk }}</td>
                        <td>{{ $detail->jumlah }}</td>
                        <td>$ {{ number_format($detail->harga, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2"><strong>Total</strong></td>
                        <td><strong>$ {{ number_format($pembelian->total_harga, 0, ',', '.') }}</strong></td>
                    </tr>
                </tfoot>
            </table>

            <p>Thank you for shopping at MogoOhana!</p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} MogoOhana. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
