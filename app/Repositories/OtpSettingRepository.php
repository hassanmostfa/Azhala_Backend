<?php

namespace App\Repositories;

use App\Interfaces\OtpSettingRepositoryInterface;
use App\Models\OtpSetting;
use Illuminate\Support\Collection;

class OtpSettingRepository implements OtpSettingRepositoryInterface
{
    protected $model;

    public function __construct(OtpSetting $model)
    {
        $this->model = $model;
    }

    /**
     * Get all OTP settings
     */
    public function getAll(): Collection
    {
        return $this->model->all();
    }

    /**
     * Get OTP setting by key
     */
    public function getByKey(string $key): ?OtpSetting
    {
        return $this->model->where('key', $key)->first();
    }

    /**
     * Create or update OTP setting
     */
    public function createOrUpdate(string $key, string $value): OtpSetting
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
