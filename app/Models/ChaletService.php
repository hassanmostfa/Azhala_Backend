<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ChaletService extends Model
{
    protected $fillable = [
        'name',
        'icon',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the chalets that have this service
     */
    public function chalets(): BelongsToMany
    {
        return $this->belongsToMany(Chalet::class, 'chalet_service_assigns', 'chalet_service_id', 'chalet_id');
    }
}
