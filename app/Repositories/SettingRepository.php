<?php

namespace App\Repositories;

use App\Interfaces\SettingRepositoryInterface;
use App\Models\Setting;
use Illuminate\Support\Collection;

class SettingRepository implements SettingRepositoryInterface
{
    protected $model;

    public function __construct(Setting $model)
    {
        $this->model = $model;
    }

    /**
     * Get all settings
     */
    public function getAll(): Collection
    {
        return $this->model->all();
    }

    /**
     * Get setting by key
     */
    public function getByKey(string $key): ?Setting
    {
        return $this->model->where('key', $key)->first();
    }

    /**
     * Create or update setting
     */
    public function createOrUpdate(string $key, string $value): Setting
    {
        return $this->model->updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    /**
     * Update or create all settings at once
     */
    public function updateOrCreateAll(array $settings): bool
    {
        try {
            foreach ($settings as $key => $value) {
                $this->model->updateOrCreate(
                    ['key' => $key],
                    ['value' => $value]
                );
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
