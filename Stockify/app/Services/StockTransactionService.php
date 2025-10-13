<?php

namespace App\Services;

use App\Models\StockTransaction;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class StockTransactionService
{
    /**
     * Ambil semua transaksi stok
     */
    public function getAllTransactions()
    {
        return StockTransaction::with(['product', 'user'])->orderBy('created_at', 'desc')->get();
    }

    /**
     * Simpan transaksi stok baru
     */
    public function createTransaction(array $data)
    {
        $product = Product::findOrFail($data['product_id']);

        // Validasi stok awal hanya untuk 'out' kalau langsung completed
        $status = $data['status'] ?? 'pending';
        if ($data['type'] === 'out' && $status === 'completed') {
            if ($product->stock < $data['quantity']) {
                throw new \Exception('Stok tidak mencukupi untuk pengeluaran barang.');
            }
        }

        // Buat transaksi
        $transaction = StockTransaction::create([
            'product_id' => $data['product_id'],
            'user_id'    => Auth::id(),
            'type'       => $data['type'] ?? 'manual',
            'quantity'   => $data['quantity'] ?? 0,
            'date'       => $data['date'] ?? now(),
            'status'     => $status,
            'notes'      => $data['notes'] ?? null,
        ]);

        // Update stok HANYA kalau completed
        if ($transaction->status === 'completed') {
            $this->updateStockForTransaction($transaction);
        }

        return $transaction;
    }

    /**
     * Update stok berdasarkan transaksi
     */
    private function updateStockForTransaction(StockTransaction $transaction)
    {
        $product = $transaction->product;
        $quantityChange = 0;

        if (in_array($transaction->type, ['in', 'out'])) {
            $quantityChange = $transaction->type === 'in' ? $transaction->quantity : -$transaction->quantity;
        } elseif ($transaction->type === 'opname') {
            $quantityChange = $transaction->quantity - $product->stock;
        }

        if ($quantityChange !== 0) {
            $product->stock += $quantityChange;
            $product->save();
        }
    }

    /**
     * Konfirmasi transaksi pending
     */
    public function confirmTransaction($transactionId)
    {
        $transaction = StockTransaction::findOrFail($transactionId);
        if ($transaction->status !== 'pending') {
            throw new \Exception('Transaksi ini bukan pending.');
        }

        $product = $transaction->product;
        if ($transaction->type === 'out' && $product->stock < $transaction->quantity) {
            throw new \Exception('Stok tidak mencukupi untuk konfirmasi.');
        }

        $transaction->status = 'completed';
        $transaction->save();

        $this->updateStockForTransaction($transaction);

        return $transaction;
    }

    /**
     * Perbarui stok minimum produk
     */
    public function updateMinimumStock($productId, $minimumStock)
    {
        $product = Product::findOrFail($productId);
        $product->minimum_stock = $minimumStock;
        $product->save();

        return $product;
    }

    /**
     * Ambil statistik dashboard untuk staff
     */
    public function getStaffDashboardStats()
    {
        $userId = Auth::id();
        return [
            'pendingIn' => StockTransaction::where('user_id', $userId)
                ->where('type', 'in')
                ->where('status', 'pending')
                ->count(),
            'pendingOut' => StockTransaction::where('user_id', $userId)
                ->where('type', 'out')
                ->where('status', 'pending')
                ->count(),
            // Fix: Hanya count transaksi COMPLETED hari ini (bukan pending/canceled)
            'myTransactionsToday' => StockTransaction::where('user_id', $userId)
                ->whereDate('date', now())
                ->where('status', 'completed')  // Tambah filter ini
                ->count(),
        ];
    }

    /**
     * Ambil daftar transaksi pending untuk staff
     */
    public function getPendingTransactionsByStaff()
    {
        return StockTransaction::where('status', 'pending')
            ->with(['product', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Batalkan transaksi pending
     */
    public function cancelTransaction($transactionId)
    {
        $transaction = StockTransaction::findOrFail($transactionId);
        if ($transaction->status !== 'pending') {
            throw new \Exception('Transaksi ini bukan pending.');
        }

        $transaction->status = 'canceled';
        $transaction->save(); // Nggak update stok, cuma ubah status

        return $transaction;
    }
}