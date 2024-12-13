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
        Schema::create('main_stocks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('stocks_code')->unique();
            $table->bigInteger('barcode')->unique();
            $table->string('stocks_name', 155);
            $table->decimal('remaining_amount', 10, 2);
            $table->string('unit', 50);
            $table->decimal('purchase_price', 15, 2);
            $table->decimal('sale_price', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('main_stocks');
    }
};
