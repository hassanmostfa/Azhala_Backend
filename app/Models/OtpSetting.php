<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtpSetting extends Model
{
    protected $fillable = [
        'key',
        'value'
    ];
}
