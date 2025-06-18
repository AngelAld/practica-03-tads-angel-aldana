<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Province;
use Illuminate\Support\Facades\DB;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $department = Department::where('code', '140000')->first();

        DB::table('provinces')->upsert([
            'name' => 'Chiclayo',
            'code' => '140100',
            'department_id' => $department->id,
        ], ['code'], ['name']);
    }
}
