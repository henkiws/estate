<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserReference extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'relationship',
        'mobile_country_code',
        'mobile_number',
        'email',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}