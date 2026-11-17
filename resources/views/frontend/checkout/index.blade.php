@extends('layouts.app')

@section('content')

<div class="bg-slate-50 min-h-screen">

    {{-- Header --}}
    <section class="bg-gradient-to-r from-emerald-800 to-green-700 text-white">

        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-14">

            <h1 class="text-4xl font-bold">
                Checkout Rental
            </h1>

            <p class="mt-3 text-emerald-100">
                Lengkapi data penyewaan untuk melanjutkan proses pemesanan.
            </p>

        </div>

    </section>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-10">

        @if ($errors->any())

            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 rounded-2xl p-5">

                <h3 class="font-semibold mb-2">
                    Terdapat kesalahan:
                </h3>

                <ul class="list-disc list-inside space-y-1">

                    @foreach($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        @php
            $total = 0;
        @endphp

        @foreach($cart->items as $item)
            @php
                $total += $item->subtotal;
            @endphp
        @endforeach

        @php
            $deposit = 100000;
            $grandTotal = $total + $deposit;
        @endphp

        <div class="grid lg:grid-cols-3 gap-8">

            {{-- FORM --}}
            <div class="lg:col-span-2">

                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

                    <div class="px-8 py-6 border-b border-slate-200">

                        <h2 class="text-2xl font-bold text-slate-800">
                            Data Penyewa
                        </h2>

                        <p class="text-slate-500 mt-1">
                            Pastikan data yang dimasukkan sesuai identitas asli.
                        </p>

                    </div>

                    <form
                        action="/checkout"
                        method="POST"
                        enctype="multipart/form-data"
                        class="p-8">

                        @csrf

                        {{-- Nama --}}
                        <div class="mb-6">

                            <label class="block text-sm font-medium text-slate-700 mb-2">

                                Nama Lengkap

                            </label>

                            <input
                                type="text"
                                name="customer_name"
                                value="{{ old('customer_name') }}"
                                class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500"
                                placeholder="Masukkan nama lengkap">

                        </div>

                        {{-- WhatsApp --}}
                        <div class="mb-6">

                            <label class="block text-sm font-medium text-slate-700 mb-2">

                                Nomor WhatsApp

                            </label>

                            <input
                                type="number"
                                name="phone"
                                value="{{ old('phone') }}"
                                class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500"
                                placeholder="08xxxxxxxxxx">

                        </div>

                        {{-- Alamat --}}
                        <div class="mb-6">

                            <label class="block text-sm font-medium text-slate-700 mb-2">

                                Alamat Lengkap

                            </label>

                            <textarea
                                name="address"
                                rows="4"
                                class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500"
                                placeholder="Masukkan alamat lengkap">{{ old('address') }}</textarea>

                        </div>

                        {{-- Upload Identitas --}}
                        <div class="mb-6">

                            <label class="block text-sm font-medium text-slate-700 mb-2">

                                Upload KTP / SIM

                            </label>

                            <input
                                type="file"
                                name="identity_card"
                                id="identity_card"
                                accept="image/*"
                                class="block w-full rounded-xl border border-slate-300 p-3">

                            <p class="text-xs text-slate-500 mt-2">
                                File digunakan untuk verifikasi penyewaan dan tidak dibagikan ke pihak lain.
                            </p>

                            <div
                                id="previewContainer"
                                class="hidden mt-4">

                                <img
                                    id="previewImage"
                                    class="w-64 rounded-2xl border border-slate-200">

                            </div>

                        </div>

                        {{-- Informasi --}}
                        <div class="bg-blue-50 border border-blue-200 rounded-2xl p-5 mb-8">

                            <div class="flex gap-3">

                                <i class="fa-solid fa-circle-info text-blue-600 mt-1"></i>

                                <div>

                                    <h3 class="font-semibold text-blue-800">
                                        Informasi Penyewaan
                                    </h3>

                                    <p class="text-sm text-blue-700 mt-1">
                                        Deposit akan dikembalikan setelah seluruh barang dikembalikan dan lolos proses validasi.
                                    </p>

                                </div>

                            </div>

                        </div>

                        <button
                            type="submit"
                            class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-4 rounded-2xl font-semibold transition">

                            Buat Pesanan

                        </button>

                    </form>

                </div>

            </div>

            {{-- SUMMARY --}}
            <div>

                <div class="sticky top-24">

                    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

                        <div class="px-6 py-5 border-b border-slate-200">

                            <h2 class="text-xl font-bold text-slate-800">
                                Ringkasan Rental
                            </h2>

                        </div>

                        <div class="p-6">

                            <div class="space-y-5">

                                @foreach($cart->items as $item)

                                    <div class="flex justify-between gap-4">

                                        <div>

                                            <h4 class="font-semibold text-slate-800">

                                                {{ $item->product->name }}

                                            </h4>

                                            <p class="text-sm text-slate-500">

                                                {{ $item->qty }} Unit

                                            </p>

                                        </div>

                                        <div class="font-semibold text-slate-700">

                                            Rp {{ number_format($item->subtotal,0,',','.') }}

                                        </div>

                                    </div>

                                @endforeach

                            </div>

                            <hr class="my-6">

                            <div class="space-y-3">

                                <div class="flex justify-between">

                                    <span class="text-slate-500">
                                        Total Rental
                                    </span>

                                    <span class="font-semibold">
                                        Rp {{ number_format($total,0,',','.') }}
                                    </span>

                                </div>

                                <div class="flex justify-between">

                                    <span class="text-slate-500">
                                        Deposit
                                    </span>

                                    <span class="font-semibold text-blue-600">
                                        Rp {{ number_format($deposit,0,',','.') }}
                                    </span>

                                </div>

                            </div>

                            <hr class="my-6">

                            <div class="flex justify-between items-center">

                                <span class="text-lg font-bold text-slate-800">

                                    Grand Total

                                </span>

                                <span class="text-3xl font-bold text-emerald-600">

                                    Rp {{ number_format($grandTotal,0,',','.') }}

                                </span>

                            </div>

                            <div class="mt-6 bg-amber-50 border border-amber-200 rounded-2xl p-4">

                                <div class="flex gap-3">

                                    <i class="fa-solid fa-shield-halved text-amber-600 mt-1"></i>

                                    <p class="text-sm text-amber-700">

                                        Deposit digunakan sebagai jaminan selama masa penyewaan dan akan dikembalikan sesuai hasil validasi pengembalian.

                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

{{-- Preview Upload --}}
<script>

document.getElementById('identity_card').addEventListener('change', function(e) {

    const file = e.target.files[0];

    if (!file) return;

    const reader = new FileReader();

    reader.onload = function(event) {

        document.getElementById('previewImage').src = event.target.result;

        document.getElementById('previewContainer').classList.remove('hidden');

    };

    reader.readAsDataURL(file);

});

</script>

@endsection