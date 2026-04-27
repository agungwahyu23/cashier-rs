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
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('user_id')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('insurance_id')->nullable();
            $table->string('insurance_name')->nullable();
            $table->string('voucher_id')->nullable();
            $table->unsignedBigInteger('subtotal')->nullable();
            $table->unsignedBigInteger('total_discount')->nullable();
            $table->unsignedBigInteger('grand_total')->nullable();
            $table->enum('status', ['draft','paid'])->default('draft')->nullable();
            $table->date('paid_at')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
