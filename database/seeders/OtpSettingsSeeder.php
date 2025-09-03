<?php

namespace Database\Seeders;

use App\Models\OtpSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OtpSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $otpSettings = [
            ['key' => 'otp_test_code', 'value' => '12345'], // size 5
            ['key' => 'is_production', 'value' => '0'], // 0 || 1
            ['key' => 'expiry_time', 'value' => '5'], // 1 - 10 min
        ];

        foreach ($otpSettings as $otpSetting) {
            OtpSetting::updateOrCreate(
                ['key' => $otpSetting['key']],
                ['value' => $otpSetting['value']]
            );
        }
    }

}
