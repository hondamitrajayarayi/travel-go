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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('subtitle')->nullable();
            $table->enum('placement', ['all', 'desktop', 'mobile'])->default('all'); // Opsi: all (dua-duanya), desktop (web saja), mobile (hp saja)
            $table->enum('type', ['image', 'video'])->default('image');
            $table->string('file_path')->nullable(); // fallback legacy
            $table->string('image_path')->nullable(); // Foto untuk Desktop Web
            $table->string('video_path')->nullable(); // Video untuk Mobile HP
            $table->string('link_url')->nullable();
            $table->string('button_text')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
