<?php

namespace App\Repositories;

use App\Interfaces\RegionRepositoryInterface;
use App\Models\Region;
use Illuminate\Database\Eloquent\Collection;

class RegionRepository implements RegionRepositoryInterface
{
    public function getAllRegions(): Collection
    {
        return Region::with('cities')->get();
    }

    public function toggleRegionStatus(int $regionId, bool $isActive): bool
    {
        $region = Region::findOrFail($regionId);
        $region->is_active = $isActive;
        return $region->save();
    }

    public function toggleAllRegionsStatus(bool $isActive): bool
{
    return Region::query()->update(['is_active' => $isActive]) > 0;
}
public function toggleSelectedRegionsStatus(array $regionIds, bool $isActive): bool
{
    return Region::whereIn('id', $regionIds)->update(['is_active' => $isActive]) > 0;
}
}
