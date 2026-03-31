<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->date('homepage_card_date_from')->nullable()->after('default_daily_capacity');
            $table->date('homepage_card_date_to')->nullable()->after('homepage_card_date_from');
        });

        if (Schema::hasColumn('homepage_spotlight_tours', 'date_from')) {
            $rows = DB::table('homepage_spotlight_tours')
                ->whereNotNull('date_from')
                ->get(['tour_id', 'date_from', 'date_to']);

            foreach ($rows as $row) {
                DB::table('tours')->where('id', $row->tour_id)->update([
                    'homepage_card_date_from' => $row->date_from,
                    'homepage_card_date_to' => $row->date_to,
                ]);
            }
        }

        Schema::table('homepage_spotlight_tours', function (Blueprint $table) {
            if (Schema::hasColumn('homepage_spotlight_tours', 'date_from')) {
                $table->dropColumn(['date_from', 'date_to']);
            }
        });
    }

    public function down(): void
    {
        Schema::table('homepage_spotlight_tours', function (Blueprint $table) {
            $table->date('date_from')->nullable()->after('sort_order');
            $table->date('date_to')->nullable()->after('date_from');
        });

        $tours = DB::table('tours')
            ->whereNotNull('homepage_card_date_from')
            ->get(['id', 'homepage_card_date_from', 'homepage_card_date_to']);

        foreach ($tours as $tour) {
            DB::table('homepage_spotlight_tours')
                ->where('tour_id', $tour->id)
                ->update([
                    'date_from' => $tour->homepage_card_date_from,
                    'date_to' => $tour->homepage_card_date_to,
                ]);
        }

        Schema::table('tours', function (Blueprint $table) {
            $table->dropColumn(['homepage_card_date_from', 'homepage_card_date_to']);
        });
    }
};
