<?php

namespace App\Services;

use App\Repositories\SupplierRepository;
use Illuminate\Support\Facades\Validator;

class SupplierService
{
    protected $supplierRepo;

    public function __construct(SupplierRepository $supplierRepo)
    {
        $this->supplierRepo = $supplierRepo;
    }

    public function getAll()
    {
        return $this->supplierRepo->getAll();
    }

    public function find($id)
    {
        return $this->supplierRepo->find($id);
    }

    public function create(array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        if ($validator->fails()) {
            throw new \InvalidArgumentException($validator->errors()->first());
        }

        return $this->supplierRepo->create($data);
    }

    public function update($id, array $data)
    {
        return $this->supplierRepo->update($id, $data);
    }

    public function delete($id)
    {
        return $this->supplierRepo->delete($id);
    }
}
