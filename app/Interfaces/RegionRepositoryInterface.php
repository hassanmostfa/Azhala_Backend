<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface RegionRepositoryInterface
{
    public function getAllRegions(): Collection;
    public function toggleRegionStatus(int $regionId, bool $isActive): bool;
}
