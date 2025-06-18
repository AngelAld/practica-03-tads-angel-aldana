<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeefunctionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('employeefunctions')->upsert([
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
        ], ['name']);
    }
}
