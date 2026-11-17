<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Cart::where(
            'user_id',
            auth()->id()
        )
            ->with('items.product')
            ->first();

        if (!$cart || $cart->items->count() == 0) {

            return redirect('/cart');

        }

        return view(
            'frontend.checkout.index',
            compact('cart')
        );
    }

    public function store(Request $request)
    {
        $request->validate([

            'customer_name' =>
                'required|string|max:255',

            'phone' =>
                'required|string|max:30',

            'address' =>
                'required|string',

            'identity_card' =>
                'required|image|mimes:jpg,jpeg,png|max:4096',

        ]);

        $cart = Cart::where(
            'user_id',
            auth()->id()
        )
            ->with('items.product')
            ->first();

        if (!$cart || $cart->items->isEmpty()) {

            return redirect('/cart')
                ->with(
                    'error',
                    'Keranjang masih kosong.'
                );

        }

        /*
        |--------------------------------------------------------------------------
        | Validasi stok
        |--------------------------------------------------------------------------
        */

        foreach ($cart->items as $item) {

            $availableStock =
                $item->product->availableStock(
                    $item->start_date,
                    $item->end_date
                );

            if ($item->qty > $availableStock) {

                return redirect('/cart')
                    ->with(
                        'error',
                        'Stok '
                        . $item->product->name .
                        ' tidak mencukupi pada tanggal yang dipilih.'
                    );

            }

        }

        /*
        |--------------------------------------------------------------------------
        | Perhitungan
        |--------------------------------------------------------------------------
        */

        $totalPrice =
            $cart->items->sum('subtotal');

        $deposit = 100000;

        $grandTotal =
            $totalPrice + $deposit;

        /*
        |--------------------------------------------------------------------------
        | Upload identitas
        |--------------------------------------------------------------------------
        */

        $identityPath = $request
            ->file('identity_card')
            ->store(
                'identity-cards',
                'public'
            );

        /*
        |--------------------------------------------------------------------------
        | Simpan Order
        |--------------------------------------------------------------------------
        */

        $order = Order::create([

            'user_id' =>
                auth()->id(),

            'invoice_number' =>
                '-',

            'customer_name' =>
                $request->customer_name,

            'phone' =>
                $request->phone,

            'address' =>
                $request->address,

            'identity_card' =>
                $identityPath,

            'total_price' =>
                $totalPrice,

            'deposit' =>
                $deposit,

            'grand_total' =>
                $grandTotal,

            'payment_status' =>
                Order::PAYMENT_PENDING,

            'rental_status' =>
                Order::RENTAL_PENDING,

        ]);

        $order->update([

            'invoice_number' =>

                'SW-' .

                now()->format('ymd') .

                str_pad(
                    $order->id,
                    6,
                    '0',
                    STR_PAD_LEFT
                )

        ]);
        /*
|--------------------------------------------------------------------------
| Simpan Detail Order
|--------------------------------------------------------------------------
*/

        foreach ($cart->items as $item) {

            OrderItem::create([

                'order_id' =>
                    $order->id,

                'product_id' =>
                    $item->product_id,

                'start_date' =>
                    $item->start_date,

                'end_date' =>
                    $item->end_date,

                'qty' =>
                    $item->qty,

                'price_per_day' =>
                    $item->price_per_day,

                /*
                |--------------------------------------------------------------------------
                | Snapshot harga beli saat transaksi
                |--------------------------------------------------------------------------
                */

                'purchase_price' =>
                    $item->product->purchase_price,

                'subtotal' =>
                    $item->subtotal,

                /*
                |--------------------------------------------------------------------------
                | Kondisi awal
                |--------------------------------------------------------------------------
                */

                'damage_status' =>
                    'good',

                'damage_penalty' =>
                    0,

                'needs_service' =>
                    false,

                'damage_note' =>
                    null,

            ]);

        }

        /*
        |--------------------------------------------------------------------------
        | Kosongkan Keranjang
        |--------------------------------------------------------------------------
        */

        $cart->items()->delete();

        return redirect('/orders/' . $order->id)
            ->with(
                'success',
                'Checkout berhasil.'
            );
    }
}