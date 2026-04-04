<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cities', function (Blueprint $table) {
            $table->string('iso_alpha2', 2)->nullable()->after('name');
            $table->string('calling_code', 8)->nullable()->after('iso_alpha2');
        });

        Schema::table('cities', function (Blueprint $table) {
            $table->unique('iso_alpha2');
        });
    }

    public function down(): void
    {
        Schema::table('cities', function (Blueprint $table) {
            $table->dropUnique(['iso_alpha2']);
            $table->dropColumn(['iso_alpha2', 'calling_code']);
        });
    }
};
