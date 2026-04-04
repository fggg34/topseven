<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Country extends Model
{
    use HasFactory, HasSlug;

    protected $table = 'cities';

    protected $fillable = [
        'name',
        'slug',
        'iso_alpha2',
        'calling_code',
        'is_active',
        'country',
        'description',
        'city_highlights',
        'city_image',
        'gallery',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'city_highlights' => 'array',
            'gallery' => 'array',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Destinations that have at least one active tour (for public listings & search).
     *
     * @param  \Illuminate\Database\Eloquent\Builder<static>  $query
     * @return \Illuminate\Database\Eloquent\Builder<static>
     */
    public function scopeWithActiveTours($query)
    {
        return $query->whereHas('tours', fn ($q) => $q->where('is_active', true));
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function tours(): BelongsToMany
    {
        return $this->belongsToMany(Tour::class, 'city_tour', 'city_id', 'tour_id');
    }

    public function hotels(): HasMany
    {
        return $this->hasMany(Hotel::class, 'country_id');
    }

    public function highlights(): BelongsToMany
    {
        return $this->belongsToMany(Highlight::class, 'city_highlight', 'city_id', 'highlight_id')
            ->withPivot('sort_order')
            ->withTimestamps()
            ->orderByPivot('sort_order');
    }

    public function getCityImageUrlAttribute(): ?string
    {
        if (empty($this->city_image)) {
            return null;
        }

        return '/storage/'.ltrim($this->city_image, '/');
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
