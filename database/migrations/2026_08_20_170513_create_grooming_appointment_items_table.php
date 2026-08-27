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
        Schema::create('grooming_appointment_items', function (Blueprint $table) {
            $table->id();
            $table->integer('duration');
            $table->decimal('price', 10, 2);

            $table->unsignedBigInteger('grooming_appointment_id');
            $table->foreign('grooming_appointment_id')->references('id')->on('grooming_appointments');

            $table->unsignedBigInteger('grooming_service_id');
            $table->foreign('grooming_service_id')->references('id')->on('grooming_services');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grooming_appointment_items');
    }
};
