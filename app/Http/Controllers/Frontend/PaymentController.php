<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function pay(Order $order)
    {
        abort_if((int) $order->user_id !== (int) auth()->id(), 403);
        Config::$serverKey =
            config('midtrans.server_key');

        Config::$isProduction =
            config('midtrans.is_production');

        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [

            'transaction_details' => [

                'order_id' =>
                    $order->invoice_number,

                'gross_amount' =>
                    $order->grand_total

            ],

            'customer_details' => [

                'first_name' =>
                    $order->customer_name,

                'phone' =>
                    $order->phone

            ]

        ];

        $snapToken = Snap::getSnapToken($params);

        return view(
            'frontend.payment.pay',
            compact('snapToken', 'order')
        );
    }
}