<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChaletImage extends Model
{
    protected $fillable = [
        'chalet_id',
        'path',
        'is_main'
    ];

    protected $casts = [
        'is_main' => 'boolean',
    ];

    /**
     * Get the chalet that owns the image
     */
    public function chalet(): BelongsTo
    {
        return $this->belongsTo(Chalet::class);
    }
}
