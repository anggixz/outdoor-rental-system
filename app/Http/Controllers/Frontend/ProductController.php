<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $products = Product::query()

            ->where('is_active', true)

            ->when($search, function ($query) use ($search) {

                $query->where(
                    'name',
                    'like',
                    "%{$search}%"
                );

            })

            ->latest()

            ->paginate(12)

            ->withQueryString();

        return view(
            'frontend.products.index',
            compact(
                'products',
                'search'
            )
        );
    }

    public function show(Product $product)
    {
        if (!$product->is_active) {
            abort(404);
        }

        return view(
            'frontend.products.show',
            compact('product')
        );
    }

    public function availability(
        Request $request,
        Product $product
    ) {
        $request->validate([
            'start_date' => 'required',
            'end_date' => 'required'
        ]);

        $availableStock =
            $product->availableStock(
                $request->start_date,
                $request->end_date
            );

        return response()->json([
            'available_stock' => $availableStock
        ]);
    }
}