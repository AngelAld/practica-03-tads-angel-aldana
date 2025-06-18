<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicletypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('vehicletypes')->upsert([
            [
                'name' => 'volquete',
                'description' => 'Vehículo utilizado para transportar residuos en grandes cantidades',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'compactadora',
                'description' => 'Vehículo utilizado para compactar residuos o materiales',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ], ['name']);
    }
}
