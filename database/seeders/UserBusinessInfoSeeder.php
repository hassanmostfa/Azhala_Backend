<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserBusinessInfo;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;


class UserBusinessInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $faker = Faker::create();
        $users = User::with('userType')->get();

        foreach ($users as $user) {
            if ($user->userType && $user->userType->type === 'customer') {
                continue;
            }

            UserBusinessInfo::create([
                'user_id' => $user->id,
                'commercial_register' => $faker->numerify('CR-##########'),
                'tax_number' => $faker->numerify('TAX-##########'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
