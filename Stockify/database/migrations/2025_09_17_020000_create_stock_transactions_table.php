<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');   // relasi ke products
            $table->unsignedBigInteger('user_id');      // relasi ke users
            $table->enum('type', ['in', 'out']);        // barang masuk / keluar
            $table->integer('quantity');
            $table->date('date');                       // tanggal transaksi
            $table->enum('status', ['pending', 'completed', 'canceled'])->default('completed');
            $table->text('notes')->nullable();
            $table->timestamps();

            // Foreign Keys
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_transactions');
    }
};
