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
        Schema::table('tours', function (Blueprint $table) {
            $table->string('meta_title')->nullable()->after('description')
                ->comment('SEO: Judul tab browser & Google. Kosong = pakai judul tour.');
            $table->text('meta_description')->nullable()->after('meta_title')
                ->comment('SEO: Meta description, 120-160 karakter. Kosong = auto dari deskripsi tour.');
            $table->string('meta_keywords')->nullable()->after('meta_description')
                ->comment('SEO: Kata kunci dipisahkan koma.');
            $table->string('og_image')->nullable()->after('meta_keywords')
                ->comment('SEO: URL gambar Open Graph (1200x630) untuk share WA/FB.');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->dropColumn(['meta_title', 'meta_description', 'meta_keywords', 'og_image']);
        });
    }
};
