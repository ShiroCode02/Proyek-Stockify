<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class StockReportExport implements FromView
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $query = Product::with(['category', 'supplier']);

        if ($this->request->category_id) {
            $query->where('category_id', $this->request->category_id);
        }

        if ($this->request->supplier_id) {
            $query->where('supplier_id', $this->request->supplier_id);
        }

        if ($this->request->only_minimum) {
            $query->whereColumn('stock', '<=', 'minimum_stock');
        }

        return view('reports.exports.stock_excel', [
            'products' => $query->get()
        ]);
    }
}
