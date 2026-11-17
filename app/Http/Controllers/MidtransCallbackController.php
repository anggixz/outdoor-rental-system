<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class MidtransCallbackController extends Controller
{
    public function receive(Request $request)
    {
        $serverKey = config('midtrans.server_key');

        $hashed = hash(
            'sha512',
            $request->order_id .
            $request->status_code .
            $request->gross_amount .
            $serverKey
        );

        if ($hashed != $request->signature_key) {

            return response()->json([
                'message' => 'Invalid signature'
            ], 403);

        }

        $order = Order::where(
            'invoice_number',
            $request->order_id
        )->first();

        if (!$order) {

            return response()->json([
                'message' => 'Order not found'
            ], 404);

        }

        $transaction =
            $request->transaction_status;

        if (
            $transaction == 'capture' ||
            $transaction == 'settlement'
        ) {

            $order->update([

                'payment_status' =>
                    Order::PAYMENT_PAID,

                'rental_status' =>
                    Order::RENTAL_READY

            ]);

        }

        elseif ($transaction == 'pending') {

            $order->update([

                'payment_status' =>
                    Order::PAYMENT_PENDING

            ]);

        }

        elseif (
            $transaction == 'expire' ||
            $transaction == 'cancel' ||
            $transaction == 'deny' ||
            $transaction == 'failure'
        ) {

            $order->update([

                'payment_status' =>
                    Order::PAYMENT_CANCELLED,

                'rental_status' =>
                    Order::RENTAL_CANCELLED

            ]);

        }

        return response()->json([
            'message' => 'Callback success'
        ]);
    }
}