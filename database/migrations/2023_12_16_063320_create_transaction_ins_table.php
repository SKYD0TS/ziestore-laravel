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
        Schema::create('transaction_ins', function (Blueprint $table) {
            $table->string('transaction_code')->primary();
            $table->unsignedBigInteger('vendor_id');
            $table->string('staff_code');
            $table->unsignedBigInteger('payment_type_id');
            $table->decimal('total', 12, 2)->default(0);
            $table->enum('status', ['in progress', 'on hold', 'done'])->default('in progress');
            $table->foreign('vendor_id')->references('id')->on('vendors');
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
        Schema::dropIfExists('transaction_ins');
    }
};
