<?php
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

    // OTP Settings Routes
    Route::get('/otp-settings', [OtpSettingController::class, 'index'])->name('otp-settings.index');
    Route::post('/otp-settings', [OtpSettingController::class, 'update'])->name('otp-settings.update');

    // Settings Routes
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

    // Sliders Routes
    Route::get('sliders', [SliderController::class, 'index'])->name('sliders.index');
    Route::get('sliders/create', [SliderController::class, 'create'])->name('sliders.create');
    Route::post('sliders', [SliderController::class, 'store'])->name('sliders.store');
    
    // Trash and Restore Routes (must come before generic {id} routes)
    Route::get('sliders/trash', [SliderController::class, 'trashed'])->name('sliders.trashed');
    Route::post('sliders/{id}/restore', [SliderController::class, 'restore'])->name('sliders.restore');
    Route::delete('sliders/{id}/force-delete', [SliderController::class, 'forceDelete'])->name('sliders.force-delete');
    
    // Specific slider routes (must come before generic {id} route)
    Route::get('sliders/{id}/edit', [SliderController::class, 'edit'])->name('sliders.edit');
    Route::delete('sliders/{id}', [SliderController::class, 'destroy'])->name('sliders.destroy');
    Route::put('sliders/{id}', [SliderController::class, 'update'])->name('sliders.update');
    Route::post('sliders/{id}/toggle-publish', [SliderController::class, 'togglePublish'])->name('sliders.toggle-publish');
    
    // Generic slider route (must come last)
    Route::get('sliders/{id}', [SliderController::class, 'show'])->name('sliders.show');

});
