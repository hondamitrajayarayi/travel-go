<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            if (!Schema::hasColumn('galleries', 'images')) {
                $table->json('images')->nullable()->after('image_path');
            }
            if (!Schema::hasColumn('galleries', 'country_id')) {
                $table->foreignId('country_id')->nullable()->after('id')->constrained('countries')->nullOnDelete();
            }
            if (Schema::hasColumn('galleries', 'image_path')) {
                $table->string('image_path')->nullable()->change();
            }
            
            // Drop unused fields according to specification
            $columnsToDrop = [];
            foreach (['customer_name', 'trip_date', 'rating', 'customer_review', 'sort_order'] as $col) {
                if (Schema::hasColumn('galleries', $col)) {
                    $columnsToDrop[] = $col;
                }
            }
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }

    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            if (Schema::hasColumn('galleries', 'country_id')) {
                $table->dropForeign(['country_id']);
                $table->dropColumn('country_id');
            }
            if (Schema::hasColumn('galleries', 'images')) {
                $table->dropColumn('images');
            }
            $table->string('customer_name')->nullable();
            $table->string('trip_date')->nullable();
            $table->unsignedTinyInteger('rating')->default(5);
            $table->text('customer_review')->nullable();
            $table->integer('sort_order')->default(0);
        });
    }
};
