@extends('layouts.admin')

@section('content')

    <div class="space-y-8">

        {{-- Header --}}
        <div class="flex items-center justify-between">

            <div>

                <h1 class="text-3xl font-bold text-slate-800">

                    Detail Rental

                </h1>

                <p class="text-slate-500 mt-2">

                    Invoice {{ $order->invoice_number }}

                </p>

            </div>

            <a href="/admin/orders"
                class="inline-flex items-center gap-2 px-5 py-3 rounded-xl border border-slate-300 hover:bg-slate-100 transition">

                <i class="fa-solid fa-arrow-left"></i>

                Kembali

            </a>

        </div>

        {{-- Alert --}}
        @if(session('success'))

            <div class="rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4">

                {{ session('success') }}

            </div>

        @endif

        @if($errors->any())

            <div class="rounded-2xl bg-red-50 border border-red-200 px-5 py-4">

                <ul class="list-disc ml-5 text-red-600">

                    @foreach($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        {{-- Informasi Rental --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">

                <h2 class="font-bold text-slate-800 mb-5">

                    Informasi Penyewa

                </h2>

                <div class="space-y-4">

                    <div class="flex justify-between">

                        <span class="text-slate-500">

                            Nama

                        </span>

                        <span class="font-semibold">

                            {{ $order->customer_name }}

                        </span>

                    </div>

                    <div class="flex justify-between">

                        <span class="text-slate-500">

                            Telepon

                        </span>

                        <span>

                            {{ $order->phone }}

                        </span>

                    </div>

                    <div class="flex justify-between">

                        <span class="text-slate-500">

                            Status Pembayaran

                        </span>

                        <span class="font-semibold text-emerald-600">

                            {{ strtoupper($order->payment_status) }}

                        </span>

                    </div>

                    <div class="flex justify-between">

                        <span class="text-slate-500">

                            Status Rental

                        </span>

                        <span class="font-semibold text-blue-600">

                            {{ strtoupper($order->rental_status) }}

                        </span>

                    </div>

                </div>

            </div>

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">

                <h2 class="font-bold text-slate-800 mb-5">

                    Ringkasan Pembayaran

                </h2>

                <div class="space-y-4">

                    <div class="flex justify-between">

                        <span>Total Sewa</span>

                        <span>

                            Rp {{ number_format($order->total_price, 0, ',', '.') }}

                        </span>

                    </div>

                    <div class="flex justify-between">

                        <span>Deposit</span>

                        <span>

                            Rp {{ number_format($order->deposit, 0, ',', '.') }}

                        </span>

                    </div>

                    <div class="flex justify-between font-bold text-lg border-t pt-4">

                        <span>Total Dibayar</span>

                        <span class="text-emerald-600">

                            Rp {{ number_format($order->grand_total, 0, ',', '.') }}

                        </span>

                    </div>

                </div>

            </div>

        </div>
        {{-- Detail Barang Rental --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

            <div class="px-6 py-5 border-b border-slate-200">

                <h2 class="text-lg font-bold text-slate-800">

                    Detail Barang Rental

                </h2>

                <p class="text-sm text-slate-500 mt-1">

                    Daftar seluruh barang yang disewa pada transaksi ini.

                </p>

            </div>

            <div class="overflow-x-auto">

                <table class="min-w-full">

                    <thead class="bg-slate-100">

                        <tr>

                            <th class="px-4 py-3 text-left">

                                Produk

                            </th>

                            <th class="px-4 py-3 text-center">

                                Qty

                            </th>

                            <th class="px-4 py-3 text-center">

                                Tanggal

                            </th>

                            <th class="px-4 py-3 text-right">

                                Harga/Hari

                            </th>

                            <th class="px-4 py-3 text-right">

                                Harga Beli

                            </th>

                            <th class="px-4 py-3 text-right">

                                Subtotal

                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($order->items as $item)

                            <tr class="border-t">

                                <td class="px-4 py-4">

                                    <div class="font-semibold">

                                        {{ $item->product->name }}

                                    </div>

                                    <div class="text-xs text-slate-500 mt-1">

                                        {{ $item->product->category->name }}

                                    </div>

                                </td>

                                <td class="px-4 py-4 text-center">

                                    {{ $item->qty }}

                                </td>

                                <td class="px-4 py-4 text-center text-sm">

                                    {{ \Carbon\Carbon::parse($item->start_date)->format('d M Y') }}

                                    <br>

                                    s/d

                                    <br>

                                    {{ \Carbon\Carbon::parse($item->end_date)->format('d M Y') }}

                                </td>

                                <td class="px-4 py-4 text-right">

                                    Rp {{ number_format($item->price_per_day, 0, ',', '.') }}

                                </td>

                                <td class="px-4 py-4 text-right text-blue-600 font-semibold">

                                    Rp {{ number_format($item->purchase_price, 0, ',', '.') }}

                                </td>

                                <td class="px-4 py-4 text-right font-bold text-emerald-600">

                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>
        {{-- Form Pengembalian --}}
        @if(
                $order->payment_status == \App\Models\Order::PAYMENT_PAID &&
                $order->rental_status != \App\Models\Order::RENTAL_RETURNED
            )

            <form action="/admin/orders/{{ $order->id }}/return" method="POST" enctype="multipart/form-data"
                class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

                @csrf

                <div class="px-6 py-5 border-b border-slate-200">

                    <h2 class="text-lg font-bold text-slate-800">

                        Proses Pengembalian Barang

                    </h2>

                    <p class="text-sm text-slate-500 mt-1">

                        Periksa kondisi setiap barang sebelum menyelesaikan transaksi.

                    </p>

                </div>

                <div class="p-6">

                    @foreach($order->items as $item)

                        <div class="border rounded-2xl p-5 mb-5">

                            <div class="flex items-center justify-between mb-5">

                                <div>

                                    <h3 class="font-bold text-slate-800">

                                        {{ $item->product->name }}

                                    </h3>

                                    <p class="text-sm text-slate-500">

                                        Qty :
                                        {{ $item->qty }}

                                    </p>

                                </div>

                                <div class="text-right">

                                    <div class="text-sm text-slate-500">

                                        Harga Beli

                                    </div>

                                    <div class="font-bold text-blue-600">

                                        Rp {{ number_format($item->purchase_price, 0, ',', '.') }}

                                    </div>

                                </div>

                            </div>

                            <div class="grid md:grid-cols-2 gap-6">

                                {{-- Kondisi --}}
                                <div>

                                    <label class="block font-semibold mb-2">

                                        Kondisi Barang

                                    </label>

                                    <select name="damage_status[{{ $item->id }}]"
                                        class="w-full rounded-xl border-slate-300 damage-status"
                                        data-price="{{ $item->purchase_price }}" data-qty="{{ $item->qty }}"
                                        data-target="penalty-{{ $item->id }}">

                                        <option value="good">
                                            Baik
                                        </option>

                                        <option value="light">
                                            Rusak Ringan (20%)
                                        </option>

                                        <option value="medium">
                                            Rusak Sedang (50%)
                                        </option>

                                        <option value="heavy">
                                            Rusak Berat (100%)
                                        </option>

                                        <option value="lost">
                                            Hilang (100%)
                                        </option>

                                    </select>

                                </div>

                                {{-- Denda --}}
                                <div>

                                    <label class="block font-semibold mb-2">

                                        Estimasi Denda

                                    </label>

                                    <div id="penalty-{{ $item->id }}"
                                        class="h-11 rounded-xl bg-red-50 border border-red-200 flex items-center px-4 font-bold text-red-600">

                                        Rp 0

                                    </div>

                                </div>

                            </div>

                            {{-- Service --}}
                            <div class="mt-5">

                                <label class="inline-flex items-center gap-3">

                                    <input type="checkbox" name="needs_service[{{ $item->id }}]" value="1">

                                    <span>

                                        Barang perlu diservis setelah kembali

                                    </span>

                                </label>

                            </div>

                            {{-- Catatan --}}
                            <div class="mt-5">

                                <label class="block font-semibold mb-2">

                                    Catatan Kerusakan

                                </label>

                                <textarea name="damage_note[{{ $item->id }}]" rows="3" class="w-full rounded-xl border-slate-300"
                                    placeholder="Contoh: Resleting rusak, frame penyok, kain sobek, dll"></textarea>

                            </div>

                        </div>

                    @endforeach
                    <div class="grid lg:grid-cols-2 gap-6 mt-8">

                        {{-- Denda & Pengembalian --}}
                        <div class="space-y-5">

                            <div>

                                <label class="block font-semibold mb-2">

                                    Keterlambatan (Hari)

                                </label>

                                <input type="number" min="0" value="0" id="lateDays" name="late_days"
                                    class="w-full rounded-xl border-slate-300">

                                <p class="text-xs text-slate-500 mt-2">

                                    Denda Rp50.000 per hari.

                                </p>

                            </div>

                            <div>

                                <label class="block font-semibold mb-2">

                                    Jumlah Barang Hilang

                                </label>

                                <input type="number" min="0" value="0" id="missingItems" name="missing_items"
                                    class="w-full rounded-xl border-slate-300">

                                <p class="text-xs text-slate-500 mt-2">

                                    Denda administrasi Rp5.000 per barang.

                                </p>

                            </div>

                            <div>

                                <label class="block font-semibold mb-2">

                                    Foto Pengembalian

                                </label>

                                <input type="file" required name="return_photo" accept="image/*"
                                    class="w-full rounded-xl border-slate-300">

                            </div>

                            <div>

                                <label class="block font-semibold mb-2">

                                    Catatan Admin

                                </label>

                                <textarea rows="4" name="admin_note" class="w-full rounded-xl border-slate-300"
                                    placeholder="Catatan tambahan..."></textarea>

                            </div>

                        </div>

                        {{-- Ringkasan --}}
                        <div>

                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">

                                <h3 class="font-bold text-lg mb-5">

                                    Ringkasan Pengembalian

                                </h3>

                                <div class="space-y-4">

                                    <div class="flex justify-between">

                                        <span>

                                            Deposit

                                        </span>

                                        <span>

                                            Rp {{ number_format($order->deposit, 0, ',', '.') }}

                                        </span>

                                    </div>

                                    <div class="flex justify-between">

                                        <span>

                                            Denda Keterlambatan

                                        </span>

                                        <span id="lateFeePreview">

                                            Rp 0

                                        </span>

                                    </div>

                                    <div class="flex justify-between">

                                        <span>

                                            Denda Barang Hilang

                                        </span>

                                        <span id="missingFeePreview">

                                            Rp 0

                                        </span>

                                    </div>

                                    <div class="flex justify-between">

                                        <span>

                                            Denda Kerusakan

                                        </span>

                                        <span id="damagePenaltyPreview">

                                            Rp 0

                                        </span>

                                    </div>

                                    <hr>

                                    <div class="flex justify-between text-lg font-bold">

                                        <span>

                                            Total Denda

                                        </span>

                                        <span class="text-red-600" id="totalPenaltyPreview">

                                            Rp 0

                                        </span>

                                    </div>

                                    <div class="flex justify-between text-xl font-bold border-t pt-4">

                                        <span>

                                            Deposit Dikembalikan

                                        </span>

                                        <span class="text-emerald-600" id="depositReturnPreview">

                                            Rp {{ number_format($order->deposit, 0, ',', '.') }}

                                        </span>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="mt-8 flex justify-end">

                        <button type="submit"
                            class="px-8 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold">

                            Proses Pengembalian

                        </button>

                    </div>

                </div>

            </form>

        @endif
        @if(
                $order->payment_status == \App\Models\Order::PAYMENT_PAID &&
                $order->rental_status != \App\Models\Order::RENTAL_RETURNED
            )

            <script>

                const DEPOSIT =
            {{ $order->deposit }};

                const LATE_FEE_PER_DAY =
                    50000;

                const MISSING_FEE_PER_ITEM =
                    5000;

                function rupiah(value) {
                    return 'Rp ' + Number(value).toLocaleString('id-ID');
                }

                function percentage(status) {
                    switch (status) {
                        case 'light':
                            return 20;

                        case 'medium':
                            return 50;

                        case 'heavy':
                            return 100;

                        case 'lost':
                            return 100;

                        default:
                            return 0;
                    }
                }

                function calculatePenalty() {
                    let damagePenalty = 0;

                    document.querySelectorAll('.damage-status')

                        .forEach(function (select) {

                            const price =
                                Number(select.dataset.price);

                            const qty =
                                Number(select.dataset.qty);

                            const percent =
                                percentage(select.value);

                            const penalty =
                                (price * percent / 100) * qty;

                            damagePenalty += penalty;

                            document.getElementById(
                                select.dataset.target
                            ).innerHTML =
                                rupiah(penalty);

                        });

                    const lateDays =
                        Number(
                            document.getElementById(
                                'lateDays'
                            ).value
                        );

                    const missingItems =
                        Number(
                            document.getElementById(
                                'missingItems'
                            ).value
                        );

                    const lateFee =
                        lateDays *
                        LATE_FEE_PER_DAY;

                    const missingFee =
                        missingItems *
                        MISSING_FEE_PER_ITEM;

                    const totalPenalty =

                        lateFee +

                        missingFee +

                        damagePenalty;

                    let depositReturn =

                        DEPOSIT -

                        totalPenalty;

                    if (depositReturn < 0) {
                        depositReturn = 0;
                    }

                    document.getElementById(
                        'lateFeePreview'
                    ).innerHTML =
                        rupiah(lateFee);

                    document.getElementById(
                        'missingFeePreview'
                    ).innerHTML =
                        rupiah(missingFee);

                    document.getElementById(
                        'damagePenaltyPreview'
                    ).innerHTML =
                        rupiah(damagePenalty);

                    document.getElementById(
                        'totalPenaltyPreview'
                    ).innerHTML =
                        rupiah(totalPenalty);

                    document.getElementById(
                        'depositReturnPreview'
                    ).innerHTML =
                        rupiah(depositReturn);
                }

                document
                    .querySelectorAll('.damage-status')
                    .forEach(function (select) {

                        select.addEventListener(
                            'change',
                            calculatePenalty
                        );

                    });

                document
                    .getElementById('lateDays')
                    .addEventListener(
                        'input',
                        calculatePenalty
                    );

                document
                    .getElementById('missingItems')
                    .addEventListener(
                        'input',
                        calculatePenalty
                    );

                calculatePenalty();

            </script>

        @endif
        {{-- Detail Setelah Pengembalian --}}
        @if($order->rental_status == \App\Models\Order::RENTAL_RETURNED)

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

                <div class="px-6 py-5 border-b border-slate-200">

                    <h2 class="text-lg font-bold text-slate-800">

                        Hasil Pemeriksaan Pengembalian

                    </h2>

                </div>

                <div class="overflow-x-auto">

                    <table class="min-w-full">

                        <thead class="bg-slate-100">

                            <tr>

                                <th class="px-4 py-3 text-left">

                                    Barang

                                </th>

                                <th class="px-4 py-3 text-center">

                                    Kondisi

                                </th>

                                <th class="px-4 py-3 text-right">

                                    Denda

                                </th>

                                <th class="px-4 py-3 text-center">

                                    Servis

                                </th>

                                <th class="px-4 py-3">

                                    Catatan

                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($order->items as $item)

                                <tr class="border-t">

                                    <td class="px-4 py-4 font-semibold">

                                        {{ $item->product->name }}

                                    </td>

                                    <td class="px-4 py-4 text-center">

                                        {{ $item->damage_status_label }}

                                    </td>

                                    <td class="px-4 py-4 text-right text-red-600 font-semibold">

                                        Rp {{ number_format($item->damage_penalty, 0, ',', '.') }}

                                    </td>

                                    <td class="px-4 py-4 text-center">

                                        @if($item->needs_service)

                                            <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">

                                                Perlu Servis

                                            </span>

                                        @else

                                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">

                                                Tidak

                                            </span>

                                        @endif

                                    </td>

                                    <td class="px-4 py-4">

                                        {{ $item->damage_note ?: '-' }}

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

            {{-- Ringkasan Pengembalian --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">

                <h2 class="text-lg font-bold text-slate-800 mb-5">

                    Ringkasan Pengembalian

                </h2>

                <div class="space-y-4">

                    <div class="flex justify-between">

                        <span>

                            Denda Keterlambatan

                        </span>

                        <span>

                            Rp {{ number_format($order->late_fee, 0, ',', '.') }}

                        </span>

                    </div>

                    <div class="flex justify-between">

                        <span>

                            Denda Barang Hilang

                        </span>

                        <span>

                            Rp {{ number_format($order->missing_fee, 0, ',', '.') }}

                        </span>

                    </div>

                    <div class="flex justify-between">

                        <span>

                            Total Denda

                        </span>

                        <span class="text-red-600 font-bold">

                            Rp {{ number_format($order->total_penalty, 0, ',', '.') }}

                        </span>

                    </div>

                    <div class="flex justify-between border-t pt-4">

                        <span>

                            Deposit Dikembalikan

                        </span>

                        <span class="font-bold text-emerald-600">

                            Rp {{ number_format($order->deposit_return, 0, ',', '.') }}

                        </span>

                    </div>

                    <div class="flex justify-between">

                        <span>

                            Status Deposit

                        </span>

                        <span>

                            @if($order->deposit_returned)

                                <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">

                                    Sudah Dikembalikan

                                </span>

                            @else

                                <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">

                                    Belum Dikembalikan

                                </span>

                            @endif

                        </span>

                    </div>

                </div>

                @if(!$order->deposit_returned)

                    <form action="{{ route('admin.orders.deposit', $order) }}" method="POST" class="mt-8">

                        @csrf

                        @method('PATCH')

                        <button class="w-full py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold">

                            Konfirmasi Deposit Sudah Dikembalikan

                        </button>

                    </form>

                @endif

            </div>

        @endif

@endsection