<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view(
            'frontend.orders.index',
            compact('orders')
        );
    }

    public function show(Order $order)
    {
        abort_if((int) $order->user_id !== (int) auth()->id(), 403);
        $order->load('items.product');

        return view(
            'frontend.orders.show',
            compact('order')
        );
    }
}