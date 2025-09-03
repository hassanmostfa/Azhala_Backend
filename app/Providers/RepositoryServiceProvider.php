<?php

namespace App\Providers;

use App\Interfaces\OtpSettingRepositoryInterface;
use App\Interfaces\SettingRepositoryInterface;
use App\Repositories\OtpSettingRepository;
use App\Repositories\SettingRepository;
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
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
