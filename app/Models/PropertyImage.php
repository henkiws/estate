<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'width',
        'height',
        'title',
        'caption',
        'sort_order',
        'is_featured',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    protected $appends = [
        'url',
        'thumbnail_url',
    ];

    // Relationships
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    // Accessors
    public function getUrlAttribute()
    {
        return \Storage::disk('public')->url($this->file_path);
    }

    public function getThumbnailUrlAttribute()
    {
        // In a real app, you'd generate thumbnails
        // For now, return the same URL
        return $this->url;
    }

    public function getFileSizeFormattedAttribute()
    {
        $bytes = $this->file_size;
        
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }
        
        return $bytes . ' bytes';
    }
}