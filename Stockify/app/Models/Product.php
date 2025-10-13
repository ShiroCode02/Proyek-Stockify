<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    /**
     * Kolom yang dapat diisi (mass-assignable).
     */
    protected $fillable = [
        'name',
        'sku',
        'description',
        'category_id',
        'supplier_id',
        'stock',
        'minimum_stock',
        'purchase_price',
        'selling_price',
        'image',
        'is_fixed',
        'locked_fields',
        'locked_for',
        'hidden_fields', // Tambahkan
        'hidden_for', // Tambahkan
    ];

    /**
     * Tipe data casting otomatis.
     */
    protected $casts = [
        'stock' => 'integer',
        'minimum_stock' => 'integer',
        'purchase_price' => 'float',
        'selling_price' => 'float',
        'is_fixed' => 'boolean',
        'locked_fields' => 'array',
        'locked_for' => 'array',
        'hidden_fields' => 'array', // Tambahkan
        'hidden_for' => 'array', // Tambahkan
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * Produk milik satu kategori.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Produk milik satu supplier.
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Produk memiliki banyak transaksi stok.
     */
    public function stockTransactions()
    {
        return $this->hasMany(StockTransaction::class);
    }

    /**
     * Produk memiliki banyak atribut dinamis.
     */
    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS & MUTATORS (Opsional)
    |--------------------------------------------------------------------------
    */

    /**
     * Dapatkan URL gambar lengkap jika tersedia.
     */
    public function getImageUrlAttribute()
    {
        if ($this->image && Storage::exists('public/' . $this->image)) {
            return asset('storage/' . $this->image);
        }
        return asset('images/default-product.png'); // Gambar default
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES (Opsional untuk filter fitur selanjutnya)
    |--------------------------------------------------------------------------
    */

    /**
     * Filter produk berdasarkan kategori.
     */
    public function scopeByCategory($query, $categoryId)
    {
        if ($categoryId) {
            return $query->where('category_id', $categoryId);
        }
        return $query;
    }

    /**
     * Filter produk berdasarkan supplier.
     */
    public function scopeBySupplier($query, $supplierId)
    {
        if ($supplierId) {
            return $query->where('supplier_id', $supplierId);
        }
        return $query;
    }

    /**
     * Produk dengan stok dibawah minimum.
     */
    public function scopeLowStock($query)
    {
        return $query->whereColumn('stock', '<', 'minimum_stock');
    }
}