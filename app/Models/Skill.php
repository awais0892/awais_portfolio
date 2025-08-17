<?php
// app/Models/Skill.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Skill extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'name', 'slug', 'icon_url', 'category', 'proficiency', 'order', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('name');
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}