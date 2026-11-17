<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');
    }

    public function download(Request $request)
    {
        $request->validate([
            'start_date' => [
                'required',
                'date',
            ],
            'end_date' => [
                'required',
                'date',
                'after_or_equal:start_date',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Ambil seluruh transaksi pada periode yang dipilih
        |--------------------------------------------------------------------------
        */

        $orders = Order::with([
            'items.product',
            'user',
        ])
            ->whereBetween(
                'created_at',
                [
                    $request->start_date . ' 00:00:00',
                    $request->end_date . ' 23:59:59',
                ]
            )
            ->latest()
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Statistik Transaksi
        |--------------------------------------------------------------------------
        */

        $totalTransactions = $orders->count();

        $totalPaid = $orders
            ->where(
                'payment_status',
                Order::PAYMENT_PAID
            )
            ->count();

        $totalPending = $orders
            ->where(
                'payment_status',
                Order::PAYMENT_PENDING
            )
            ->count();

        $totalCancelled = $orders
            ->where(
                'payment_status',
                Order::PAYMENT_CANCELLED
            )
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Ambil hanya transaksi yang sudah dibayar
        |--------------------------------------------------------------------------
        */

        $paidOrders = $orders->where(
            'payment_status',
            Order::PAYMENT_PAID
        );

        /*
        |--------------------------------------------------------------------------
        | Ringkasan Keuangan
        |--------------------------------------------------------------------------
        */

        // Pendapatan sewa

        $totalRevenue = $paidOrders->sum(
            'total_price'
        );

        // Deposit diterima

        $totalDepositReceived = $paidOrders->sum(
            'deposit'
        );

        // Pendapatan denda

        $totalPenaltyRevenue = $paidOrders->sum(
            'total_penalty'
        );

        // Total uang masuk

        $totalCashIn =
            $totalRevenue +
            $totalDepositReceived +
            $totalPenaltyRevenue;

        // Deposit yang telah dikembalikan

        $totalDepositReturned = $paidOrders
            ->where(
                'deposit_returned',
                true
            )
            ->sum(
                'deposit_return'
            );

        // Total kas bersih

        $totalNetCash =
            $totalCashIn -
            $totalDepositReturned;

        /*
|--------------------------------------------------------------------------
| Detail Denda
|--------------------------------------------------------------------------
*/

        $totalLateFee = $paidOrders->sum(
            'late_fee'
        );

        $totalMissingFee = $paidOrders->sum(
            'missing_fee'
        );

        $totalDamagePenalty = $orders
            ->flatMap
            ->items
            ->sum(
                'damage_penalty'
            );

        /*
        |--------------------------------------------------------------------------
        | Inventaris
        |--------------------------------------------------------------------------
        */

        $serviceItems = $orders
            ->flatMap
            ->items
            ->where(
                'needs_service',
                true
            )
            ->count();

        $damagedItems = $orders
            ->flatMap
            ->items
            ->whereIn(
                'damage_status',
                [
                    'light',
                    'medium',
                    'heavy'
                ]
            )
            ->count();

        $lostItems = $orders
            ->flatMap
            ->items
            ->where(
                'damage_status',
                'lost'
            )
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Generate PDF
        |--------------------------------------------------------------------------
        */

        $pdf = Pdf::loadView(
            'admin.reports.pdf',
            compact(
                'orders',

                // Statistik
                'totalTransactions',
                'totalPaid',
                'totalPending',
                'totalCancelled',

                // Ringkasan Keuangan
                'totalRevenue',
                'totalDepositReceived',
                'totalPenaltyRevenue',
                'totalCashIn',
                'totalDepositReturned',
                'totalNetCash',
                
                // Detail Denda
                'totalLateFee',
                'totalMissingFee',
                'totalDamagePenalty',

                // Inventaris
                'serviceItems',
                'damagedItems',
                'lostItems',

                // Periode
                'request'
            )
        );

        $pdf->setPaper('a4', 'landscape');

        return $pdf->download(
            'laporan-keuangan-rental.pdf'
        );
    }
}