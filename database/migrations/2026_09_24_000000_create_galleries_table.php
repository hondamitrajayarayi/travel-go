<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category')->default('Asia'); // Asia, Eropa, Timur Tengah, Private Trip, dll
            $table->string('image_path');
            $table->string('destination')->nullable(); // e.g. Tokyo, Jepang
            $table->string('trip_date')->nullable(); // e.g. Oktober 2026
            $table->string('customer_name')->nullable(); // e.g. Rombongan Bpk. Hendrawan
            $table->text('customer_review')->nullable(); // Testimoni / cerita singkat
            $table->unsignedTinyInteger('rating')->default(5);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};
