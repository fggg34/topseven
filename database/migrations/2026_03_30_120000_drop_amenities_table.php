<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('amenities');
    }

    public function down(): void
    {
        // Intentionally not restoring amenities (feature removed).
    }
};
