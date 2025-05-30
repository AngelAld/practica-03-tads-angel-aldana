<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeetypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('employeetypes')->insert([
            [
                'name' => 'conductor',
                'description' => 'Empleado encargado de conducir vehículos',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'ayudante',
                'description' => 'Empleado que asiste al conductor u otras tareas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
