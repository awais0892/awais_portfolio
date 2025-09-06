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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->string('rateable_type'); // 'App\Models\Blog', 'App\Models\Project', etc.
            $table->unsignedBigInteger('rateable_id'); // ID of the blog post, project, etc.
            $table->string('name');
            $table->string('email');
            $table->integer('rating'); // 1-5 stars
            $table->text('review')->nullable(); // Optional review text
            $table->boolean('is_approved')->default(false);
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();

            // Indexes
            $table->index(['rateable_type', 'rateable_id']);
            $table->index('rating');
            $table->index('is_approved');
            $table->index('email');
            
            // Prevent duplicate ratings from same email
            $table->unique(['rateable_type', 'rateable_id', 'email'], 'unique_rating_per_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
