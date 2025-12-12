<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserIncome extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'source_of_income',
        'net_weekly_amount',
        'bank_statement_path',
    ];

    protected $casts = [
        'net_weekly_amount' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getAnnualIncomeAttribute(): float
    {
        return $this->net_weekly_amount * 52;
    }
}