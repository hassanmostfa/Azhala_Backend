<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOtpSettingRequest;
use App\Interfaces\OtpSettingRepositoryInterface;

class OtpSettingController extends Controller
{
    protected $otpSettingRepository;

    public function __construct(OtpSettingRepositoryInterface $otpSettingRepository)
    {
        $this->otpSettingRepository = $otpSettingRepository;
    }

    /**
     * Display the OTP settings page
     */
    public function index()
    {
        $settings = $this->otpSettingRepository->getAll();
        
        // Convert to key-value array for easier handling in view
        $settingsArray = [];
        foreach ($settings as $setting) {
            $settingsArray[$setting->key] = $setting->value;
        }

        return view('dashboard.pages.otp-settings.index', compact('settingsArray'));
    }

    /**
     * Update OTP settings
     */
    public function update(UpdateOtpSettingRequest $request)
    {
        $settings = [
            'otp_test_code' => $request->otp_test_code,
            'is_production' => $request->has('is_production') ? '1' : '0',
            'expiry_time' => $request->expiry_time,
        ];

        $result = $this->otpSettingRepository->updateOrCreateAll($settings);

        if ($result) {
            return redirect()->route('dashboard.otp-settings.index')
                ->with('success', 'تم تحديث إعدادات رمز التحقق بنجاح!');
        }

        return redirect()->route('dashboard.otp-settings.index')
            ->with('error', 'فشل في تحديث إعدادات رمز التحقق. يرجى المحاولة مرة أخرى.');
    }

    /**
     * Reset OTP settings to default values
     */
    public function reset()
    {
        $defaultSettings = [
            'otp_test_code' => '12345',
            'is_production' => '0',
            'expiry_time' => '5',
        ];

        $result = $this->otpSettingRepository->updateOrCreateAll($defaultSettings);

        if ($result) {
            return redirect()->route('dashboard.otp-settings.index')
                ->with('success', 'تم إعادة تعيين إعدادات رمز التحقق للقيم الافتراضية بنجاح!');
        }

        return redirect()->route('dashboard.otp-settings.index')
            ->with('error', 'فشل في إعادة تعيين إعدادات رمز التحقق. يرجى المحاولة مرة أخرى.');
    }
}
