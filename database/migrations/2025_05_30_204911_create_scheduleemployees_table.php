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
        Schema::create('scheduleemployees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')
                ->constrained('schedules')
                ->onDelete('restrict');
            $table->foreignId('contract_id')
                ->constrained('contracts')
                ->onDelete('restrict');
            $table->foreignId('employee_id')
                ->constrained('employees')
                ->onDelete('restrict');
            $table->boolean('status')->default(true);
            $table->foreignId('employeefunction_id')
                ->constrained('employeefunctions')
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
        Schema::dropIfExists('scheduleemployees');
    }
};
