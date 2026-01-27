<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingRate extends Model
{
    protected $fillable = [
        'destination_city',
        'price_per_kg',
        'minimum_weight',
    ];
}
