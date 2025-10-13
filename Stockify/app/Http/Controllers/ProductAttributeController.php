<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;

class ProductAttributeController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'value' => 'required|string|max:255',
        ]);

        $product->attributes()->create($request->only('name', 'value'));

        return redirect()->route('products.edit', $product->id)
                         ->with('success', 'Atribut berhasil ditambahkan.');
    }

    public function update(Request $request, Product $product, ProductAttribute $attribute)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'value' => 'required|string|max:255',
        ]);

        $attribute->update($request->only('name', 'value'));

        return redirect()->route('products.edit', $product->id)
                         ->with('success', 'Atribut berhasil diperbarui.');
    }

    public function destroy(Product $product, ProductAttribute $attribute)
    {
        $attribute->delete();

        return redirect()->route('products.edit', $product->id)
                         ->with('success', 'Atribut berhasil dihapus.');
    }
}
