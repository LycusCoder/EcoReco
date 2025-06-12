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
            background-color: #f9fafb;
        }
        .invoice-container {
            width: 100%;
            max-width: 210mm; /* Lebar A4 */
            margin: 20mm auto;
            padding: 20mm;
            box-sizing: border-box;
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #2c3e50;
            padding-bottom: 15mm;
            position: relative;
        }
        .header img {
            max-width: 100px;
            margin-bottom: 10mm;
        }
        .header h1 {
            margin: 0;
            font-size: 28pt;
            color: #2c3e50;
            font-weight: 700;
        }
        .header p {
            margin: 5px 0;
            font-size: 11pt;
            color: #7f8c8d;
        }
        .header h2 {
            margin: 5mm 0 0;
            font-size: 18pt;
            color: #34495e;
            font-weight: 600;
        }
        .customer-info, .total-section {
            margin: 15mm 0;
        }
        .customer-info p {
            margin: 3mm 0;
            font-size: 11pt;
            color: #34495e;
        }
        .customer-info strong {
            color: #2c3e50;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11pt;
            margin-bottom: 15mm;
        }
        th, td {
            padding: 8mm 10mm;
            text-align: left;
            border-bottom: 1px solid #ecf0f1;
        }
        th {
            background-color: #f5f7fa;
            font-weight: 600;
            color: #2c3e50;
            text-transform: uppercase;
            letter-spacing: 0.5pt;
        }
        .total-row {
            font-weight: 700;
            border-top: 2px solid #2c3e50;
            background-color: #e8f4f1;
            color: #27ae60;
        }
        .notes {
            margin-top: 15mm;
            font-size: 10pt;
            color: #7f8c8d;
            border-top: 1px dashed #ddd;
            padding-top: 10mm;
        }
        .notes strong {
            color: #34495e;
        }
        @page {
            margin: 20mm;
        }
        @media print {
            .invoice-container {
                margin: 0;
                padding: 0;
                box-shadow: none;
                border-radius: 0;
            }
            .header img {
                max-width: 80px;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="header">
            <img src="{{ asset('images/logo.png') }}" alt="Ecoreco Store Logo" onerror="this.style.display='none';">
            <h1>Ecoreco Store</h1>
            <p>Jl. Raya No. 123, Jakarta, Indonesia</p>
            <p>Email: info@ecoreco.com | Tel: +62 812 3456 789</p>
            <h2>INVOICE #{{ $order->id }}</h2>
            <p>Tanggal: {{ $date }}</p>
        </div>

        <div class="customer-info">
            <p><strong>Pelanggan:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Alamat:</strong> {{ $user->address ?? 'Alamat tidak tersedia' }}</p>
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
            <p><strong>Catatan:</strong> Terima kasih atas pesanan Anda! Silakan simpan invoice ini untuk catatan Anda. Hubungi kami jika ada pertanyaan.</p>
        </div>
    </div>
</body>
</html>