<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public const PAYMENT_PENDING = 'pending';
    public const PAYMENT_PAID = 'paid';
    public const PAYMENT_EXPIRED = 'expired';
    public const PAYMENT_CANCELLED = 'cancelled';

    public const RENTAL_PENDING = 'pending';
    public const RENTAL_READY = 'ready';
    public const RENTAL_PICKED_UP = 'picked_up';
    public const RENTAL_RETURNED = 'returned';
    public const RENTAL_CANCELLED = 'cancelled';

    protected $fillable = [

        'user_id',
        'invoice_number',
        'customer_name',
        'phone',
        'address',
        'identity_card',
        'total_price',
        'deposit',
        'grand_total',

        'payment_status',
        'rental_status',

        'pickup_photo',
        'return_photo',

        'late_days',
        'late_fee',
        'missing_items',
        'missing_fee',
        'total_penalty',
        'deposit_return',

        'admin_note',
        'deposit_returned',
        'deposit_returned_at',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getPickupPhotoUrlAttribute()
    {
        return $this->pickup_photo
            ? asset('storage/' . $this->pickup_photo)
            : null;
    }

    public function getReturnPhotoUrlAttribute()
    {
        return $this->return_photo
            ? asset('storage/' . $this->return_photo)
            : null;
    }
}