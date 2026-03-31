<?php

namespace Tests\Unit;

use App\Models\HomepageHero;
use PHPUnit\Framework\TestCase;

class HomepageHeroNormalizePathTest extends TestCase
{
    public function test_normalizes_filament_style_associative_array_to_path(): void
    {
        $path = HomepageHero::normalizeStoragePath([
            '550e8400-e29b-41d4-a716-446655440000' => 'heroes/01ABCDEFGHJKMNPQRSTVWXYZ.jpg',
        ]);

        $this->assertSame('heroes/01ABCDEFGHJKMNPQRSTVWXYZ.jpg', $path);
    }

    public function test_legacy_numeric_zero_index_array_still_works(): void
    {
        $path = HomepageHero::normalizeStoragePath(['heroes/foo.jpg']);

        $this->assertSame('heroes/foo.jpg', $path);
    }
}
