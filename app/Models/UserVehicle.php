<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserVehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'vehicle_type',
        'year',
        'make',
        'model',
        'state',
        'registration_number',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}