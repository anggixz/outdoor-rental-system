@extends('layouts.app')

@section('content')

<div class="bg-slate-50 min-h-screen">

    {{-- Hero --}}
    <section class="bg-gradient-to-r from-emerald-800 to-green-700 text-white">

        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-14">

            <h1 class="text-4xl font-bold">
                Riwayat Rental
            </h1>

            <p class="mt-3 text-emerald-100">
                Pantau status pembayaran dan proses rental perlengkapan outdoor Anda.
            </p>

        </div>

    </section>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-10">

        {{-- Statistik --}}
        <div class="grid md:grid-cols-3 gap-6 mb-8">

            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">

                <p class="text-slate-500 text-sm">
                    Total Pesanan
                </p>

                <h3 class="text-3xl font-bold text-slate-800 mt-2">
                    {{ $orders->count() }}
                </h3>

            </div>

            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">

                <p class="text-slate-500 text-sm">
                    Pesanan Lunas
                </p>

                <h3 class="text-3xl font-bold text-emerald-600 mt-2">
                    {{ $orders->where('payment_status','paid')->count() }}
                </h3>

            </div>

            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">

                <p class="text-slate-500 text-sm">
                    Menunggu Pembayaran
                </p>

                <h3 class="text-3xl font-bold text-amber-600 mt-2">
                    {{ $orders->where('payment_status','pending')->count() }}
                </h3>

            </div>

        </div>

        {{-- List Order --}}
        <div class="space-y-6">

            @forelse($orders as $order)

                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

                    <div class="p-6 lg:p-8">

                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

                            {{-- Kiri --}}
                            <div>

                                <div class="flex items-center gap-3 mb-3">

                                    <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-sm">

                                        #{{ $order->invoice_number }}

                                    </span>

                                </div>

                                <h2 class="text-2xl font-bold text-slate-800">

                                    Pesanan Rental

                                </h2>

                                <p class="text-slate-500 mt-2">

                                    Dibuat pada
                                    {{ $order->created_at->format('d M Y H:i') }}

                                </p>

                            </div>

                            {{-- Tengah --}}
                            <div>

                                <p class="text-sm text-slate-500">
                                    Total Pembayaran
                                </p>

                                <h3 class="text-3xl font-bold text-emerald-600 mt-1">

                                    Rp {{ number_format($order->grand_total,0,',','.') }}

                                </h3>

                            </div>

                            {{-- Kanan --}}
                            <div class="flex flex-col gap-3">

                                {{-- Status Payment --}}
                                @if($order->payment_status == 'paid')

                                    <span class="px-4 py-2 rounded-full bg-emerald-100 text-emerald-700 text-sm font-semibold text-center">

                                        Pembayaran Lunas

                                    </span>

                                @elseif($order->payment_status == 'pending')

                                    <span class="px-4 py-2 rounded-full bg-yellow-100 text-yellow-700 text-sm font-semibold text-center">

                                        Menunggu Pembayaran

                                    </span>

                                @elseif($order->payment_status == 'expired')

                                    <span class="px-4 py-2 rounded-full bg-red-100 text-red-700 text-sm font-semibold text-center">

                                        Expired

                                    </span>

                                @else

                                    <span class="px-4 py-2 rounded-full bg-slate-100 text-slate-700 text-sm font-semibold text-center">

                                        {{ ucfirst($order->payment_status) }}

                                    </span>

                                @endif

                                {{-- Status Rental --}}
                                @if($order->rental_status == 'ready')

                                    <span class="px-4 py-2 rounded-full bg-blue-100 text-blue-700 text-sm font-semibold text-center">

                                        Siap Diambil

                                    </span>

                                @elseif($order->rental_status == 'returned')

                                    <span class="px-4 py-2 rounded-full bg-emerald-100 text-emerald-700 text-sm font-semibold text-center">

                                        Sudah Dikembalikan

                                    </span>

                                @elseif($order->rental_status == 'pending')

                                    <span class="px-4 py-2 rounded-full bg-yellow-100 text-yellow-700 text-sm font-semibold text-center">

                                        Menunggu Konfirmasi

                                    </span>

                                @else

                                    <span class="px-4 py-2 rounded-full bg-slate-100 text-slate-700 text-sm font-semibold text-center">

                                        {{ ucfirst($order->rental_status) }}

                                    </span>

                                @endif

                            </div>

                        </div>

                        <div class="mt-8 flex flex-wrap gap-4">

                            <a
                                href="/orders/{{ $order->id }}"
                                class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-medium transition">

                                <i class="fa-solid fa-eye"></i>

                                Lihat Detail

                            </a>

                            @if($order->payment_status == 'pending')

                                <span class="inline-flex items-center gap-2 px-6 py-3 bg-amber-50 border border-amber-200 text-amber-700 rounded-xl">

                                    <i class="fa-solid fa-circle-info"></i>

                                    Menunggu Pembayaran

                                </span>

                            @endif

                        </div>

                    </div>

                </div>

            @empty

                {{-- Empty State --}}
                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-16 text-center">

                    <i class="fa-solid fa-box-open text-7xl text-slate-300"></i>

                    <h2 class="text-3xl font-bold text-slate-800 mt-6">

                        Belum Ada Pesanan

                    </h2>

                    <p class="text-slate-500 mt-3 max-w-lg mx-auto">

                        Anda belum pernah melakukan penyewaan perlengkapan outdoor.

                    </p>

                    <a
                        href="/products"
                        class="inline-flex items-center gap-3 mt-8 bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-4 rounded-2xl font-semibold">

                        <i class="fa-solid fa-tent"></i>

                        Mulai Sewa Sekarang

                    </a>

                </div>

            @endforelse

        </div>

    </div>

</div>

@endsection