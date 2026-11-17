@extends('layouts.app')

@section('content')

<section class="bg-gradient-to-r from-emerald-800 to-green-700 text-white">

    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-16">

        <h1 class="text-4xl lg:text-5xl font-bold">

            Katalog Produk

        </h1>

        <p class="mt-4 text-emerald-100 max-w-2xl">

            Temukan perlengkapan camping dan outdoor terbaik untuk mendukung petualanganmu.

        </p>

    </div>

</section>

<div class="max-w-7xl mx-auto px-6 lg:px-8 py-10">

    {{-- Search --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 mb-8">

        <form method="GET" action="/products">

            <div class="flex flex-col md:flex-row gap-4">

                <div class="flex-1 relative">

                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari produk camping..."
                        class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">

                </div>

                <button
                    type="submit"
                    class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-medium transition">

                    Cari Produk

                </button>

            </div>

        </form>

    </div>

    {{-- Info --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-3">

        <div>

            <h2 class="text-2xl font-bold text-slate-800">

                Produk Tersedia

            </h2>

            <p class="text-slate-500 mt-1">

                Menampilkan {{ $products->total() }} produk

            </p>

        </div>

    </div>

    {{-- Produk --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">

        @forelse($products as $product)

            <div class="group bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-xl transition duration-300">

                {{-- Thumbnail --}}
                <div class="relative overflow-hidden">

                    @if($product->thumbnail)

                        <img
                            src="{{ asset('storage/' . $product->thumbnail) }}"
                            alt="{{ $product->name }}"
                            class="w-full h-64 object-cover group-hover:scale-105 transition duration-500">

                    @else

                        <div class="w-full h-64 bg-slate-100 flex items-center justify-center">

                            <i class="fa-solid fa-image text-5xl text-slate-300"></i>

                        </div>

                    @endif

                    {{-- Badge --}}
                    <div class="absolute top-4 right-4">

                        @if($product->stock > 10)

                            <span class="bg-emerald-500 text-white text-xs px-3 py-1 rounded-full font-semibold">

                                Ready

                            </span>

                        @elseif($product->stock > 0)

                            <span class="bg-yellow-500 text-white text-xs px-3 py-1 rounded-full font-semibold">

                                Terbatas

                            </span>

                        @else

                            <span class="bg-red-500 text-white text-xs px-3 py-1 rounded-full font-semibold">

                                Habis

                            </span>

                        @endif

                    </div>

                </div>

                {{-- Body --}}
                <div class="p-6">

                    <h3 class="font-bold text-lg text-slate-800 line-clamp-2 min-h-[56px]">

                        {{ $product->name }}

                    </h3>

                    <div class="mt-4">

                        <p class="text-sm text-slate-500">

                            Harga Sewa

                        </p>

                        <p class="text-2xl font-bold text-emerald-600">

                            Rp {{ number_format($product->price_per_day,0,',','.') }}

                        </p>

                        <p class="text-sm text-slate-500">

                            per hari

                        </p>

                    </div>

                    <div class="mt-5 flex justify-between items-center">

                        <span class="text-sm text-slate-500">

                            Stok:
                            {{ $product->stock }}

                        </span>

                        <a
                            href="/products/{{ $product->slug }}"
                            class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-xl transition">

                            Detail

                            <i class="fa-solid fa-arrow-right"></i>

                        </a>

                    </div>

                </div>

            </div>

        @empty

            <div class="col-span-full">

                <div class="bg-white rounded-3xl border border-slate-200 p-16 text-center">

                    <i class="fa-solid fa-tent text-6xl text-slate-300"></i>

                    <h3 class="text-2xl font-bold text-slate-700 mt-6">

                        Produk Tidak Ditemukan

                    </h3>

                    <p class="text-slate-500 mt-3">

                        Coba gunakan kata kunci lain.

                    </p>

                </div>

            </div>

        @endforelse

    </div>

    {{-- Pagination --}}
    @if($products->hasPages())

        <div class="mt-10">

            {{ $products->links() }}

        </div>

    @endif

</div>

@endsection