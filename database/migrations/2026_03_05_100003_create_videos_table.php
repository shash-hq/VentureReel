<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->string('title');
            $table->string('slug')->unique()->default('');
            $table->text('description');
            $table->string('youtube_url');
            $table->string('youtube_video_id')->nullable(); // extracted from URL
            $table->string('thumbnail_path')->nullable();
            $table->string('entrepreneur_name');
            $table->string('business_name');
            $table->string('tags')->nullable(); // comma-separated
            $table->unsignedInteger('views_count')->default(0);
            $table->boolean('is_approved')->default(false);
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();

            $table->index('is_approved');
            $table->index('views_count');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
