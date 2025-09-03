<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserType;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $userTypeIds = UserType::pluck('id')->toArray();

        for ($i = 0; $i < 10; $i++) {
            User::create([
                'name' => $faker->name,
                'phone_code' => '+966',
                'phone' => '5' . $faker->unique()->numerify('########'),
                'photo' => '/assets/media/avatars/300-1.jpg',
                'address' => $faker->address,
                'latitude' => $faker->latitude(16.0, 33.0),
                'longitude' => $faker->longitude(34.0, 55.0),
                'is_approved' => true,
                'user_type_id' => $faker->randomElement($userTypeIds),
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
