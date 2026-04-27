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
        Schema::create('detail_transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('transaction_id')->nullable();
            $table->string('procedure_id')->nullable();
            $table->string('procedure_name')->nullable();
            $table->string('price_id')->nullable();
            $table->unsignedBigInteger('price')->nullable();
            $table->date('price_start_date')->nullable();
            $table->date('price_end_date')->nullable();
            $table->unsignedInteger('qty')->nullable();
            $table->unsignedBigInteger('discount_per_item')->nullable();
            $table->unsignedBigInteger('subtotal')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transactions');
    }
};
