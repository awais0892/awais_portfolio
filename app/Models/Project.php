<?php
// app/Models/Project.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Project extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'title', 'slug', 'description', 'long_description', 'image', 'image_url', 'fallback_image_url',
        'technologies', 'live_url', 'github_url', 'featured', 'order', 'is_active'
    ];

    protected $casts = [
        'technologies' => 'array',
        'featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('created_at', 'desc');
    }

    public function getDisplayImageUrlAttribute(): string
    {
        if ($this->image) {
            if (filter_var($this->image, FILTER_VALIDATE_URL)) {
                return $this->image;
            }

            if (Storage::disk('public')->exists($this->image)) {
                return asset('storage/' . $this->image);
            }
        }

        $explicit = $this->getRawOriginal('image_url') ?? ($this->attributes['image_url'] ?? null);
        if (!empty($explicit)) {
            return $explicit;
        }

        $fallback = $this->getRawOriginal('fallback_image_url') ?? ($this->attributes['fallback_image_url'] ?? null);
        if (!empty($fallback)) {
            return $fallback;
        }

        return asset('assets/project-placeholder.svg');
    }
}
