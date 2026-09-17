<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            if (!Schema::hasColumn('testimonials', 'name')) {
                $table->string('name')->default('Traveler');
            }
            if (!Schema::hasColumn('testimonials', 'tour_title')) {
                $table->string('tour_title')->default('Paket Tour');
            }
            if (!Schema::hasColumn('testimonials', 'trip_date')) {
                $table->string('trip_date')->nullable();
            }
            if (!Schema::hasColumn('testimonials', 'story')) {
                $table->text('story')->nullable();
            }
            if (!Schema::hasColumn('testimonials', 'rating')) {
                $table->unsignedTinyInteger('rating')->default(5);
            }
            if (!Schema::hasColumn('testimonials', 'avatar')) {
                $table->string('avatar')->nullable();
            }
            if (!Schema::hasColumn('testimonials', 'photo')) {
                $table->string('photo')->nullable();
            }
            if (!Schema::hasColumn('testimonials', 'sort_order')) {
                $table->integer('sort_order')->default(0);
            }

            // Make legacy columns nullable if they exist
            if (Schema::hasColumn('testimonials', 'title')) {
                $table->string('title')->nullable()->change();
            }
            if (Schema::hasColumn('testimonials', 'platform')) {
                $table->string('platform')->nullable()->change();
            }
            if (Schema::hasColumn('testimonials', 'embed_url')) {
                $table->string('embed_url')->nullable()->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            //
        });
    }
};
