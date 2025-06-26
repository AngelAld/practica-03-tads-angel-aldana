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
        Schema::create('detalle_horario_mantenimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('horario_mantenimiento_id')
                ->constrained('horario_mantenimientos')
                ->onDelete('restrict');
            $table->string('descripcion');
            $table->date('fecha');
            $table->string('imagen')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_horario_mantenimientos');
    }
};
