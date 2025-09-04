<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;
use App\Models\Slider;

interface SliderRepositoryInterface
{
    public function getAll(): Collection;
    public function getPublished(): Collection;
    public function getTrashed(): Collection;
    public function findById(int $id): ?Slider;
    public function findTrashedById(int $id): ?Slider;
    public function create(array $data): Slider;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function restore(int $id): bool;
    public function forceDelete(int $id): bool;
    public function togglePublish(int $id): bool;
}
