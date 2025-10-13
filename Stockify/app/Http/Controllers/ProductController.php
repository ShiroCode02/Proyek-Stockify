<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductsExport;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->middleware('auth');
        $this->middleware('role:admin,manager,staff');
        $this->productService = $productService;
    }

    public function index()
    {
        $products = $this->productService->getAll();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        $default_hidden_fields = Settings::get('default_hidden_fields', []);
        $default_hidden_for = Settings::get('default_hidden_for', []);
        return view('products.create', compact('categories', 'suppliers', 'default_hidden_fields', 'default_hidden_for'));
    }

    public function store(Request $request)
    {
        if ($request->input('action') !== 'save') {
            return back()->withErrors(['error' => 'Aksi tidak valid.'])->withInput();
        }

        $validated = $this->validateRequest($request);

        // Jika tombol "Simpan Produk" dan apply_hidden_settings dicentang, pastikan hidden_fields dan hidden_for diisi
        if ($request->has('apply_hidden_settings') && Auth::user()->role === 'admin') {
            if (empty($validated['hidden_fields']) || empty($validated['hidden_for'])) {
                return back()->withErrors(['error' => 'Field yang disembunyikan dan role target harus dipilih saat menerapkan pengaturan sembunyi.'])->withInput();
            }
        }

        try {
            $this->productService->create($validated);
            return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
        } catch (\Throwable $e) {
            Log::error('Error saat menambahkan produk: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan produk: ' . $e->getMessage()])->withInput();
        }
    }

    public function show($id)
    {
        $product = $this->productService->find($id);
        return view('products.show', compact('product'));
    }

    public function edit($id)
    {
        $product = $this->productService->find($id);
        $categories = Category::all();
        $suppliers = Supplier::all();

        // Batasi akses edit jika is_fixed = true untuk manager/staff
        if (in_array(Auth::user()->role, ['manager', 'staff']) && $product->is_fixed) {
            return redirect()->route('products.index')->withErrors(['error' => 'Anda tidak memiliki izin untuk mengedit produk ini.']);
        }

        return view('products.edit', compact('product', 'categories', 'suppliers'));
    }

    public function update(Request $request, $id)
    {
        $product = $this->productService->find($id);
        $validated = $this->validateRequest($request, $id);

        // Batasi akses edit jika is_fixed = true untuk manager/staff
        if (in_array(Auth::user()->role, ['manager', 'staff']) && $product->is_fixed) {
            return redirect()->route('products.index')->withErrors(['error' => 'Anda tidak memiliki izin untuk mengedit produk ini.']);
        }

        // Jika admin, tangani pengaturan kunci dan sembunyikan
        if (Auth::user()->role === 'admin') {
            $validated['is_fixed'] = $request->has('is_fixed') ? true : false;
            $validated['locked_fields'] = $request->input('locked_fields', []);
            $validated['locked_for'] = $request->input('locked_for', []);
            $validated['hidden_fields'] = $request->input('hidden_fields', []);
            $validated['hidden_for'] = $request->input('hidden_for', []);
        } else {
            // Untuk non-admin, pertahankan nilai existing
            $validated['is_fixed'] = $product->is_fixed;
            $validated['locked_fields'] = $product->locked_fields;
            $validated['locked_for'] = $product->locked_for;
            $validated['hidden_fields'] = $product->hidden_fields;
            $validated['hidden_for'] = $product->hidden_for;
        }

        try {
            $this->productService->update($id, $validated);
            return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
        } catch (\Throwable $e) {
            Log::error('Error saat mengupdate produk: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui produk: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy($id)
    {
        $product = $this->productService->find($id);

        // Batasi hapus jika is_fixed = true untuk manager/staff
        if (in_array(Auth::user()->role, ['manager', 'staff']) && $product->is_fixed) {
            return redirect()->route('products.index')->withErrors(['error' => 'Anda tidak memiliki izin untuk menghapus produk ini.']);
        }

        try {
            $this->productService->delete($id);
            return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
        } catch (\Throwable $e) {
            Log::error('Error saat menghapus produk: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal menghapus produk: ' . $e->getMessage()]);
        }
    }

    public function export()
    {
        return Excel::download(new ProductsExport, 'produk.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'image' => 'image|mimes:jpeg,png,gif,webp|max:2048',
            'file' => 'required|file|mimes:xlsx,csv|max:2048',
        ]);

        $file = $request->file('file');
        if ($file->getClientOriginalExtension() === 'csv') {
            $data = array_map('str_getcsv', file($file->getRealPath()));
            foreach (array_slice($data, 1) as $row) {
                if (count($row) >= 4) {
                    $this->productService->create([
                        'name' => $row[0],
                        'sku' => $row[1],
                        'stock' => $row[2],
                        'selling_price' => $row[3],
                    ]);
                }
            }
        }

        return redirect()->route('products.index')->with('success', 'Import berhasil! Data produk ditambahkan.');
    }

    private function validateRequest(Request $request, $id = null)
    {
        $uniqueSkuRule = 'unique:products,sku';
        if ($id) {
            $uniqueSkuRule .= ',' . $id;
        }

        $rules = [
            'name' => 'required|string|max:255',
            'sku' => "required|string|max:50|$uniqueSkuRule",
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'stock' => 'required|integer|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,gif,webp|max:2048',
            'remove_image' => 'nullable|boolean',
            'attributes' => 'nullable|array',
            'attributes.*.name' => 'nullable|string|max:255',
            'attributes.*.value' => 'nullable|string|max:255',
            'apply_hidden_settings' => 'nullable|boolean',
        ];

        // Jika role pengguna ada di default_hidden_for dan field ada di default_hidden_fields, buat field tersebut opsional
        if (Auth::user()->role !== 'admin') {
            $default_hidden_fields = Settings::get('default_hidden_fields', []);
            $default_hidden_for = Settings::get('default_hidden_for', []);
            if (in_array(Auth::user()->role, $default_hidden_for)) {
                foreach ($default_hidden_fields as $field) {
                    if (in_array($field, ['sku', 'minimum_stock', 'category_id', 'supplier_id', 'stock', 'purchase_price', 'selling_price'])) {
                        $rules[$field] = str_replace('required|', 'nullable|', $rules[$field]);
                    } elseif ($field === 'attributes') {
                        $rules['attributes'] = 'nullable|array';
                        $rules['attributes.*.name'] = 'nullable|string|max:255';
                        $rules['attributes.*.value'] = 'nullable|string|max:255';
                    }
                }
            }
        }

        // Jika role pengguna ada di hidden_for dan field ada di hidden_fields, buat field tersebut opsional (untuk update)
        $product = $id ? $this->productService->find($id) : null;
        if ($product && in_array(Auth::user()->role, $product->hidden_for ?? [])) {
            foreach ($product->hidden_fields ?? [] as $field) {
                if (in_array($field, ['sku', 'minimum_stock', 'category_id', 'supplier_id', 'stock', 'purchase_price', 'selling_price'])) {
                    $rules[$field] = str_replace('required|', 'nullable|', $rules[$field]);
                } elseif ($field === 'attributes') {
                    $rules['attributes'] = 'nullable|array';
                    $rules['attributes.*.name'] = 'nullable|string|max:255';
                    $rules['attributes.*.value'] = 'nullable|string|max:255';
                }
            }
        }

        if (Auth::user()->role === 'admin') {
            $rules['is_fixed'] = 'nullable|boolean';
            $rules['locked_fields'] = 'nullable|array';
            $rules['locked_fields.*'] = 'in:name,sku,description,category_id,supplier_id,stock,minimum_stock,purchase_price,selling_price,image,attributes';
            $rules['locked_for'] = 'nullable|array';
            $rules['locked_for.*'] = 'in:manager,staff';
            $rules['hidden_fields'] = 'nullable|array';
            $rules['hidden_fields.*'] = 'in:name,sku,description,category_id,supplier_id,stock,minimum_stock,purchase_price,selling_price,image,attributes';
            $rules['hidden_for'] = 'nullable|array';
            $rules['hidden_for.*'] = 'in:manager,staff';
        }

        return $request->validate($rules);
    }

    public function lock(Request $request, $id)
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['error' => 'Anda tidak memiliki izin untuk mengunci produk ini.'], 403);
        }

        $product = $this->productService->find($id);
        $product->is_fixed = !$product->is_fixed;
        $product->save();

        $message = $product->is_fixed ? 'Produk berhasil dikunci.' : 'Produk berhasil dibuka kunci.';
        return response()->json([
            'success' => true,
            'message' => $message,
            'is_fixed' => $product->is_fixed,
        ]);
    }

    public function gallery()
    {
        $products = $this->productService->getAll();
        return view('products.gallery', compact('products'));
    }
}