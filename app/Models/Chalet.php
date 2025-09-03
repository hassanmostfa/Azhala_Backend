<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Chalet extends Model
{
    protected $fillable = [
        'owner_id',
        'has_offer',
        'offer_text',
        'title',
        'region_id',
        'city_id',
        'price',
        'price_note',
        'description',
        'notes'
    ];

    protected $casts = [
        'has_offer' => 'boolean',
        'price' => 'decimal:2',
    ];

    /**
     * Get the owner of the chalet
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Get the region of the chalet
     */
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    /**
     * Get the city of the chalet
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get the images for the chalet
     */
    public function images(): HasMany
    {
        return $this->hasMany(ChaletImage::class);
    }

    /**
     * Get the main image for the chalet
     */
    public function mainImage(): HasMany
    {
        return $this->hasMany(ChaletImage::class)->where('is_main', true);
    }

    /**
     * Get the services for the chalet
     */
    public function services(): BelongsToMany
    {
        return $this->belongsToMany(ChaletService::class, 'chalet_service_assigns', 'chalet_id', 'chalet_service_id');
    }
}
