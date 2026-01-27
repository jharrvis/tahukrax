<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingPageContent extends Model
{
    protected $fillable = [
        'key',
        'type',
        'content',
    ];

    protected $casts = [
        'content' => 'array',
    ];
}
