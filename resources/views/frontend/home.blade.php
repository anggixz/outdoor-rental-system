@extends('layouts.app')

@section('content')

{{-- HERO --}}
<section class="relative overflow-hidden bg-gradient-to-br from-emerald-900 via-green-800 to-emerald-700 text-white">

    <div class="absolute inset-0 bg-black/20"></div>

    <div class="relative max-w-7xl mx-auto px-6 lg:px-8 py-24 lg:py-32">

        <div class="grid lg:grid-cols-2 gap-12 items-center">

            <div>

                <span class="inline-flex items-center gap-2 bg-white/10 border border-white/20 px-4 py-2 rounded-full text-sm mb-6">

                    <i class="fa-solid fa-mountain"></i>

                    Rental Alat Camping & Outdoor

                </span>

                <h1 class="text-5xl lg:text-7xl font-extrabold leading-tight">

                    Jelajahi Alam

                    <span class="text-emerald-300">
                        Tanpa Ribet
                    </span>

                </h1>

                <p class="mt-6 text-lg lg:text-xl text-emerald-100 max-w-2xl">

                    Sewa tenda, carrier, sleeping bag, kompor portable dan berbagai perlengkapan outdoor berkualitas dengan proses cepat, aman dan terpercaya.

                </p>

                <div class="flex flex-col sm:flex-row gap-4 mt-10">

                    <a href="/products"
                        class="inline-flex items-center justify-center gap-3 bg-white text-emerald-700 hover:bg-slate-100 px-8 py-4 rounded-2xl font-semibold transition">

                        <i class="fa-solid fa-tent"></i>

                        Mulai Sewa

                    </a>

                    <a href="#produk"
                        class="inline-flex items-center justify-center gap-3 border border-white/30 hover:bg-white/10 px-8 py-4 rounded-2xl font-semibold transition">

                        <i class="fa-solid fa-arrow-down"></i>

                        Lihat Produk

                    </a>

                </div>

            </div>

            <div class="hidden lg:block">

                <div class="bg-white/10 backdrop-blur-lg border border-white/20 rounded-3xl p-8">

                    <div class="grid grid-cols-2 gap-5">

                        <div class="bg-white/10 rounded-2xl p-6">

                            <i class="fa-solid fa-tent text-3xl text-emerald-300"></i>

                            <h3 class="font-bold mt-4">
                                Tenda
                            </h3>

                        </div>

                        <div class="bg-white/10 rounded-2xl p-6">

                            <i class="fa-solid fa-briefcase text-3xl text-emerald-300"></i>

                            <h3 class="font-bold mt-4">
                                Carrier
                            </h3>

                        </div>

                        <div class="bg-white/10 rounded-2xl p-6">

                            <i class="fa-solid fa-fire text-3xl text-emerald-300"></i>

                            <h3 class="font-bold mt-4">
                                Kompor
                            </h3>

                        </div>

                        <div class="bg-white/10 rounded-2xl p-6">

                            <i class="fa-solid fa-moon text-3xl text-emerald-300"></i>

                            <h3 class="font-bold mt-4">
                                Sleeping Bag
                            </h3>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

{{-- STATISTIK --}}
<section class="bg-white">

    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-14">

        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">

            <div class="text-center">

                <h3 class="text-4xl font-bold text-emerald-600">
                    {{ $totalProducts }}+
                </h3>

                <p class="text-slate-500 mt-2">
                    Produk Rental
                </p>

            </div>

            <div class="text-center">

                <h3 class="text-4xl font-bold text-emerald-600">
                    {{ $totalCustomers }}+
                </h3>

                <p class="text-slate-500 mt-2">
                    Customer
                </p>

            </div>

            <div class="text-center">

                <h3 class="text-4xl font-bold text-emerald-600">
                    {{ $totalOrders }}+
                </h3>

                <p class="text-slate-500 mt-2">
                    Transaksi
                </p>

            </div>

            <div class="text-center">

                <h3 class="text-4xl font-bold text-emerald-600">
                    100%
                </h3>

                <p class="text-slate-500 mt-2">
                    Produk Terawat
                </p>

            </div>

        </div>

    </div>

</section>

{{-- KATEGORI --}}
<section class="py-20 bg-slate-50">

    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        <div class="text-center mb-12">

            <h2 class="text-4xl font-bold text-slate-800">
                Kategori Produk
            </h2>

            <p class="text-slate-500 mt-3">
                Berbagai perlengkapan outdoor untuk petualanganmu.
            </p>

        </div>

        <div class="grid md:grid-cols-3 lg:grid-cols-6 gap-6">

            @foreach($categories as $category)

                <div class="bg-white rounded-2xl p-6 text-center border border-slate-200 hover:border-emerald-500 hover:-translate-y-1 transition">

                    <i class="fa-solid fa-campground text-3xl text-emerald-600"></i>

                    <h3 class="font-semibold mt-4">
                        {{ $category->name }}
                    </h3>

                    <p class="text-sm text-slate-500 mt-1">
                        {{ $category->products_count }} Produk
                    </p>

                </div>

            @endforeach

        </div>

    </div>

</section>

{{-- PRODUK --}}
<section id="produk" class="py-20 bg-white">

    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        <div class="flex justify-between items-center mb-10">

            <div>

                <h2 class="text-4xl font-bold text-slate-800">
                    Produk Terbaru
                </h2>

                <p class="text-slate-500 mt-2">
                    Siap menemani petualanganmu.
                </p>

            </div>

            <a href="/products"
                class="text-emerald-600 font-semibold">

                Lihat Semua

            </a>

        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">

            @foreach($products as $product)

                <div class="bg-white border border-slate-200 rounded-3xl overflow-hidden shadow-sm hover:shadow-lg transition">

                    <img
                        src="{{ asset('storage/' . $product->thumbnail) }}"
                        class="w-full h-56 object-cover">

                    <div class="p-6">

                        <h3 class="font-bold text-lg text-slate-800">
                            {{ $product->name }}
                        </h3>

                        <p class="text-emerald-600 font-bold text-xl mt-3">
                            Rp {{ number_format($product->price_per_day,0,',','.') }}/hari
                        </p>

                        <a href="/products/{{ $product->slug }}"
                            class="block mt-5 text-center bg-emerald-600 hover:bg-emerald-700 text-white py-3 rounded-xl">

                            Lihat Detail

                        </a>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</section>

{{-- KEUNGGULAN --}}
<section class="bg-slate-50 py-20">

    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        <div class="text-center mb-16">

            <h2 class="text-4xl font-bold text-slate-800">
                Kenapa Memilih Kami?
            </h2>

        </div>

        <div class="grid md:grid-cols-3 gap-8">

            <div class="bg-white rounded-3xl p-8 border border-slate-200">

                <i class="fa-solid fa-shield-halved text-4xl text-emerald-600"></i>

                <h3 class="text-xl font-bold mt-5">
                    Aman & Terpercaya
                </h3>

            </div>

            <div class="bg-white rounded-3xl p-8 border border-slate-200">

                <i class="fa-solid fa-bolt text-4xl text-emerald-600"></i>

                <h3 class="text-xl font-bold mt-5">
                    Proses Cepat
                </h3>

            </div>

            <div class="bg-white rounded-3xl p-8 border border-slate-200">

                <i class="fa-solid fa-award text-4xl text-emerald-600"></i>

                <h3 class="text-xl font-bold mt-5">
                    Kualitas Terbaik
                </h3>

            </div>

        </div>

    </div>

</section>

{{-- CTA --}}
<section class="bg-emerald-700 text-white py-20">

    <div class="max-w-4xl mx-auto text-center px-6">

        <h2 class="text-4xl font-bold">

            Siap Memulai Petualangan?

        </h2>

        <p class="mt-5 text-lg text-emerald-100">

            Temukan perlengkapan outdoor terbaik dan mulai perjalananmu hari ini.

        </p>

        <a href="/products"
            class="inline-flex items-center gap-3 mt-8 bg-white text-emerald-700 px-8 py-4 rounded-2xl font-semibold hover:bg-slate-100 transition">

            <i class="fa-solid fa-arrow-right"></i>

            Lihat Semua Produk

        </a>

    </div>

</section>

@endsection