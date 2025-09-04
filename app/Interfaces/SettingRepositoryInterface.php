<?php

namespace App\Interfaces;

interface SettingRepositoryInterface
{
    /**
     * Get all settings
     */
    public function getAll();

    /**
     * Get setting by key
     */
    public function getByKey(string $key);

    /**
     * Create or update setting
     */
    public function createOrUpdate(string $key, string $value);

    /**
     * Update or create all settings at once
     */
    public function updateOrCreateAll(array $settings);

}
