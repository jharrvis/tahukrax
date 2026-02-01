<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderConfirmation extends Model
{
    protected $fillable = [
        'order_id',
        'condition',
        'issue_types',
        'note',
        'proof_images',
        'rating',
        'received_at',
    ];

    protected $casts = [
        'issue_types' => 'array',
        'proof_images' => 'array',
        'received_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
