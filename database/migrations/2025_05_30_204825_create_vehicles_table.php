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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('plate')->unique();
            $table->year('year');
            $table->integer('load_capacity');
            $table->text('description')->nullable();
            $table->decimal('fuel_capacity', 8, 2)->nullable();
            $table->integer('ocuppants')->nullable();
            $table->boolean('status')->default(true);
            $table->foreignId('model_id')
                ->constrained('brandmodels')
                ->onDelete('restrict');
            $table->foreignId('color_id')
                ->constrained('colors')
                ->onDelete('restrict');
            $table->foreignId('brand_id')
                ->constrained('brands')
                ->onDelete('restrict');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
