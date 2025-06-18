<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContracttypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('contracttypes')->upsert([
            [
                'name' => 'nombrado',
                'description' => 'Contrato de nombramiento estable',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'contrato permanente',
                'description' => 'Contrato de trabajo por tiempo indefinido',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'contrato temporal',
                'description' => 'Contrato de trabajo por tiempo determinado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ], [
            'name'
        ]);
    }
}
