@extends('layouts.app')

@section('content')

<div class="bg-slate-50 min-h-screen">

    {{-- Header --}}
    <section class="bg-gradient-to-r from-emerald-800 to-green-700 text-white">

        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-14">

            <h1 class="text-4xl font-bold">
                Detail Rental
            </h1>

            <p class="mt-3 text-emerald-100">

                Invoice:
                {{ $order->invoice_number }}

            </p>

        </div>

    </section>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-10">

        {{-- STATUS --}}
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8 mb-8">

            <div class="grid md:grid-cols-2 gap-6">

                <div>

                    <h2 class="text-xl font-bold text-slate-800 mb-4">

                        Status Pembayaran

                    </h2>

                    @if($order->payment_status == 'paid')

                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-100 text-emerald-700 font-semibold">

                            <i class="fa-solid fa-circle-check"></i>

                            Lunas

                        </span>

                    @elseif($order->payment_status == 'pending')

                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-yellow-100 text-yellow-700 font-semibold">

                            <i class="fa-solid fa-clock"></i>

                            Menunggu Pembayaran

                        </span>

                    @elseif($order->payment_status == 'expired')

                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-red-100 text-red-700 font-semibold">

                            <i class="fa-solid fa-circle-xmark"></i>

                            Expired

                        </span>

                    @else

                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-slate-100 text-slate-700 font-semibold">

                            {{ ucfirst($order->payment_status) }}

                        </span>

                    @endif

                </div>

                <div>

                    <h2 class="text-xl font-bold text-slate-800 mb-4">

                        Status Rental

                    </h2>

                    @if($order->rental_status == 'pending')

                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-yellow-100 text-yellow-700 font-semibold">

                            Menunggu Konfirmasi

                        </span>

                    @elseif($order->rental_status == 'ready')

                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-100 text-blue-700 font-semibold">

                            Siap Diambil

                        </span>

                    @elseif($order->rental_status == 'returned')

                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-100 text-emerald-700 font-semibold">

                            Sudah Dikembalikan

                        </span>

                    @elseif($order->rental_status == 'cancelled')

                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-red-100 text-red-700 font-semibold">

                            Dibatalkan

                        </span>

                    @endif

                </div>

            </div>

        </div>

        {{-- DATA PENYEWA --}}
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8 mb-8">

            <h2 class="text-2xl font-bold text-slate-800 mb-6">

                Data Penyewa

            </h2>

            <div class="grid md:grid-cols-3 gap-6">

                <div>

                    <p class="text-sm text-slate-500">
                        Nama
                    </p>

                    <p class="font-semibold">
                        {{ $order->customer_name }}
                    </p>

                </div>

                <div>

                    <p class="text-sm text-slate-500">
                        WhatsApp
                    </p>

                    <p class="font-semibold">
                        {{ $order->phone }}
                    </p>

                </div>

                <div>

                    <p class="text-sm text-slate-500">
                        Alamat
                    </p>

                    <p class="font-semibold">
                        {{ $order->address }}
                    </p>

                </div>

            </div>

        </div>

        {{-- ITEM RENTAL --}}
        <div class="space-y-6">

            @foreach($order->items as $item)

                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

                    <div class="p-6">

                        <div class="flex flex-col md:flex-row gap-6">

                            <img
                                src="{{ asset('storage/' . $item->product->thumbnail) }}"
                                alt="{{ $item->product->name }}"
                                class="w-full md:w-40 h-40 object-cover rounded-2xl">

                            <div class="flex-1">

                                <h3 class="text-2xl font-bold text-slate-800">

                                    {{ $item->product->name }}

                                </h3>

                                <div class="mt-4 space-y-2 text-slate-600">

                                    <p>

                                        <i class="fa-solid fa-calendar-days mr-2 text-emerald-600"></i>

                                        {{ \Carbon\Carbon::parse($item->start_date)->format('d M Y') }}

                                        -

                                        {{ \Carbon\Carbon::parse($item->end_date)->format('d M Y') }}

                                    </p>

                                    <p>

                                        <i class="fa-solid fa-box mr-2 text-emerald-600"></i>

                                        Qty:
                                        {{ $item->qty }}

                                    </p>

                                </div>

                            </div>

                            <div>

                                <div class="text-2xl font-bold text-emerald-600">

                                    Rp {{ number_format($item->subtotal,0,',','.') }}

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

        {{-- RINGKASAN --}}
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8 mt-8">

            <h2 class="text-2xl font-bold text-slate-800 mb-6">

                Ringkasan Pembayaran

            </h2>

            <div class="space-y-4">

                <div class="flex justify-between">

                    <span class="text-slate-500">
                        Total Rental
                    </span>

                    <span class="font-semibold">

                        Rp {{ number_format($order->total_price,0,',','.') }}

                    </span>

                </div>

                <div class="flex justify-between">

                    <span class="text-slate-500">
                        Deposit
                    </span>

                    <span class="font-semibold">

                        Rp {{ number_format($order->deposit,0,',','.') }}

                    </span>

                </div>

                @if($order->total_penalty > 0)

                    <div class="flex justify-between">

                        <span class="text-red-600">
                            Total Denda
                        </span>

                        <span class="font-semibold text-red-600">

                            Rp {{ number_format($order->total_penalty,0,',','.') }}

                        </span>

                    </div>

                @endif

                @if($order->deposit_return > 0)

                    <div class="flex justify-between">

                        <span class="text-emerald-600">
                            Deposit Dikembalikan
                        </span>

                        <span class="font-semibold text-emerald-600">

                            Rp {{ number_format($order->deposit_return,0,',','.') }}

                        </span>

                    </div>

                @endif

            </div>

            <hr class="my-6">

            <div class="flex justify-between items-center">

                <span class="text-xl font-bold text-slate-800">

                    Grand Total

                </span>

                <span class="text-4xl font-bold text-emerald-600">

                    Rp {{ number_format($order->grand_total,0,',','.') }}

                </span>

            </div>

            @if($order->payment_status == 'pending')

                <a
                    href="/payment/{{ $order->id }}"
                    class="block text-center mt-8 bg-emerald-600 hover:bg-emerald-700 text-white py-4 rounded-2xl font-semibold transition">

                    <i class="fa-solid fa-credit-card mr-2"></i>

                    Bayar Sekarang

                </a>

            @endif

        </div>

        {{-- HASIL PENGEMBALIAN --}}
        @if($order->rental_status == 'returned')

            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8 mt-8">

                <h2 class="text-2xl font-bold text-slate-800 mb-6">

                    Hasil Pengembalian

                </h2>

                <div class="grid md:grid-cols-2 gap-6">

                    <div>

                        <p class="text-slate-500">
                            Telat
                        </p>

                        <p class="font-semibold">

                            {{ $order->late_days }} Hari

                        </p>

                    </div>

                    <div>

                        <p class="text-slate-500">
                            Barang Hilang
                        </p>

                        <p class="font-semibold">

                            {{ $order->missing_items }}

                        </p>

                    </div>

                    <div>

                        <p class="text-slate-500">
                            Denda Telat
                        </p>

                        <p class="font-semibold">

                            Rp {{ number_format($order->late_fee,0,',','.') }}

                        </p>

                    </div>

                    <div>

                        <p class="text-slate-500">
                            Denda Barang
                        </p>

                        <p class="font-semibold">

                            Rp {{ number_format($order->missing_fee,0,',','.') }}

                        </p>

                    </div>

                </div>

                @if($order->admin_note)

                    <div class="mt-6 bg-slate-50 rounded-2xl p-5">

                        <h3 class="font-semibold mb-2">

                            Catatan Admin

                        </h3>

                        <p class="text-slate-600">

                            {{ $order->admin_note }}

                        </p>

                    </div>

                @endif

            </div>

        @endif

    </div>

</div>

@endsection