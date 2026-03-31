<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageWhyBookCard extends Model
{
    protected $table = 'homepage_why_book_cards';

    protected $fillable = [
        'sort_order',
        'title',
        'description',
        'icon_path',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }

    public function getIconUrlAttribute(): ?string
    {
        if (empty($this->icon_path)) {
            return null;
        }

        return '/storage/'.ltrim($this->icon_path, '/');
    }
}
