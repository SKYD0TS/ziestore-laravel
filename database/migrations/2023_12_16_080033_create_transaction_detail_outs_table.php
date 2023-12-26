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
        Schema::create('transaction_detail_outs', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_code');
            $table->string('barcode');
            $table->integer('quantity');
            $table->decimal('subtotal', 9, 2);
            $table->foreign('transaction_code')->references('transaction_code')->on('transaction_outs');
            $table->foreign('barcode')->references('barcode')->on('products');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_detail_outs');
    }
};
