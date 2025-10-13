<?php

namespace App\Http\Controllers;

use App\Services\StockTransactionService;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockTransactionController extends Controller
{
    protected $transactionService;

    public function __construct(StockTransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    /**
     * Tampilkan semua transaksi stok
     */
    public function index()
    {
        $transactions = $this->transactionService->getAllTransactions();
        $products = Product::all();
        $pendingTransactions = StockTransaction::where('status', 'pending')->with('product')->get(); // Tambah untuk manager

        if (Auth::user()->role === 'manager') {
            return view('stock_manager.index', compact('transactions', 'products', 'pendingTransactions'));
        } elseif (Auth::user()->role === 'staff') {
            $pendingTransactions = $this->transactionService->getPendingTransactionsByStaff();
            return view('stock_staff.index', compact('pendingTransactions'));
        }
        return view('stock_admin.index', compact('transactions'));
    }

    /**
     * Form tambah barang masuk
     */
    public function in(Request $request)
    {
        $productId = $request->query('product_id');
        $products = Product::with('supplier')->get();
        $suppliers = Supplier::all(); // Tetap kalau mau pilih, meski nggak simpan
        $type = 'in';
        $selectedSupplierId = null;
        if ($productId) {
            $product = Product::find($productId);
            $selectedSupplierId = $product ? $product->supplier_id : null;
        }
        if (Auth::user()->role === 'manager') {
            return view('stock_manager.in', compact('products', 'type', 'productId', 'suppliers', 'selectedSupplierId'));
        } elseif (Auth::user()->role === 'staff') {
            return view('stock_staff.in', compact('products', 'type', 'productId', 'suppliers', 'selectedSupplierId'));
        }
        return view('stock_admin.create', compact('products', 'type', 'suppliers', 'productId', 'selectedSupplierId'));
    }

    /**
     * Form tambah barang keluar
     */
    public function out(Request $request)
    {
        $productId = $request->query('product_id');
        $products = Product::all();
        $type = 'out';
        if (Auth::user()->role === 'manager') {
            return view('stock_manager.out', compact('products', 'type', 'productId'));
        } elseif (Auth::user()->role === 'staff') {
            return view('stock_staff.out', compact('products', 'type', 'productId'));
        }
        return view('stock_admin.create', compact('products', 'type', 'productId'));
    }

    /**
     * Simpan transaksi baru masuk
     */
    public function storeIn(Request $request)
    {
        $request->merge(['type' => 'in']);
        return $this->store($request);
    }

    /**
     * Simpan transaksi baru keluar
     */
    public function storeOut(Request $request)
    {
        $request->merge(['type' => 'out']);
        return $this->store($request);
    }

    /**
     * Simpan transaksi baru (logic umum)
     */
    public function store(Request $request)
    {
        try {
            $rules = [
                'product_id' => 'required|exists:products,id',
                'type'       => 'required|in:in,out',
                'quantity'   => 'required|integer|min:1',
                'date'       => 'nullable|date',
                'status'     => 'nullable|in:pending,completed,canceled',
                'notes'      => 'nullable|string',
            ];

            // Hapus supplier_id validate, karena nggak simpan
            $request->validate($rules);

            $data = $request->all();
            $data['date'] = $data['date'] ?? now();
            $data['status'] = $request->status ?? (Auth::user()->role === 'staff' ? 'pending' : 'completed');

            $this->transactionService->createTransaction($data);

            $message = $data['status'] === 'pending' ? 'Transaksi pending berhasil dicatat.' : 'Transaksi berhasil dicatat.';
            return redirect()->route('stock.index')->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Konfirmasi transaksi pending
     */
    public function confirm($id)
    {
        try {
            $this->transactionService->confirmTransaction($id);
            return redirect()->route('stock.index')->with('success', 'Transaksi dikonfirmasi.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Batalkan transaksi pending
     */
    public function cancel($id)
    {
        try {
            $this->transactionService->cancelTransaction($id);
            return redirect()->route('stock.index')->with('success', 'Transaksi berhasil dibatalkan.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Tampilkan halaman stock opname
     */
    public function opname()
    {
        $products = Product::with('attributes')->get();
        if (Auth::user()->role === 'manager') {
            return view('stock_manager.opname', compact('products'));
        }
        return view('stock_admin.opname', compact('products'));
    }

    /**
     * Simpan hasil stock opname
     */
    public function saveOpname(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'actual_stock' => 'required|integer|min:0',
            ]);

            $this->transactionService->createTransaction([
                'product_id' => $request->product_id,
                'type' => 'opname',
                'quantity' => $request->actual_stock,
                'notes' => 'Stock opname adjustment',
                'date' => now(),
                'status' => 'completed',
            ]);

            if (Auth::user()->role === 'manager') {
                return redirect()->route('stock.opname')
                                 ->with('success', 'Stock opname berhasil disimpan');
            }
            return redirect()->route('stock.opname')
                             ->with('success', 'Stock opname berhasil disimpan');
        } catch (\Exception $e) {
            return redirect()->back()
                             ->withInput()
                             ->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Tampilkan halaman pengaturan stok minimum
     */
    public function minimum()
    {
        $products = Product::all();
        return view('stock_admin.minimum', compact('products')); // Ubah ke stock_admin
    }

    /**
     * Perbarui stok minimum
     */
    public function updateMinimum(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'minimum_stock' => 'required|integer|min:0',
            ]);

            $this->transactionService->updateMinimumStock($request->product_id, $request->minimum_stock);

            return redirect()->route('stock.minimum')
                             ->with('success', 'Stok minimum berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()
                             ->withInput()
                             ->withErrors(['error' => $e->getMessage()]);
        }
    }
}