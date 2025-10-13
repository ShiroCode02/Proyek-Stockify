<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use App\Models\Settings;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProductService
{
    protected $productRepo;

    public function __construct(ProductRepository $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function getAll()
    {
        return $this->productRepo->getAll();
    }

    public function find($id)
    {
        return $this->productRepo->find($id)->load('attributes');
    }

    public function create(array $data)
    {
        $isAdmin = Auth::user()->role === 'admin';

        $rules = [
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'stock' => 'required|integer|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,gif,webp|max:2048',
            'attributes' => 'nullable|array',
            'attributes.*.name' => 'nullable|string|max:255',
            'attributes.*.value' => 'nullable|string|max:255',
            'apply_hidden_settings' => 'nullable|boolean',
        ];

        // Jika role pengguna ada di default_hidden_for dan field ada di default_hidden_fields, buat field tersebut opsional
        if (!$isAdmin) {
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

        // Jika role pengguna ada di hidden_for dan field ada di hidden_fields, buat field tersebut opsional
        if (!$isAdmin && isset($data['hidden_for']) && isset($data['hidden_fields']) && $data['apply_hidden_settings']) {
            if (in_array(Auth::user()->role, $data['hidden_for'])) {
                foreach ($data['hidden_fields'] as $field) {
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

        if ($isAdmin) {
            $rules['is_fixed'] = 'nullable|boolean';
            $rules['locked_fields'] = 'nullable|array';
            $rules['locked_fields.*'] = 'in:name,sku,description,category_id,supplier_id,stock,minimum_stock,purchase_price,selling_price,image,attributes';
            $rules['locked_for'] = 'nullable|array';
            $rules['locked_for.*'] = 'in:manager,staff';
            $rules['hidden_fields'] = 'nullable|array';
            $rules['hidden_fields.*'] = 'in:name,sku,description,category_id,supplier_id,stock,minimum_stock,purchase_price,selling_price,image,attributes';
            $rules['hidden_for'] = 'nullable|array';
            $rules['hidden_for.*'] = 'in:manager,staff';
        } else {
            $data = array_merge($data, [
                'is_fixed' => false,
                'locked_fields' => [],
                'locked_for' => [],
                'hidden_fields' => [],
                'hidden_for' => [],
            ]);
        }

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new \InvalidArgumentException($validator->errors()->first());
        }

        // Untuk non-admin, set nilai default untuk field yang disembunyikan jika tidak dikirim (untuk menghindari error not null di database)
        if (!$isAdmin) {
            $default_hidden_fields = Settings::get('default_hidden_fields', []);
            $default_hidden_for = Settings::get('default_hidden_for', []);
            if (in_array(Auth::user()->role, $default_hidden_for)) {
                foreach ($default_hidden_fields as $field) {
                    if (!isset($data[$field])) {
                        switch ($field) {
                            case 'sku':
                                $data[$field] = Str::random(6);
                                break;
                            case 'description':
                                $data[$field] = '';
                                break;
                            case 'category_id':
                                $data[$field] = Category::first()->id ?? abort(500, 'No category available');
                                break;
                            case 'supplier_id':
                                $data[$field] = Supplier::first()->id ?? abort(500, 'No supplier available');
                                break;
                            case 'stock':
                            case 'minimum_stock':
                            case 'purchase_price':
                            case 'selling_price':
                                $data[$field] = 0;
                                break;
                            case 'image':
                                $data[$field] = null;
                                break;
                            case 'attributes':
                                $data[$field] = [];
                                break;
                        }
                    }
                }
            }
        }

        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            $data['image'] = $data['image']->store('product_images', 'public');
        }

        $product = $this->productRepo->create($data);

        if (isset($data['attributes']) && is_array($data['attributes'])) {
            foreach ($data['attributes'] as $attribute) {
                if (isset($attribute['name']) && isset($attribute['value'])) {
                    $product->attributes()->create([
                        'name' => $attribute['name'],
                        'value' => $attribute['value'],
                    ]);
                }
            }
        }

        return $product;
    }

    public function update($id, array $data)
    {
        $isAdmin = Auth::user()->role === 'admin';
        $product = $this->find($id);

        // Cek apakah manager/staff mencoba mengedit produk yang dikunci
        if (!$isAdmin && $product->is_fixed) {
            throw new \InvalidArgumentException('Anda tidak memiliki izin untuk mengedit produk ini.');
        }

        // Validasi data
        $rules = [
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku,' . $id,
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
        ];

        // Jika role pengguna ada di default_hidden_for dan field ada di default_hidden_fields, buat field tersebut opsional
        if (!$isAdmin) {
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

        // Jika role pengguna ada di hidden_for dan field ada di hidden_fields, buat field tersebut opsional
        if (!$isAdmin && in_array(Auth::user()->role, $product->hidden_for ?? [])) {
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

        if ($isAdmin) {
            $rules['is_fixed'] = 'nullable|boolean';
            $rules['locked_fields'] = 'nullable|array';
            $rules['locked_fields.*'] = 'in:name,sku,description,category_id,supplier_id,stock,minimum_stock,purchase_price,selling_price,image,attributes';
            $rules['locked_for'] = 'nullable|array';
            $rules['locked_for.*'] = 'in:manager,staff';
            $rules['hidden_fields'] = 'nullable|array';
            $rules['hidden_fields.*'] = 'in:name,sku,description,category_id,supplier_id,stock,minimum_stock,purchase_price,selling_price,image,attributes';
            $rules['hidden_for'] = 'nullable|array';
            $rules['hidden_for.*'] = 'in:manager,staff';
        } else {
            $data = array_merge($data, [
                'is_fixed' => $product->is_fixed,
                'locked_fields' => $product->locked_fields,
                'locked_for' => $product->locked_for,
                'hidden_fields' => $product->hidden_fields,
                'hidden_for' => $product->hidden_for,
            ]);
        }

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new \InvalidArgumentException($validator->errors()->first());
        }

        // Tangani penguncian field untuk non-admin
        if (!$isAdmin && !empty($data['locked_fields']) && !empty($data['locked_for'])) {
            foreach ($data['locked_fields'] as $field) {
                if (in_array(Auth::user()->role, $data['locked_for']) && array_key_exists($field, $data)) {
                    $data[$field] = $product->$field; // Kembalikan ke nilai asli
                }
            }
        }

        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $data['image']->store('product_images', 'public');
        } elseif (isset($data['remove_image']) && $product->image) {
            Storage::disk('public')->delete($product->image);
            $data['image'] = null;
        }

        $product->update($data);

        if (isset($data['attributes']) && is_array($data['attributes'])) {
            $product->attributes()->delete();
            foreach ($data['attributes'] as $attribute) {
                if (isset($attribute['name']) && isset($attribute['value'])) {
                    $product->attributes()->create([
                        'name' => $attribute['name'],
                        'value' => $attribute['value'],
                    ]);
                }
            }
        }

        return $product;
    }

    public function delete($id)
    {
        $product = $this->find($id);

        // Cek apakah manager/staff mencoba menghapus produk yang dikunci
        if (Auth::user()->role !== 'admin' && $product->is_fixed) {
            throw new \InvalidArgumentException('Anda tidak memiliki izin untuk menghapus produk ini.');
        }

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->attributes()->delete();
        return $this->productRepo->delete($id);
    }
}