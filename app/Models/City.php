<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class City extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'is_active',
        'region_id'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the region that owns the city
     */
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }
}
