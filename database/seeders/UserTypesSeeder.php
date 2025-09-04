<?php

namespace Database\Seeders;

use App\Models\UserType;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userTypes = [
            ['name' => 'عميل', 'type' => 'customer'],
            ['name' => 'مطعم', 'type' => 'restaurant'],
            ['name' => 'محل حلوى', 'type' => 'candy_store'],
            ['name' => 'صباب', 'type' => 'pourivy'],
        ];

        foreach ($userTypes as $type) {
            UserType::create([
                'name' => $type['name'],
                'type' => $type['type'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
