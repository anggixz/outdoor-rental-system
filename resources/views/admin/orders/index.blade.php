@extends('layouts.admin')

@section('content')

    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>

                <h1 class="text-3xl font-bold text-slate-800">
                    Data Rental
                </h1>

                <p class="text-slate-500 mt-2">
                    Kelola seluruh transaksi penyewaan alat camping dan outdoor.
                </p>

            </div>

        </div>

        {{-- Filter Status --}}
        <div class="flex flex-wrap gap-3">

            <a href="/admin/orders" class="px-5 py-3 rounded-xl border font-medium transition
                        {{ request('status') == null
        ? 'bg-emerald-600 text-white border-emerald-600'
        : 'bg-white border-slate-200 hover:border-emerald-500 hover:text-emerald-600' }}">

                Semua

            </a>

            <a href="/admin/orders?status=pending" class="px-5 py-3 rounded-xl border font-medium transition
                        {{ request('status') == 'pending'
        ? 'bg-yellow-500 text-white border-yellow-500'
        : 'bg-yellow-50 text-yellow-700 border-yellow-200 hover:bg-yellow-100' }}">

                Pending

            </a>

            <a href="/admin/orders?status=ready" class="px-5 py-3 rounded-xl border font-medium transition
                        {{ request('status') == 'ready'
        ? 'bg-blue-600 text-white border-blue-600'
        : 'bg-blue-50 text-blue-700 border-blue-200 hover:bg-blue-100' }}">

                Ready

            </a>

            <a href="/admin/orders?status=picked_up" class="px-5 py-3 rounded-xl border font-medium transition
                {{ request('status') == 'picked_up'
        ? 'bg-indigo-600 text-white border-indigo-600'
        : 'bg-indigo-50 text-indigo-700 border-indigo-200 hover:bg-indigo-100' }}">

                Sudah Diambil

            </a>

            <a href="/admin/orders?status=returned" class="px-5 py-3 rounded-xl border font-medium transition
                        {{ request('status') == 'returned'
        ? 'bg-emerald-600 text-white border-emerald-600'
        : 'bg-emerald-50 text-emerald-700 border-emerald-200 hover:bg-emerald-100' }}">

                Returned

            </a>

            <a href="/admin/orders?status=cancelled" class="px-5 py-3 rounded-xl border font-medium transition
                        {{ request('status') == 'cancelled'
        ? 'bg-red-600 text-white border-red-600'
        : 'bg-red-50 text-red-700 border-red-200 hover:bg-red-100' }}">

                Cancelled

            </a>

        </div>

        {{-- Tabel --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

            <div class="px-6 py-5 border-b border-slate-200">

                <h2 class="font-semibold text-slate-800">
                    Daftar Rental
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Total Data: {{ $orders->total() }}
                </p>

            </div>

            <div class="overflow-x-auto">

                <table class="w-full min-w-[1000px]">

                    <thead class="bg-slate-50">

                        <tr>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Invoice
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Penyewa
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Total
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Pembayaran
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Status Rental
                            </th>

                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Aksi
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @forelse($orders as $order)

                            <tr class="hover:bg-slate-50 transition">

                                {{-- Invoice --}}
                                <td class="px-6 py-4">

                                    <div>

                                        <div class="font-semibold text-slate-800">
                                            {{ $order->invoice_number }}
                                        </div>

                                        <div class="text-xs text-slate-500">
                                            #{{ $order->id }}
                                        </div>

                                    </div>

                                </td>

                                {{-- Penyewa --}}
                                <td class="px-6 py-4">

                                    <div class="font-medium text-slate-800">
                                        {{ $order->customer_name }}
                                    </div>

                                </td>

                                {{-- Total --}}
                                <td class="px-6 py-4">

                                    <span class="font-semibold text-slate-800">
                                        Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                                    </span>

                                </td>

                                {{-- Status Pembayaran --}}
                                <td class="px-6 py-4">

                                    @if($order->payment_status == 'paid')

                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">

                                            <i class="fa-solid fa-circle-check mr-1"></i>

                                            Lunas

                                        </span>

                                    @elseif($order->payment_status == 'pending')

                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">

                                            <i class="fa-solid fa-clock mr-1"></i>

                                            Pending

                                        </span>

                                    @else

                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">

                                            <i class="fa-solid fa-circle-xmark mr-1"></i>

                                            {{ ucfirst($order->payment_status) }}

                                        </span>

                                    @endif

                                </td>

                                {{-- Status Rental --}}
                                <td class="px-6 py-4">

                                    @if($order->rental_status == 'pending')

                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">

                                            <i class="fa-solid fa-hourglass-half mr-1"></i>

                                            Pending

                                        </span>

                                    @elseif($order->rental_status == 'ready')

                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">

                                            <i class="fa-solid fa-box-open mr-1"></i>

                                            Siap Diambil

                                        </span>

                                    @elseif($order->rental_status == 'picked_up')

                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-700">

                                            <i class="fa-solid fa-truck-fast mr-1"></i>

                                            Sudah Diambil

                                        </span>

                                    @elseif($order->rental_status == 'returned')

                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">

                                            <i class="fa-solid fa-check-circle mr-1"></i>

                                            Dikembalikan

                                        </span>

                                    @elseif($order->rental_status == 'cancelled')

                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">

                                            <i class="fa-solid fa-ban mr-1"></i>

                                            Dibatalkan

                                        </span>

                                    @else

                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">

                                            {{ ucfirst($order->rental_status) }}

                                        </span>

                                    @endif

                                </td>

                                {{-- Aksi --}}
                                <td class="px-6 py-4">

                                    <div class="flex justify-center">

                                        <a href="/admin/orders/{{ $order->id }}"
                                            class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-medium transition">

                                            <i class="fa-solid fa-eye mr-2"></i>

                                            Detail

                                        </a>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" class="py-16 text-center">

                                    <div class="flex flex-col items-center">

                                        <i class="fa-solid fa-box-open text-5xl text-slate-300 mb-4"></i>

                                        <h3 class="text-lg font-semibold text-slate-700">
                                            Belum Ada Data Rental
                                        </h3>

                                        <p class="text-slate-500 mt-1">
                                            Data transaksi penyewaan akan muncul di sini.
                                        </p>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        {{-- Pagination --}}
        <div class="bg-white border border-slate-200 rounded-2xl px-6 py-4">

            {{ $orders->links() }}

        </div>

    </div>

@endsection