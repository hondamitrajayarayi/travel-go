<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'tour_title',
        'trip_date',
        'story',
        'rating',
        'avatar',
        'photo',
        'is_active',
        'sort_order',
        // legacy
        'title',
        'platform',
        'embed_url',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'rating'     => 'integer',
        'sort_order' => 'integer',
    ];
}
