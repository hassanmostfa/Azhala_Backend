<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserBusinessInfo extends Model
{
    protected $fillable = [
        'commercial_register',
        'user_id',
        'tax_number'
    ];

    /**
     * Get the user that owns the business info
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
