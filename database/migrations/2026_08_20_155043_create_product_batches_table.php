<?php

use App\Enums\StatusEnum;
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
        Schema::create('product_batches', function (Blueprint $table) {
            $table->id();
            $table->string('batch_number')->unique();
            $table->date('expiry_date')->nullable();
            $table->integer('quantity');
            $table->decimal('purchase_price', 10, 2)->nullable();
            $table->string('status')->default(StatusEnum::ACTIVE->value);

            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products');

            $table->unsignedBigInteger('purchase_item_id');
            $table->foreign('purchase_item_id')->references('id')->on('purchase_items');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_batches');
    }
};
