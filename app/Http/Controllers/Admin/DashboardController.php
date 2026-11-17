<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Statistik Utama
        |--------------------------------------------------------------------------
        */

        $totalProducts = Product::count();

        $totalCustomers = User::where(
            'role',
            'customer'
        )->count();

        $totalOrders = Order::count();

        $pendingOrders = Order::where(
            'payment_status',
            Order::PAYMENT_PENDING
        )->count();

        $paidOrders = Order::where(
            'payment_status',
            Order::PAYMENT_PAID
        )->count();

        /*
        |--------------------------------------------------------------------------
        | Statistik Keuangan
        |--------------------------------------------------------------------------
        */

        $paidOrdersQuery = Order::where(
            'payment_status',
            Order::PAYMENT_PAID
        );

        // Pendapatan dari biaya sewa
        $totalRevenue = (clone $paidOrdersQuery)
            ->sum('total_price');

        // Total deposit yang diterima
        $totalDeposit = (clone $paidOrdersQuery)
            ->sum('deposit');

        // Total pendapatan dari denda
        $totalPenalty = (clone $paidOrdersQuery)
            ->sum('total_penalty');

        /*
        |--------------------------------------------------------------------------
        | Detail Denda
        |--------------------------------------------------------------------------
        */

        $totalLateFee = (clone $paidOrdersQuery)
            ->sum('late_fee');

        $totalMissingFee = (clone $paidOrdersQuery)
            ->sum('missing_fee');

        $totalDamagePenalty = OrderItem::sum(
            'damage_penalty'
        );

        // Seluruh uang yang masuk
        $totalCashIn =
            $totalRevenue +
            $totalDeposit +
            $totalPenalty;

        // Deposit yang masih menjadi kewajiban
        $unreturnedDeposit = Order::where(
            'payment_status',
            Order::PAYMENT_PAID
        )
            ->where(
                'deposit_returned',
                false
            )
            ->sum('deposit');

        /*
        |--------------------------------------------------------------------------
        | Order Terbaru
        |--------------------------------------------------------------------------
        */

        $latestOrders = Order::latest()
            ->take(5)
            ->get();

        /*
|--------------------------------------------------------------------------
| Statistik Inventaris
|--------------------------------------------------------------------------
*/

        $activeProducts = Product::where(
            'is_active',
            true
        )->count();

        $inactiveProducts = Product::where(
            'is_active',
            false
        )->count();

        $totalStock = Product::sum(
            'stock'
        );

        $returnedOrders = Order::where(
            'rental_status',
            Order::RENTAL_RETURNED
        )->count();

        /*
        |--------------------------------------------------------------------------
        | Barang Rusak
        |--------------------------------------------------------------------------
        */

        $damagedItems = OrderItem::whereIn(
            'damage_status',
            [
                'light',
                'medium',
                'heavy'
            ]
        )->count();

        /*
        |--------------------------------------------------------------------------
        | Barang Hilang
        |--------------------------------------------------------------------------
        */

        $lostItems = OrderItem::where(
            'damage_status',
            'lost'
        )->count();

        /*
        |--------------------------------------------------------------------------
        | Barang Perlu Servis
        |--------------------------------------------------------------------------
        */

        $serviceItems = OrderItem::where(
            'needs_service',
            true
        )->count();

        /*
        |--------------------------------------------------------------------------
        | Deposit
        |--------------------------------------------------------------------------
        */

        $depositReturned = Order::where(
            'deposit_returned',
            true
        )->sum('deposit_return');

        /*
        |--------------------------------------------------------------------------
        | Produk Terlaris
        |--------------------------------------------------------------------------
        */

        $topProducts = OrderItem::select(
            'product_id',
            DB::raw('SUM(qty) as total_rented')
        )
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_rented')
            ->take(5)
            ->get();

        return view(
            'admin.dashboard',
            compact(
                'totalProducts',
                'totalCustomers',
                'totalOrders',
                'pendingOrders',
                'paidOrders',
                'totalRevenue',
                'totalDeposit',
                'totalPenalty',
                'totalCashIn',
                'unreturnedDeposit',
                'latestOrders',
                'topProducts',
                'activeProducts',

                'inactiveProducts',

                'totalStock',

                'returnedOrders',

                'totalLateFee',

                'totalMissingFee',

                'totalDamagePenalty',

                'damagedItems',

                'lostItems',

                'serviceItems',

                'depositReturned',
            )
        );
    }
}