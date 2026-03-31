<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;

/**
 * Local/dev convenience: after migrate, you can log in without running db:seed.
 * Seeding still adds tours, blog, settings, etc.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (User::query()->exists()) {
            return;
        }

        User::create([
            'name' => 'Admin',
            'email' => 'admin@top7travel.com',
            'password' => 'password',
            'role' => 'admin',
            'is_active' => true,
        ]);
    }

    public function down(): void
    {
        // Intentionally empty: do not remove users on rollback.
    }
};
