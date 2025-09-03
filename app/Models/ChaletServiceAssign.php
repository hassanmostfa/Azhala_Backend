<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChaletServiceAssign extends Model
{
    protected $fillable = [
        'chalet_id',
        'chalet_service_id'
    ];

    /**
     * Get the chalet that owns the service assignment
     */
    public function chalet(): BelongsTo
    {
        return $this->belongsTo(Chalet::class);
    }

    /**
     * Get the service that is assigned
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(ChaletService::class, 'chalet_service_id');
    }

}
