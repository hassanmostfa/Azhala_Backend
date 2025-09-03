<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSettingRequest;
use App\Interfaces\SettingRepositoryInterface;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    use ImageUploadTrait;

    protected $settingRepository;

    public function __construct(SettingRepositoryInterface $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    /**
     * Display the settings page
     */
    public function index()
    {
        $settings = $this->settingRepository->getAll();
        
        // Convert collection to associative array for easier use in view
        $settingsArray = [];
        foreach ($settings as $setting) {
            $settingsArray[$setting->key] = $setting->value;
        }

        return view('dashboard.pages.settings.index', compact('settingsArray'));
    }

    /**
     * Update settings
     */
    public function update(UpdateSettingRequest $request)
    {
        $settings = $request->validated();
        
        // Handle logo upload if provided
        if ($request->hasFile('logo')) {
            $logoFile = $request->file('logo');
            
            // Create a temporary model instance for the trait
            $tempModel = new \App\Models\Admin();
            $tempModel->id = 1; // Use Admin model with ID 1
            
            // Upload the logo
            $logoPath = $this->uploadSingleImage($logoFile, $tempModel, 'logo.png', 'images');
            
            if ($logoPath) {
                // Store the full path including /storage/ prefix
                $settings['logo'] = '/storage/' . $logoPath;
            }
        }
        
        $result = $this->settingRepository->updateOrCreateAll($settings);

        if ($result) {
            return redirect()->route('dashboard.settings.index')
                ->with('success', 'تم تحديث الإعدادات بنجاح');
        }

        return redirect()->route('dashboard.settings.index')
            ->with('error', 'حدث خطأ أثناء تحديث الإعدادات');
    }
}
