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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('insurance_id')->nullable();
            $table->string('insurance_name')->nullable();
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->enum('type', ['percentage', 'fixed'])->nullable();
            $table->integer('value', false)->nullable();
            $table->integer('max_discount', false)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
