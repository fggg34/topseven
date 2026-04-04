<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Hotel extends Model
{
    use HasFactory, HasSlug;

    public const CLASSIFICATION_HOTEL = 'hotel';

    public const CLASSIFICATION_RESORT = 'resort';

    protected $fillable = [
        'country_id',
        'name',
        'slug',
        'classification',
        'description',
        'featured_image',
        'gallery',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'gallery' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function tours(): BelongsToMany
    {
        return $this->belongsToMany(Tour::class, 'hotel_tour', 'hotel_id', 'tour_id');
    }

    public function getFeaturedImageUrlAttribute(): ?string
    {
        if (empty($this->featured_image)) {
            return null;
        }

        return '/storage/'.ltrim($this->featured_image, '/');
    }

    /**
     * @return array<string>|null
     */
    public function getGalleryUrlsAttribute(): ?array
    {
        if (empty($this->gallery) || ! is_array($this->gallery)) {
            return null;
        }

        return array_map(fn (string $path) => '/storage/'.ltrim($path, '/'), $this->gallery);
    }
}
