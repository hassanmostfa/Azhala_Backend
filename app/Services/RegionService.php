<?php

namespace App\Services;

use App\Interfaces\RegionRepositoryInterface;
use App\Interfaces\CityRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class RegionService
{
    protected $regionRepository;
    protected $cityRepository;

    public function __construct(
        RegionRepositoryInterface $regionRepository,
        CityRepositoryInterface $cityRepository
    ) {
        $this->regionRepository = $regionRepository;
        $this->cityRepository = $cityRepository;
    }

    public function getAllRegions(): Collection
    {
        return $this->regionRepository->getAllRegions();
    }

    public function getCitiesByRegionId(int $regionId): Collection
    {
        return $this->cityRepository->getCitiesByRegionId($regionId);
    }

    public function toggleCityStatus(int $cityId, bool $isActive): bool
    {
        return $this->cityRepository->toggleCityStatus($cityId, $isActive);
    }

    public function toggleRegionStatus(int $regionId, bool $isActive): bool
    {
        return $this->regionRepository->toggleRegionStatus($regionId, $isActive);
    }

    public function toggleAllRegionsStatus(bool $isActive): bool
{
    return $this->regionRepository->toggleAllRegionsStatus($isActive);
}

public function toggleAllCitiesStatus(int $regionId, bool $isActive): bool
{
    return $this->cityRepository->toggleAllCitiesStatus($regionId, $isActive);
}
public function toggleSelectedRegionsStatus(array $regionIds, bool $isActive): bool
{
    return $this->regionRepository->toggleSelectedRegionsStatus($regionIds, $isActive);
}
public function toggleSelectedCitiesStatus(array $cityIds, bool $isActive): bool
{
    return $this->cityRepository->toggleSelectedCitiesStatus($cityIds, $isActive);
}
}
