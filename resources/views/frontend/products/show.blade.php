@extends('layouts.app')

@section('content')

<div class="bg-slate-50 min-h-screen">

    {{-- Breadcrumb --}}
    <div class="bg-white border-b border-slate-200">

        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-4">

            <div class="flex items-center gap-2 text-sm">

                <a href="/"
                    class="text-slate-500 hover:text-emerald-600">

                    Home

                </a>

                <span class="text-slate-400">/</span>

                <a href="/products"
                    class="text-slate-500 hover:text-emerald-600">

                    Produk

                </a>

                <span class="text-slate-400">/</span>

                <span class="text-slate-800 font-medium">

                    {{ $product->name }}

                </span>

            </div>

        </div>

    </div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-10">

        <div class="grid lg:grid-cols-2 gap-10">

            {{-- Gambar --}}
            <div>

                <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">

                    @if($product->thumbnail)

                        <img
                            src="{{ asset('storage/' . $product->thumbnail) }}"
                            alt="{{ $product->name }}"
                            class="w-full h-[550px] object-cover">

                    @else

                        <div class="h-[550px] flex items-center justify-center bg-slate-100">

                            <i class="fa-solid fa-image text-7xl text-slate-300"></i>

                        </div>

                    @endif

                </div>

            </div>

            {{-- Informasi Produk --}}
            <div>

                <div class="flex flex-wrap gap-3 mb-4">

                    <span class="px-4 py-2 rounded-full bg-emerald-100 text-emerald-700 text-sm font-semibold">

                        {{ $product->category->name }}

                    </span>

                    @if($product->stock > 10)

                        <span class="px-4 py-2 rounded-full bg-green-100 text-green-700 text-sm font-semibold">

                            Ready Stock

                        </span>

                    @elseif($product->stock > 0)

                        <span class="px-4 py-2 rounded-full bg-yellow-100 text-yellow-700 text-sm font-semibold">

                            Stok Terbatas

                        </span>

                    @else

                        <span class="px-4 py-2 rounded-full bg-red-100 text-red-700 text-sm font-semibold">

                            Habis

                        </span>

                    @endif

                </div>

                <h1 class="text-4xl lg:text-5xl font-bold text-slate-800">

                    {{ $product->name }}

                </h1>

                <div class="mt-6">

                    <div class="text-sm text-slate-500">

                        Harga Sewa

                    </div>

                    <div class="text-5xl font-bold text-emerald-600 mt-2">

                        Rp {{ number_format($product->price_per_day,0,',','.') }}

                    </div>

                    <div class="text-slate-500 mt-1">

                        per hari

                    </div>

                </div>

                <div class="mt-8 bg-white rounded-2xl border border-slate-200 p-5">

                    <div class="flex justify-between">

                        <span class="text-slate-500">
                            Stok
                        </span>

                        <span class="font-semibold">
                            {{ $product->stock }} Unit
                        </span>

                    </div>

                </div>

                <div class="mt-8 bg-white rounded-2xl border border-slate-200 p-6">

                    <h2 class="text-xl font-bold text-slate-800 mb-4">

                        Deskripsi Produk

                    </h2>

                    <p class="leading-relaxed text-slate-600">

                        {{ $product->description }}

                    </p>

                </div>

            </div>

        </div>

        {{-- Alert --}}
        @if(session('success'))

            <div class="mt-8 bg-green-50 border border-green-200 text-green-700 p-5 rounded-2xl">

                {{ session('success') }}

            </div>

        @endif

        @if(session('error'))

            <div class="mt-8 bg-red-50 border border-red-200 text-red-700 p-5 rounded-2xl">

                {{ session('error') }}

            </div>

        @endif

        {{-- Form Rental --}}
        <div class="mt-10 bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

            <div class="px-8 py-6 border-b border-slate-200">

                <h2 class="text-2xl font-bold text-slate-800">

                    Sewa Produk

                </h2>

            </div>

            <form
                action="/cart/{{ $product->id }}"
                method="POST"
                class="p-8">

                @csrf

                <div class="grid md:grid-cols-3 gap-6">

                    <div>

                        <label class="block text-sm font-medium mb-2">

                            Tanggal Mulai

                        </label>

                        <input
                            type="text"
                            name="start_date"
                            id="start_date"
                            class="w-full rounded-xl border-slate-300">

                    </div>

                    <div>

                        <label class="block text-sm font-medium mb-2">

                            Tanggal Selesai

                        </label>

                        <input
                            type="text"
                            name="end_date"
                            id="end_date"
                            class="w-full rounded-xl border-slate-300">

                    </div>

                    <div>

                        <label class="block text-sm font-medium mb-2">

                            Jumlah

                        </label>

                        <input
                            type="number"
                            name="qty"
                            id="qty"
                            value="1"
                            min="1"
                            class="w-full rounded-xl border-slate-300">

                    </div>

                </div>

                <div
                    id="availability_box"
                    class="hidden mt-6 p-4 rounded-xl">

                </div>

                <div class="mt-8 bg-emerald-50 border border-emerald-200 rounded-2xl p-6">

                    <div class="text-sm text-slate-500">

                        Estimasi Total Biaya

                    </div>

                    <div
                        id="total_price"
                        class="text-4xl font-bold text-emerald-700 mt-2">

                        Rp 0

                    </div>

                </div>

                <button
                    type="submit"
                    class="w-full mt-8 bg-emerald-600 hover:bg-emerald-700 text-white py-4 rounded-2xl font-semibold transition">

                    <i class="fa-solid fa-cart-shopping mr-2"></i>

                    Tambah ke Keranjang

                </button>

            </form>

        </div>

    </div>

</div>

{{-- SCRIPT ASLI TETAP DIPAKAI --}}
<script>

const pricePerDay = {{ $product->price_per_day }}

const startDate = document.getElementById('start_date')
const endDate = document.getElementById('end_date')
const qty = document.getElementById('qty')
const totalPrice = document.getElementById('total_price')

function calculateTotal() {

    if (startDate.value && endDate.value) {

        const startParts = startDate.value.split("-")
        const endParts = endDate.value.split("-")

        const start = new Date(
            startParts[2],
            startParts[1] - 1,
            startParts[0]
        )

        const end = new Date(
            endParts[2],
            endParts[1] - 1,
            endParts[0]
        )

        const diffTime =
            end.getTime() - start.getTime()

        const days = Math.ceil(
            diffTime / (1000 * 60 * 60 * 24)
        )

        if (days <= 0) {

            totalPrice.innerHTML =
                'Tanggal tidak valid'

            return
        }

        const total =
            days *
            pricePerDay *
            qty.value

        totalPrice.innerHTML =
            'Rp ' +
            Number(total)
            .toLocaleString('id-ID')
    }

}

startDate.addEventListener('change', calculateTotal)
endDate.addEventListener('change', calculateTotal)
qty.addEventListener('input', calculateTotal)

</script>

<script>

document.addEventListener('DOMContentLoaded', function () {

    flatpickr("#start_date", {
        dateFormat: "d-m-Y",
        minDate: "today"
    });

    flatpickr("#end_date", {
        dateFormat: "d-m-Y",
        minDate: "today"
    });

});

</script>

<script>

const availabilityBox =
    document.getElementById(
        'availability_box'
    )

async function checkAvailability() {

    if (
        !startDate.value ||
        !endDate.value
    ) {
        return
    }

    const startParts =
        startDate.value.split("-")

    const endParts =
        endDate.value.split("-")

    const start =
        startParts[2] + "-" +
        startParts[1] + "-" +
        startParts[0]

    const end =
        endParts[2] + "-" +
        endParts[1] + "-" +
        endParts[0]

    const response =
        await fetch(
            '/products/{{ $product->id }}/availability?' +
            new URLSearchParams({
                start_date: start,
                end_date: end
            })
        )

    const data =
        await response.json()

    qty.max =
        data.available_stock

    availabilityBox.classList.remove(
        'hidden'
    )

    if (data.available_stock > 0) {

        availabilityBox.className =
            'bg-green-50 border border-green-200 text-green-700 mt-6 p-4 rounded-xl'

        availabilityBox.innerHTML =
            '✓ Tersedia ' +
            data.available_stock +
            ' unit pada tanggal tersebut'

    } else {

        availabilityBox.className =
            'bg-red-50 border border-red-200 text-red-700 mt-6 p-4 rounded-xl'

        availabilityBox.innerHTML =
            '✕ Produk tidak tersedia pada tanggal tersebut'

    }

}

startDate.addEventListener(
    'change',
    checkAvailability
)

endDate.addEventListener(
    'change',
    checkAvailability
)

</script>

@endsection