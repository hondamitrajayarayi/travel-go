<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('meta_title')->nullable()->after('content')
                ->comment('SEO: Judul tab browser & Google. Kosong = pakai judul artikel.');
            $table->text('meta_description')->nullable()->after('meta_title')
                ->comment('SEO: Meta description 120-160 karakter. Kosong = auto dari excerpt.');
            $table->string('meta_keywords')->nullable()->after('meta_description')
                ->comment('SEO: Kata kunci dipisahkan koma.');
            $table->string('og_image')->nullable()->after('meta_keywords')
                ->comment('SEO: URL gambar Open Graph (1200x630) untuk share WA/FB/Twitter.');
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn(['meta_title', 'meta_description', 'meta_keywords', 'og_image']);
        });
    }
};
