<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserIdentification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'identification_type',
        'document_number',
        'expiry_date',
        'points',
        'document_paths',
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'points' => 'integer',
        'document_paths' => 'array',
    ];

    public const ID_POINTS = [
        'australian_drivers_licence' => 40,
        'passport' => 40,
        'birth_certificate' => 30,
        'medicare' => 20,
        'other' => 10,
    ];

    public const ID_LABELS = [
        'australian_drivers_licence' => 'Australian Drivers Licence (40 points)',
        'passport' => 'Passport (40 points)',
        'birth_certificate' => 'Birth Certificate (30 points)',
        'medicare' => 'Medicare (20 points)',
        'other' => 'Other (10 points)',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the first document path (for backward compatibility)
     */
    public function getDocumentPathAttribute()
    {
        return $this->document_paths[0] ?? null;
    }

    /**
     * Get points based on identification type
     */
    public static function getPointsForType(string $type): int
    {
        return match($type) {
            'australian_drivers_licence' => 40,
            'passport' => 70,
            'birth_certificate' => 70,
            'medicare' => 25,
            default => 0,
        };
    }

    // public static function getPointsForType(string $type): int
    // {
    //     return self::ID_POINTS[$type] ?? 0;
    // }

    public function getTypeLabelAttribute(): string
    {
        return self::ID_LABELS[$this->identification_type] ?? $this->identification_type;
    }
}