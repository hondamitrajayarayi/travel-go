<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tour extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'destination',
        'price',
        'duration',
        'description',
        'thumbnail',
    ];

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
