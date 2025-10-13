<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi Stok</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #444; padding: 6px; text-align: center; }
        th { background: #efefef; }
        .footer { margin-top: 20px; font-size: 11px; text-align: right; color: #555; }
    </style>
</head>
<body>
    <h2>Laporan Transaksi Stok</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                @if(!in_array('product', $default_hidden_columns_transactions ?? []) || !in_array($user_role, $default_hidden_for_transactions ?? []) || $user_role === 'admin')
                    <th>Produk</th>
                @endif
                @if(!in_array('type', $default_hidden_columns_transactions ?? []) || !in_array($user_role, $default_hidden_for_transactions ?? []) || $user_role === 'admin')
                    <th>Jenis</th>
                @endif
                @if(!in_array('quantity', $default_hidden_columns_transactions ?? []) || !in_array($user_role, $default_hidden_for_transactions ?? []) || $user_role === 'admin')
                    <th>Jumlah</th>
                @endif
                @if(!in_array('date', $default_hidden_columns_transactions ?? []) || !in_array($user_role, $default_hidden_for_transactions ?? []) || $user_role === 'admin')
                    <th>Tanggal</th>
                @endif
                @if(!in_array('status', $default_hidden_columns_transactions ?? []) || !in_array($user_role, $default_hidden_for_transactions ?? []) || $user_role === 'admin')
                    <th>Status</th>
                @endif
                @if(!in_array('notes', $default_hidden_columns_transactions ?? []) || !in_array($user_role, $default_hidden_for_transactions ?? []) || $user_role === 'admin')
                    <th>Catatan</th>
                @endif
                @if(!in_array('user', $default_hidden_columns_transactions ?? []) || !in_array($user_role, $default_hidden_for_transactions ?? []) || $user_role === 'admin')
                    <th>User</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $i => $transaction)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    @if(!in_array('product', $default_hidden_columns_transactions ?? []) || !in_array($user_role, $default_hidden_for_transactions ?? []) || $user_role === 'admin')
                        <td>{{ $transaction->product->name }}</td>
                    @endif
                    @if(!in_array('type', $default_hidden_columns_transactions ?? []) || !in_array($user_role, $default_hidden_for_transactions ?? []) || $user_role === 'admin')
                        <td>{{ $transaction->type == 'in' ? 'Masuk' : 'Keluar' }}</td>
                    @endif
                    @if(!in_array('quantity', $default_hidden_columns_transactions ?? []) || !in_array($user_role, $default_hidden_for_transactions ?? []) || $user_role === 'admin')
                        <td>{{ $transaction->quantity }}</td>
                    @endif
                    @if(!in_array('date', $default_hidden_columns_transactions ?? []) || !in_array($user_role, $default_hidden_for_transactions ?? []) || $user_role === 'admin')
                        <td>{{ $transaction->date }}</td>
                    @endif
                    @if(!in_array('status', $default_hidden_columns_transactions ?? []) || !in_array($user_role, $default_hidden_for_transactions ?? []) || $user_role === 'admin')
                        <td>{{ ucfirst($transaction->status) }}</td>
                    @endif
                    @if(!in_array('notes', $default_hidden_columns_transactions ?? []) || !in_array($user_role, $default_hidden_for_transactions ?? []) || $user_role === 'admin')
                        <td>{{ $transaction->notes ?? '-' }}</td>
                    @endif
                    @if(!in_array('user', $default_hidden_columns_transactions ?? []) || !in_array($user_role, $default_hidden_for_transactions ?? []) || $user_role === 'admin')
                        <td>{{ $transaction->user->name }}</td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ $generated_at }}
    </div>
</body>
</html>