<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'placement', // 'all', 'desktop', 'mobile'
        'type',
        'file_path',
        'image_path',
        'video_path',
        'link_url',
        'button_text',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Dapatkan URL gambar untuk tampilan Desktop Web
     */
    public function getDesktopImageUrlAttribute(): ?string
    {
        $path = $this->image_path ?: ($this->type === 'image' ? $this->file_path : null);
        return $path ? asset('storage/' . $path) : null;
    }

    /**
     * Dapatkan URL video untuk tampilan Mobile (HP)
     */
    public function getMobileVideoUrlAttribute(): ?string
    {
        $path = $this->video_path ?: ($this->type === 'video' ? $this->file_path : null);
        return $path ? asset('storage/' . $path) : null;
    }
}
