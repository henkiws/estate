<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// ============================================
// 1. SubscriptionPlan Model
// ============================================
class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'currency',
        'billing_period',
        'stripe_price_id',
        'stripe_product_id',
        'features',
        'max_agents',
        'max_properties',
        'document_storage',
        'email_support',
        'priority_support',
        'api_access',
        'custom_branding',
        'is_active',
        'is_popular',
        'sort_order',
    ];

    protected $casts = [
        'features' => 'array',
        'price' => 'decimal:2',
        'document_storage' => 'boolean',
        'email_support' => 'boolean',
        'priority_support' => 'boolean',
        'api_access' => 'boolean',
        'custom_branding' => 'boolean',
        'is_active' => 'boolean',
        'is_popular' => 'boolean',
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePopular($query)
    {
        return $query->where('is_popular', true);
    }

    public function getFormattedPriceAttribute(): string
    {
        return '$' . number_format($this->price, 2);
    }

    public function getPricePerYearAttribute(): float
    {
        return $this->billing_period === 'yearly' ? $this->price : $this->price * 12;
    }
}
