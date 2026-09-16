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
        if (Schema::hasTable('banners')) {
            Schema::table('banners', function (Blueprint $table) {
                if (!Schema::hasColumn('banners', 'placement')) {
                    $table->enum('placement', ['all', 'desktop', 'mobile'])->default('all')->after('subtitle');
                }
                if (!Schema::hasColumn('banners', 'image_path')) {
                    $table->string('image_path')->nullable()->after('file_path');
                }
                if (!Schema::hasColumn('banners', 'video_path')) {
                    $table->string('video_path')->nullable()->after('image_path');
                }
                if (Schema::hasColumn('banners', 'file_path')) {
                    $table->string('file_path')->nullable()->change();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('banners')) {
            Schema::table('banners', function (Blueprint $table) {
                if (Schema::hasColumn('banners', 'video_path')) {
                    $table->dropColumn('video_path');
                }
                if (Schema::hasColumn('banners', 'image_path')) {
                    $table->dropColumn('image_path');
                }
            });
        }
    }
};
