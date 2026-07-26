<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';

    protected $fillable = [
        'id_pengguna',
        'id_produk',
        'jumlah',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_pengguna');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_produk');
    }
}
