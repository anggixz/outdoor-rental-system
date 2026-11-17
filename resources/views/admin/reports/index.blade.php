@extends('layouts.admin')

@section('content')

    <div class="max-w-6xl mx-auto space-y-8">

        {{-- Header --}}
        <div class="flex items-start justify-between">

            <div>

                <h1 class="text-3xl font-bold text-slate-800">

                    Laporan Keuangan

                </h1>

                <p class="text-slate-500 mt-2">

                    Generate laporan keuangan transaksi persewaan berdasarkan periode
                    yang dipilih dalam format PDF.

                </p>

            </div>

            <div class="hidden md:flex items-center justify-center w-16 h-16 rounded-2xl bg-emerald-100">

                <i class="fa-solid fa-file-invoice-dollar text-emerald-600 text-3xl"></i>

            </div>

        </div>

        {{-- Filter --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

            <div class="px-6 py-5 border-b border-slate-200">

                <h2 class="font-semibold text-slate-800 text-lg">

                    Filter Periode Laporan

                </h2>

                <p class="text-sm text-slate-500 mt-1">

                    Pilih rentang tanggal untuk menghasilkan laporan keuangan.

                </p>

            </div>

            <form action="{{ route('reports.download') }}" method="POST">

                @csrf

                <div class="p-6 space-y-8">

                    <div class="grid md:grid-cols-2 gap-6">

                        <div>

                            <label class="block text-sm font-semibold text-slate-700 mb-2">

                                Tanggal Awal

                            </label>

                            <input type="date" name="start_date" required
                                class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">

                        </div>

                        <div>

                            <label class="block text-sm font-semibold text-slate-700 mb-2">

                                Tanggal Akhir

                            </label>

                            <input type="date" name="end_date" required
                                class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">

                        </div>

                    </div>

                    {{-- Quick Filter --}}
                    <div>

                        <label class="block text-sm font-semibold text-slate-700 mb-4">

                            Pilih Cepat

                        </label>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

                            <button type="button" onclick="setToday()"
                                class="rounded-xl border border-slate-300 bg-white py-3 hover:bg-emerald-50 hover:border-emerald-500 transition">

                                <i class="fa-solid fa-calendar-day text-emerald-600 mb-2 block"></i>

                                Hari Ini

                            </button>

                            <button type="button" onclick="setWeek()"
                                class="rounded-xl border border-slate-300 bg-white py-3 hover:bg-emerald-50 hover:border-emerald-500 transition">

                                <i class="fa-solid fa-calendar-week text-emerald-600 mb-2 block"></i>

                                Minggu Ini

                            </button>

                            <button type="button" onclick="setMonth()"
                                class="rounded-xl border border-slate-300 bg-white py-3 hover:bg-emerald-50 hover:border-emerald-500 transition">

                                <i class="fa-solid fa-calendar-days text-emerald-600 mb-2 block"></i>

                                Bulan Ini

                            </button>

                            <button type="button" onclick="setYear()"
                                class="rounded-xl border border-slate-300 bg-white py-3 hover:bg-emerald-50 hover:border-emerald-500 transition">

                                <i class="fa-solid fa-calendar text-emerald-600 mb-2 block"></i>

                                Tahun Ini

                            </button>

                        </div>

                    </div>

                    {{-- Informasi --}}
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">

                        <h3 class="font-semibold text-slate-800 flex items-center gap-2 mb-5">

                            <i class="fa-solid fa-circle-info text-emerald-600"></i>

                            Laporan yang Akan Dihasilkan

                        </h3>

                        <div class="grid md:grid-cols-2 gap-y-4 gap-x-10">

                            <div class="flex items-center gap-3">

                                <i class="fa-solid fa-circle-check text-emerald-600"></i>

                                <span>Pendapatan Sewa</span>

                            </div>

                            <div class="flex items-center gap-3">

                                <i class="fa-solid fa-circle-check text-emerald-600"></i>

                                <span>Deposit Diterima</span>

                            </div>

                            <div class="flex items-center gap-3">

                                <i class="fa-solid fa-circle-check text-emerald-600"></i>

                                <span>Pendapatan Denda
                                    (Keterlambatan, Kehilangan & Kerusakan)</span>

                            </div>

                            <div class="flex items-center gap-3">

                                <i class="fa-solid fa-circle-check text-emerald-600"></i>

                                <span>Total Uang Masuk</span>

                            </div>

                            <div class="flex items-center gap-3">

                                <i class="fa-solid fa-circle-check text-emerald-600"></i>

                                <span>Deposit Dikembalikan</span>

                            </div>

                            <div class="flex items-center gap-3">

                                <i class="fa-solid fa-circle-check text-emerald-600"></i>

                                <span>Total Kas Bersih</span>

                            </div>

                            <div class="flex items-center gap-3">

                                <i class="fa-solid fa-circle-check text-emerald-600"></i>

                                <span>Statistik Operasional</span>

                            </div>

                            <div class="flex items-center gap-3">

                                <i class="fa-solid fa-circle-check text-emerald-600"></i>

                                <span>Daftar Transaksi Rental</span>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="px-6 py-5 bg-slate-50 border-t border-slate-200 flex justify-end">
                    <button type="submit"
                        class="inline-flex items-center gap-3 px-8 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold shadow-sm transition">

                        <i class="fa-solid fa-file-pdf"></i>

                        Generate Laporan PDF

                    </button>

                </div>

            </form>

        </div>

        {{-- Keterangan --}}
        <div class="grid lg:grid-cols-3 gap-6">

            <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm p-6">

                <h2 class="text-lg font-semibold text-slate-800 mb-5">

                    Ringkasan Isi Laporan

                </h2>

                <div class="overflow-x-auto">

                    <table class="min-w-full text-sm">

                        <thead>

                            <tr class="bg-slate-100">

                                <th class="text-left px-4 py-3 font-semibold text-slate-700">

                                    Komponen Laporan

                                </th>

                                <th class="text-left px-4 py-3 font-semibold text-slate-700">

                                    Keterangan

                                </th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-slate-200">

                            <tr>

                                <td class="px-4 py-3 font-medium">

                                    Pendapatan Sewa

                                </td>

                                <td class="px-4 py-3 text-slate-600">

                                    Total pendapatan yang diperoleh dari biaya penyewaan alat.

                                </td>

                            </tr>

                            <tr>

                                <td class="px-4 py-3 font-medium">

                                    Deposit Diterima

                                </td>

                                <td class="px-4 py-3 text-slate-600">

                                    Total uang jaminan yang diterima dari seluruh transaksi yang telah dibayar.

                                </td>

                            </tr>

                            <tr>

                                <td class="px-4 py-3 font-medium">

                                    Pendapatan Denda

                                </td>

                                <td class="px-4 py-3 text-slate-600">

                                    Total pendapatan dari denda keterlambatan,
                                    kehilangan, dan kerusakan barang berdasarkan
                                    hasil inspeksi pengembalian.

                                </td>

                            </tr>

                            <tr>

                                <td class="px-4 py-3 font-medium">

                                    Total Uang Masuk

                                </td>

                                <td class="px-4 py-3 text-slate-600">

                                    Akumulasi pendapatan sewa, deposit diterima, dan pendapatan denda.

                                </td>

                            </tr>

                            <tr>

                                <td class="px-4 py-3 font-medium">

                                    Deposit Dikembalikan

                                </td>

                                <td class="px-4 py-3 text-slate-600">

                                    Total deposit yang telah dikembalikan kepada penyewa setelah proses pengembalian
                                    selesai.

                                </td>

                            </tr>

                            <tr>

                                <td class="px-4 py-3 font-medium">

                                    Total Kas Bersih

                                </td>

                                <td class="px-4 py-3 text-slate-600">

                                    Selisih antara Total Uang Masuk dengan Deposit Dikembalikan.

                                </td>

                            </tr>

                            <tr>

                                <td class="px-4 py-3 font-medium">

                                    Barang Rusak

                                </td>

                                <td class="px-4 py-3 text-slate-600">

                                    Rekapitulasi jumlah barang yang mengalami
                                    kerusakan selama periode laporan.

                                </td>

                            </tr>

                            <tr>

                                <td class="px-4 py-3 font-medium">

                                    Barang Perlu Servis

                                </td>

                                <td class="px-4 py-3 text-slate-600">

                                    Daftar barang yang memerlukan
                                    perbaikan sebelum dapat disewakan kembali.

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">

                <div class="flex items-center gap-3 mb-5">

                    <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center">

                        <i class="fa-solid fa-lightbulb text-emerald-600 text-xl"></i>

                    </div>

                    <div>

                        <h3 class="font-semibold text-slate-800">

                            Informasi

                        </h3>

                        <p class="text-sm text-slate-500">

                            Sebelum mengunduh laporan

                        </p>

                    </div>

                </div>

                <ul class="space-y-4 text-sm text-slate-600">

                    <li class="flex gap-3">

                        <i class="fa-solid fa-check text-emerald-600 mt-1"></i>

                        <span>

                            Pastikan periode laporan telah dipilih dengan benar.

                        </span>

                    </li>

                    <li class="flex gap-3">

                        <i class="fa-solid fa-check text-emerald-600 mt-1"></i>

                        <span>

                            Laporan hanya menghitung transaksi yang telah berhasil dibayar sebagai pendapatan.

                        </span>

                    </li>

                    <li class="flex gap-3">

                        <i class="fa-solid fa-check text-emerald-600 mt-1"></i>

                        <span>

                            Deposit yang telah dikembalikan akan dicatat sebagai pengurang kas sehingga laporan lebih
                            akurat.

                        </span>

                    </li>

                    <li class="flex gap-3">

                        <i class="fa-solid fa-check text-emerald-600 mt-1"></i>

                        <span>

                            File akan diunduh dalam format PDF dan siap dicetak.

                        </span>

                    </li>

                    <li class="flex gap-3">

                        <i class="fa-solid fa-check text-emerald-600 mt-1"></i>

                        <span>

                            Laporan juga memuat rekapitulasi kerusakan barang, denda kerusakan, dan kondisi inventaris
                            selama periode yang dipilih.

                        </span>

                    </li>

                </ul>

            </div>

        </div>

    </div>

    <script>

        function formatDate(date) {
            return date.toISOString().split('T')[0];
        }

        function setToday() {
            const today = new Date();

            document.querySelector('[name=start_date]').value = formatDate(today);
            document.querySelector('[name=end_date]').value = formatDate(today);
        }

        function setWeek() {
            const today = new Date();

            const first = new Date(today);

            first.setDate(today.getDate() - today.getDay());

            document.querySelector('[name=start_date]').value = formatDate(first);
            document.querySelector('[name=end_date]').value = formatDate(today);
        }

        function setMonth() {
            const today = new Date();

            const first = new Date(
                today.getFullYear(),
                today.getMonth(),
                1
            );

            document.querySelector('[name=start_date]').value = formatDate(first);
            document.querySelector('[name=end_date]').value = formatDate(today);
        }

        function setYear() {
            const today = new Date();

            const first = new Date(
                today.getFullYear(),
                0,
                1
            );

            document.querySelector('[name=start_date]').value = formatDate(first);
            document.querySelector('[name=end_date]').value = formatDate(today);
        }

    </script>

@endsection