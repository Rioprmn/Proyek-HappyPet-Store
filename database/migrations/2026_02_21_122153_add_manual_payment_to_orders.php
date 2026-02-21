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
        Schema::table('orders', function (Blueprint $table) {
    // Kita cek dulu, kalau kolomnya belum ada, baru kita buat
    if (!Schema::hasColumn('orders', 'payment_receipt')) {
        $table->string('payment_receipt')->nullable();
    }
    if (!Schema::hasColumn('orders', 'payment_method')) {
        $table->string('payment_method')->default('Manual Transfer');
    }
    
    // Karena 'status' sudah ada, kita "modifikasi" saja isinya 
    // agar support status 'waiting_verification'
    $table->enum('status', ['pending', 'waiting_verification', 'completed', 'cancelled'])
          ->default('pending')
          ->change(); // <-- Gunakan change() untuk menimpa yang lama
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
