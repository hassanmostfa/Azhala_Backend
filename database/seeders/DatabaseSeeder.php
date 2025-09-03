<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            OtpSettingsSeeder::class,
            AdminSeeder::class,
            RegionSeeder::class,
            CitySeeder::class,
            UserTypesSeeder::class,
            UsersSeeder::class,
            UserBusinessInfoSeeder::class,
        ]);
    }
}
