<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agency_id')->constrained()->onDelete('cascade');
            $table->foreignId('listing_agent_id')->nullable()->constrained('agents')->onDelete('set null');
            $table->foreignId('property_manager_id')->nullable()->constrained('agents')->onDelete('set null');
            
            // Property Code
            $table->string('property_code', 20)->unique();
            
            // Property Type & Category
            $table->enum('property_type', [
                'house',
                'apartment',
                'unit',
                'townhouse',
                'villa',
                'land',
                'studio',
                'duplex',
                'farm',
                'acreage',
                'retirement',
                'block_of_units',
                'commercial',
                'industrial'
            ]);
            $table->enum('listing_type', ['sale', 'rent', 'lease', 'sold', 'leased'])->default('sale');
            $table->enum('status', [
                'draft',
                'active',
                'under_contract',
                'sold',
                'leased',
                'withdrawn',
                'off_market',
                'expired'
            ])->default('draft');

            $table->enum('storage', [
                'Yes',
                'No'
            ])->default('No');
            $table->enum('condition', [
                'Furnished',
                'Unfurnished'
            ])->default('Unfurnished');
            
            // Address
            $table->string('street_number', 20)->nullable();
            $table->string('street_name');
            $table->string('street_type', 50)->nullable(); // Street, Road, Avenue, etc.
            $table->string('unit_number', 20)->nullable();
            $table->string('suburb');
            $table->string('state', 10);
            $table->string('postcode', 10);
            $table->string('country', 50)->default('Australia');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            
            // Property Details
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->integer('parking_spaces')->nullable();
            $table->integer('garages')->nullable();
            $table->decimal('land_area', 10, 2)->nullable()->comment('Square meters');
            $table->string('land_area_unit', 10)->default('sqm');
            $table->decimal('floor_area', 10, 2)->nullable()->comment('Square meters');
            $table->string('floor_area_unit', 10)->default('sqm');
            $table->integer('year_built')->nullable();
            
            // Pricing
            $table->decimal('price', 15, 2)->nullable();
            $table->decimal('price_min', 15, 2)->nullable(); // For price ranges
            $table->decimal('price_max', 15, 2)->nullable();
            $table->boolean('price_display')->default(true); // Show/hide price
            $table->string('price_text')->nullable(); // "POA", "Offers Over", etc.
            
            // Rental specific
            $table->decimal('rent_per_week', 10, 2)->nullable();
            $table->decimal('rent_per_month', 10, 2)->nullable();
            $table->decimal('bond_amount', 10, 2)->nullable();
            $table->date('available_from')->nullable();
            $table->integer('lease_term_months')->nullable();
            
            // Description & Features
            $table->string('headline', 255)->nullable();
            $table->text('description')->nullable();
            $table->json('features')->nullable(); // ['Air Conditioning', 'Pool', etc.]
            $table->json('indoor_features')->nullable();
            $table->json('outdoor_features')->nullable();
            
            // Marketing
            $table->string('video_url')->nullable();
            $table->string('virtual_tour_url')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->integer('view_count')->default(0);
            $table->integer('enquiry_count')->default(0);
            $table->integer('inspection_count')->default(0);
            
            // Auction / Sale Details
            $table->dateTime('auction_date')->nullable();
            $table->string('auction_venue')->nullable();
            $table->date('sale_date')->nullable();
            $table->decimal('sale_price', 15, 2)->nullable();
            
            // Open Home Inspections
            $table->json('inspection_times')->nullable(); // [{date, start, end}]
            
            // Listing Dates
            $table->date('listed_at')->nullable();
            $table->date('unlisted_at')->nullable();
            $table->date('sold_at')->nullable();
            $table->date('leased_at')->nullable();
            
            // Additional Info
            $table->string('council_rates')->nullable();
            $table->string('strata_fees')->nullable();
            $table->string('water_rates')->nullable();
            $table->string('zoning')->nullable();

            $table->integer('land_size')->default(0)->nullable();
            $table->string('land_size_unit')->nullable();
            $table->integer('building_size')->default(0)->nullable();
            $table->string('building_size_unit')->nullable();
            $table->text('full_address')->nullable();
            
            // SEO & Publishing
            $table->string('slug')->unique();
            $table->boolean('is_published')->default(false);
            $table->dateTime('published_at')->nullable();
            
            // Metadata
            $table->json('metadata')->nullable();
            
            $table->softDeletes();
            $table->timestamps();
            
            // Indexes
            $table->index(['agency_id', 'status']);
            $table->index(['listing_agent_id']);
            $table->index(['property_type', 'listing_type']);
            $table->index(['suburb', 'state']);
            $table->index(['price']);
            $table->index('is_published');
            $table->index('listed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};