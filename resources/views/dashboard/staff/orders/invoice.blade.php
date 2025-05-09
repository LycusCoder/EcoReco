<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Invoice Order #{{ $order->id }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            background-color: #f9fafb;
            color: #1f2937;
            margin: 0;
            padding: 20px;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        .container {
            max-width: 960px;
            margin: 0 auto;
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(99, 102, 241, 0.3);
            padding: 0 24px;
            box-sizing: border-box;
        }
        .header {
            background: linear-gradient(90deg, #4f46e5 0%, #8b5cf6 100%);
            color: white;
            padding: 32px 24px;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            align-items: center;
            gap: 16px;
            box-sizing: border-box;
        }
        .header h1 {
            font-size: 28px;
            font-weight: 900;
            margin: 0;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            text-shadow: 0 2px 6px rgba(0,0,0,0.15);
        }
        .header p.subtitle {
            margin: 6px 0 0;
            font-weight: 600;
            font-size: 14px;
            opacity: 0.85;
            letter-spacing: 0.03em;
        }
        .order-info {
            text-align: right;
            font-size: 14px;
            font-weight: 600;
            line-height: 1.4;
            min-width: 160px;
            box-sizing: border-box;
            word-break: break-word;
        }
        .order-info p {
            margin: 4px 0;
        }
        .order-info span {
            background-color: rgba(255, 255, 255, 0.25);
            padding: 4px 12px;
            border-radius: 12px;
            font-family: monospace;
            font-weight: 700;
            letter-spacing: 0.05em;
            display: inline-block;
            box-shadow: 0 1px 4px rgba(0,0,0,0.1);
            user-select: text;
        }
        .section {
            padding: 40px 24px;
            box-sizing: border-box;
        }
        .section-title {
            font-size: 22px;
            font-weight: 900;
            margin-bottom: 28px;
            padding-bottom: 8px;
            border-bottom: 2px solid #e0e7ff;
            color: #4338ca;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            text-shadow: 0 1px 2px rgba(67, 56, 202, 0.3);
        }
        .details-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 32px;
            font-size: 15px;
            color: #374151;
        }
        .details-grid > div {
            flex: 1 1 30%;
            min-width: 180px;
            box-sizing: border-box;
        }
        .details-grid p {
            margin: 6px 0;
            line-height: 1.5;
            word-wrap: break-word;
            word-break: break-word;
        }
        .label {
            font-weight: 800;
            color: #1e40af;
            margin-bottom: 6px;
            display: block;
            letter-spacing: 0.03em;
        }
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 8px;
            margin-top: 20px;
            font-size: 15px;
            color: #374151;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.15);
            border-radius: 16px;
            overflow: hidden;
            table-layout: fixed;
            word-wrap: break-word;
            word-break: break-word;
        }
        thead tr {
            background-color: #eef2ff;
            color: #4338ca;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.05em;
            font-size: 13px;
            box-shadow: inset 0 -2px 0 #c7d2fe;
        }
        thead th {
            padding: 16px 12px;
            text-align: left;
            user-select: none;
            overflow-wrap: break-word;
            word-wrap: break-word;
            word-break: break-word;
        }
        thead th:nth-child(2),
        thead th:nth-child(4) {
            text-align: right;
        }
        thead th:nth-child(3) {
            text-align: center;
        }
        tbody tr {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            transition: background-color 0.2s ease;
            display: table-row;
        }
        tbody tr:hover {
            background-color: #f0f4ff;
        }
        tbody td {
            padding: 16px 12px;
            vertical-align: middle;
            overflow-wrap: break-word;
            word-wrap: break-word;
            word-break: break-word;
        }
        tbody td:nth-child(2),
        tbody td:nth-child(4) {
            text-align: right;
            font-variant-numeric: tabular-nums;
        }
        tbody td:nth-child(3) {
            text-align: center;
        }
        tr.total {
            background-color: #e0e7ff;
            font-weight: 900;
            color: #3730a3;
            font-size: 17px;
            box-shadow: none;
            border-radius: 0 0 24px 24px;
        }
        tr.total td {
            padding: 20px 16px;
        }
        tr.total td:first-child {
            text-align: right;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }
        .footer {
            background-color: #eef2ff;
            color: #4338ca;
            text-align: center;
            padding: 28px 20px;
            font-weight: 700;
            font-size: 16px;
            border-bottom-left-radius: 24px;
            border-bottom-right-radius: 24px;
            margin-top: 40px;
            user-select: none;
            letter-spacing: 0.03em;
        }
        .footer span.heart {
            color: #ef4444;
            font-size: 20px;
            vertical-align: middle;
            margin-right: 8px;
            user-select: text;
        }
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .container {
                max-width: 100%;
                border-radius: 20px;
                padding: 0 16px;
            }
            .header {
                padding: 24px 16px;
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }
            .header h1 {
                font-size: 26px;
            }
            .order-info {
                text-align: left;
                min-width: auto;
                font-size: 13px;
            }
            .section {
                padding: 32px 16px;
            }
            .section-title {
                font-size: 20px;
                margin-bottom: 20px;
            }
            .details-grid {
                flex-direction: column;
                gap: 20px;
            }
            .details-grid > div {
                flex: 1 1 100%;
                min-width: auto;
            }
            table {
                font-size: 13px;
                border-spacing: 0 6px;
            }
            thead th {
                padding: 12px 8px;
                font-size: 12px;
            }
            tbody td {
                padding: 12px 8px;
            }
            tr.total {
                font-size: 15px;
            }
            tr.total td {
                padding: 16px 8px;
            }
        }
        @media (max-width: 480px) {
            body {
                padding: 12px;
            }
            .header h1 {
                font-size: 22px;
            }
            .header p.subtitle {
                font-size: 12px;
            }
            .order-info {
                font-size: 12px;
            }
            .section-title {
                font-size: 18px;
                margin-bottom: 16px;
            }
            table {
                font-size: 12px;
                border-spacing: 0 4px;
            }
            thead th {
                padding: 10px 6px;
            }
            tbody td {
                padding: 10px 6px;
            }
            tr.total {
                font-size: 14px;
            }
            tr.total td {
                padding: 14px 6px;
            }
        }
    </style>
</head>
<body>
    <div class="container" role="main">
        <!-- Header -->
        <div class="header" role="banner">
            <div>
                <h1>Nota Pesanan</h1>
                <p class="subtitle">Toko Online Kami</p>
            </div>
            <div class="" role="contentinfo" aria-label="Informasi pesanan">
                <p>ID Pesanan: <span>#{{ $order->id }}</span></p>
                <p>Tanggal: <span>{{ $date }}</span></p>
            </div>
        </div>
        <!-- Detail Pelanggan -->
        <div class="section" role="region" aria-labelledby="customer-details-title">
            <h2 class="section-title" id="customer-details-title">Detail Pelanggan</h2>
            <div class="details-grid">
                <div>
                    <p class="label">Nama</p>
                    <p>{{ $user->name }}</p>
                </div>
                <div>
                    <p class="label">Email</p>
                    <p>{{ $user->email }}</p>
                </div>
                <div>
                    <p class="label">Alamat</p>
                    <p>{{ $user->address }}</p>
                </div>
            </div>
        </div>
        <!-- Daftar Produk -->
        <div class="section" role="region" aria-labelledby="product-details-title">
            <h2 class="section-title" id="product-details-title">Rincian Produk</h2>
            <table role="table" aria-describedby="total-payment">
                <thead>
                    <tr>
                        <th scope="col">Produk</th>
                        <th scope="col" style="text-align: right;">Harga</th>
                        <th scope="col" style="text-align: center;">Jumlah</th>
                        <th scope="col" style="text-align: right;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td style="text-align: right;">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td style="text-align: center;">{{ $item->quantity }}</td>
                        <td style="text-align: right;">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                    <tr class="total" aria-label="Total pembayaran">
                        <td colspan="3" style="text-align: right;">Total Pembayaran:</td>
                        <td style="text-align: right;" id="total-payment">Rp {{ number_format($total_price, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Footer -->
        <div class="footer" role="contentinfo">
            <p><span class="heart" aria-hidden="true">❤️</span>Terima kasih telah berbelanja di toko kami!</p>
        </div>
    </div>
</body>
</html>
