<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'breed',
        'desexed',
        'size',
        'registration_number',
        'photo_paths',
        'document_paths',
    ];

    protected $casts = [
        'photo_paths' => 'array',
        'document_paths' => 'array',
        'desexed' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the first photo path (for backward compatibility)
     */
    public function getPhotoPathAttribute()
    {
        return $this->photo_paths[0] ?? null;
    }
    
    /**
     * Get the first document path (for backward compatibility)
     */
    public function getDocumentPathAttribute()
    {
        return $this->document_paths[0] ?? null;
    }
}