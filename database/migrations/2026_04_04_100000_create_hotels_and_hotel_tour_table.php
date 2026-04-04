<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->nullable()->constrained('cities')->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('classification', 32)->default('hotel');
            $table->longText('description')->nullable();
            $table->string('featured_image')->nullable();
            $table->json('gallery')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('hotel_tour', function (Blueprint $table) {
            $table->foreignId('hotel_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tour_id')->constrained()->cascadeOnDelete();
            $table->primary(['hotel_id', 'tour_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hotel_tour');
        Schema::dropIfExists('hotels');
    }
};
