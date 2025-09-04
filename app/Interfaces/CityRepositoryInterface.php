<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface CityRepositoryInterface
{
    public function getCitiesByRegionId(int $regionId): Collection;
    public function toggleCityStatus(int $cityId, bool $isActive): bool;
    public function toggleAllCitiesStatus(int $regionId, bool $isActive): bool;
    public function toggleSelectedCitiesStatus(array $cityIds, bool $isActive): bool;
}
