<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        if (Schema::hasColumn('tour_itineraries', 'hotel_id')) {
            try {
                Schema::table('tour_itineraries', function (Blueprint $table) {
                    $table->dropForeign(['hotel_id']);
                });
            } catch (\Throwable) {
                // SQLite / legacy installs without named FK
            }
            Schema::table('tour_itineraries', function (Blueprint $table) {
                if (Schema::hasColumn('tour_itineraries', 'hotel_id')) {
                    $table->dropColumn('hotel_id');
                }
            });
        }

        Schema::dropIfExists('amenity_hotel');
        Schema::dropIfExists('hotels');

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        // Intentionally not restoring hotels (removed feature).
    }
};
