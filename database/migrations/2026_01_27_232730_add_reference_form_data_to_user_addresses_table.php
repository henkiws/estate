<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_addresses', function (Blueprint $table) {
            // Reference form answers
            $table->string('ref_is_leaseholder')->nullable()->after('reference_email_sent_at'); // yes, no, n/a
            $table->text('ref_is_leaseholder_comment')->nullable();
            
            $table->string('ref_would_rent_again')->nullable(); // yes, no, n/a
            $table->text('ref_would_rent_again_comment')->nullable();
            
            $table->string('ref_lived_at_address')->nullable(); // yes, no, n/a
            $table->text('ref_lived_at_address_comment')->nullable();
            
            $table->string('ref_rent_paid_on_time')->nullable(); // yes, no, n/a
            $table->text('ref_rent_paid_on_time_comment')->nullable();
            
            $table->string('ref_last_inspection_month')->nullable();
            $table->string('ref_last_inspection_year')->nullable();
            $table->text('ref_last_inspection_comment')->nullable();
            
            $table->decimal('ref_rent_per_week', 10, 2)->nullable();
            $table->text('ref_rent_per_week_comment')->nullable();
            
            $table->string('ref_full_bond_refund')->nullable(); // yes, no, n/a
            $table->text('ref_full_bond_refund_comment')->nullable();

            $table->string('ref_breach_free')->nullable()->after('ref_full_bond_refund_comment'); // yes, no, n/a
            $table->text('ref_breach_free_comment')->nullable();
            
            $table->string('ref_property_clean')->nullable(); // yes, no, n/a
            $table->text('ref_property_clean_comment')->nullable();
            
            $table->string('ref_had_pet')->nullable(); // yes, no, n/a
            $table->text('ref_had_pet_comment')->nullable();
            
            $table->string('ref_pet_policy_complied')->nullable(); // yes, no, n/a
            $table->text('ref_pet_policy_complied_comment')->nullable();
            
            $table->integer('ref_cooperative_rating')->nullable(); // 1-5
            $table->text('ref_cooperative_rating_comment')->nullable();
            
            $table->integer('ref_property_condition_rating')->nullable(); // 1-5
            $table->text('ref_property_condition_rating_comment')->nullable();
            
            $table->integer('ref_overall_rating')->nullable(); // 1-5
            $table->text('ref_overall_rating_comment')->nullable();
            
            // Ledger upload
            $table->string('ref_tenant_ledger_path')->nullable();
            
            // Status tracking
            $table->boolean('ref_is_draft')->default(false);
            $table->timestamp('ref_saved_as_draft_at')->nullable();
            $table->timestamp('ref_submitted_at')->nullable();
            
            // Signature
            $table->string('ref_signature_name')->nullable();
            $table->date('ref_signature_date')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('user_addresses', function (Blueprint $table) {
            $table->dropColumn([
                'ref_is_leaseholder',
                'ref_is_leaseholder_comment',
                'ref_would_rent_again',
                'ref_would_rent_again_comment',
                'ref_lived_at_address',
                'ref_lived_at_address_comment',
                'ref_rent_paid_on_time',
                'ref_rent_paid_on_time_comment',
                'ref_last_inspection_month',
                'ref_last_inspection_year',
                'ref_last_inspection_comment',
                'ref_rent_per_week',
                'ref_rent_per_week_comment',
                'ref_full_bond_refund',
                'ref_full_bond_refund_comment',
                'ref_breach_free',
                'ref_breach_free_comment',
                'ref_property_clean',
                'ref_property_clean_comment',
                'ref_had_pet',
                'ref_had_pet_comment',
                'ref_pet_policy_complied',
                'ref_pet_policy_complied_comment',
                'ref_cooperative_rating',
                'ref_cooperative_rating_comment',
                'ref_property_condition_rating',
                'ref_property_condition_rating_comment',
                'ref_overall_rating',
                'ref_overall_rating_comment',
                'ref_tenant_ledger_path',
                'ref_is_draft',
                'ref_saved_as_draft_at',
                'ref_submitted_at',
                'ref_signature_name',
                'ref_signature_date',
            ]);
        });
    }
};