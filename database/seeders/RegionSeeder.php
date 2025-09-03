<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regions = [
            ['name' => 'الرياض', 'is_active' => true],
            ['name' => 'مكة المكرمة', 'is_active' => true],
            ['name' => 'المدينة المنورة', 'is_active' => true],
            ['name' => 'القصيم', 'is_active' => true],
            ['name' => 'الشرقية', 'is_active' => true],
            ['name' => 'عسير', 'is_active' => true],
            ['name' => 'تبوك', 'is_active' => true],
            ['name' => 'حائل', 'is_active' => true],
            ['name' => 'الحدود الشمالية', 'is_active' => true],
            ['name' => 'جازان', 'is_active' => true],
            ['name' => 'نجران', 'is_active' => true],
            ['name' => 'الباحة', 'is_active' => true],
            ['name' => 'الجوف', 'is_active' => true],
        ];

        foreach ($regions as $region) {
            Region::create($region);
        }
    }
}
