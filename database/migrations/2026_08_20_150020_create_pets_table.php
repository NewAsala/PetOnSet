<?php

use App\Enums\GenderEnum;
use App\Enums\PetTypeEnum;
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
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('gender', [GenderEnum::MALE,GenderEnum::FEMALE,])->nullable();
            $table->enum('type', [PetTypeEnum::DOG,PetTypeEnum::CAT,])->nullable();
            $table->integer('age')->nullable();
            $table->decimal('weight', 10, 2)->nullable();
            $table->text('notes')->nullable();

            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
