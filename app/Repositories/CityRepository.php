<?php

namespace App\Repositories;

use App\Interfaces\CityRepositoryInterface;
use App\Models\City;
use Illuminate\Database\Eloquent\Collection;

class CityRepository implements CityRepositoryInterface
{
    public function getCitiesByRegionId(int $regionId): Collection
    {
        return City::where('region_id', $regionId)->get(['id', 'name', 'is_active']);
    }

    public function toggleCityStatus(int $cityId, bool $isActive): bool
    {
        $city = City::findOrFail($cityId);
        $city->is_active = $isActive;
        return $city->save();
    }
}
