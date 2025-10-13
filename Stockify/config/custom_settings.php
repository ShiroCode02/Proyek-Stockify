<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Pengaturan Tampilan Produk
    |--------------------------------------------------------------------------
    | Atur visibilitas komponen pada halaman produk.
    */

    // ✅ Apakah gambar produk ditampilkan?
    'show_product_image' => true,

    // ✅ Apakah harga beli ditampilkan ke user?
    'show_purchase_price' => false,

    /*
    |--------------------------------------------------------------------------
    | Fitur Ekspor & Maintenance
    |--------------------------------------------------------------------------
    */

    // ✅ Aktifkan tombol ekspor data (misalnya ke Excel)
    'enable_export' => true,

    // ✅ Aktifkan mode perawatan: semua akses user dibatasi
    'maintenance_mode' => false,


    /*
    |--------------------------------------------------------------------------
    | Fitur Tambahan (Bisa dikembangkan)
    |--------------------------------------------------------------------------
    */

    // Contoh: Tampilkan tombol cetak struk?
    'enable_print_invoice' => false,

    // Contoh: Tampilkan grafik statistik produk?
    'enable_product_chart' => false,

    // Contoh: Tampilkan QR code per produk
    'show_product_qr_code' => false,

];
