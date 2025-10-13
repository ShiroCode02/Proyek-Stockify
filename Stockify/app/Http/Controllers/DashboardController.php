<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockTransaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            // Ambil data ringkasan untuk admin
            $totalProducts = Product::count();
            $transIn = StockTransaction::where('type', 'in')->count();
            $transOut = StockTransaction::where('type', 'out')->count();
            $totalUsers = User::count();

            // Data untuk grafik stok (top 5 produk berdasarkan stok)
            $topProducts = Product::where('stock', '>', 0)
                ->orderBy('stock', 'desc')
                ->take(5)
                ->get();
            
            $chartLabels = $topProducts->pluck('name')->toArray();
            $chartData = $topProducts->pluck('stock')->map(function($stock) {
                return (int) $stock; // Pastikan data integer
            })->toArray();

            // Validasi data chart
            $hasChartData = !empty($chartData) && array_sum($chartData) > 0;

            // Aktivitas pengguna terbaru
            $latestActivities = StockTransaction::with(['user', 'product'])
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            // Statistik tambahan untuk admin
            $lowStockProducts = Product::whereColumn('stock', '<=', 'minimum_stock')->count();
            $todayTransactions = StockTransaction::whereDate('created_at', today())->count();

            // Variabel untuk progress bar
            $maxProducts = 1000; // Sesuaikan batas maksimal
            $maxTransIn = 1000;
            $maxTransOut = 1000;
            $maxUsers = 100;

            return view('dashboard.admin', compact(
                'totalProducts',
                'transIn',
                'transOut',
                'totalUsers',
                'chartLabels',
                'chartData',
                'hasChartData',
                'latestActivities',
                'lowStockProducts',
                'todayTransactions',
                'maxProducts',
                'maxTransIn',
                'maxTransOut',
                'maxUsers'
            ));
        }

        if ($user->role === 'manager') {
            $lowStockCount = Product::whereColumn('stock', '<=', 'minimum_stock')->count();
            $transactionsInToday = StockTransaction::where('type', 'in')
                ->whereDate('created_at', today())
                ->count();
            $transactionsOutToday = StockTransaction::where('type', 'out')
                ->whereDate('created_at', today())
                ->count();

            $topProducts = Product::where('stock', '>', 0)
                ->orderBy('stock', 'desc')
                ->take(5)
                ->get();

            $chartLabels = $topProducts->pluck('name')->toArray();
            $chartData = $topProducts->pluck('stock')->map(function($stock) {
                return (int) $stock;
            })->toArray();

            $hasChartData = !empty($chartData) && array_sum($chartData) > 0;

            $totalProducts = Product::count();
            $criticalStock = Product::where('stock', '<=', DB::raw('minimum_stock * 0.5'))->count();
            
            $weeklyTransactionsIn = StockTransaction::where('type', 'in')
                ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->count();
                
            $weeklyTransactionsOut = StockTransaction::where('type', 'out')
                ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->count();

            $lowStockProducts = Product::whereColumn('stock', '<=', 'minimum_stock')
                ->orderBy('stock', 'asc')
                ->take(10)
                ->get();

            $todayTransactions = StockTransaction::with(['user', 'product'])
                ->whereDate('created_at', today())
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
            
            return view('dashboard.manager', compact(
                'lowStockCount',
                'transactionsInToday',
                'transactionsOutToday',
                'chartLabels',
                'chartData',
                'hasChartData',
                'totalProducts',
                'criticalStock',
                'weeklyTransactionsIn',
                'weeklyTransactionsOut',
                'lowStockProducts',
                'todayTransactions'
            ));
        }

        if ($user->role === 'staff') {
            $pendingIn = StockTransaction::where('type', 'in')
                ->where('status', 'pending')
                ->count();
            $pendingOut = StockTransaction::where('type', 'out')
                ->where('status', 'pending')
                ->count();

            // Fix: Hanya count transaksi COMPLETED hari ini (bukan pending/canceled)
            $myTransactionsToday = StockTransaction::where('user_id', Auth::id())
                ->whereDate('created_at', today())
                ->where('status', 'completed')  // Tambah filter ini
                ->count() ?? 0;

            $recentTransactions = StockTransaction::with(['user', 'product'])
                ->where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get() ?? collect();

            $totalMyTransactions = StockTransaction::where('user_id', Auth::id())->count() ?? 0;
            
            return view('dashboard.staff', compact(
                'pendingIn',
                'pendingOut',
                'myTransactionsToday',
                'recentTransactions',
                'totalMyTransactions'
            ));
        }

        return view('dashboard');
    }

    public function getChartData()
    {
        $topProducts = Product::where('stock', '>', 0)
            ->orderBy('stock', 'desc')
            ->take(5)
            ->get();
        
        $chartLabels = $topProducts->pluck('name')->toArray();
        $chartData = $topProducts->pluck('stock')->map(function($stock) {
            return (int) $stock;
        })->toArray();

        return response()->json([
            'labels' => $chartLabels,
            'data' => $chartData,
            'hasData' => !empty($chartData) && array_sum($chartData) > 0
        ]);
    }

    public function getStats()
    {
        $user = Auth::user();
        
        $stats = [
            'total_products' => Product::count(),
            'low_stock_count' => Product::whereColumn('stock', '<=', 'minimum_stock')->count(),
            'transactions_today' => StockTransaction::whereDate('created_at', today())->count(),
            'transactions_in_today' => StockTransaction::where('type', 'in')->whereDate('created_at', today())->count(),
            'transactions_out_today' => StockTransaction::where('type', 'out')->whereDate('created_at', today())->count(),
        ];

        if ($user->role === 'admin') {
            $stats['total_users'] = User::count();
        }

        if ($user->role === 'staff') {
            $stats['pending_in'] = StockTransaction::where('type', 'in')->where('status', 'pending')->count();
            $stats['pending_out'] = StockTransaction::where('type', 'out')->where('status', 'pending')->count();
            $stats['my_transactions_today'] = StockTransaction::where('user_id', Auth::id())->whereDate('created_at', today())->count();
        }

        return response()->json($stats);
    }
}