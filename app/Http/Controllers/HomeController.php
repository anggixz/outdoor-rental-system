<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::where('is_active', true)
            ->latest()
            ->take(8)
            ->get();

        $categories = Category::withCount('products')
            ->take(6)
            ->get();

        $totalProducts = Product::where(
            'is_active',
            true
        )->count();

        $totalCustomers = User::where(
            'role',
            'customer'
        )->count();

        $totalOrders = Order::count();

        return view(
            'frontend.home',
            compact(
                'products',
                'categories',
                'totalProducts',
                'totalCustomers',
                'totalOrders'
            )
        );
    }
}