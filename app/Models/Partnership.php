<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partnership extends Model
{
    protected $fillable = [
        'user_id',
        'package_id',
        'partnership_code',
        'outlet_name',
        'recipient_name',
        'phone_number',
        'address',
        'city',
        'province',
        'postal_code',
        'joined_at',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }


}
