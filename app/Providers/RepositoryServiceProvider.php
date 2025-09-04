<?php

namespace App\Providers;

use App\Interfaces\CityRepositoryInterface;
use App\Interfaces\OtpSettingRepositoryInterface;
use App\Interfaces\RegionRepositoryInterface;
use App\Interfaces\SettingRepositoryInterface;
use App\Interfaces\SliderRepositoryInterface;
use App\Repositories\CityRepository;
use App\Repositories\OtpSettingRepository;
use App\Repositories\RegionRepository;
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
        $this->app->bind(CityRepositoryInterface::class, CityRepository::class);
        $this->app->bind(RegionRepositoryInterface::class, RegionRepository::class);
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
