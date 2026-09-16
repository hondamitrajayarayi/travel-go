<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->foreignId('country_id')->nullable()->after('id')->constrained('countries')->nullOnDelete();
            $table->decimal('promo_price', 12, 2)->nullable()->after('price');
            $table->string('departure_date')->nullable()->after('duration');
            $table->string('status')->default('tersedia')->after('departure_date');
            $table->string('file_itinerary')->nullable()->after('thumbnail');
        });
    }

    public function down(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->dropForeign(['country_id']);
            $table->dropColumn([
                'country_id',
                'promo_price',
                'departure_date',
                'status',
                'file_itinerary',
            ]);
        });
    }
};
