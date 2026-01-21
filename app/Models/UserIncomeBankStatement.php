<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserIncomeBankStatement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_income_id',
        'file_path',
        'original_filename',
        'file_size',
        'mime_type',
    ];

    /**
     * Get the income that owns the bank statement
     */
    public function income()
    {
        return $this->belongsTo(UserIncome::class, 'user_income_id');
    }
}