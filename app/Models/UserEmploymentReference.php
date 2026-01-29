<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserEmploymentReference extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_employment_id',
        'currently_works_there',
        'current_works_there_comment',
        'job_title_correct',
        'job_title_comment',
        'employment_type',
        'employment_type_comment',
        'actual_start_date',
        'start_date_comment',
        'annual_income',
        'annual_income_comment',
        'role_ongoing',
        'role_ongoing_comment',
        'referee_name',
        'referee_email',
        'referee_position',
        'additional_comments',
        'submitted_at',
        'submitted_ip',
    ];

    protected $casts = [
        'currently_works_there' => 'boolean',
        'job_title_correct' => 'boolean',
        'role_ongoing' => 'boolean',
        'annual_income' => 'decimal:2',
        'actual_start_date' => 'date',
        'submitted_at' => 'datetime',
    ];

    public function employment(): BelongsTo
    {
        return $this->belongsTo(UserEmployment::class, 'user_employment_id');
    }
}