<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Province;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $department = Department::where('code', '140000')->first();

        Province::create([
            'name' => 'Chiclayo',
            'code' => '140100',
            'department_id' => $department->id,
        ]);
    }
}
