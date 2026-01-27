<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnershipBonus extends Model
{
    protected $fillable = [
        'partnership_id',
        'bonus_id',
        'granted_at',
        'expires_at',
    ];

    public function partnership()
    {
        return $this->belongsTo(Partnership::class);
    }

    public function bonus()
    {
        return $this->belongsTo(Bonus::class);
    }
}
