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
        Schema::create('vehicleimages', function (Blueprint $table) {
            $table->id();
            $table->string('image_path');
            $table->boolean('is_profile')->default(false);
            $table->boolean('status')->default(true);
            $table->foreignId('vehicle_id')
                ->constrained('vehicles')
                ->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicleimages');
    }
};
