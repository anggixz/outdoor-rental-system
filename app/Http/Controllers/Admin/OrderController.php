<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status;

        $orders = Order::query()

            ->when($status, function ($query) use ($status) {

                $query->where(
                    'rental_status',
                    $status
                );

            })

            ->latest()

            ->paginate(10);

        return view(
            'admin.orders.index',
            compact(
                'orders',
                'status'
            )
        );
    }

    public function show(Order $order)
    {
        $order->load('items.product');

        return view(
            'admin.orders.show',
            compact('order')
        );
    }

    public function update(
        Request $request,
        Order $order
    ) {

        $request->validate([

            'rental_status' =>

                'required|in:pending,ready,picked_up,returned,cancelled',

            'pickup_photo' =>

                'nullable|image|mimes:jpg,jpeg,png|max:4096',

        ]);

        /*
        |--------------------------------------------------------------------------
        | Foto serah terima wajib saat picked up
        |--------------------------------------------------------------------------
        */

        if (

            $request->rental_status === Order::RENTAL_PICKED_UP &&

            !$order->pickup_photo &&

            !$request->hasFile('pickup_photo')

        ) {

            return back()

                ->withErrors([

                    'pickup_photo' =>

                        'Foto serah terima wajib diupload.'

                ])

                ->withInput();

        }

        /*
        |--------------------------------------------------------------------------
        | Upload foto pickup
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('pickup_photo')) {

            $pickupPhoto = $request

                ->file('pickup_photo')

                ->store(
                    'pickup-photos',
                    'public'
                );

            $order->pickup_photo = $pickupPhoto;

        }

        /*
        |--------------------------------------------------------------------------
        | Update status
        |--------------------------------------------------------------------------
        */

        $order->rental_status =
            $request->rental_status;

        $order->save();

        return back()->with(

            'success',

            'Status rental berhasil diupdate.'

        );
    }

    public function returnProcess(
        Request $request,
        Order $order
    ) {

        $request->validate([

            'late_days' =>
                'required|integer|min:0',

            'missing_items' =>
                'required|integer|min:0',

            'admin_note' =>
                'nullable',

            'return_photo' =>
                'required|image|mimes:jpg,jpeg,png|max:4096',

            /*
            |--------------------------------------------------------------------------
            | Data kerusakan per barang
            |--------------------------------------------------------------------------
            */

            'damage_status' =>
                'required|array',

            'damage_status.*' =>
                'required|in:good,light,medium,heavy,lost',

            'damage_note' =>
                'nullable|array',

            'needs_service' =>
                'nullable|array',

        ]);

        /*
        |--------------------------------------------------------------------------
        | Upload foto pengembalian
        |--------------------------------------------------------------------------
        */

        $returnPhoto = $request

            ->file('return_photo')

            ->store(
                'return-photos',
                'public'
            );

        /*
        |--------------------------------------------------------------------------
        | Denda keterlambatan & kehilangan jumlah barang
        |--------------------------------------------------------------------------
        */

        $lateFeePerDay = 50000;

        $missingFeePerItem = 5000;

        $lateFee =
            $request->late_days *
            $lateFeePerDay;

        $missingFee =
            $request->missing_items *
            $missingFeePerItem;

        /*
        |--------------------------------------------------------------------------
        | Hitung denda kerusakan
        |--------------------------------------------------------------------------
        */

        $damagePenalty = 0;
        foreach ($order->items as $item) {

            $status = $request->damage_status[$item->id];

            /*
            |--------------------------------------------------------------------------
            | Persentase denda
            |--------------------------------------------------------------------------
            */

            $percentage = match ($status) {

                'good' => 0,

                'light' => 20,

                'medium' => 50,

                'heavy' => 100,

                'lost' => 100,

                default => 0,

            };

            /*
            |--------------------------------------------------------------------------
            | Hitung denda
            |--------------------------------------------------------------------------
            */

            $penalty =

                ($item->purchase_price * $percentage / 100)

                * $item->qty;

            /*
            |--------------------------------------------------------------------------
            | Perlu servis
            |--------------------------------------------------------------------------
            */

            $needsService =

                isset($request->needs_service[$item->id]);

            /*
            |--------------------------------------------------------------------------
            | Update item
            |--------------------------------------------------------------------------
            */

            $item->update([

                'damage_status' =>

                    $status,

                'damage_penalty' =>

                    $penalty,

                'needs_service' =>

                    $needsService,

                'damage_note' =>

                    $request->damage_note[$item->id]
                    ?? null,

            ]);

            /*
            |--------------------------------------------------------------------------
            | Akumulasi denda
            |--------------------------------------------------------------------------
            */

            $damagePenalty +=
                $penalty;

        }

        /*
        |--------------------------------------------------------------------------
        | Total seluruh denda
        |--------------------------------------------------------------------------
        */

        $totalPenalty =

            $lateFee +

            $missingFee +

            $damagePenalty;

        /*
        |--------------------------------------------------------------------------
        | Hitung sisa deposit
        |--------------------------------------------------------------------------
        */

        $depositReturn =

            $order->deposit -

            $totalPenalty;

        if ($depositReturn < 0) {

            $depositReturn = 0;

        }

        /*
        |--------------------------------------------------------------------------
        | Update Order
        |--------------------------------------------------------------------------
        */

        $order->update([

            'late_days' =>

                $request->late_days,

            'late_fee' =>

                $lateFee,

            'missing_items' =>

                $request->missing_items,

            'missing_fee' =>

                $missingFee,

            'total_penalty' =>

                $totalPenalty,

            'deposit_return' =>

                $depositReturn,
            /*
|--------------------------------------------------------------------------
| Deposit dikembalikan manual
|--------------------------------------------------------------------------
*/

            'deposit_returned' => false,

            'deposit_returned_at' => null,

            /*
            |--------------------------------------------------------------------------
            | Catatan admin
            |--------------------------------------------------------------------------
            */

            'admin_note' =>

                $request->admin_note,

            /*
            |--------------------------------------------------------------------------
            | Foto pengembalian
            |--------------------------------------------------------------------------
            */

            'return_photo' =>

                $returnPhoto,

            /*
            |--------------------------------------------------------------------------
            | Status rental
            |--------------------------------------------------------------------------
            */

            'rental_status' =>

                Order::RENTAL_RETURNED,

        ]);

        return back()->with(

            'success',

            'Pengembalian berhasil diproses.'

        );
    }

    /*
    |--------------------------------------------------------------------------
    | Konfirmasi deposit telah dikembalikan
    |--------------------------------------------------------------------------
    */

    public function returnDeposit(Order $order)
    {
        $order->update([

            'deposit_returned' => true,

            'deposit_returned_at' => now(),

        ]);

        return back()->with(

            'success',

            'Pengembalian deposit berhasil dikonfirmasi.'

        );
    }
}