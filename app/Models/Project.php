<?php
// app/Models/Project.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    public function getImageUrlAttribute()
    {
        // Prefer explicit URLs if present on the model (use raw to avoid recursion)
        $explicit = $this->getRawOriginal('image_url') ?? ($this->attributes['image_url'] ?? null);
        if (!empty($explicit)) {
            return $explicit;
        }

        $fallback = $this->getRawOriginal('fallback_image_url') ?? ($this->attributes['fallback_image_url'] ?? null);
        if (!empty($fallback)) {
            return $fallback;
        }
        
        // Use the existing image field if available
        if ($this->image) {
            // Check if image is a URL or local path
            if (filter_var($this->image, FILTER_VALIDATE_URL)) {
                return $this->image; // Return URL directly
            } else {
                return asset('storage/' . $this->image); // Treat as local path
            }
        }
        
        // Return a default image
        return 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&h=600&fit=crop&crop=center';
    }
}