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
        Schema::create('refillshedules', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->decimal('refill_amount', 10, 2);
            $table->foreignId('vehicle_id')
                ->constrained('vehicles')
                ->onDelete('restrict');
            $table->foreignId('driver_id')
                ->constrained('employeefunctiondetails')
                ->onDelete('restrict');
            $table->foreignId('schedule_status_id')
                ->constrained('schedule_status')
                ->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refillshedules');
    }
};
