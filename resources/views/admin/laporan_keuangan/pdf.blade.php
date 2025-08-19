<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan</title>
    <style>
        body {
            font-family: "Times New Roman", serif;
            font-size: 13px;
            background-color: #fff;
            color: #222;
            margin: 20px;
        }

        h2 {
            text-align: center;
            margin: 0;
            font-size: 20px;
            color: #1a3d7c; /* biru tua */
        }
        p {
            text-align: center;
            margin: 2px 0 20px;
            font-size: 12px;
            color: #666; /* abu abu medium */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            margin-top: 10px;
            border: 1px solid #bbb; /* abu abu */
        }
        th, td {
            border: 1px solid #bbb; /* abu abu */
            padding: 8px 10px;
            text-align: left;
        }
        th {
            background: #1a3d7c; /* biru tua */
            color: #fff;
            font-weight: bold;
            font-size: 12px;
            text-align: center;
        }
        tbody tr:nth-child(odd) {
            background-color: #f2f2f2; /* abu abu muda */
        }
        tbody tr:nth-child(even) {
            background-color: #ffffff;
        }
        tbody td {
            font-size: 12px;
        }
        tfoot th {
            background: #d9e2f3; /* biru muda keabu */
            font-weight: bold;
            text-align: right;
            color: #1a3d7c;
        }
        tfoot th:last-child {
            font-size: 13px;
        }

        /* Cetak A4 */
        @page {
            size: A4;
            margin: 20mm;
        }
        @media print {
            body { margin: 0; }
            table { border: 1px solid #000; }
            th { background: #333 !important; color: #fff !important; }
            tfoot th { background: #ccc !important; color:#000 !important; }
        }
    </style>
</head>
<body>
    <h2>Laporan Keuangan Hotel</h2>
    <p>Bulan: {{ $bulan ?? 'Semua' }} / Tahun: {{ $tahun ?? 'Semua' }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Bayar</th>
                <th>Tamu</th>
                <th>Kamar</th>
                <th>Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payments as $index => $payment)
                <tr>
                    <td style="text-align:center;">{{ $index + 1 }}</td>
                    <td style="text-align:center;">{{ optional($payment->paid_at)->format('d-m-Y') ?? '-' }}</td>
                    <td>{{ $payment->booking->guest->name ?? '-' }}</td>
                    <td style="text-align:center;">{{ $payment->booking->room->number ?? '-' }}</td>
                    <td style="text-align:right;">{{ number_format($payment->amount, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: #888; font-style: italic;">Tidak ada data pembayaran.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4">Total</th>
                <th style="text-align:right;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>
</body>
</html>
