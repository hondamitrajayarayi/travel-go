<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category')->default('Tips Tour');
            $table->string('thumbnail')->nullable();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->string('author')->default('Tim TravelGo');
            $table->string('reading_time')->default('5 menit baca');
            $table->dateTime('published_at')->nullable();
            $table->boolean('is_published')->default(true);
            $table->unsignedInteger('views_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
