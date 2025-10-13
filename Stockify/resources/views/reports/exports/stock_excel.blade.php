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
                    <td>{{ $product->purchase_price }}</td>
                @endif
                @if(!in_array('selling_price', $default_hidden_columns_stock ?? []) || !in_array($user_role, $default_hidden_for_stock ?? []) || $user_role === 'admin')
                    <td>{{ $product->selling_price }}</td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>