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
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content')->nullable();
            
            // Media
            $table->string('image_url')->nullable();
            $table->string('thumbnail_url')->nullable();
            
            // Categorization
            $table->enum('category', [
                'good_to_know',
                'tips',
                'news',
                'guides',
                'updates'
            ])->default('good_to_know');
            
            $table->json('tags')->nullable();
            
            // Publishing
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->foreignId('author_id')->nullable()->constrained('users')->onDelete('set null');
            
            // Engagement
            $table->integer('views_count')->default(0);
            $table->integer('likes_count')->default(0);
            
            // SEO
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index('slug');
            $table->index('category');
            $table->index('is_published');
            $table->index('published_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
    }
};