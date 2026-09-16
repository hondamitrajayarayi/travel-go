<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tour extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id',
        'title',
        'slug',
        'destination',
        'price',
        'promo_price',
        'duration',
        'season',
        'start_date',
        'end_date',
        'status',
        'description',
        'thumbnail',
        'file_itinerary',
    ];

    protected $casts = [
        'price'          => 'decimal:2',
        'promo_price'    => 'decimal:2',
        'start_date'     => 'date',
        'end_date'       => 'date',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function itineraries(): HasMany
    {
        return $this->hasMany(TourItinerary::class);
    }

    public function facilities(): HasMany
    {
        return $this->hasMany(TourFacility::class);
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(TourGallery::class);
    }
}
