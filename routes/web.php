<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\OtpSettingController;

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
    Route::post('/otp-settings/reset', [OtpSettingController::class, 'reset'])->name('otp-settings.reset');

});
