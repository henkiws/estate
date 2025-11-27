<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'max_agents' => 'integer',
        'max_properties' => 'integer',
        'sort_order' => 'integer',
    ];

    /**
     * Get subscriptions for this plan
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Scope: Only active plans
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: Only popular plans
     */
    public function scopePopular($query)
    {
        return $query->where('is_popular', true);
    }

    /**
     * Scope: Order by sort order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('price');
    }

    /**
     * Get formatted price with currency symbol
     */
    public function getFormattedPriceAttribute(): string
    {
        $symbol = $this->getCurrencySymbol();
        return $symbol . number_format($this->price, 2);
    }

    /**
     * Get price per year (monthly * 12)
     */
    public function getPricePerYearAttribute(): float
    {
        return $this->billing_period === 'yearly' ? $this->price : $this->price * 12;
    }

    /**
     * Get formatted yearly price
     */
    public function getFormattedYearlyPriceAttribute(): string
    {
        $symbol = $this->getCurrencySymbol();
        return $symbol . number_format($this->price_per_year, 2);
    }

    /**
     * Get yearly price with 20% discount
     */
    public function getYearlyDiscountedPriceAttribute(): float
    {
        return $this->price * 12 * 0.8; // 20% discount
    }

    /**
     * Get formatted yearly discounted price
     */
    public function getFormattedYearlyDiscountedPriceAttribute(): string
    {
        $symbol = $this->getCurrencySymbol();
        return $symbol . number_format($this->yearly_discounted_price, 2);
    }

    /**
     * Get yearly savings amount
     */
    public function getYearlySavingsAttribute(): float
    {
        return $this->price * 12 * 0.2; // 20% savings
    }

    /**
     * Get formatted yearly savings
     */
    public function getFormattedYearlySavingsAttribute(): string
    {
        $symbol = $this->getCurrencySymbol();
        return $symbol . number_format($this->yearly_savings, 2);
    }

    /**
     * Get currency symbol
     */
    public function getCurrencySymbol(): string
    {
        $symbols = [
            'AUD' => '$',
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
        ];

        return $symbols[$this->currency] ?? $this->currency . ' ';
    }

    /**
     * Check if plan has unlimited agents
     */
    public function hasUnlimitedAgents(): bool
    {
        return $this->max_agents >= 999;
    }

    /**
     * Check if plan has unlimited properties
     */
    public function hasUnlimitedProperties(): bool
    {
        return $this->max_properties >= 9999;
    }

    /**
     * Get agents display text
     */
    public function getAgentsDisplayAttribute(): string
    {
        return $this->hasUnlimitedAgents() ? 'Unlimited' : $this->max_agents;
    }

    /**
     * Get properties display text
     */
    public function getPropertiesDisplayAttribute(): string
    {
        return $this->hasUnlimitedProperties() ? 'Unlimited' : $this->max_properties;
    }

    /**
     * Check if agency can use this plan (check limits)
     */
    public function canAccommodateAgency($agentCount, $propertyCount): bool
    {
        $agentsOk = $this->hasUnlimitedAgents() || $agentCount <= $this->max_agents;
        $propertiesOk = $this->hasUnlimitedProperties() || $propertyCount <= $this->max_properties;

        return $agentsOk && $propertiesOk;
    }
}