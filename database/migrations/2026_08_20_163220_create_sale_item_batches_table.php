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
        Schema::create('sale_item_batches', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->decimal('purchase_price', 10, 2);

            $table->unsignedBigInteger('sale_item_id');
            $table->foreign('sale_item_id')->references('id')->on('sale_items');

            $table->unsignedBigInteger('product_batch_id');
            $table->foreign('product_batch_id')->references('id')->on('product_batches');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_item_batches');
    }
};
