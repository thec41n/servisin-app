<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>E-Receipt - {{ $order->tracking_code }}</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            color: #333;
        }

        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
        }

        .details p {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>E-Receipt Servis.in</h2>
            <p>Kode Pelacakan: <strong>{{ $order->tracking_code }}</strong></p>
        </div>

        <div class="details">
            <h4>Detail Pelanggan</h4>
            <p><strong>Nama:</strong> {{ $order->name }}</p>
            <p><strong>Email:</strong> {{ $order->email }}</p>
            <p><strong>No. Telepon:</strong> {{ $order->phone_number }}</p>
        </div>

        <h4>Detail Pesanan</h4>
        <table>
            <thead>
                <tr>
                    <th>Layanan</th>
                    <th>Detail Kendala</th>
                    <th>Estimasi Biaya</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $order->service->name }}</td>
                    <td>{{ $order->item_detail }}</td>
                    <td>Rp {{ number_format($order->service->price, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="footer">
            <p>Terima kasih telah menggunakan jasa kami.</p>
            <p>Dicetak pada: {{ now()->format('d M Y, H:i') }}</p>
        </div>
    </div>
</body>

</html>