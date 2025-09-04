<?php

namespace App\Interfaces;

interface OtpSettingRepositoryInterface
{
    /**
     * Get all OTP settings
     */
    public function getAll();

    /**
     * Get OTP setting by key
     */
    public function getByKey(string $key);

    /**
     * Create or update OTP setting
     */
    public function createOrUpdate(string $key, string $value);

    /**
     * Update or create all settings at once
     */
    public function updateOrCreateAll(array $settings);

}
