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
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
