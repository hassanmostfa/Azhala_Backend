<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface CityRepositoryInterface
{
    public function getCitiesByRegionId(int $regionId): Collection;
    public function toggleCityStatus(int $cityId, bool $isActive): bool;
}
