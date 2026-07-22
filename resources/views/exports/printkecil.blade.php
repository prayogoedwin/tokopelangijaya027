<!DOCTYPE html>
<html>

<head>
    <title>Nota Pembelian</title>
    <style>
        /* CSS khusus untuk mode cetak */
        @media print {
            @page {
                size: 48mm auto;
                /* Memaksa ukuran kertas thermal 58mm */
                margin: 0;
                /* Menghilangkan margin browser (header/footer tanggal url) */
            }

            body {
                margin: 0;
                padding: 2mm;
                /* Beri sedikit jarak aman di kiri kanan */
                width: 48mm;
                /* Batas lebar konten */
            }
        }

        body {
            font-family: 'Courier New', Courier, monospace;
            /* Font monospace agar rapi */
            font-size: 9px;
            /* Perkecil ukuran font agar muat di 58mm */
            line-height: 1.2;
            color: #000;
        }

        .header {
            text-align: center;
            margin-bottom: 8px;
            border-bottom: 1px dashed #000;
            padding-bottom: 5px;
        }

        .header h2 {
            font-size: 11px;
            margin: 0 0 3px 0;
        }

        .header p {
            margin: 0;
            font-size: 8px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        .table th {
            border-bottom: 1px solid #000;
            text-align: left;
            padding: 2px 0;
            font-size: 8px;
        }

        .table td {
            padding: 3px 0;
            vertical-align: top;
            font-size: 8px;
        }

        .text-right {
            text-align: right;
        }

        .total-section {
            margin-top: 8px;
            border-top: 1px dashed #000;
            padding-top: 5px;
        }

        .total-section td {
            font-size: 8px;
            padding: 1px 0;
        }

        .footer {
            margin-top: 15px;
            text-align: center;
            font-size: 8px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Toko Nouval {{ $toko->status_toko }}</h2>
        <p>{{ $toko->alamat }} <br> Telp: {{ $toko->telp }}</p>
    </div>

    <table style="width: 100%">
        <tr>
            <td>No. Nota: {{ $penjualan->no_invoice }}</td>
            <td class="text-right">Tgl: {{ $penjualan->created_at->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <td>Customer: </td>
            <td></td>
        </tr>
    </table>

    <table class="table">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Qty</th>
                <th>Harga</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penjualan->details as $detail)
            <tr>
                <td>{{ $detail->produk->name }}</td>
                <td>{{ $detail->jumlah }} {{ $detail->produk->satuan }}</td>
                <td>{{ number_format($detail->harga_jual, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($detail->harga_jual * $detail->jumlah, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-section">
        <table style="width: 100%">
            <tr>
                <td style="width: 70%" class="text-right"><strong>Grand Total:</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($penjualan->total_pembelian, 0, ',', '.') }}</strong></td>
            </tr>
            <tr>
                <td style="width: 70%" class="text-right"><strong>Diskon :</strong> {{$penjualan->diskon_percentage}} % </td>
                <td class="text-right"><strong>Rp {{ number_format($penjualan->diskon_nominal, 0, ',', '.') }}</strong></td>
            </tr>
            <tr>
                <td style="width: 70%" class="text-right"><strong>Total Harus Dibayar :</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($penjualan->total_harus_dibayar, 0, ',', '.') }}</strong></td>
            </tr>
            <tr>
                <td style="width: 70%" class="text-right"><strong>Dibayar :</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($penjualan->dibayar, 0, ',', '.') }}</strong></td>
            </tr>
            <tr>
                <td style="width: 70%" class="text-right"><strong>kembalian :</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($penjualan->kembalian, 0, ',', '.') }}</strong></td>
            </tr>
        </table>
    </div>

    <div class="footer" style="text-align: center; margin-top: 20px;">
        <p style="font-size: 11px; margin-bottom: 15px;">
            Barang yang sudah dibeli tidak dapat dikembalikan kecuali ada perjanjian
        </p>
        <p style="font-weight: bold; line-height: 1.5;">
            TERIMA KASIH <br/> 
            JUAL SE’ADA NYA BARELA’AN
        </p>
    </div>
</body>

</html>