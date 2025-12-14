<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'image_url',
        'thumbnail_url',
        'category',
        'tags',
        'is_published',
        'published_at',
        'author_id',
        'views_count',
        'likes_count',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'tags' => 'array',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'views_count' => 'integer',
        'likes_count' => 'integer',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-generate slug from title
        static::creating(function ($post) {
            if (!$post->slug) {
                $post->slug = Str::slug($post->title);
            }
        });
    }

    /**
     * Get the author
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Get category display name
     */
    public function getCategoryDisplayAttribute()
    {
        return match($this->category) {
            'good_to_know' => 'Good to know',
            'tips' => 'Tips',
            'news' => 'News',
            'guides' => 'Guides',
            'updates' => 'Updates',
            default => ucfirst($this->category),
        };
    }

    /**
     * Get category icon
     */
    public function getCategoryIconAttribute()
    {
        return match($this->category) {
            'good_to_know' => '💡',
            'tips' => '✨',
            'news' => '📰',
            'guides' => '📖',
            'updates' => '🔔',
            default => '📄',
        };
    }

    /**
     * Get category color
     */
    public function getCategoryColorAttribute()
    {
        return match($this->category) {
            'good_to_know' => 'teal',
            'tips' => 'purple',
            'news' => 'blue',
            'guides' => 'green',
            'updates' => 'orange',
            default => 'gray',
        };
    }

    /**
     * Get reading time (minutes)
     */
    public function getReadingTimeAttribute()
    {
        $wordCount = str_word_count(strip_tags($this->content));
        return ceil($wordCount / 200); // Average reading speed: 200 words/minute
    }

    /**
     * Increment view count
     */
    public function incrementViews()
    {
        $this->increment('views_count');
    }

    /**
     * Scope to published posts
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                    ->where('published_at', '<=', now());
    }

    /**
     * Scope to by category
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope to recent posts
     */
    public function scopeRecent($query, $limit = 5)
    {
        return $query->published()
                    ->orderBy('published_at', 'desc')
                    ->limit($limit);
    }

    /**
     * Scope to popular posts
     */
    public function scopePopular($query, $limit = 5)
    {
        return $query->published()
                    ->orderBy('views_count', 'desc')
                    ->limit($limit);
    }
}