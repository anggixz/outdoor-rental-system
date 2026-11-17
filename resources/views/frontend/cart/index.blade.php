@extends('layouts.app')

@section('content')

<div class="bg-slate-50 min-h-screen">

    {{-- Header --}}
    <section class="bg-gradient-to-r from-emerald-800 to-green-700 text-white">

        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-14">

            <h1 class="text-4xl font-bold">

                Keranjang Rental

            </h1>

            <p class="mt-3 text-emerald-100">

                Periksa kembali perlengkapan yang akan disewa sebelum melanjutkan checkout.

            </p>

        </div>

    </section>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-10">

        {{-- Alert --}}
        @if(session('success'))

            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-2xl">

                {{ session('success') }}

            </div>

        @endif

        @if($cart && $cart->items->count())

            @php
                $grandTotal = 0;
            @endphp

            <div class="grid lg:grid-cols-3 gap-8">

                {{-- Produk --}}
                <div class="lg:col-span-2 space-y-6">

                    @foreach($cart->items as $item)

                        @php

                            $grandTotal += $item->subtotal;

                            $start =
                                \Carbon\Carbon::parse($item->start_date);

                            $end =
                                \Carbon\Carbon::parse($item->end_date);

                            $days =
                                $start->diffInDays($end);

                        @endphp

                        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

                            <div class="p-6">

                                <div class="flex flex-col md:flex-row gap-6">

                                    {{-- Thumbnail --}}
                                    <div class="shrink-0">

                                        <img
                                            src="{{ asset('storage/' . $item->product->thumbnail) }}"
                                            alt="{{ $item->product->name }}"
                                            class="w-full md:w-44 h-44 object-cover rounded-2xl">

                                    </div>

                                    {{-- Info --}}
                                    <div class="flex-1">

                                        <h2 class="text-2xl font-bold text-slate-800">

                                            {{ $item->product->name }}

                                        </h2>

                                        <div class="mt-4 space-y-2 text-slate-600">

                                            <p>

                                                <i class="fa-solid fa-calendar-days mr-2 text-emerald-600"></i>

                                                {{ \Carbon\Carbon::parse($item->start_date)->format('d M Y') }}

                                                -

                                                {{ \Carbon\Carbon::parse($item->end_date)->format('d M Y') }}

                                            </p>

                                            <p>

                                                <i class="fa-solid fa-clock mr-2 text-emerald-600"></i>

                                                {{ $days }} Hari Rental

                                            </p>

                                            <p>

                                                <i class="fa-solid fa-box mr-2 text-emerald-600"></i>

                                                Qty: {{ $item->qty }}

                                            </p>

                                        </div>

                                        <div class="mt-5">

                                            <div class="text-sm text-slate-500">

                                                Total Biaya

                                            </div>

                                            <div class="text-3xl font-bold text-emerald-600">

                                                Rp {{ number_format($item->subtotal,0,',','.') }}

                                            </div>

                                        </div>

                                    </div>

                                    {{-- Hapus --}}
                                    <div>

                                        <form
                                            action="/cart/{{ $item->id }}"
                                            method="POST">

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                onclick="return confirm('Hapus item dari keranjang?')"
                                                class="px-4 py-3 bg-red-500 hover:bg-red-600 text-white rounded-xl transition">

                                                <i class="fa-solid fa-trash"></i>

                                            </button>

                                        </form>

                                    </div>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

                {{-- Summary --}}
                <div>

                    <div class="sticky top-24">

                        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

                            <div class="p-6 border-b border-slate-200">

                                <h2 class="text-xl font-bold text-slate-800">

                                    Ringkasan Pesanan

                                </h2>

                            </div>

                            <div class="p-6">

                                <div class="flex justify-between mb-4">

                                    <span class="text-slate-500">

                                        Total Item

                                    </span>

                                    <span class="font-semibold">

                                        {{ $cart->items->count() }}

                                    </span>

                                </div>

                                <div class="flex justify-between">

                                    <span class="text-slate-500">

                                        Subtotal

                                    </span>

                                    <span class="font-semibold">

                                        Rp {{ number_format($grandTotal,0,',','.') }}

                                    </span>

                                </div>

                                <hr class="my-5">

                                <div class="flex justify-between items-center">

                                    <span class="text-lg font-semibold text-slate-800">

                                        Grand Total

                                    </span>

                                    <span class="text-2xl font-bold text-emerald-600">

                                        Rp {{ number_format($grandTotal,0,',','.') }}

                                    </span>

                                </div>

                                <div class="mt-6 bg-amber-50 border border-amber-200 rounded-2xl p-4">

                                    <p class="text-sm text-amber-700">

                                        Deposit dan biaya tambahan akan dihitung pada tahap checkout.

                                    </p>

                                </div>

                                <a
                                    href="/checkout"
                                    class="block mt-6 text-center bg-emerald-600 hover:bg-emerald-700 text-white py-4 rounded-2xl font-semibold transition">

                                    Lanjut Checkout

                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        @else

            {{-- Empty State --}}
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-16 text-center">

                <i class="fa-solid fa-cart-shopping text-7xl text-slate-300"></i>

                <h2 class="text-3xl font-bold text-slate-800 mt-6">

                    Keranjang Masih Kosong

                </h2>

                <p class="text-slate-500 mt-3 max-w-lg mx-auto">

                    Belum ada perlengkapan yang ditambahkan ke keranjang rental.

                </p>

                <a
                    href="/products"
                    class="inline-flex items-center gap-3 mt-8 bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-4 rounded-2xl font-semibold">

                    <i class="fa-solid fa-tent"></i>

                    Lihat Produk

                </a>

            </div>

        @endif

    </div>

</div>

@endsection