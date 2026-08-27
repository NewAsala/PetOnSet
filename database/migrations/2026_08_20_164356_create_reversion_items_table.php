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
        Schema::create('reversion_items', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->decimal('total', 10, 2);
            $table->text('reason');
            $table->enum('condition', ['good', 'damaged', 'expired'])->default('good');

            $table->unsignedBigInteger('reversion_id');
            $table->foreign('reversion_id')->references('id')->on('reversions');

            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products');

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
        Schema::dropIfExists('reversion_items');
    }
};
