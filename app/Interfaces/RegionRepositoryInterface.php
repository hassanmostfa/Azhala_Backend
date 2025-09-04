<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface RegionRepositoryInterface
{
    public function getAllRegions(): Collection;
    public function toggleRegionStatus(int $regionId, bool $isActive): bool;
    public function toggleSelectedRegionsStatus(array $regionIds, bool $isActive): bool;
    
}
