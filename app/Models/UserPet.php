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
        'document_path',
        'photo_path'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}