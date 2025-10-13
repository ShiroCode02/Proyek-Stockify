# Proyek-Stockify
Tugas Awal Magang/PKL


Stockify: Aplikasi Manajemen Stok Barang

Stockify adalah aplikasi web yang dirancang untuk membantu bisnis, khususnya yang memiliki gudang, dalam mengelola stok barang secara efisien dan akurat.

Tujuan Stockify:
⦁	Memudahkan pencatatan dan pemantauan stok barang.
⦁	Meningkatkan akurasi data stok.
⦁	Mempermudah proses penerimaan dan pengeluaran barang.
⦁	Menyediakan laporan stok yang informatif.

Fitur Utama:
⦁	Manajemen Produk: Mencatat data produk, kategori, supplier, dan atribut produk.
⦁	Manajemen Stok: Mencatat transaksi barang masuk dan keluar, monitoring stok, dan stock opname.
⦁	Manajemen Pengguna: Membuat dan mengelola akun pengguna dengan role yang berbeda (Admin, Manajer Gudang, Staff Gudang).
⦁	Laporan: Menyediakan berbagai laporan stok dan transaksi.

Teknologi:
⦁	Laravel 10 (PHP Framework)
⦁	MySQL (Database)
⦁	Tailwind CSS (Frontend Framework)
⦁	Flowbite (UI Component Library)
⦁	Flowbite Admin Dashboard (Template)


Fungsi Per role

Role Admin:
⦁	Mengelola seluruh aspek aplikasi.
⦁	Membuat, membaca, mengupdate, dan menghapus (CRUD) data kategori produk, supplier, dan pengguna.
⦁	Melihat laporan stok barang, riwayat transaksi, dan aktivitas pengguna.
⦁	Mengatur hak akses pengguna lain.

Manajer Gudang:
⦁	Bertanggung jawab atas manajemen stok barang.
⦁	Menerima barang masuk dan mencatat data produk baru.
⦁	Mengeluarkan barang dan mencatat data pengeluaran.
⦁	Memantau stok barang dan melakukan stock opname.
⦁	Membuat laporan stok barang.

Staff Gudang:
⦁	Membantu Manajer Gudang dalam operasional gudang.
⦁	Menerima dan memeriksa barang masuk.
⦁	Menyiapkan dan mengirimkan barang keluar.
⦁	Membantu dalam proses stock opname.


Alur dan Gambaran:

1.	Manajemen Produk:
⦁	Admin dapat menambahkan kategori produk baru (misalnya: Elektronik, Pakaian, Makanan) dan mendefinisikan atribut produk (misalnya: ukuran, warna, berat).
⦁	Manajer Gudang dapat menambahkan produk baru ke dalam sistem, melengkapi data produk seperti nama, deskripsi, harga beli, harga jual, stok awal, dan gambar produk.
⦁	Data produk disimpan dalam database dengan relasi yang sesuai antar tabel (kategori, supplier, dll.).

2. Manajemen Stok:
⦁	Ketika barang masuk, Staff Gudang mencatat transaksi penerimaan barang, menambahkan stok produk yang ada, atau membuat data produk baru jika belum terdaftar.
⦁	Ketika barang keluar (misalnya: penjualan, retur), Staff Gudang mencatat transaksi pengeluaran barang dan mengurangi stok produk.
⦁	Manajer Gudang dapat melihat laporan stok barang secara real-time, termasuk stok minimum, stok tersedia, dan riwayat perubahan stok.

3. Manajemen Supplier:
⦁	Admin dapat menambahkan data supplier, termasuk nama, alamat, kontak, dan informasi lainnya.
⦁	Manajer Gudang dapat memilih supplier saat mencatat transaksi penerimaan barang.

4. Laporan:
Admin dan Manajer Gudang dapat mengakses berbagai laporan, seperti:
⦁	Laporan stok barang (per kategori, per periode, dll.)
⦁	Laporan barang masuk dan keluar
⦁	Laporan aktivitas pengguna


Fitur:

Admin fitur:
Dashboard:
⦁	Menampilkan ringkasan informasi penting, seperti:
⦁	Jumlah produk
⦁	Jumlah transaksi masuk dan keluar dalam periode tertentu
⦁	Grafik stok barang
⦁	Aktivitas pengguna terbaru

Produk:
⦁	Manajemen data produk (CRUD)
⦁	Kategori produk (CRUD)
⦁	Atribut produk (misalnya: ukuran, warna)
⦁	Import/export data produk

Stok:
⦁	Riwayat transaksi barang masuk dan keluar
⦁	Stock opname
⦁	Pengaturan stok minimum

Supplier:
⦁	Manajemen data supplier (CRUD)

Pengguna:
⦁	Manajemen data pengguna (CRUD)

Laporan:
⦁	Laporan stok barang (per periode, per kategori, dll.)
⦁	Laporan transaksi barang masuk dan keluar
⦁	Laporan aktivitas pengguna

Pengaturan:
⦁	Pengaturan umum aplikasi (misalnya: logo, nama aplikasi)

Manajer Gudang fitur:
Dashboard:
⦁	Menampilkan ringkasan informasi stok barang, seperti: Stok menipis, Barang masuk hari ini, Barang keluar hari ini

Produk:
⦁	Melihat daftar produk
⦁	Detail produk

Stok:
⦁	Transaksi barang masuk (mencatat penerimaan barang)
⦁	Transaksi barang keluar (mencatat pengeluaran barang)
⦁	Stock opname

Supplier:
⦁	Melihat daftar supplier

Laporan:
⦁	Laporan stok barang (per periode, per kategori)
⦁	Laporan barang masuk dan keluar

Staff Gudang fitur:
Dashboard:
⦁	Menampilkan daftar tugas yang harus diselesaikan, seperti: Barang masuk yang perlu diperiksa, Barang keluar yang perlu disiapkan

Stok:
⦁	Konfirmasi penerimaan barang
⦁	Konfirmasi pengeluaran barang
