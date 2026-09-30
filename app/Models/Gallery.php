<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'country_id',
        'image_path',
        'images',
        'destination',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'images'      => 'array',
        'is_featured' => 'boolean',
        'is_active'   => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (Gallery $gallery) {
            // Jika admin upload beberapa gambar melalui field images
            if (!empty($gallery->images) && is_array($gallery->images)) {
                $gallery->image_path = $gallery->images[0] ?? $gallery->image_path;
            } elseif (!empty($gallery->image_path) && empty($gallery->images)) {
                $gallery->images = [$gallery->image_path];
            }

            // Otomatis hubungkan country_id jika category diisi
            if (!empty($gallery->category) && empty($gallery->country_id)) {
                $country = Country::where('name', $gallery->category)->first();
                if ($country) {
                    $gallery->country_id = $country->id;
                }
            } elseif (!empty($gallery->country_id) && empty($gallery->category)) {
                $country = Country::find($gallery->country_id);
                if ($country) {
                    $gallery->category = $country->name;
                }
            }
        });
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'category', 'name');
    }

    /**
     * Dapatkan daftar seluruh file path foto dalam dokumentasi ini
     *
     * @return array<string>
     */
    public function getAllPhotos(): array
    {
        if (!empty($this->images) && is_array($this->images)) {
            return array_values($this->images);
        }

        if (!empty($this->image_path)) {
            return [$this->image_path];
        }

        return [];
    }
}

