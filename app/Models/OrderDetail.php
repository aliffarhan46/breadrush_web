<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
        'id_pesanan',
        'id_produk',
        'jumlah',
        'harga',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'id_pesanan');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_produk');
    }
}
