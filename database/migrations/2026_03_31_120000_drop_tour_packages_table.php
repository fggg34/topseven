<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('tour_packages');
    }

    public function down(): void
    {
        // Intentionally empty: tour packages feature was removed.
    }
};
