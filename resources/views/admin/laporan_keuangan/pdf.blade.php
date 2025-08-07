<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2, p { text-align: center; margin: 0; padding: 4px; }
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
                    <td>{{ $index + 1 }}</td>
                    <td>{{ optional($payment->paid_at)->format('d-m-Y') ?? '-' }}</td>
                    <td>{{ $payment->booking->guest->name ?? '-' }}</td>
                    <td>{{ $payment->booking->room->number ?? '-' }}</td>
                    <td>{{ number_format($payment->amount, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Tidak ada data pembayaran.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4">Total</th>
                <th>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>
</body>
</html>
