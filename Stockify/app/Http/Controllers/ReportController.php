<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\StockTransaction;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View as LaravelView;

class ReportController extends Controller
{
    /**
     * 📊 Laporan Stok Produk (tampilan di halaman)
     */
    public function stock(Request $request)
    {
        $query = Product::with(['category', 'supplier']);
        $categories = Category::all();
        $suppliers = Supplier::all();

        // 🔍 Filter kategori
        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        // 🔍 Filter supplier
        if ($request->supplier_id) {
            $query->where('supplier_id', $request->supplier_id);
        }

        // 🔍 Filter keyword (nama produk)
        if ($request->keyword) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        // 🔍 Filter tanggal updated_at
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('updated_at', [$request->start_date, $request->end_date]);
        }

        // 🔍 Filter stok kosong
        if ($request->only_empty) {
            $query->where('stock', '=', 0);
        }

        // 🔍 Filter stok minimum
        if ($request->only_minimum) {
            $query->whereColumn('stock', '<=', 'minimum_stock');
        }

        $products = $query->get();

        // Ambil pengaturan sembunyi kolom dari Settings
        $default_hidden_columns_stock = Settings::get('default_hidden_columns_stock', []);
        $default_hidden_for_stock = Settings::get('default_hidden_for_stock', []);

        return view('reports.stock', compact('products', 'categories', 'suppliers', 'default_hidden_columns_stock', 'default_hidden_for_stock'));
    }

    /**
     * 💾 Ekspor laporan stok ke PDF
     */
    public function exportStockPdf(Request $request)
    {
        $query = Product::with(['category', 'supplier']);

        // Terapkan filter yang sama seperti di stock()
        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->supplier_id) {
            $query->where('supplier_id', $request->supplier_id);
        }
        if ($request->keyword) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('updated_at', [$request->start_date, $request->end_date]);
        }
        if ($request->only_empty) {
            $query->where('stock', '=', 0);
        }
        if ($request->only_minimum) {
            $query->whereColumn('stock', '<=', 'minimum_stock');
        }

        $products = $query->get();
        $default_hidden_columns_stock = Settings::get('default_hidden_columns_stock', []);
        $default_hidden_for_stock = Settings::get('default_hidden_for_stock', []);
        $user_role = Auth::user()->role;
        $generated_at = now()->format('d-m-Y H:i:s');

        $pdf = Pdf::loadView('reports.exports.stock_pdf', compact('products', 'default_hidden_columns_stock', 'default_hidden_for_stock', 'user_role', 'generated_at'));
        return $pdf->download('laporan_stok_produk.pdf');
    }

    /**
     * 💾 Ekspor laporan stok ke Excel
     */
    public function exportStockExcel(Request $request)
    {
        $query = Product::with(['category', 'supplier']);

        // Terapkan filter yang sama seperti di stock()
        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->supplier_id) {
            $query->where('supplier_id', $request->supplier_id);
        }
        if ($request->keyword) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('updated_at', [$request->start_date, $request->end_date]);
        }
        if ($request->only_empty) {
            $query->where('stock', '=', 0);
        }
        if ($request->only_minimum) {
            $query->whereColumn('stock', '<=', 'minimum_stock');
        }

        $products = $query->get();
        $default_hidden_columns_stock = Settings::get('default_hidden_columns_stock', []);
        $default_hidden_for_stock = Settings::get('default_hidden_for_stock', []);
        $user_role = Auth::user()->role;

        return Excel::download(new class($products, $default_hidden_columns_stock, $default_hidden_for_stock, $user_role) implements FromView {
            private $products, $default_hidden_columns_stock, $default_hidden_for_stock, $user_role;

            public function __construct($products, $default_hidden_columns_stock, $default_hidden_for_stock, $user_role)
            {
                $this->products = $products;
                $this->default_hidden_columns_stock = $default_hidden_columns_stock;
                $this->default_hidden_for_stock = $default_hidden_for_stock;
                $this->user_role = $user_role;
            }

            public function view(): LaravelView
            {
                return view('reports.exports.stock_excel', [
                    'products' => $this->products,
                    'default_hidden_columns_stock' => $this->default_hidden_columns_stock,
                    'default_hidden_for_stock' => $this->default_hidden_for_stock,
                    'user_role' => $this->user_role,
                ]);
            }
        }, 'Laporan_Stok_' . now()->format('Ymd_His') . '.xlsx');
    }

    /**
     * 🧾 Laporan Transaksi Stok
     */
    public function transactions(Request $request)
    {
        $query = StockTransaction::with('product', 'user');

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }

        $transactions = $query->orderBy('date', 'desc')->get();

        // Ambil pengaturan sembunyi kolom dari Settings
        $default_hidden_columns_transactions = Settings::get('default_hidden_columns_transactions', []);
        $default_hidden_for_transactions = Settings::get('default_hidden_for_transactions', []);

        return view('reports.transactions', compact('transactions', 'default_hidden_columns_transactions', 'default_hidden_for_transactions'));
    }

    /**
     * 💾 Ekspor laporan transaksi ke PDF
     */
    public function exportTransactionsPdf(Request $request)
    {
        $query = StockTransaction::with('product', 'user');

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }

        $transactions = $query->orderBy('date', 'desc')->get();
        $default_hidden_columns_transactions = Settings::get('default_hidden_columns_transactions', []);
        $default_hidden_for_transactions = Settings::get('default_hidden_for_transactions', []);
        $user_role = Auth::user()->role;
        $generated_at = now()->format('d-m-Y H:i:s');

        $pdf = Pdf::loadView('reports.exports.transactions_pdf', compact('transactions', 'default_hidden_columns_transactions', 'default_hidden_for_transactions', 'user_role', 'generated_at'));
        return $pdf->download('laporan_transaksi_stok.pdf');
    }

    /**
     * 💾 Ekspor laporan transaksi ke Excel
     */
    public function exportTransactionsExcel(Request $request)
    {
        $query = StockTransaction::with('product', 'user');

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }

        $transactions = $query->orderBy('date', 'desc')->get();
        $default_hidden_columns_transactions = Settings::get('default_hidden_columns_transactions', []);
        $default_hidden_for_transactions = Settings::get('default_hidden_for_transactions', []);
        $user_role = Auth::user()->role;

        return Excel::download(new class($transactions, $default_hidden_columns_transactions, $default_hidden_for_transactions, $user_role) implements FromView {
            private $transactions, $default_hidden_columns_transactions, $default_hidden_for_transactions, $user_role;

            public function __construct($transactions, $default_hidden_columns_transactions, $default_hidden_for_transactions, $user_role)
            {
                $this->transactions = $transactions;
                $this->default_hidden_columns_transactions = $default_hidden_columns_transactions;
                $this->default_hidden_for_transactions = $default_hidden_for_transactions;
                $this->user_role = $user_role;
            }

            public function view(): LaravelView
            {
                return view('reports.exports.transactions_excel', [
                    'transactions' => $this->transactions,
                    'default_hidden_columns_transactions' => $this->default_hidden_columns_transactions,
                    'default_hidden_for_transactions' => $this->default_hidden_for_transactions,
                    'user_role' => $this->user_role,
                ]);
            }
        }, 'Laporan_Transaksi_' . now()->format('Ymd_His') . '.xlsx');
    }

    /**
     * 👥 Laporan Pengguna (aktivitas)
     */
    public function users(Request $request)
    {
        $query = User::withCount('stockTransactions');

        if ($request->role) {
            $query->where('role', $request->role);
        }

        $users = $query->get();

        return view('reports.users', compact('users'));
    }
}