<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'id_kategori',
        'nama_produk',
        'deskripsi',
        'harga',
        'stok',
        'gambar',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_kategori');
    }
}
