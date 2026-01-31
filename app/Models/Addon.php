<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Addon extends Model
{
    protected $fillable = [
        'name',
        'type',
        'image_url',
        'price',
        'weight_kg',
        'description',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'weight_kg' => 'float',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
