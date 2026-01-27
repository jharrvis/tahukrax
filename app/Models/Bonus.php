<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bonus extends Model
{
    protected $fillable = [
        'name',
        'description',
        'duration_days',
        'is_active',
    ];

    public function partnerships()
    {
        return $this->belongsToMany(Partnership::class, 'partnership_bonuses')
            ->withPivot('granted_at', 'expires_at')
            ->withTimestamps();
    }
}
