<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentTracking extends Model
{
    protected $table = 'payment_tracking';

    protected $fillable = [
        'id_transaksi',
        'nama_pelanggan',
        'metode_pembayaran',
        'total_bayar',
        'status_tracking',
        'items'
    ];

    protected $casts = [
        'items' => 'array'
    ];
}
