<?php

namespace App\Repositories;

use App\Interfaces\SliderRepositoryInterface;
use App\Models\Slider;
use Illuminate\Support\Collection;

class SliderRepository implements SliderRepositoryInterface
{
    protected $model;

    public function __construct(Slider $model)
    {
        $this->model = $model;
    }

    public function getAll(): Collection
    {
        return $this->model->get();
    }

    public function getAllPaginated(int $perPage = 10)
    {
        return $this->model->paginate($perPage);
    }

    public function getPublished(): Collection
    {
        return $this->model->where('is_published', true)
                          ->orderBy('created_at', 'desc')
                          ->get();
    }

    public function getTrashed(): Collection
    {
        return $this->model->onlyTrashed()
                          ->get();
    }

    public function getTrashedPaginated(int $perPage = 10)
    {
        return $this->model->onlyTrashed()
                        ->paginate($perPage);
    }

    public function findById(int $id): ?Slider
    {
        return $this->model->find($id);
    }

    public function findTrashedById(int $id): ?Slider
    {
        return $this->model->onlyTrashed()->find($id);
    }

    public function create(array $data): Slider
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        $slider = $this->findById($id);
        
        if (!$slider) {
            return false;
        }

        return $slider->update($data);
    }

    public function delete(int $id): bool
    {
        $slider = $this->findById($id);
        
        if (!$slider) {
            return false;
        }

        return $slider->delete();
    }

    public function restore(int $id): bool
    {
        $slider = $this->findTrashedById($id);
        
        if (!$slider) {
            return false;
        }

        return $slider->restore();
    }

    public function forceDelete(int $id): bool
    {
        $slider = $this->findTrashedById($id);
        
        if (!$slider) {
            return false;
        }

        return $slider->forceDelete();
    }

    public function togglePublish(int $id): bool
    {
        $slider = $this->findById($id);
        
        if (!$slider) {
            return false;
        }

        return $slider->update([
            'is_published' => !$slider->is_published
        ]);
    }
}
