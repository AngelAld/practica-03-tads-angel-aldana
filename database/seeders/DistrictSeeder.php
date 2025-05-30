<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Province;
use App\Models\District;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $province = Province::where('code', '140100')->first();

        District::create([
            'name' => 'José Leonardo Ortiz',
            'code' => '140110',
            'province_id' => $province->id,
        ]);
    }
}
