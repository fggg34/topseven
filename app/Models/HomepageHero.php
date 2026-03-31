<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class HomepageHero extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'banner_type',
        'banner_image',
        'banner_video',
        'cta_text',
        'cta_url',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function setBannerImageAttribute(mixed $value): void
    {
        $this->attributes['banner_image'] = static::normalizeStoragePath($value);
    }

    public function setBannerVideoAttribute(mixed $value): void
    {
        $this->attributes['banner_video'] = static::normalizeStoragePath($value);
    }

    /**
     * Filament FileUpload may persist a string path, a JSON string, or (legacy) an array.
     */
    public static function normalizeStoragePath(mixed $value): ?string
    {
        if ($value === null || $value === '' || $value === false) {
            return null;
        }
        // Filament single FileUpload keeps state as e.g. ['<uuid>' => 'heroes/file.jpg'] — not index 0.
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

    public function getBannerImageUrlAttribute(): ?string
    {
        $path = static::normalizeStoragePath($this->banner_image);
        if ($path === null) {
            return null;
        }

        return Storage::disk('public')->url($path);
    }

    public function getBannerVideoUrlAttribute(): ?string
    {
        $path = static::normalizeStoragePath($this->banner_video);
        if ($path === null) {
            return null;
        }

        return Storage::disk('public')->url($path);
    }

    public static function getActive(): ?self
    {
        return static::where('is_active', true)->first();
    }
}
