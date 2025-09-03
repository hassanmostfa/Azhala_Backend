<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOtpSettingRequest;
use App\Interfaces\OtpSettingRepositoryInterface;
use Illuminate\Http\Request;

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
        
        // Convert collection to associative array for easier use in view
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
        $settings = $request->validated();
        
        // Handle is_production toggle
        if (!isset($settings['is_production'])) {
            $settings['is_production'] = '0';
        }
        
        $result = $this->otpSettingRepository->updateOrCreateAll($settings);

        if ($result) {
            return redirect()->route('dashboard.otp-settings.index')
                ->with('success', 'تم تحديث إعدادات رمز التحقق بنجاح');
        }

        return redirect()->route('dashboard.otp-settings.index')
            ->with('error', 'حدث خطأ أثناء تحديث إعدادات رمز التحقق');
    }
}
