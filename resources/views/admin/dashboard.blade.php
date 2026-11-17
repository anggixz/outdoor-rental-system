@extends('layouts.admin')

@section('content')

    <div class="space-y-8">

        {{-- Header --}}
        <div>

            <h1 class="text-4xl font-bold text-slate-800">
                Dashboard
            </h1>

            <p class="text-slate-500 mt-2">
                Selamat datang di panel administrasi Pemuda Berkelana.
            </p>

        </div>

        {{-- Statistik Utama --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

            {{-- Total Produk --}}
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-slate-500 text-sm">
                            Total Produk
                        </p>

                        <h2 class="text-4xl font-bold text-slate-800 mt-3">
                            {{ $totalProducts }}
                        </h2>

                    </div>

                    <div class="w-14 h-14 rounded-xl bg-emerald-100 flex items-center justify-center">

                        <i class="fa-solid fa-campground text-emerald-600 text-2xl"></i>

                    </div>

                </div>

            </div>

            {{-- Customer --}}
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-slate-500 text-sm">
                            Customer
                        </p>

                        <h2 class="text-4xl font-bold text-slate-800 mt-3">
                            {{ $totalCustomers }}
                        </h2>

                    </div>

                    <div class="w-14 h-14 rounded-xl bg-blue-100 flex items-center justify-center">

                        <i class="fa-solid fa-users text-blue-600 text-2xl"></i>

                    </div>

                </div>

            </div>

            {{-- Total Rental --}}
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-slate-500 text-sm">
                            Total Rental
                        </p>

                        <h2 class="text-4xl font-bold text-slate-800 mt-3">
                            {{ $totalOrders }}
                        </h2>

                    </div>

                    <div class="w-14 h-14 rounded-xl bg-amber-100 flex items-center justify-center">

                        <i class="fa-solid fa-box-open text-amber-600 text-2xl"></i>

                    </div>

                </div>

            </div>

            {{-- Pending --}}
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-slate-500 text-sm">
                            Order Pending
                        </p>

                        <h2 class="text-4xl font-bold text-orange-600 mt-3">
                            {{ $pendingOrders }}
                        </h2>

                    </div>

                    <div class="w-14 h-14 rounded-xl bg-orange-100 flex items-center justify-center">

                        <i class="fa-solid fa-hourglass-half text-orange-600 text-2xl"></i>

                    </div>

                </div>

            </div>

        </div>

        {{-- Statistik Inventaris --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

            {{-- Produk Aktif --}}
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">

                <div class="flex justify-between items-center">

                    <div>

                        <p class="text-sm text-slate-500">

                            Produk Aktif

                        </p>

                        <h2 class="text-4xl font-bold text-emerald-600 mt-3">

                            {{ $activeProducts }}

                        </h2>

                    </div>

                    <div class="w-16 h-16 rounded-2xl bg-emerald-100 flex items-center justify-center">

                        <i class="fa-solid fa-box-open text-emerald-600 text-2xl"></i>

                    </div>

                </div>

            </div>

            {{-- Produk Nonaktif --}}
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">

                <div class="flex justify-between items-center">

                    <div>

                        <p class="text-sm text-slate-500">

                            Produk Nonaktif

                        </p>

                        <h2 class="text-4xl font-bold text-red-600 mt-3">

                            {{ $inactiveProducts }}

                        </h2>

                    </div>

                    <div class="w-16 h-16 rounded-2xl bg-red-100 flex items-center justify-center">

                        <i class="fa-solid fa-box text-red-600 text-2xl"></i>

                    </div>

                </div>

            </div>

            {{-- Total Stok --}}
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">

                <div class="flex justify-between items-center">

                    <div>

                        <p class="text-sm text-slate-500">

                            Total Stok

                        </p>

                        <h2 class="text-4xl font-bold text-blue-600 mt-3">

                            {{ $totalStock }}

                        </h2>

                    </div>

                    <div class="w-16 h-16 rounded-2xl bg-blue-100 flex items-center justify-center">

                        <i class="fa-solid fa-warehouse text-blue-600 text-2xl"></i>

                    </div>

                </div>

            </div>

            {{-- Rental Selesai --}}
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">

                <div class="flex justify-between items-center">

                    <div>

                        <p class="text-sm text-slate-500">

                            Rental Selesai

                        </p>

                        <h2 class="text-4xl font-bold text-purple-600 mt-3">

                            {{ $returnedOrders }}

                        </h2>

                    </div>

                    <div class="w-16 h-16 rounded-2xl bg-purple-100 flex items-center justify-center">

                        <i class="fa-solid fa-circle-check text-purple-600 text-2xl"></i>

                    </div>

                </div>

            </div>

        </div>

        {{-- Monitoring Inventaris --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

            {{-- Barang Perlu Servis --}}
            <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-2xl p-6 text-white shadow-lg">

                <div class="flex justify-between items-center">

                    <div>

                        <p class="text-red-100">

                            Barang Perlu Servis

                        </p>

                        <h2 class="text-4xl font-bold mt-3">

                            {{ $serviceItems }}

                        </h2>

                    </div>

                    <i class="fa-solid fa-screwdriver-wrench text-5xl text-red-200"></i>

                </div>

            </div>

            {{-- Barang Rusak --}}
            <div class="bg-gradient-to-br from-amber-500 to-orange-500 rounded-2xl p-6 text-white shadow-lg">

                <div class="flex justify-between items-center">

                    <div>

                        <p class="text-amber-100">

                            Barang Rusak

                        </p>

                        <h2 class="text-4xl font-bold mt-3">

                            {{ $damagedItems }}

                        </h2>

                    </div>

                    <i class="fa-solid fa-triangle-exclamation text-5xl text-amber-200"></i>

                </div>

            </div>

            {{-- Barang Hilang --}}
            <div class="bg-gradient-to-br from-slate-700 to-slate-900 rounded-2xl p-6 text-white shadow-lg">

                <div class="flex justify-between items-center">

                    <div>

                        <p class="text-slate-200">

                            Barang Hilang

                        </p>

                        <h2 class="text-4xl font-bold mt-3">

                            {{ $lostItems }}

                        </h2>

                    </div>

                    <i class="fa-solid fa-box-open text-5xl text-slate-300"></i>

                </div>

            </div>

            {{-- Deposit Belum Dikembalikan --}}
            <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl p-6 text-white shadow-lg">

                <div class="flex justify-between items-center">

                    <div>

                        <p class="text-blue-100">

                            Deposit Belum Dikembalikan

                        </p>

                        <h2 class="text-2xl font-bold mt-3">

                            Rp {{ number_format($unreturnedDeposit, 0, ',', '.') }}

                        </h2>

                    </div>

                    <i class="fa-solid fa-wallet text-5xl text-blue-200"></i>

                </div>

            </div>

        </div>

        {{-- Ringkasan Keuangan --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

            <div class="px-6 py-5 border-b border-slate-200">

                <h2 class="text-xl font-bold text-slate-800">

                    Ringkasan Keuangan

                </h2>

                <p class="text-sm text-slate-500 mt-1">

                    Ringkasan arus kas dan pendapatan sistem rental.

                </p>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4">

                {{-- Pendapatan Rental --}}
                <div class="p-6 border-r border-b border-slate-200">

                    <p class="text-sm text-slate-500">

                        Pendapatan Rental

                    </p>

                    <h3 class="text-2xl font-bold text-emerald-600 mt-3">

                        Rp {{ number_format($totalRevenue, 0, ',', '.') }}

                    </h3>

                </div>

                {{-- Deposit Masuk --}}
                <div class="p-6 border-r border-b border-slate-200">

                    <p class="text-sm text-slate-500">

                        Deposit Masuk

                    </p>

                    <h3 class="text-2xl font-bold text-blue-600 mt-3">

                        Rp {{ number_format($totalDeposit, 0, ',', '.') }}

                    </h3>

                </div>

                {{-- Deposit Dikembalikan --}}
                <div class="p-6 border-r border-b border-slate-200">

                    <p class="text-sm text-slate-500">

                        Deposit Dikembalikan

                    </p>

                    <h3 class="text-2xl font-bold text-orange-600 mt-3">

                        Rp {{ number_format($depositReturned, 0, ',', '.') }}

                    </h3>

                </div>

                {{-- Total Kas Masuk --}}
                <div class="p-6 border-b border-slate-200">

                    <p class="text-sm text-slate-500">

                        Total Kas Masuk

                    </p>

                    <h3 class="text-2xl font-bold text-indigo-600 mt-3">

                        Rp {{ number_format($totalCashIn, 0, ',', '.') }}

                    </h3>

                </div>

                {{-- Denda Keterlambatan --}}
                <div class="p-6 border-r border-slate-200">

                    <p class="text-sm text-slate-500">

                        Denda Keterlambatan

                    </p>

                    <h3 class="text-xl font-bold text-red-600 mt-3">

                        Rp {{ number_format($totalLateFee, 0, ',', '.') }}

                    </h3>

                </div>

                {{-- Denda Barang Hilang --}}
                <div class="p-6 border-r border-slate-200">

                    <p class="text-sm text-slate-500">

                        Denda Barang Hilang

                    </p>

                    <h3 class="text-xl font-bold text-red-600 mt-3">

                        Rp {{ number_format($totalMissingFee, 0, ',', '.') }}

                    </h3>

                </div>

                {{-- Denda Kerusakan --}}
                <div class="p-6 border-r border-slate-200">

                    <p class="text-sm text-slate-500">

                        Denda Kerusakan

                    </p>

                    <h3 class="text-xl font-bold text-red-600 mt-3">

                        Rp {{ number_format($totalDamagePenalty, 0, ',', '.') }}

                    </h3>

                </div>

                {{-- Total Denda --}}
                <div class="p-6">

                    <p class="text-sm text-slate-500">

                        Total Denda

                    </p>

                    <h3 class="text-2xl font-bold text-red-700 mt-3">

                        Rp {{ number_format($totalPenalty, 0, ',', '.') }}

                    </h3>

                </div>

            </div>

        </div>

        {{-- Informasi Operasional --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Ringkasan Sistem --}}
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">

                <h3 class="font-semibold text-slate-800 mb-5">
                    Ringkasan Sistem
                </h3>

                <div class="space-y-4">

                    <div class="flex justify-between">
                        <span class="text-slate-500">Produk Aktif</span>
                        <span class="font-semibold">{{ $totalProducts }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-slate-500">Customer</span>
                        <span class="font-semibold">{{ $totalCustomers }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-slate-500">Total Rental</span>
                        <span class="font-semibold">{{ $totalOrders }}</span>
                    </div>

                </div>

            </div>

            {{-- Status Rental --}}
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">

                <h3 class="font-semibold text-slate-800 mb-5">
                    Status Rental
                </h3>

                <div class="space-y-4">

                    <div class="flex justify-between">
                        <span class="text-slate-500">Pending</span>
                        <span class="font-semibold text-orange-600">
                            {{ $pendingOrders }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-slate-500">Paid</span>
                        <span class="font-semibold text-emerald-600">
                            {{ $paidOrders }}
                        </span>
                    </div>

                </div>

            </div>

            {{-- Keuangan --}}
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">

                <h3 class="font-semibold text-slate-800 mb-5">
                    Keuangan
                </h3>

                <div class="space-y-4">

                    <div class="flex justify-between">

                        <span class="text-slate-500">
                            Pendapatan Sewa
                        </span>

                        <span class="font-semibold text-emerald-600">
                            Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                        </span>

                    </div>

                    <div class="flex justify-between">

                        <span class="text-slate-500">
                            Deposit Diterima
                        </span>

                        <span class="font-semibold text-sky-600">
                            Rp {{ number_format($totalDeposit, 0, ',', '.') }}
                        </span>

                    </div>

                    <div class="flex justify-between">

                        <span class="text-slate-500">
                            Pendapatan Denda
                        </span>

                        <span class="font-semibold text-amber-600">
                            Rp {{ number_format($totalPenalty, 0, ',', '.') }}
                        </span>

                    </div>

                    <div class="flex justify-between">

                        <span class="text-slate-500">
                            Deposit Belum Dikembalikan
                        </span>

                        <span class="font-semibold text-rose-600">
                            Rp {{ number_format($unreturnedDeposit, 0, ',', '.') }}
                        </span>

                    </div>

                    <hr>

                    <div class="flex justify-between">

                        <span class="font-semibold text-slate-700">
                            Total Uang Masuk
                        </span>

                        <span class="font-bold text-violet-600">
                            Rp {{ number_format($totalCashIn, 0, ',', '.') }}
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection