<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();

        $totalProducts = Product::count();

        $activeProducts = Product::where(
            'is_active',
            true
        )->count();

        $inactiveProducts = Product::where(
            'is_active',
            false
        )->count();

        $totalStock = Product::sum('stock');

        return view(
            'admin.products.index',
            compact(
                'products',
                'totalProducts',
                'activeProducts',
                'inactiveProducts',
                'totalStock'
            )
        );
    }

    public function create()
    {
        $categories = Category::all();

        return view(
            'admin.products.create',
            compact('categories')
        );
    }

    public function store(Request $request)
    {
        $request->validate([

            'category_id' =>
                'required|exists:categories,id',

            'name' =>
                'required|string|max:255',

            'description' =>
                'nullable|string',

            'price_per_day' =>
                'required|numeric|min:0',

            /*
            |--------------------------------------------------------------------------
            | Harga beli
            |--------------------------------------------------------------------------
            */

            'purchase_price' =>
                'required|numeric|min:0',

            'stock' =>
                'required|integer|min:0',

            'thumbnail' =>
                'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',

        ]);

        $thumbnail = null;

        if ($request->hasFile('thumbnail')) {

            $thumbnail = $request
                ->file('thumbnail')
                ->store(
                    'products',
                    'public'
                );
        }

        Product::create([

            'category_id' =>
                $request->category_id,

            'name' =>
                $request->name,

            'slug' =>
                Str::slug($request->name),

            'description' =>
                $request->description,

            'price_per_day' =>
                $request->price_per_day,

            /*
            |--------------------------------------------------------------------------
            | Harga beli
            |--------------------------------------------------------------------------
            */

            'purchase_price' =>
                $request->purchase_price,

            'stock' =>
                $request->stock,

            'thumbnail' =>
                $thumbnail,

            'is_active' =>
                true,

        ]);

        return redirect('/admin/products')
            ->with(
                'success',
                'Produk berhasil ditambahkan.'
            );
    }

    public function edit(Product $product)
    {
        $categories = Category::all();

        return view(
            'admin.products.edit',
            compact(
                'product',
                'categories'
            )
        );
    }

    public function update(
        Request $request,
        Product $product
    ) {

        $request->validate([

            'category_id' =>
                'required|exists:categories,id',

            'name' =>
                'required|string|max:255',

            'description' =>
                'nullable|string',

            'price_per_day' =>
                'required|numeric|min:0',

            /*
            |--------------------------------------------------------------------------
            | Harga beli
            |--------------------------------------------------------------------------
            */

            'purchase_price' =>
                'required|numeric|min:0',

            'stock' =>
                'required|integer|min:0',

            'thumbnail' =>
                'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',

        ]);

        $thumbnail = $product->thumbnail;

        if ($request->hasFile('thumbnail')) {

            $thumbnail = $request
                ->file('thumbnail')
                ->store(
                    'products',
                    'public'
                );
        }

        $product->update([

            'category_id' =>
                $request->category_id,

            'name' =>
                $request->name,

            'slug' =>
                Str::slug($request->name),

            'description' =>
                $request->description,

            'price_per_day' =>
                $request->price_per_day,

            /*
            |--------------------------------------------------------------------------
            | Harga beli
            |--------------------------------------------------------------------------
            */

            'purchase_price' =>
                $request->purchase_price,

            'stock' =>
                $request->stock,

            'thumbnail' =>
                $thumbnail,

        ]);

        return redirect('/admin/products')
            ->with(
                'success',
                'Produk berhasil diperbarui.'
            );
    }

    public function destroy(Product $product)
    {
        $product->update([

            'is_active' => false

        ]);

        return back()->with(
            'success',
            'Produk berhasil dinonaktifkan.'
        );
    }

    public function restore(Product $product)
    {
        $product->update([

            'is_active' => true

        ]);

        return back()->with(
            'success',
            'Produk berhasil diaktifkan kembali.'
        );
    }
}