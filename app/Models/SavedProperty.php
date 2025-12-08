<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedProperty extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'property_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user who saved the property
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the property that was saved
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}