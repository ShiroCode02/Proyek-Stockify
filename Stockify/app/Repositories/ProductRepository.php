<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function getAll()
    {
        return Product::with('category', 'supplier', 'attributes')->get(); // Load relasi untuk efisiensi
    }

    public function find($id)
    {
        return Product::with('attributes')->findOrFail($id); // Tetap load atribut
    }

    public function create(array $data)
    {
        return Product::create($data);
    }

    public function update($id, array $data)
    {
        $product = $this->find($id);
        $product->update($data);
        return $product;
    }

    public function delete($id)
    {
        $product = $this->find($id);
        return $product->delete();
    }
}