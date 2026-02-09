<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'image_url',
        'features',
        'description',
        'price',
        'weight_kg',
        'is_featured',
    ];

    protected $casts = [
        'features' => 'array',
        'price' => 'decimal:2',
        'weight_kg' => 'float',
        'is_featured' => 'boolean',
    ];

    public function partnerships()
    {
        return $this->hasMany(Partnership::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
