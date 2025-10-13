<?php

namespace App\Repositories;

use App\Models\Transaction;

class TransactionRepository
{
    public function getAll()
    {
        return Transaction::with(['product','user'])->latest()->get();
    }

    public function create(array $data)
    {
        return Transaction::create($data);
    }
}
