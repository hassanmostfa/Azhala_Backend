<?php

namespace App\Providers;

use App\Interfaces\OtpSettingRepositoryInterface;
use App\Interfaces\SettingRepositoryInterface;
use App\Interfaces\SliderRepositoryInterface;
use App\Repositories\OtpSettingRepository;
use App\Repositories\SettingRepository;
use App\Repositories\SliderRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(OtpSettingRepositoryInterface::class, OtpSettingRepository::class);
        $this->app->bind(SettingRepositoryInterface::class, SettingRepository::class);
        $this->app->bind(SliderRepositoryInterface::class, SliderRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
