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
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->text('address');
        $table->string('whatsapp');
        $table->decimal('total_price', 15, 2);
        $table->text('items'); // Kita simpan detail barang (JSON)
        $table->string('status')->default('pending'); // pending, processing, completed, cancelled
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
