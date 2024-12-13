<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branchs_id')->constrained('branchs')->onDelete('cascade');
            $table->bigInteger('stocks_code')->unique();
            $table->bigInteger('barcode')->unique();
            $table->string('stocks_name', 155);
            $table->decimal('remaining_amount', 10, 2);
            $table->string('unit', 50);
            $table->decimal('purchase_price', 15, 2);
            $table->decimal('sale_price', 15, 2);
            $table->engine = 'InnoDB';
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
