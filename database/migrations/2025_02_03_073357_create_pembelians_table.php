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
        Schema::create('pembelian', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('nomer_order')->unique();
            $table->date('tanggal_order');
            $table->float('total_harga');
            $table->float('harga_asli')->nullable(); // Original total price before discount
            $table->float('diskon')->default(0); // Total discount amount
            $table->string('kode_kupon')->nullable(); // Coupon code used
            $table->enum('metode_pembayaran', ['PayPal', 'CashApp', 'Venmo', 'Usdt'])->default('PayPal');
            $table->string('bukti_transfer')->nullable();
            $table->enum('status', ['pending', 'diterima'])->default('pending');

            // Colum Akun Game
            $table->string('username');
            $table->string('facebook');
            $table->string('link');
            
            // New columns for billing details
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->text('note')->nullable();
            
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian');
    }
};
