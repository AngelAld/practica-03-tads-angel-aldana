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
        Schema::create('schedulevehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')
                ->constrained('schedules')
                ->onDelete('restrict');
            $table->foreignId('vehicle_id')
                ->constrained('vehicles')
                ->onDelete('restrict');
            $table->boolean('status');
            $table->text('observation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedulevehicles');
    }
};
