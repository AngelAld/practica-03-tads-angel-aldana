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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('shift_id')
                ->constrained('scheduleshifts')
                ->onDelete('restrict');
            $table->foreignId('status_id')
                ->constrained('schedulestatuses')
                ->onDelete('restrict');
            $table->foreignId('zone_id')
                ->constrained('zones')
                ->onDelete('restrict');
            $table->text('observation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
