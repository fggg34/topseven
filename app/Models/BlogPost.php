<?php

namespace App\Models;

use Filament\Forms\Components\RichEditor\RichContentRenderer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class BlogPost extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'blog_category_id',
        'user_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'meta_title',
        'meta_description',
        'is_published',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(BlogTag::class, 'blog_post_tag');
    }

    /**
     * Public URL for the featured image (handles full URLs, /storage paths, Filament array/JSON quirks).
     */
    public function getFeaturedImageUrlAttribute(): ?string
    {
        $raw = $this->featured_image;
        if ($raw === null || $raw === '') {
            return null;
        }

        if (is_array($raw)) {
            $raw = reset($raw) ?: null;
        }

        if (! is_string($raw)) {
            return null;
        }

        $raw = trim($raw);

        if ($raw === '') {
            return null;
        }

        if (str_starts_with($raw, '[') || str_starts_with($raw, '{')) {
            $decoded = json_decode($raw, true);
            if (is_array($decoded)) {
                $strings = array_values(array_filter($decoded, fn ($v) => is_string($v) && $v !== ''));
                $raw = $strings[0] ?? (is_string(reset($decoded)) ? reset($decoded) : $raw);
            }
        }

        if ($raw === '' || ! is_string($raw)) {
            return null;
        }

        if (filter_var($raw, FILTER_VALIDATE_URL) || str_starts_with($raw, 'data:')) {
            return $raw;
        }

        if (str_starts_with($raw, '/storage/') || str_starts_with($raw, 'storage/')) {
            return str_starts_with($raw, '/') ? $raw : '/'.$raw;
        }

        return Storage::disk('public')->url(ltrim($raw, '/'));
    }

    /**
     * HTML for the post body. Supports stored HTML or TipTap JSON (fixes missing inline images when JSON is stored).
     */
    public function getContentHtmlAttribute(): string
    {
        $content = $this->attributes['content'] ?? null;
        if ($content === null || $content === '') {
            return '';
        }

        $decoded = json_decode($content, true);
        if (is_array($decoded) && (($decoded['type'] ?? null) === 'doc')) {
            return RichContentRenderer::make($decoded)
                ->fileAttachmentsDisk('public')
                ->fileAttachmentsVisibility('public')
                ->toHtml();
        }

        return is_string($content) ? $content : '';
    }

    /**
     * Plain text for listings (excerpt may be HTML or TipTap JSON).
     */
    public function getExcerptPlainAttribute(): string
    {
        $raw = $this->attributes['excerpt'] ?? null;
        if ($raw === null || $raw === '') {
            return '';
        }

        if (! is_string($raw)) {
            return '';
        }

        $decoded = json_decode($raw, true);
        if (is_array($decoded) && (($decoded['type'] ?? null) === 'doc')) {
            return RichContentRenderer::make($decoded)
                ->fileAttachmentsDisk('public')
                ->fileAttachmentsVisibility('public')
                ->toText();
        }

        return trim(preg_replace('/\s+/', ' ', strip_tags($raw)));
    }
}
