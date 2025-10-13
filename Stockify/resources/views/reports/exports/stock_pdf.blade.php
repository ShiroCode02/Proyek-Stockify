<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Stok Produk</title>
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
    <h2>Laporan Stok Produk</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                @if(!in_array('name', $default_hidden_columns_stock ?? []) || !in_array($user_role, $default_hidden_for_stock ?? []) || $user_role === 'admin')
                    <th>Nama Produk</th>
                @endif
                @if(!in_array('category', $default_hidden_columns_stock ?? []) || !in_array($user_role, $default_hidden_for_stock ?? []) || $user_role === 'admin')
                    <th>Kategori</th>
                @endif
                @if(!in_array('supplier', $default_hidden_columns_stock ?? []) || !in_array($user_role, $default_hidden_for_stock ?? []) || $user_role === 'admin')
                    <th>Supplier</th>
                @endif
                @if(!in_array('stock', $default_hidden_columns_stock ?? []) || !in_array($user_role, $default_hidden_for_stock ?? []) || $user_role === 'admin')
                    <th>Stok</th>
                @endif
                @if(!in_array('minimum_stock', $default_hidden_columns_stock ?? []) || !in_array($user_role, $default_hidden_for_stock ?? []) || $user_role === 'admin')
                    <th>Stok Minimum</th>
                @endif
                @if(!in_array('purchase_price', $default_hidden_columns_stock ?? []) || !in_array($user_role, $default_hidden_for_stock ?? []) || $user_role === 'admin')
                    <th>Harga Beli</th>
                @endif
                @if(!in_array('selling_price', $default_hidden_columns_stock ?? []) || !in_array($user_role, $default_hidden_for_stock ?? []) || $user_role === 'admin')
                    <th>Harga Jual</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $i => $product)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    @if(!in_array('name', $default_hidden_columns_stock ?? []) || !in_array($user_role, $default_hidden_for_stock ?? []) || $user_role === 'admin')
                        <td>{{ $product->name }}</td>
                    @endif
                    @if(!in_array('category', $default_hidden_columns_stock ?? []) || !in_array($user_role, $default_hidden_for_stock ?? []) || $user_role === 'admin')
                        <td>{{ $product->category->name ?? '-' }}</td>
                    @endif
                    @if(!in_array('supplier', $default_hidden_columns_stock ?? []) || !in_array($user_role, $default_hidden_for_stock ?? []) || $user_role === 'admin')
                        <td>{{ $product->supplier->name ?? '-' }}</td>
                    @endif
                    @if(!in_array('stock', $default_hidden_columns_stock ?? []) || !in_array($user_role, $default_hidden_for_stock ?? []) || $user_role === 'admin')
                        <td>{{ $product->stock }}</td>
                    @endif
                    @if(!in_array('minimum_stock', $default_hidden_columns_stock ?? []) || !in_array($user_role, $default_hidden_for_stock ?? []) || $user_role === 'admin')
                        <td>{{ $product->minimum_stock }}</td>
                    @endif
                    @if(!in_array('purchase_price', $default_hidden_columns_stock ?? []) || !in_array($user_role, $default_hidden_for_stock ?? []) || $user_role === 'admin')
                        <td>Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</td>
                    @endif
                    @if(!in_array('selling_price', $default_hidden_columns_stock ?? []) || !in_array($user_role, $default_hidden_for_stock ?? []) || $user_role === 'admin')
                        <td>Rp {{ number_format($product->selling_price, 0, ',', '.') }}</td>
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