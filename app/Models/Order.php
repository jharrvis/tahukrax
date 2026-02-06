<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'partnership_id',
        'package_id',
        'total_amount',
        'shipping_cost',
        'status',
        'payment_channel',
        'tracking_number',
        'note',
        'xendit_invoice_id',
        'payment_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function partnership()
    {
        return $this->belongsTo(Partnership::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function confirmation()
    {
        return $this->hasOne(OrderConfirmation::class);
    }
}
