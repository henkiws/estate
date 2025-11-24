<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgencyBilling extends Model
{
    use HasFactory;

    protected $table = 'agency_billing';

    protected $fillable = [
        'agency_id',
        'billing_contact_name',
        'billing_email',
        'billing_phone',
        'billing_address',
        'payment_method',
    ];

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }
}