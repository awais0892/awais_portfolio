<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'status',
        'author',
        'category',
        'tags',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'views',
        'published_at'
    ];

    protected $casts = [
        'tags' => 'array',
        'published_at' => 'datetime',
        'views' => 'integer'
    ];

    protected $dates = [
        'published_at',
        'created_at',
        'updated_at'
    ];

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->where('published_at', '<=', now());
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeArchived($query)
    {
        return $query->where('status', 'archived');
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('content', 'like', "%{$search}%")
              ->orWhere('excerpt', 'like', "%{$search}%")
              ->orWhere('tags', 'like', "%{$search}%");
        });
    }

    // Accessors
    public function getReadTimeAttribute()
    {
        $words = str_word_count(strip_tags($this->content));
        $minutes = ceil($words / 200); // Average reading speed: 200 words per minute
        return $minutes . ' min read';
    }

    public function getFormattedPublishedDateAttribute()
    {
        if ($this->published_at) {
            return $this->published_at->format('M d, Y');
        }
        return $this->created_at->format('M d, Y');
    }

    public function getFormattedTagsAttribute()
    {
        if (is_array($this->tags)) {
            return implode(', ', $this->tags);
        }
        return $this->tags;
    }

    public function getFeaturedImageUrlAttribute()
    {
        if ($this->featured_image) {
            return asset('storage/' . $this->featured_image);
        }
        return asset('images/default-blog-image.jpg');
    }

    public function getExcerptAttribute($value)
    {
        if ($value) {
            return $value;
        }
        
        // Generate excerpt from content if not provided
        $content = strip_tags($this->content);
        return Str::limit($content, 150);
    }

    public function getMetaTitleAttribute($value)
    {
        return $value ?: $this->title;
    }

    public function getMetaDescriptionAttribute($value)
    {
        return $value ?: $this->excerpt;
    }

    // Mutators
    public function setSlugAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['slug'] = Str::slug($this->title);
        } else {
            $this->attributes['slug'] = Str::slug($value);
        }
    }

    public function setTagsAttribute($value)
    {
        if (is_string($value)) {
            $this->attributes['tags'] = json_encode(array_filter(array_map('trim', explode(',', $value))));
        } else {
            $this->attributes['tags'] = json_encode($value);
        }
    }

    public function setPublishedAtAttribute($value)
    {
        if ($value && $this->status === 'published') {
            $this->attributes['published_at'] = $value;
        } elseif ($this->status === 'published' && !$value) {
            $this->attributes['published_at'] = now();
        }
    }

    // Methods
    public function incrementViews()
    {
        $this->increment('views');
    }

    public function isPublished()
    {
        return $this->status === 'published' && 
               $this->published_at && 
               $this->published_at <= now();
    }

    public function isDraft()
    {
        return $this->status === 'draft';
    }

    public function isArchived()
    {
        return $this->status === 'archived';
    }

    public function publish()
    {
        $this->update([
            'status' => 'published',
            'published_at' => now()
        ]);
    }

    public function unpublish()
    {
        $this->update([
            'status' => 'draft',
            'published_at' => null
        ]);
    }

    public function archive()
    {
        $this->update(['status' => 'archived']);
    }

    public function getRelatedPosts($limit = 3)
    {
        return static::published()
            ->where('id', '!=', $this->id)
            ->where(function($query) {
                $query->where('category', $this->category)
                      ->orWhereJsonContains('tags', $this->tags);
            })
            ->limit($limit)
            ->get();
    }

    public function getNextPost()
    {
        return static::published()
            ->where('published_at', '>', $this->published_at)
            ->orderBy('published_at', 'asc')
            ->first();
    }

    public function getPreviousPost()
    {
        return static::published()
            ->where('published_at', '<', $this->published_at)
            ->orderBy('published_at', 'desc')
            ->first();
    }

    // Static methods
    public static function getCategories()
    {
        return static::distinct()->pluck('category')->filter()->values();
    }

    public static function getPopularPosts($limit = 5)
    {
        return static::published()
            ->orderBy('views', 'desc')
            ->limit($limit)
            ->get();
    }

    public static function getRecentPosts($limit = 5)
    {
        return static::published()
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
