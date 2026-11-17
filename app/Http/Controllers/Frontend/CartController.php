<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::where('user_id', auth()->id())
            ->with('items.product')
            ->first();

        return view('frontend.cart.index', compact('cart'));
    }

    public function store(Request $request, Product $product)
    {
        $request->validate([
            'start_date' => 'required',
            'end_date' => 'required',
            'qty' => 'required|integer|min:1'
        ]);

        $cart = Cart::firstOrCreate([
            'user_id' => auth()->id()
        ]);

        $startDate = Carbon::createFromFormat(
            'd-m-Y',
            $request->start_date
        );

        $endDate = Carbon::createFromFormat(
            'd-m-Y',
            $request->end_date
        );

        $availableStock =
            $product->availableStock(
                $startDate->format('Y-m-d'),
                $endDate->format('Y-m-d')
            );

        if ($request->qty > $availableStock) {

            return back()->with(
                'error',
                'Stok tidak tersedia pada tanggal tersebut. '
                . 'Sisa stok hanya '
                . $availableStock
            );

        }

        $days = $startDate->diffInDays($endDate);

        $subtotal =
            $days *
            $product->price_per_day *
            $request->qty;

        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
            'qty' => $request->qty,
            'price_per_day' => $product->price_per_day,
            'subtotal' => $subtotal
        ]);

        return redirect('/cart')
            ->with('success', 'Produk masuk keranjang');
    }

    public function destroy(CartItem $cartItem)
    {
        $cartItem->delete();

        return back()->with('success', 'Item dihapus');
    }
}