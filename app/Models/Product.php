<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem;

class Product extends Model
{
    protected $fillable = [

        'category_id',

        'name',

        'slug',

        'description',

        'price_per_day',

        /*
        |--------------------------------------------------------------------------
        | Harga beli (modal)
        |--------------------------------------------------------------------------
        */

        'purchase_price',

        'stock',

        'is_active',

        'thumbnail',

    ];

    /*
    |--------------------------------------------------------------------------
    | Relasi Kategori
    |--------------------------------------------------------------------------
    */

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Relasi Order Item
    |--------------------------------------------------------------------------
    */

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Hitung Stok Tersedia
    |--------------------------------------------------------------------------
    */

    public function availableStock(
        string $startDate,
        string $endDate
    ): int {

        $bookedQty = OrderItem::query()

            ->where(
                'product_id',
                $this->id
            )

            ->whereHas('order', function ($query) {

                $query

                    ->where(
                        'payment_status',
                        Order::PAYMENT_PAID
                    )

                    ->whereNotIn(
                        'rental_status',
                        [
                            Order::RENTAL_RETURNED,
                            Order::RENTAL_CANCELLED,
                        ]
                    );

            })

            ->where(function ($query) use (
                $startDate,
                $endDate
            ) {

                $query

                    ->whereBetween(
                        'start_date',
                        [
                            $startDate,
                            $endDate
                        ]
                    )

                    ->orWhereBetween(
                        'end_date',
                        [
                            $startDate,
                            $endDate
                        ]
                    )

                    ->orWhere(function ($q) use (
                        $startDate,
                        $endDate
                    ) {

                        $q

                            ->where(
                                'start_date',
                                '<=',
                                $startDate
                            )

                            ->where(
                                'end_date',
                                '>=',
                                $endDate
                            );

                    });

            })

            ->sum('qty');

        return max(
            0,
            $this->stock - $bookedQty
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Format Harga Sewa
    |--------------------------------------------------------------------------
    */

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format(
            $this->price_per_day,
            0,
            ',',
            '.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Format Harga Beli
    |--------------------------------------------------------------------------
    */

    public function getFormattedPurchasePriceAttribute(): string
    {
        return 'Rp ' . number_format(
            $this->purchase_price,
            0,
            ',',
            '.'
        );
    }
}