<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [

        'order_id',

        'product_id',

        'start_date',

        'end_date',

        'qty',

        'price_per_day',

        'subtotal',

        /*
        |--------------------------------------------------------------------------
        | Snapshot harga beli saat transaksi
        |--------------------------------------------------------------------------
        */

        'purchase_price',

        /*
        |--------------------------------------------------------------------------
        | Kerusakan
        |--------------------------------------------------------------------------
        */

        'damage_status',

        'damage_penalty',

        'needs_service',

        'damage_note',

    ];

    /*
    |--------------------------------------------------------------------------
    | Relasi Order
    |--------------------------------------------------------------------------
    */

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Relasi Produk
    |--------------------------------------------------------------------------
    */

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessor Status Kerusakan
    |--------------------------------------------------------------------------
    */

    public function getDamageStatusLabelAttribute()
    {
        return match ($this->damage_status) {

            'good' => 'Baik',

            'light' => 'Rusak Ringan',

            'medium' => 'Rusak Sedang',

            'heavy' => 'Rusak Berat',

            'lost' => 'Hilang',

            default => '-',

        };
    }

    /*
    |--------------------------------------------------------------------------
    | Accessor Persentase Denda
    |--------------------------------------------------------------------------
    */

    public function getDamagePercentageAttribute()
    {
        return match ($this->damage_status) {

            'good' => 0,

            'light' => 20,

            'medium' => 50,

            'heavy' => 100,

            'lost' => 100,

            default => 0,

        };
    }

    /*
    |--------------------------------------------------------------------------
    | Format Harga Beli
    |--------------------------------------------------------------------------
    */

    public function getFormattedPurchasePriceAttribute()
    {
        return 'Rp ' . number_format(
            $this->purchase_price,
            0,
            ',',
            '.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Format Denda Kerusakan
    |--------------------------------------------------------------------------
    */

    public function getFormattedDamagePenaltyAttribute()
    {
        return 'Rp ' . number_format(
            $this->damage_penalty,
            0,
            ',',
            '.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Format Subtotal
    |--------------------------------------------------------------------------
    */

    public function getFormattedSubtotalAttribute()
    {
        return 'Rp ' . number_format(
            $this->subtotal,
            0,
            ',',
            '.'
        );
    }
}