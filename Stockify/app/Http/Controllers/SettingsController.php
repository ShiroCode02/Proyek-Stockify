<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin')->only(['applyDefaultHidden', 'applyDefaultHiddenStock', 'applyDefaultHiddenTransactions']);
    }

    public function index()
    {
        // Ambil semua settings sebagai object
        $settings = collect();
        Settings::all()->each(function ($item) use ($settings) {
            $settings[$item->key] = $item->value;
        });

        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'app_name' => 'required|string|max:255',
            'admin_email' => 'required|email',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
        ]);

        // Simpan text fields
        Settings::set('app_name', $request->app_name);
        Settings::set('admin_email', $request->admin_email);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Hapus logo lama kalau ada
            if (Settings::get('logo_url')) {
                Storage::disk('public')->delete(Settings::get('logo_url'));
            }
            $path = $request->file('logo')->store('logos', 'public');
            Settings::set('logo_url', Storage::url($path));
        }

        return redirect()->route('settings.index')->with('success', 'Pengaturan umum berhasil disimpan!');
    }

    public function updateDisplay(Request $request)
    {
        $request->validate([
            'dark_mode_default' => 'boolean',
            'show_logo_sidebar' => 'boolean',
        ]);

        Settings::set('dark_mode_default', $request->boolean('dark_mode_default'));
        Settings::set('show_logo_sidebar', $request->boolean('show_logo_sidebar'));

        return redirect()->route('settings.index')->with('success', 'Pengaturan tampilan berhasil disimpan!');
    }

    public function applyDefaultHidden(Request $request)
    {
        $validated = $request->validate([
            'default_hidden_fields' => 'required|array',
            'default_hidden_fields.*' => 'in:name,sku,description,category_id,supplier_id,stock,minimum_stock,purchase_price,selling_price,image,attributes',
            'default_hidden_for' => 'required|array',
            'default_hidden_for.*' => 'in:manager,staff',
        ]);

        try {
            Settings::set('default_hidden_fields', $validated['default_hidden_fields']);
            Settings::set('default_hidden_for', $validated['default_hidden_for']);
            return redirect()->route('products.index')->with('success', 'Pengaturan sembunyi default berhasil diterapkan.');
        } catch (\Throwable $e) {
            Log::error('Error saat menerapkan pengaturan sembunyi default: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menerapkan pengaturan sembunyi default: ' . $e->getMessage()])->withInput();
        }
    }

    public function applyDefaultHiddenStock(Request $request)
    {
        $validated = $request->validate([
            'default_hidden_columns_stock' => 'required|array',
            'default_hidden_columns_stock.*' => 'in:name,category,supplier,stock,minimum_stock,purchase_price,selling_price',
            'default_hidden_for_stock' => 'required|array',
            'default_hidden_for_stock.*' => 'in:manager,staff',
        ]);

        try {
            Settings::set('default_hidden_columns_stock', $validated['default_hidden_columns_stock']);
            Settings::set('default_hidden_for_stock', $validated['default_hidden_for_stock']);
            return redirect()->route('reports.stock')->with('success', 'Pengaturan sembunyi kolom laporan stok berhasil diterapkan.');
        } catch (\Throwable $e) {
            Log::error('Error saat menerapkan pengaturan sembunyi kolom stok: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menerapkan pengaturan.'])->withInput();
        }
    }

    public function applyDefaultHiddenTransactions(Request $request)
    {
        $validated = $request->validate([
            'default_hidden_columns_transactions' => 'required|array',
            'default_hidden_columns_transactions.*' => 'in:product,type,quantity,date,status,notes,user',
            'default_hidden_for_transactions' => 'required|array',
            'default_hidden_for_transactions.*' => 'in:manager,staff',
        ]);

        try {
            Settings::set('default_hidden_columns_transactions', $validated['default_hidden_columns_transactions']);
            Settings::set('default_hidden_for_transactions', $validated['default_hidden_for_transactions']);
            return redirect()->route('reports.transactions')->with('success', 'Pengaturan sembunyi kolom laporan transaksi berhasil diterapkan.');
        } catch (\Throwable $e) {
            Log::error('Error saat menerapkan pengaturan sembunyi kolom transaksi: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menerapkan pengaturan.'])->withInput();
        }
    }
}