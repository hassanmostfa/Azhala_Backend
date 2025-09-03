<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            // الرياض (Riyadh Region) - ID: 1
            ['name' => 'الرياض', 'region_id' => 1, 'is_active' => true],
            ['name' => 'الدرعية', 'region_id' => 1, 'is_active' => true],
            ['name' => 'الخرج', 'region_id' => 1, 'is_active' => true],
            ['name' => 'الزلفي', 'region_id' => 1, 'is_active' => true],
            ['name' => 'شقراء', 'region_id' => 1, 'is_active' => true],
            ['name' => 'عفيف', 'region_id' => 1, 'is_active' => true],
            ['name' => 'الدرعية', 'region_id' => 1, 'is_active' => true],
            ['name' => 'رماح', 'region_id' => 1, 'is_active' => true],
            ['name' => 'ثادق', 'region_id' => 1, 'is_active' => true],
            ['name' => 'حريملاء', 'region_id' => 1, 'is_active' => true],
            ['name' => 'الغاط', 'region_id' => 1, 'is_active' => true],
            ['name' => 'مرات', 'region_id' => 1, 'is_active' => true],
            ['name' => 'رنية', 'region_id' => 1, 'is_active' => true],
            ['name' => 'ثادق', 'region_id' => 1, 'is_active' => true],
            ['name' => 'الدرعية', 'region_id' => 1, 'is_active' => true],

            // مكة المكرمة (Makkah Region) - ID: 2
            ['name' => 'مكة المكرمة', 'region_id' => 2, 'is_active' => true],
            ['name' => 'جدة', 'region_id' => 2, 'is_active' => true],
            ['name' => 'الطائف', 'region_id' => 2, 'is_active' => true],
            ['name' => 'رابغ', 'region_id' => 2, 'is_active' => true],
            ['name' => 'خليص', 'region_id' => 2, 'is_active' => true],
            ['name' => 'رنية', 'region_id' => 2, 'is_active' => true],
            ['name' => 'تربة', 'region_id' => 2, 'is_active' => true],
            ['name' => 'القنفذة', 'region_id' => 2, 'is_active' => true],
            ['name' => 'الليث', 'region_id' => 2, 'is_active' => true],
            ['name' => 'رابغ', 'region_id' => 2, 'is_active' => true],
            ['name' => 'أبو عريش', 'region_id' => 2, 'is_active' => true],

            // المدينة المنورة (Madinah Region) - ID: 3
            ['name' => 'المدينة المنورة', 'region_id' => 3, 'is_active' => true],
            ['name' => 'ينبع', 'region_id' => 3, 'is_active' => true],
            ['name' => 'العلا', 'region_id' => 3, 'is_active' => true],
            ['name' => 'مهد الذهب', 'region_id' => 3, 'is_active' => true],
            ['name' => 'الحناكية', 'region_id' => 3, 'is_active' => true],
            ['name' => 'بدر', 'region_id' => 3, 'is_active' => true],
            ['name' => 'خيبر', 'region_id' => 3, 'is_active' => true],
            ['name' => 'العيص', 'region_id' => 3, 'is_active' => true],
            ['name' => 'رابغ', 'region_id' => 3, 'is_active' => true],

            // القصيم (Al-Qassim Region) - ID: 4
            ['name' => 'بريدة', 'region_id' => 4, 'is_active' => true],
            ['name' => 'عنيزة', 'region_id' => 4, 'is_active' => true],
            ['name' => 'الرس', 'region_id' => 4, 'is_active' => true],
            ['name' => 'المذنب', 'region_id' => 4, 'is_active' => true],
            ['name' => 'البكيرية', 'region_id' => 4, 'is_active' => true],
            ['name' => 'البدائع', 'region_id' => 4, 'is_active' => true],
            ['name' => 'الأسياح', 'region_id' => 4, 'is_active' => true],
            ['name' => 'النبهانية', 'region_id' => 4, 'is_active' => true],
            ['name' => 'عيون الجواء', 'region_id' => 4, 'is_active' => true],
            ['name' => 'رياض الخبراء', 'region_id' => 4, 'is_active' => true],
            ['name' => 'عقلة الصقور', 'region_id' => 4, 'is_active' => true],
            ['name' => 'ضرية', 'region_id' => 4, 'is_active' => true],

            // الشرقية (Eastern Province) - ID: 5
            ['name' => 'الدمام', 'region_id' => 5, 'is_active' => true],
            ['name' => 'الخبر', 'region_id' => 5, 'is_active' => true],
            ['name' => 'الظهران', 'region_id' => 5, 'is_active' => true],
            ['name' => 'القطيف', 'region_id' => 5, 'is_active' => true],
            ['name' => 'الأحساء', 'region_id' => 5, 'is_active' => true],
            ['name' => 'حفر الباطن', 'region_id' => 5, 'is_active' => true],
            ['name' => 'الجبيل', 'region_id' => 5, 'is_active' => true],
            ['name' => 'رأس تنورة', 'region_id' => 5, 'is_active' => true],
            ['name' => 'بقيق', 'region_id' => 5, 'is_active' => true],
            ['name' => 'النعيرية', 'region_id' => 5, 'is_active' => true],
            ['name' => 'رفحاء', 'region_id' => 5, 'is_active' => true],
            ['name' => 'دير الزور', 'region_id' => 5, 'is_active' => true],
            ['name' => 'قرية العليا', 'region_id' => 5, 'is_active' => true],
            ['name' => 'رأس الخير', 'region_id' => 5, 'is_active' => true],

            // عسير (Asir Region) - ID: 6
            ['name' => 'أبها', 'region_id' => 6, 'is_active' => true],
            ['name' => 'خميس مشيط', 'region_id' => 6, 'is_active' => true],
            ['name' => 'بيشة', 'region_id' => 6, 'is_active' => true],
            ['name' => 'النماص', 'region_id' => 6, 'is_active' => true],
            ['name' => 'محايل عسير', 'region_id' => 6, 'is_active' => true],
            ['name' => 'أحد رفيدة', 'region_id' => 6, 'is_active' => true],
            ['name' => 'سراة عبيدة', 'region_id' => 6, 'is_active' => true],
            ['name' => 'رجال ألمع', 'region_id' => 6, 'is_active' => true],
            ['name' => 'بلقرن', 'region_id' => 6, 'is_active' => true],
            ['name' => 'المندق', 'region_id' => 6, 'is_active' => true],
            ['name' => 'العقيق', 'region_id' => 6, 'is_active' => true],
            ['name' => 'القرى', 'region_id' => 6, 'is_active' => true],
            ['name' => 'ثادق', 'region_id' => 6, 'is_active' => true],
            ['name' => 'رنية', 'region_id' => 6, 'is_active' => true],

            // تبوك (Tabuk Region) - ID: 7
            ['name' => 'تبوك', 'region_id' => 7, 'is_active' => true],
            ['name' => 'الوجه', 'region_id' => 7, 'is_active' => true],
            ['name' => 'ضباء', 'region_id' => 7, 'is_active' => true],
            ['name' => 'أملج', 'region_id' => 7, 'is_active' => true],
            ['name' => 'حقل', 'region_id' => 7, 'is_active' => true],
            ['name' => 'البدع', 'region_id' => 7, 'is_active' => true],
            ['name' => 'الشيخ حميد', 'region_id' => 7, 'is_active' => true],

            // حائل (Hail Region) - ID: 8
            ['name' => 'حائل', 'region_id' => 8, 'is_active' => true],
            ['name' => 'بقعاء', 'region_id' => 8, 'is_active' => true],
            ['name' => 'الغزالة', 'region_id' => 8, 'is_active' => true],
            ['name' => 'الشنان', 'region_id' => 8, 'is_active' => true],
            ['name' => 'موقق', 'region_id' => 8, 'is_active' => true],
            ['name' => 'سميراء', 'region_id' => 8, 'is_active' => true],

            // الحدود الشمالية (Northern Borders) - ID: 9
            ['name' => 'عرعر', 'region_id' => 9, 'is_active' => true],
            ['name' => 'رفحاء', 'region_id' => 9, 'is_active' => true],
            ['name' => 'دير الزور', 'region_id' => 9, 'is_active' => true],
            ['name' => 'طريف', 'region_id' => 9, 'is_active' => true],

            // جازان (Jazan Region) - ID: 10
            ['name' => 'جازان', 'region_id' => 10, 'is_active' => true],
            ['name' => 'صبيا', 'region_id' => 10, 'is_active' => true],
            ['name' => 'أبو عريش', 'region_id' => 10, 'is_active' => true],
            ['name' => 'صامطة', 'region_id' => 10, 'is_active' => true],
            ['name' => 'أحد المسارحة', 'region_id' => 10, 'is_active' => true],
            ['name' => 'الدائر', 'region_id' => 10, 'is_active' => true],
            ['name' => 'العارضة', 'region_id' => 10, 'is_active' => true],
            ['name' => 'أبو عريش', 'region_id' => 10, 'is_active' => true],
            ['name' => 'صامطة', 'region_id' => 10, 'is_active' => true],
            ['name' => 'بيش', 'region_id' => 10, 'is_active' => true],
            ['name' => 'الدرب', 'region_id' => 10, 'is_active' => true],
            ['name' => 'الريث', 'region_id' => 10, 'is_active' => true],
            ['name' => 'فرسان', 'region_id' => 10, 'is_active' => true],
            ['name' => 'الدائر', 'region_id' => 10, 'is_active' => true],

            // نجران (Najran Region) - ID: 11
            ['name' => 'نجران', 'region_id' => 11, 'is_active' => true],
            ['name' => 'شرورة', 'region_id' => 11, 'is_active' => true],
            ['name' => 'حبونا', 'region_id' => 11, 'is_active' => true],
            ['name' => 'بدر الجنوب', 'region_id' => 11, 'is_active' => true],
            ['name' => 'يدمة', 'region_id' => 11, 'is_active' => true],
            ['name' => 'ثار', 'region_id' => 11, 'is_active' => true],
            ['name' => 'خباش', 'region_id' => 11, 'is_active' => true],

            // الباحة (Al-Baha Region) - ID: 12
            ['name' => 'الباحة', 'region_id' => 12, 'is_active' => true],
            ['name' => 'بلجرشي', 'region_id' => 12, 'is_active' => true],
            ['name' => 'المندق', 'region_id' => 12, 'is_active' => true],
            ['name' => 'العقيق', 'region_id' => 12, 'is_active' => true],
            ['name' => 'القرى', 'region_id' => 12, 'is_active' => true],
            ['name' => 'المخواة', 'region_id' => 12, 'is_active' => true],
            ['name' => 'العقيق', 'region_id' => 12, 'is_active' => true],

            // الجوف (Al-Jouf Region) - ID: 13
            ['name' => 'سكاكا', 'region_id' => 13, 'is_active' => true],
            ['name' => 'القريات', 'region_id' => 13, 'is_active' => true],
            ['name' => 'دومة الجندل', 'region_id' => 13, 'is_active' => true],
            ['name' => 'طبرجل', 'region_id' => 13, 'is_active' => true],
        ];

        foreach ($cities as $city) {
            City::create($city);
        }
    }
}
