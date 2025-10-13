<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockTransactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductAttributeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingsController;
use App\Models\Product;

/*
|--------------------------------------------------------------------------
| Halaman Awal
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Dashboard (redirect by role)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Profil Pengguna
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| 📊 ROUTE KHUSUS: Semua Role (Admin, Manager, Staff)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin,manager,staff'])->group(function () {

    // 📦 Laporan
    Route::get('/reports/stock', [ReportController::class, 'stock'])->name('reports.stock');
    Route::get('/reports/transactions', [ReportController::class, 'transactions'])->name('reports.transactions');

    // ✅ Ekspor Laporan Stok (PDF & Excel)
    Route::get('/reports/stock/export/pdf', [ReportController::class, 'exportStockPdf'])->name('reports.stock.export.pdf');
    Route::get('/reports/stock/export/excel', [ReportController::class, 'exportStockExcel'])->name('reports.stock.export.excel');

    // Ekspor Laporan Transaksi (PDF & Excel)
    Route::get('/reports/transactions/export/pdf', [ReportController::class, 'exportTransactionsPdf'])->name('reports.transactions.export.pdf');
    Route::get('/reports/transactions/export/excel', [ReportController::class, 'exportTransactionsExcel'])->name('reports.transactions.export.excel');

    // 📦 Produk
    Route::resource('products', ProductController::class);
});

/*
|--------------------------------------------------------------------------
| 🔐 Role: Admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Master Data
    Route::resource('categories', CategoryController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('users', UserController::class);

    // 📤 Ekspor Supplier (PDF & Excel)
    Route::get('/suppliers/export/pdf', [SupplierController::class, 'exportPdf'])->name('suppliers.export.pdf');
    Route::get('/suppliers/export/excel', [SupplierController::class, 'exportExcel'])->name('suppliers.export.excel');

    // Manajemen Stok
    Route::get('/stock', [StockTransactionController::class, 'index'])->name('stock.admin.index');
    Route::get('/stock/minimum', [StockTransactionController::class, 'minimum'])->name('stock.minimum');
    Route::post('/stock/minimum', [StockTransactionController::class, 'updateMinimum'])->name('stock.updateMinimum');

    // Laporan Admin
    Route::get('/reports/users', [ReportController::class, 'users'])->name('reports.users');
    Route::get('/reports/activities', [ReportController::class, 'activities'])->name('reports.activities');

    // Atribut Produk
    Route::post('products/{product}/attributes', [ProductAttributeController::class, 'store'])->name('products.attributes.store');
    Route::put('products/{product}/attributes/{attribute}', [ProductAttributeController::class, 'update'])->name('products.attributes.update');
    Route::delete('products/{product}/attributes/{attribute}', [ProductAttributeController::class, 'destroy'])->name('products.attributes.destroy');

    // Ekspor & Impor Produk
    Route::get('/product/export', [ProductController::class, 'export'])->name('products.export');
    Route::post('/product/import', [ProductController::class, 'import'])->name('products.import');

    // Pengaturan Sistem
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::put('/settings/display', [SettingsController::class, 'updateDisplay'])->name('settings.update.display');

    // Pengaturan Produk
    Route::post('/settings/apply-default-hidden', [SettingsController::class, 'applyDefaultHidden'])->name('settings.apply-default-hidden');
    Route::patch('/products/{id}/lock', [ProductController::class, 'lock'])->name('products.lock');
    Route::post('products/create/settings', [ProductController::class, 'createSettings'])->name('products.create.settings');

    // Pengaturan Laporan
    Route::post('/settings/apply-default-hidden-stock', [SettingsController::class, 'applyDefaultHiddenStock'])->name('settings.apply-default-hidden-stock');
    Route::post('/settings/apply-default-hidden-transactions', [SettingsController::class, 'applyDefaultHiddenTransactions'])->name('settings.apply-default-hidden-transactions');
});

/*
|--------------------------------------------------------------------------
| 🔐 Role: Manager (Kosong bila tidak dipakai)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:manager'])->group(function () {
    //
});

/*
|--------------------------------------------------------------------------
| 🔐 Role: Admin & Manager
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin,manager'])->group(function () {
    Route::resource('stock-transactions', StockTransactionController::class);

    // Supplier View
    Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');

    // Stok Opname
    Route::get('/stock/opname', [StockTransactionController::class, 'opname'])->name('stock.opname');
    Route::post('/stock/opname', [StockTransactionController::class, 'saveOpname'])->name('stock.saveOpname');
});

/*
|--------------------------------------------------------------------------
| 🔐 Role: Manager & Staff (Staff Gudang)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:manager,staff'])->group(function () {
    Route::get('/stock', [StockTransactionController::class, 'index'])->name('stock.index');
    Route::get('/stock/in', [StockTransactionController::class, 'in'])->name('stock.in');
    Route::get('/stock/out', [StockTransactionController::class, 'out'])->name('stock.out');
    Route::post('/stock/storeIn', [StockTransactionController::class, 'storeIn'])->name('stock.storeIn');
    Route::post('/stock/storeOut', [StockTransactionController::class, 'storeOut'])->name('stock.storeOut');

    // ✅ Pending Masuk & Keluar
    Route::post('/stock/confirm/{id}', [StockTransactionController::class, 'confirm'])->name('stock.confirm');
    Route::post('/stock/cancel/{id}', [StockTransactionController::class, 'cancel'])->name('stock.cancel');
});

/*
|--------------------------------------------------------------------------
| 🌄 Galeri Produk
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->get('/gallery', function () {
    $products = Product::all();
    return view('products.gallery', compact('products'));
})->name('gallery.index');

/*
|--------------------------------------------------------------------------
| Autentikasi Laravel (bawaan Breeze/Fortify)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
