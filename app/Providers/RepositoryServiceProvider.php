<?php

namespace App\Providers;

use App\Interfaces\OtpSettingRepositoryInterface;
use App\Repositories\OtpSettingRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(OtpSettingRepositoryInterface::class, OtpSettingRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
