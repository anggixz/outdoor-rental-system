@extends('layouts.admin')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

        <div>

            <h1 class="text-3xl font-bold text-slate-800">
                Data Produk
            </h1>

            <p class="text-slate-500 mt-2">
                Kelola seluruh perlengkapan camping dan outdoor yang tersedia untuk disewakan.
            </p>

        </div>

        <a
            href="/admin/products/create"
            class="inline-flex items-center gap-2 px-5 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-medium transition">

            <i class="fa-solid fa-plus"></i>

            Tambah Produk

        </a>

    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-slate-500 text-sm">
                        Total Produk
                    </p>

                    <h3 class="text-3xl font-bold text-slate-800 mt-2">
                        {{ $totalProducts }}
                    </h3>

                </div>

                <div class="w-14 h-14 rounded-xl bg-emerald-100 flex items-center justify-center">

                    <i class="fa-solid fa-campground text-emerald-600 text-xl"></i>

                </div>

            </div>

        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-slate-500 text-sm">
                        Produk Aktif
                    </p>

                    <h3 class="text-3xl font-bold text-emerald-600 mt-2">
                        {{ $activeProducts }}
                    </h3>

                </div>

                <div class="w-14 h-14 rounded-xl bg-emerald-100 flex items-center justify-center">

                    <i class="fa-solid fa-circle-check text-emerald-600 text-xl"></i>

                </div>

            </div>

        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-slate-500 text-sm">
                        Produk Nonaktif
                    </p>

                    <h3 class="text-3xl font-bold text-red-600 mt-2">
                        {{ $inactiveProducts }}
                    </h3>

                </div>

                <div class="w-14 h-14 rounded-xl bg-red-100 flex items-center justify-center">

                    <i class="fa-solid fa-ban text-red-600 text-xl"></i>

                </div>

            </div>

        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-slate-500 text-sm">
                        Total Stok
                    </p>

                    <h3 class="text-3xl font-bold text-blue-600 mt-2">
                        {{ $totalStock }}
                    </h3>

                </div>

                <div class="w-14 h-14 rounded-xl bg-blue-100 flex items-center justify-center">

                    <i class="fa-solid fa-boxes-stacked text-blue-600 text-xl"></i>

                </div>

            </div>

        </div>

    </div>

    {{-- Alert --}}
    @if(session('success'))

        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-xl">

            {{ session('success') }}

        </div>

    @endif

    @if(session('error'))

        <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-xl">

            {{ session('error') }}

        </div>

    @endif

    {{-- Tabel Produk --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

        <div class="px-6 py-5 border-b border-slate-200">

            <h2 class="font-semibold text-slate-800">
                Daftar Produk
            </h2>

            <p class="text-sm text-slate-500 mt-1">
                Total Data: {{ $totalProducts }}
            </p>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full min-w-[950px]">

                <thead class="bg-slate-50">

                    <tr>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-500">
                            Produk
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-500">
                            Harga
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-500">
                            Stok
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-500">
                            Status
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-slate-500">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($products as $product)

                        <tr class="hover:bg-slate-50">

                            <td class="px-6 py-4">

                                <div class="flex items-center gap-4">

                                    @if($product->thumbnail)

                                        <img
                                            src="{{ asset('storage/' . $product->thumbnail) }}"
                                            class="w-20 h-20 object-cover rounded-xl border">

                                    @else

                                        <div class="w-20 h-20 rounded-xl bg-slate-100 flex items-center justify-center">

                                            <i class="fa-solid fa-image text-slate-400"></i>

                                        </div>

                                    @endif

                                    <div>

                                        <h3 class="font-semibold text-slate-800">
                                            {{ $product->name }}
                                        </h3>

                                        <p class="text-sm text-slate-500">
                                            ID #{{ $product->id }}
                                        </p>

                                    </div>

                                </div>

                            </td>

                            <td class="px-6 py-4 font-semibold text-slate-800">

                                Rp {{ number_format($product->price_per_day,0,',','.') }}

                            </td>

                            <td class="px-6 py-4">

                                @if($product->stock > 10)

                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">

                                        {{ $product->stock }} Unit

                                    </span>

                                @elseif($product->stock > 0)

                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">

                                        {{ $product->stock }} Unit

                                    </span>

                                @else

                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">

                                        Habis

                                    </span>

                                @endif

                            </td>

                            <td class="px-6 py-4">

                                @if($product->is_active)

                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">

                                        Aktif

                                    </span>

                                @else

                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">

                                        Nonaktif

                                    </span>

                                @endif

                            </td>

                            <td class="px-6 py-4">

                                <div class="flex justify-center gap-2">

                                    <a
                                        href="/admin/products/{{ $product->id }}/edit"
                                        class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-lg">

                                        <i class="fa-solid fa-pen-to-square"></i>

                                    </a>

                                    @if($product->is_active)

                                        <form action="/admin/products/{{ $product->id }}" method="POST">

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                onclick="return confirm('Yakin ingin menonaktifkan produk ini?')"
                                                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg">

                                                <i class="fa-solid fa-ban"></i>

                                            </button>

                                        </form>

                                    @else

                                        <form action="/admin/products/{{ $product->id }}/restore" method="POST">

                                            @csrf
                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg">

                                                <i class="fa-solid fa-check"></i>

                                            </button>

                                        </form>

                                    @endif

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5" class="py-16 text-center">

                                <div class="flex flex-col items-center">

                                    <i class="fa-solid fa-campground text-5xl text-slate-300 mb-4"></i>

                                    <h3 class="text-lg font-semibold text-slate-700">
                                        Belum Ada Produk
                                    </h3>

                                    <p class="text-slate-500 mt-1">
                                        Tambahkan produk pertama untuk mulai menyewakan perlengkapan camping.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection