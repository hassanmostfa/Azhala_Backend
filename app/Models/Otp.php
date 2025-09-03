<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Carbon\Carbon;

class Otp extends Model
{
    use HasUuids;

    protected $fillable = [
        'otp_code',
        'otp_type',
        'otp_mode',
        'user_identifier',
        'phone_code',
        'phone',
        'expires_at',
        'is_used',
        'generated_by_ip',
        'user_agent'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_used' => 'boolean',
    ];
}
