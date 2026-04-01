<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class HomepageSeasonalBanner extends Model
{
    protected $fillable = [
        'background_image',
        'title',
        'button_text',
        'button_url',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function setBackgroundImageAttribute(mixed $value): void
    {
        $this->attributes['background_image'] = static::normalizeStoragePath($value);
    }

    public static function normalizeStoragePath(mixed $value): ?string
    {
        if ($value === null || $value === '' || $value === false) {
            return null;
        }

        while (is_array($value)) {
            if ($value === []) {
                return null;
            }
            $value = Arr::first($value);
        }

        if (! is_string($value)) {
            return null;
        }

        $value = trim($value);
        if ($value === '') {
            return null;
        }

        if (str_starts_with($value, '[') || str_starts_with($value, '{')) {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                $first = $decoded[0] ?? null;
                $value = is_string($first) ? $first : '';
            }
        }

        $value = ltrim($value, '/');
        if (str_starts_with($value, 'storage/')) {
            $value = substr($value, strlen('storage/'));
        }

        return $value !== '' ? $value : null;
    }

    public function getBackgroundImageUrlAttribute(): ?string
    {
        $path = static::normalizeStoragePath($this->background_image);
        if ($path === null) {
            return null;
        }

        return Storage::disk('public')->url($path);
    }
}
