<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'id_pengguna',
        'total_harga',
        'status_pesanan',
        'tanggal_pesanan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_pengguna');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'id_pesanan');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'id_pesanan');
    }
}
