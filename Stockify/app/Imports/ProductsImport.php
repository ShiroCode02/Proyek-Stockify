<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Product([
            'name' => $row['name'],
            'sku' => $row['sku'],
            'description' => $row['description'],
            'stock' => $row['stock'],
            'purchase_price' => $row['purchase_price'],
            'selling_price' => $row['selling_price'],
            'category_id' => $row['category_id'],
        ]);
    }
}