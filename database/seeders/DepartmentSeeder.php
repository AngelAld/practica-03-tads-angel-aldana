<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Department::upsert([
            'name' => 'Lambayeque',
            'code' => '140000',
        ], [
            'code', 'name'
        ]);
    }
}
