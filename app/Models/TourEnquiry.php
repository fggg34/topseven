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
}
