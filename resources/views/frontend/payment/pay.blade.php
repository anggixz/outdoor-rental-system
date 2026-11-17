@extends('layouts.app')

@section('content')

<div class="bg-slate-50 min-h-screen">

    {{-- Header --}}
    <section class="bg-gradient-to-r from-emerald-800 to-green-700 text-white">

        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-14">

            <h1 class="text-4xl font-bold">
                Pembayaran Rental
            </h1>

            <p class="mt-3 text-emerald-100">
                Selesaikan pembayaran untuk mengonfirmasi pesanan rental Anda.
            </p>

        </div>

    </section>

    <div class="max-w-5xl mx-auto px-6 lg:px-8 py-10">

        <div class="grid lg:grid-cols-2 gap-8">

            {{-- Detail Pembayaran --}}
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

                <div class="p-8">

                    <div class="flex items-center gap-3 mb-6">

                        <div class="w-14 h-14 rounded-2xl bg-amber-100 flex items-center justify-center">

                            <i class="fa-solid fa-clock text-amber-600 text-xl"></i>

                        </div>

                        <div>

                            <h2 class="text-xl font-bold text-slate-800">
                                Menunggu Pembayaran
                            </h2>

                            <p class="text-slate-500 text-sm">
                                Pesanan akan diproses setelah pembayaran berhasil.
                            </p>

                        </div>

                    </div>

                    <div class="space-y-6">

                        <div>

                            <p class="text-sm text-slate-500 mb-1">
                                Nomor Invoice
                            </p>

                            <p class="text-2xl font-bold text-slate-800 break-all">
                                {{ $order->invoice_number }}
                            </p>

                        </div>

                        <div>

                            <p class="text-sm text-slate-500 mb-1">
                                Nama Penyewa
                            </p>

                            <p class="font-semibold text-slate-800">
                                {{ $order->customer_name }}
                            </p>

                        </div>

                        <div>

                            <p class="text-sm text-slate-500 mb-1">
                                Status Pembayaran
                            </p>

                            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-yellow-100 text-yellow-700 font-medium">

                                <i class="fa-solid fa-hourglass-half"></i>

                                Pending

                            </span>

                        </div>

                    </div>

                </div>

            </div>

            {{-- Ringkasan --}}
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

                <div class="p-8">

                    <h2 class="text-xl font-bold text-slate-800 mb-6">
                        Ringkasan Pembayaran
                    </h2>

                    <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-6">

                        <p class="text-sm text-emerald-700">
                            Total yang harus dibayar
                        </p>

                        <h3 class="text-5xl font-bold text-emerald-600 mt-3">

                            Rp {{ number_format($order->grand_total, 0, ',', '.') }}

                        </h3>

                    </div>

                    <div class="mt-6 space-y-4">

                        <div class="flex justify-between">

                            <span class="text-slate-500">
                                Invoice
                            </span>

                            <span class="font-medium text-slate-800">
                                {{ $order->invoice_number }}
                            </span>

                        </div>

                        <div class="flex justify-between">

                            <span class="text-slate-500">
                                Penyewa
                            </span>

                            <span class="font-medium text-slate-800">
                                {{ $order->customer_name }}
                            </span>

                        </div>

                    </div>

                    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-2xl p-5">

                        <div class="flex gap-3">

                            <i class="fa-solid fa-shield-halved text-blue-600 mt-1"></i>

                            <div>

                                <h4 class="font-semibold text-blue-800">
                                    Pembayaran Aman
                                </h4>

                                <p class="text-sm text-blue-700 mt-1">
                                    Pembayaran diproses melalui Midtrans dan mendukung transfer bank, QRIS, e-wallet, kartu kredit, dan metode pembayaran lainnya.
                                </p>

                            </div>

                        </div>

                    </div>

                    <button
                        id="pay-button"
                        class="w-full mt-8 bg-emerald-600 hover:bg-emerald-700 text-white py-5 rounded-2xl text-lg font-semibold transition">

                        <i class="fa-solid fa-credit-card mr-2"></i>

                        Bayar Sekarang

                    </button>

                </div>

            </div>

        </div>

    </div>

</div>

<script
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.client_key') }}">
</script>

<script>

document
.getElementById('pay-button')
.addEventListener('click', function () {

    snap.pay('{{ $snapToken }}', {

        onSuccess: function(result) {

            window.location.href =
                '/orders/{{ $order->id }}';

        },

        onPending: function(result) {

            window.location.href =
                '/orders/{{ $order->id }}';

        },

        onError: function(result) {

            alert('Pembayaran gagal. Silakan coba kembali.');

        }

    });

});

</script>

@endsection