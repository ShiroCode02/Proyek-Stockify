<?php

namespace App\Exports;

use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SuppliersExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Supplier::select('name', 'address', 'phone', 'email')->get();
    }

    public function headings(): array
    {
        return ['Nama', 'Alamat', 'Telepon', 'Email'];
    }
}
