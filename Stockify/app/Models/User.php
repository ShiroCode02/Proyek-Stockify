<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use InvalidArgumentException;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Mutator untuk role (validasi nilai)
     */
    public function setRoleAttribute($value)
    {
        $allowedRoles = ['admin', 'manager', 'staff'];
        if (!in_array($value, $allowedRoles)) {
            throw new InvalidArgumentException('Role harus admin, manager, atau staff.');
        }
        $this->attributes['role'] = $value;
    }

    /**
     * Relasi ke transaksi stok
     */
    public function stockTransactions()
    {
        return $this->hasMany(StockTransaction::class, 'user_id');
    }
}