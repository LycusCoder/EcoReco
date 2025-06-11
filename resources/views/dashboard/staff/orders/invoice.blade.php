<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Pesanan #{{ $order->id }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .invoice-container {
            width: 100%;
            max-width: 210mm; /* Lebar A4 */
            margin: 20mm auto;
            padding: 10mm;
            box-sizing: border-box;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10mm;
        }
        .header h1 {
            margin: 0;
            font-size: 24pt;
            color: #2c3e50;
        }
        .header p {
            margin: 5px 0;
            font-size: 10pt;
        }
        .customer-info, .total-section {
            margin: 10mm 0;
        }
        .customer-info p {
            margin: 2mm 0;
            font-size: 10pt;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10pt;
        }
        th, td {
            padding: 5mm;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .total-row {
            font-weight: bold;
            border-top: 2px solid #000;
        }
        .notes {
            margin-top: 10mm;
            font-size: 9pt;
            color: #7f8c8d;
        }
        @page {
            margin: 20mm;
        }
        @media print {
            .invoice-container {
                margin: 0;
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="header">
            <h1>Ecoreco Store</h1>
            <p>Jl. Raya No. 123, Jakarta, Indonesia</p>
            <p>Email: info@ecoreco.com | Tel: +62 812 3456 789</p>
            <h2>INVOICE #{{ $order->id }}</h2>
            <p>Tanggal: {{ $date }}</p>
        </div>

        <div class="customer-info">
            <p><strong>Pelanggan:</strong> {{ $user->name }}</p>
            <p>Email: {{ $user->email }}</p>
            <p>Alamat: {{ $user->address ?? 'Alamat tidak tersedia' }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Deskripsi</th>
                    <th>Kuantitas</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->product->description }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="3">Total Harga:</td>
                    <td>Rp {{ number_format($total_price, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="notes">
            <p><strong>Catatan:</strong> Terima kasih atas pesanan Anda! Silakan simpan invoice ini untuk catatan Anda.</p>
        </div>
    </div>
</body>
</html>