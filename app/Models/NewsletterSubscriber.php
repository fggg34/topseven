<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsletterSubscriber extends Model
{
    protected $fillable = [
        'full_name',
        'email',
        'opt_in',
        'source',
        'ip_address',
    ];

    protected function casts(): array
    {
        return [
            'opt_in' => 'boolean',
        ];
    }
}
