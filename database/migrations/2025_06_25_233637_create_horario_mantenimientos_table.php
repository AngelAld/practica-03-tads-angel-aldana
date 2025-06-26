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
        Schema::create('horario_mantenimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mantenimiento_id')
                ->constrained('mantenimientos')
                ->onDelete('restrict');
            $table->string('dia_de_la_semana');
            $table->foreignId('vehicle_id')
                ->constrained('vehicles')
                ->onDelete('restrict');
            $table->foreignId('employee_id')
                ->constrained('employees')
                ->onDelete('restrict');
            $table->string('tipo');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horario_mantenimientos');
    }
};
