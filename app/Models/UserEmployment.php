<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserEmployment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_name',
        'address',
        'position',
        'gross_annual_salary',
        'manager_full_name',
        'contact_number',
        'email',
        'employment_letter_path',
        'start_date',
        'still_employed',
        'end_date',
    ];

    protected $casts = [
        'gross_annual_salary' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'still_employed' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}