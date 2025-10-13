<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SupplierService;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SuppliersExport;

class SupplierController extends Controller
{
    protected $supplierService;

    public function __construct(SupplierService $supplierService)
    {
        $this->supplierService = $supplierService;
        $this->middleware('auth');
        $this->middleware('role:admin')->except('index'); // Hanya admin untuk CRUD, index untuk semua role
    }

    /**
     * Tampilkan daftar supplier.
     */
    public function index()
    {
        $suppliers = $this->supplierService->getAll();
        return view('suppliers.index', compact('suppliers'));
    }

    /**
     * Form tambah supplier.
     */
    public function create()
    {
        return view('suppliers.create');
    }

    /**
     * Simpan supplier baru.
     */
    public function store(Request $request)
    {
        try {
            $this->supplierService->create($request->all());
            return redirect()->route('suppliers.index')
                             ->with('success', 'Supplier berhasil ditambahkan.');
        } catch (\InvalidArgumentException $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Form edit supplier.
     */
    public function edit($id)
    {
        $supplier = $this->supplierService->find($id);
        return view('suppliers.edit', compact('supplier'));
    }

    /**
     * Update supplier.
     */
    public function update(Request $request, $id)
    {
        try {
            $this->supplierService->update($id, $request->all());
            return redirect()->route('suppliers.index')
                             ->with('success', 'Supplier berhasil diperbarui.');
        } catch (\InvalidArgumentException $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Hapus supplier.
     */
    public function destroy($id)
    {
        $this->supplierService->delete($id);
        return redirect()->route('suppliers.index')
                         ->with('success', 'Supplier berhasil dihapus.');
    }

    /**
     * 📄 Ekspor daftar supplier ke PDF.
     */
    public function exportPdf()
    {
        $suppliers = $this->supplierService->getAll();
        $pdf = Pdf::loadView('suppliers.export_pdf', compact('suppliers'))
                  ->setPaper('a4', 'portrait');
        return $pdf->download('Daftar_Supplier_' . date('Ymd') . '.pdf');
    }

    /**
     * 📊 Ekspor daftar supplier ke Excel.
     */
    public function exportExcel()
    {
        return Excel::download(new SuppliersExport, 'Daftar_Supplier_' . date('Ymd') . '.xlsx');
    }
}
