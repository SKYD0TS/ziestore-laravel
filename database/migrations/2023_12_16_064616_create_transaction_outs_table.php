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
        Schema::create('transaction_outs', function (Blueprint $table) {
            $table->string('transaction_code')->primary();
            $table->string('customer_code');
            $table->string('staff_code');
            $table->unsignedBigInteger('payment_type_id');
            $table->decimal('total', 12, 2);
            $table->enum('status', ['in progress', 'on hold', 'done']);
            $table->foreign('customer_code')->references('customer_code')->on('customers');
            $table->foreign('staff_code')->references('staff_code')->on('staff');
            $table->foreign('payment_type_id')->references('id')->on('payment_types');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_outs');
    }
};
