<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchedulestatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('schedulestatuses')->upsert([
            [
                'name' => 'asignado',
                'description' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'listo para iniciar',
                'description' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'en proceso',
                'description' => 'El horario está actualmente en ejecución',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'completado',
                'description' => 'El horario ha sido completado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'cancelado',
                'description' => 'El horario ha sido cancelado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ], ['name']);
    }
}
