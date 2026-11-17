@extends('layouts.admin')

@section('content')

    <div class="max-w-7xl mx-auto">

        {{-- Header --}}
        <div class="mb-8">

            <a href="/admin/products"
                class="inline-flex items-center gap-2 text-emerald-600 hover:text-emerald-700 font-medium mb-4">

                <i class="fa-solid fa-arrow-left"></i>

                Kembali ke Data Produk

            </a>

            <h1 class="text-3xl font-bold text-slate-800">
                Tambah Produk
            </h1>

            <p class="text-slate-500 mt-2">
                Tambahkan perlengkapan camping atau outdoor baru ke dalam sistem.
            </p>

        </div>

        {{-- Error --}}
        @if ($errors->any())

            <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-5">

                <h3 class="font-semibold text-red-700 mb-3">

                    <i class="fa-solid fa-circle-exclamation mr-2"></i>

                    Terdapat Kesalahan

                </h3>

                <ul class="list-disc list-inside text-red-600 space-y-1">

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        <form action="/admin/products" method="POST" enctype="multipart/form-data">

            @csrf

            <div class="grid lg:grid-cols-3 gap-6">

                {{-- FORM --}}
                <div class="lg:col-span-2">

                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm">

                        <div class="px-6 py-5 border-b border-slate-200">

                            <h2 class="font-semibold text-slate-800">
                                Informasi Produk
                            </h2>

                        </div>

                        <div class="p-6 space-y-6">

                            {{-- Kategori --}}
                            <div>

                                <label class="block text-sm font-semibold text-slate-700 mb-2">

                                    Kategori *

                                </label>

                                <select name="category_id" id="category"
                                    class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">

                                    @foreach($categories as $category)

                                        <option value="{{ $category->id }}">

                                            {{ $category->name }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                            {{-- Nama --}}
                            <div>

                                <label class="block text-sm font-semibold text-slate-700 mb-2">

                                    Nama Produk *

                                </label>

                                <input type="text" id="name" name="name" value="{{ old('name') }}"
                                    placeholder="Contoh: Tenda Eiger 4 Orang"
                                    class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">

                            </div>

                            <div class="grid md:grid-cols-2 gap-6">

                                {{-- Harga --}}
                                <div>

                                    <label class="block text-sm font-semibold text-slate-700 mb-2">

                                        Harga / Hari *

                                    </label>

                                    <input type="number" id="price" name="price_per_day" value="{{ old('price_per_day') }}"
                                        class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">

                                </div>

                                {{-- Harga Beli --}}
                                <div>

                                    <label class="block text-sm font-semibold text-slate-700 mb-2">

                                        Harga Beli *

                                    </label>

                                    <input type="number" id="purchase_price" name="purchase_price"
                                        value="{{ old('purchase_price') }}" placeholder="Contoh: 2500000"
                                        class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">

                                    <p class="mt-2 text-xs text-slate-500">

                                        Digunakan sebagai acuan perhitungan denda kerusakan barang.

                                    </p>

                                </div>

                                {{-- Stok --}}
                                <div>

                                    <label class="block text-sm font-semibold text-slate-700 mb-2">

                                        Stok *

                                    </label>

                                    <input type="number" id="stock" name="stock" value="{{ old('stock') }}"
                                        class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">

                                </div>

                            </div>

                            {{-- Thumbnail --}}
                            <div>

                                <label class="block text-sm font-semibold text-slate-700 mb-2">

                                    Thumbnail

                                </label>

                                <input type="file" name="thumbnail" id="thumbnail" accept="image/*"
                                    class="block w-full rounded-xl border border-slate-300 p-3">

                            </div>

                            {{-- Deskripsi --}}
                            <div>

                                <label class="block text-sm font-semibold text-slate-700 mb-2">

                                    Deskripsi

                                </label>

                                <textarea name="description" rows="6"
                                    class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">{{ old('description') }}</textarea>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- PREVIEW --}}
                <div>

                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm sticky top-6">

                        <div class="px-6 py-5 border-b border-slate-200">

                            <h2 class="font-semibold text-slate-800">

                                Preview Produk

                            </h2>

                        </div>

                        <div class="p-6">

                            <img id="previewImage" src="https://placehold.co/600x600/e2e8f0/64748b?text=No+Image"
                                class="w-full aspect-square object-cover rounded-xl border">

                            <div class="mt-5">

                                <h3 id="previewName" class="text-xl font-bold text-slate-800">

                                    Nama Produk

                                </h3>

                                <p id="previewCategory" class="text-sm text-slate-500 mt-1">

                                    Kategori

                                </p>

                            </div>

                            <div class="mt-6 space-y-3">

                                <div class="flex justify-between">

                                    <span class="text-slate-500">
                                        Harga
                                    </span>

                                    <span id="previewPrice" class="font-semibold text-emerald-600">

                                        Rp 0

                                    </span>

                                </div>

                                <div class="flex justify-between">

                                    <span class="text-slate-500">
                                        Harga Beli
                                    </span>

                                    <span id="previewPurchasePrice" class="font-semibold text-blue-600">

                                        Rp 0

                                    </span>

                                </div>

                                <div class="flex justify-between">

                                    <span class="text-slate-500">
                                        Stok
                                    </span>

                                    <span id="previewStock" class="font-semibold">

                                        0 Unit

                                    </span>

                                </div>

                                <div class="flex justify-between">

                                    <span class="text-slate-500">
                                        Status
                                    </span>

                                    <span class="text-emerald-600 font-semibold">

                                        Aktif

                                    </span>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- Action --}}
            <div class="flex justify-end gap-3 mt-6">

                <a href="/admin/products" class="px-6 py-3 rounded-xl border border-slate-300 hover:bg-slate-100">

                    Batal

                </a>

                <button type="submit"
                    class="px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-medium">

                    <i class="fa-solid fa-floppy-disk mr-2"></i>

                    Simpan Produk

                </button>

            </div>

        </form>

    </div>

    <script>

        const nameInput = document.getElementById('name');
        const priceInput = document.getElementById('price');
        const purchasePriceInput = document.getElementById('purchase_price');
        const stockInput = document.getElementById('stock');
        const categoryInput = document.getElementById('category');

        nameInput.addEventListener('input', () => {
            document.getElementById('previewName').innerText =
                nameInput.value || 'Nama Produk';
        });

        priceInput.addEventListener('input', () => {
            document.getElementById('previewPrice').innerText =
                'Rp ' + Number(priceInput.value || 0).toLocaleString('id-ID');
        });

        purchasePriceInput.addEventListener('input', () => {
            document.getElementById('previewPurchasePrice').innerText =

                'Rp ' + Number(
                    purchasePriceInput.value || 0
                ).toLocaleString('id-ID');
        });

        stockInput.addEventListener('input', () => {
            document.getElementById('previewStock').innerText =
                (stockInput.value || 0) + ' Unit';
        });

        categoryInput.addEventListener('change', () => {
            document.getElementById('previewCategory').innerText =
                categoryInput.options[categoryInput.selectedIndex].text;
        });

        document.getElementById('thumbnail').addEventListener('change', function (e) {

            const file = e.target.files[0];

            if (!file) return;

            const reader = new FileReader();

            reader.onload = function (event) {

                document.getElementById('previewImage').src =
                    event.target.result;

            }

            reader.readAsDataURL(file);

        });

    </script>

@endsection