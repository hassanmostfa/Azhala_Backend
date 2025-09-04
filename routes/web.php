<?php
use App\Http\Controllers\Dashboard\RegionController;
use App\Http\Controllers\Dashboard\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\OtpSettingController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\SliderController;

Route::prefix('dashboard')->name('dashboard.')->group(function () {

    Route::get('/', function () {
        return redirect()->route('dashboard.index');
    });

    Route::get('/index', function () {
        return view('dashboard.index');
    })->name('index');

    // Users Routes
    Route::get('users/trashed', [UserController::class, 'trashed'])->name('users.trashed');
    Route::post('users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
    Route::delete('users/{id}/force-delete', [UserController::class, 'forceDelete'])->name('users.forceDelete');

    Route::resource('users', UserController::class)->names([
        'index' => 'users.index',
        'create' => 'users.create',
        'store' => 'users.store',
        'edit' => 'users.edit',
        'update' => 'users.update',
        'destroy' => 'users.destroy',
    ]);

    // OTP Settings Routes
    Route::get('/otp-settings', [OtpSettingController::class, 'index'])->name('otp-settings.index');
    Route::post('/otp-settings', [OtpSettingController::class, 'update'])->name('otp-settings.update');

    // Settings Routes
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

    // Sliders Routes
    Route::resource('sliders', SliderController::class);
    Route::post('sliders/{id}/toggle-publish', [SliderController::class, 'togglePublish'])->name('sliders.toggle-publish');

    // Regions Routes
    Route::get('/regions', [RegionController::class, 'index'])->name('regions.index');
    Route::get('/regions/{regionId}/cities', [RegionController::class, 'getCities'])->name('regions.cities');
    Route::post('/regions/{regionId}/toggle', [RegionController::class, 'toggleRegionStatus'])->name('regions.toggle');
    Route::post('/cities/{cityId}/toggle', [RegionController::class, 'toggleCityStatus'])->name('cities.toggle');
});
