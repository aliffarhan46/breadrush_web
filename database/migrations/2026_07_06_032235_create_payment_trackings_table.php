<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
     public function up(): void
     {
         if (Schema::hasTable('payment_tracking')) {
             if (Schema::hasColumn('payment_tracking', 'id_tracking')) {
                 Schema::dropIfExists('payment_tracking');
             }
         }

         if (!Schema::hasTable('payment_tracking')) {
             Schema::create('payment_tracking', function (Blueprint $table) {
                 $table->id();
                 $table->string('id_transaksi')->nullable();
                 $table->string('nama_pelanggan');
                 $table->string('metode_pembayaran');
                 $table->integer('total_bayar');
                 $table->string('status_tracking')->default('Pesanan diterima');
                 $table->text('items')->nullable(); // JSON of ordered items
                 $table->timestamps();
             });
         }
     }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_tracking');
    }
};
