<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TourEnquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_id',
        'user_id',
        'full_name',
        'email',
        'phone',
        'departure_date',
        'return_date',
        'guests',
        'message',
        'status',
        'ip_address',
    ];

    protected function casts(): array
    {
        return [
            'departure_date' => 'date',
            'return_date' => 'date',
            'guests' => 'integer',
        ];
    }

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Estimated total using package "from" price × guests (same basis as public listings).
     */
    public function estimatedTotal(): ?float
    {
        $tour = $this->relationLoaded('tour') ? $this->tour : $this->tour()->first();
        if (! $tour || $tour->price === null) {
            return null;
        }

        return round((float) $tour->price * max(1, (int) $this->guests), 2);
    }
}
