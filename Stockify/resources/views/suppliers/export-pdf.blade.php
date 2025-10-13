<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Daftar Supplier</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        h2 { text-align: center; margin-bottom: 5px; }
        p.sub-title { text-align: center; font-size: 11px; color: #666; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #444; padding: 6px; text-align: left; }
        th { background: #f5f5f5; font-weight: bold; }
        .footer { margin-top: 20px; font-size: 11px; text-align: right; color: #555; }
    </style>
</head>
<body>
    <h2>Laporan Daftar Supplier</h2>
    <p class="sub-title">Sistem Informasi Manajemen Stok — Dicetak {{ now()->format('d F Y, H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 25%;">Nama Supplier</th>
                <th style="width: 30%;">Alamat</th>
                <th style="width: 15%;">Telepon</th>
                <th style="width: 25%;">Email</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($suppliers as $i => $supplier)
                <tr>
                    <td style="text-align: center;">{{ $i + 1 }}</td>
                    <td>{{ $supplier->nama ?? '-' }}</td>
                    <td>{{ $supplier->alamat ?? '-' }}</td>
                    <td>{{ $supplier->telepon ?? '-' }}</td>
                    <td>{{ $supplier->email ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: #999;">Tidak ada data supplier</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak otomatis oleh sistem pada {{ now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>
