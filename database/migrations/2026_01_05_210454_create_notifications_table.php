<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('message');
            $table->string('type')->default('system'); // 'broadcast', 'system'
            $table->string('category')->nullable(); // 'payment', 'approval', 'document', 'support', 'subscription', 'general'
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            
            // Sender (null for system notifications)
            $table->foreignId('sender_id')->nullable()->constrained('users')->nullOnDelete();
            
            // Recipient
            $table->foreignId('recipient_id')->constrained('users')->cascadeOnDelete();
            
            // Optional action link
            $table->string('action_url')->nullable();
            $table->string('action_text')->nullable(); // e.g., "View Details", "Go to Payment"
            
            // Icon/styling
            $table->string('icon')->nullable(); // icon class or name
            
            // Metadata for additional info
            $table->json('metadata')->nullable();
            
            // Tracking
            $table->timestamp('read_at')->nullable();
            $table->timestamp('sent_at')->nullable(); // For scheduled notifications
            $table->timestamp('scheduled_for')->nullable(); // Schedule for future
            
            // Soft delete for admin to "delete" sent notifications
            $table->softDeletes();
            $table->timestamps();
            
            // Indexes
            $table->index('recipient_id');
            $table->index('type');
            $table->index('priority');
            $table->index('read_at');
            $table->index('scheduled_for');
            $table->index(['recipient_id', 'read_at']); // For unread count queries
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};