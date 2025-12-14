<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'property_id',
    ];

    /**
     * Relationships
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Scopes
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Helper Methods
     */
    public static function toggle($userId, $propertyId): bool
    {
        $favorite = self::where('user_id', $userId)
                       ->where('property_id', $propertyId)
                       ->first();

        if ($favorite) {
            $favorite->delete();
            return false; // Removed
        } else {
            self::create([
                'user_id' => $userId,
                'property_id' => $propertyId,
            ]);
            return true; // Added
        }
    }

    public static function isFavorited($userId, $propertyId): bool
    {
        return self::where('user_id', $userId)
                  ->where('property_id', $propertyId)
                  ->exists();
    }

    public static function countForUser($userId): int
    {
        return self::where('user_id', $userId)->count();
    }
}