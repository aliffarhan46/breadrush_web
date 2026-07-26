<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    // use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create a dummy category
        $category = Category::firstOrCreate([
            'nama_kategori' => 'Roti Premium',
        ]);

        // 2. Create some dummy products to prevent foreign key errors during testing
        for ($i = 1; $i <= 10; $i++) {
            Product::firstOrCreate(
                ['id' => $i],
                [
                    'id_kategori' => $category->id,
                    'nama_produk' => 'Roti Menu ' . $i,
                    'deskripsi' => 'Deskripsi roti menu ' . $i,
                    'harga' => 40000,
                    'stok' => 100,
                    'gambar' => 'Gambar/Menu/cinnamon.png',
                ]
            );
        }
    }
}
