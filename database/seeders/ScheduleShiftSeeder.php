<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScheduleShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('scheduleshifts')->insert([
            [
                'name' => 'mañana',
                'description' => 'Turno de la mañana',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'tarde',
                'description' => 'Turno de la tarde',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'noche',
                'description' => 'Turno de la noche',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
