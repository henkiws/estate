<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgencyDocumentRequirement extends Model
{
    use HasFactory;

    protected $fillable = [
        'agency_id',
        'name',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'status',
        'license_certificate_uploaded',
        'proof_of_identity_uploaded',
        'abn_certificate_uploaded',
        'insurance_professional_indemnity_uploaded',
        'insurance_public_liability_uploaded',
        'completion_percentage',
        'completed_at',
    ];

    protected $casts = [
        'license_certificate_uploaded' => 'boolean',
        'proof_of_identity_uploaded' => 'boolean',
        'abn_certificate_uploaded' => 'boolean',
        'insurance_professional_indemnity_uploaded' => 'boolean',
        'insurance_public_liability_uploaded' => 'boolean',
        'completed_at' => 'datetime',
    ];

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    public function calculateCompletion(): int
    {
        $total = 5; // Total required documents
        $completed = 0;

        if ($this->license_certificate_uploaded) $completed++;
        if ($this->proof_of_identity_uploaded) $completed++;
        if ($this->abn_certificate_uploaded) $completed++;
        if ($this->insurance_professional_indemnity_uploaded) $completed++;
        if ($this->insurance_public_liability_uploaded) $completed++;

        return (int) (($completed / $total) * 100);
    }

    public function updateCompletion(): void
    {
        $percentage = $this->calculateCompletion();
        
        $this->update([
            'completion_percentage' => $percentage,
            'completed_at' => $percentage === 100 ? now() : null,
        ]);
    }

    public function isCompleted(): bool
    {
        return $this->completion_percentage === 100;
    }

    public function getRequiredDocuments(): array
    {
        return [
            'license_certificate' => [
                'name' => 'Real Estate License Certificate',
                'uploaded' => $this->license_certificate_uploaded,
                'required' => true,
            ],
            'proof_of_identity' => [
                'name' => 'Proof of Identity (Passport or Driver License)',
                'uploaded' => $this->proof_of_identity_uploaded,
                'required' => true,
            ],
            'abn_certificate' => [
                'name' => 'ABN Registration Certificate',
                'uploaded' => $this->abn_certificate_uploaded,
                'required' => true,
            ],
            'insurance_professional_indemnity' => [
                'name' => 'Professional Indemnity Insurance',
                'uploaded' => $this->insurance_professional_indemnity_uploaded,
                'required' => true,
            ],
            'insurance_public_liability' => [
                'name' => 'Public Liability Insurance',
                'uploaded' => $this->insurance_public_liability_uploaded,
                'required' => true,
            ],
        ];
    }
}