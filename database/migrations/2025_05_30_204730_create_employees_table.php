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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('names');
            $table->string('lastnames');
            $table->string('dni')->unique();
            $table->date('birthday');
            $table->string('license')->nullable();
            $table->string('address');
            $table->string('email')->unique();
            $table->string('photo')->nullable();
            $table->string('phone');
            $table->boolean('status')->default(true);
            // $table->foreignId('function_id')         // Ahora se maneja con un many to many
            //     ->constrained('employeefunctions')
            //     ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
