<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [

        'user_id',

        'order_number',

        'subtotal',

        'shipping_cost',

        'discount',

        'total',

        'status',

        'payment_status',

        'payment_method',

        'phone',

        'city',

        'address',

        'note',

        'ordered_at',

        'delivered_at',

    ];

    protected $casts = [

        'ordered_at'=>'datetime',

        'delivered_at'=>'datetime',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}