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
        Schema::create('product_requests', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->unsignedBigInteger('product_id'); // main_stocks tablosundaki ürünün ID'si
            $table->unsignedBigInteger('user_id'); // kullanıcı ID'si
            $table->decimal('requested_amount', 10, 2); // talep edilen miktar
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); // talep durumu
            $table->timestamps();

            // Foreign key tanımlamaları
            $table->foreign('product_id')->references('id')->on('main_stocks')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_requests');
    }
};
