<?php

// database/migrations/2024_01_02_000001_create_subscription_tables.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Update agencies table - add subscription fields
        Schema::table('agencies', function (Blueprint $table) {
            // Change status enum to include 'approved' and 'rejected'
            $table->enum('status', ['pending', 'approved', 'active', 'rejected', 'suspended', 'inactive'])
                ->default('pending')
                ->change();
            
            // Add rejection reason
            $table->text('rejection_reason')->nullable()->after('verified_by');
            $table->timestamp('rejected_at')->nullable()->after('rejection_reason');
            
            // Add approval tracking
            $table->timestamp('approved_at')->nullable()->after('verified_at');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null')->after('approved_at');
        });

        // 2. Subscription Plans table
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Basic, Pro, Enterprise
            $table->string('slug')->unique(); // basic, pro, enterprise
            $table->text('description')->nullable();
            
            // Pricing
            $table->decimal('price', 10, 2); // Monthly price
            $table->string('currency', 3)->default('AUD');
            $table->enum('billing_period', ['monthly', 'yearly'])->default('monthly');
            
            // Stripe
            $table->string('stripe_price_id')->nullable();
            $table->string('stripe_product_id')->nullable();
            
            // Features (JSON)
            $table->json('features')->nullable();
            
            // Limits
            $table->integer('max_agents')->default(5);
            $table->integer('max_properties')->default(50);
            $table->boolean('document_storage')->default(true);
            $table->boolean('email_support')->default(true);
            $table->boolean('priority_support')->default(false);
            $table->boolean('api_access')->default(false);
            $table->boolean('custom_branding')->default(false);
            
            // Status
            $table->boolean('is_active')->default(true);
            $table->boolean('is_popular')->default(false);
            $table->integer('sort_order')->default(0);
            
            $table->timestamps();
        });

        // 3. Subscriptions table
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agency_id')->constrained()->onDelete('cascade');
            $table->foreignId('subscription_plan_id')->constrained()->onDelete('restrict');
            
            // Stripe
            $table->string('stripe_subscription_id')->unique()->nullable();
            $table->string('stripe_customer_id')->nullable();
            
            // Status
            $table->enum('status', ['active', 'cancelled', 'expired', 'past_due', 'trialing'])->default('active');
            
            // Dates
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamp('current_period_start')->nullable();
            $table->timestamp('current_period_end')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            
            $table->timestamps();
            
            $table->index('stripe_subscription_id');
            $table->index('agency_id');
        });

        // 4. Transactions table (for logging)
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agency_id')->constrained()->onDelete('cascade');
            $table->foreignId('subscription_id')->nullable()->constrained()->onDelete('set null');
            
            // Transaction details
            $table->string('transaction_id')->unique(); // Stripe payment intent ID
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('AUD');
            
            // Type & Status
            $table->enum('type', ['subscription', 'addon', 'refund', 'adjustment']);
            $table->enum('status', ['pending', 'completed', 'failed', 'refunded'])->default('pending');
            
            // Payment method
            $table->string('payment_method')->nullable(); // card, bank_transfer, etc.
            $table->string('payment_method_last4')->nullable();
            
            // Stripe details
            $table->string('stripe_charge_id')->nullable();
            $table->string('stripe_invoice_id')->nullable();
            $table->json('stripe_response')->nullable();
            
            // Description
            $table->text('description')->nullable();
            $table->text('failure_reason')->nullable();
            
            // Metadata
            $table->json('metadata')->nullable();
            
            $table->timestamps();
            
            $table->index('agency_id');
            $table->index('transaction_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('subscriptions');
        Schema::dropIfExists('subscription_plans');
        
        Schema::table('agencies', function (Blueprint $table) {
            $table->dropColumn([
                'rejection_reason',
                'rejected_at',
                'approved_at',
                'approved_by'
            ]);
        });
    }
};