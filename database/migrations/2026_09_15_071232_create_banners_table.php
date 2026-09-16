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
        if (!Schema::hasTable('banners')) {
            Schema::create('banners', function (Blueprint $table) {
                $table->id();
                $table->string('title')->nullable();
                $table->text('subtitle')->nullable();
                $table->enum('placement', ['all', 'desktop', 'mobile'])->default('all');
                $table->enum('type', ['image', 'video'])->default('image');
                $table->string('file_path')->nullable();
                $table->string('image_path')->nullable();
                $table->string('video_path')->nullable();
                $table->string('link_url')->nullable();
                $table->string('button_text')->nullable();
                $table->boolean('is_active')->default(true);
                $table->integer('sort_order')->default(0);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
