@extends('layouts.app')

@section('content')

<div class="bg-slate-50 min-h-screen">

    {{-- Hero --}}
    <section class="bg-gradient-to-r from-emerald-800 to-green-700 text-white">

        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-14">

            <div class="flex flex-col md:flex-row items-center gap-6">

                <div class="w-24 h-24 rounded-full bg-white/20 backdrop-blur flex items-center justify-center text-4xl font-bold">

                    {{ strtoupper(substr($user->name, 0, 1)) }}

                </div>

                <div>

                    <h1 class="text-4xl font-bold">

                        {{ $user->name }}

                    </h1>

                    <p class="text-emerald-100 mt-2">

                        {{ $user->email }}

                    </p>

                </div>

            </div>

        </div>

    </section>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-10">

        {{-- Alert Success --}}
        @if (session('status') === 'profile-updated')

            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 p-5 rounded-2xl">

                Profil berhasil diperbarui.

            </div>

        @endif

        @if (session('status') === 'password-updated')

            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 p-5 rounded-2xl">

                Password berhasil diperbarui.

            </div>

        @endif

        {{-- Alert Error --}}
        @if(
            $errors->updateProfileInformation->any()
            || $errors->updatePassword->any()
        )

            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 p-5 rounded-2xl">

                <ul class="list-disc ml-5 space-y-1">

                    @foreach ($errors->updateProfileInformation->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                    @foreach ($errors->updatePassword->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        {{-- Statistik --}}
        <div class="grid md:grid-cols-3 gap-6 mb-8">

            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">

                <div class="flex justify-between items-center">

                    <div>

                        <p class="text-slate-500 text-sm">
                            Total Pesanan
                        </p>

                        <h3 class="text-3xl font-bold text-slate-800 mt-2">

                            {{ $totalOrders }}

                        </h3>

                    </div>

                    <i class="fa-solid fa-box text-3xl text-emerald-500"></i>

                </div>

            </div>

            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">

                <div class="flex justify-between items-center">

                    <div>

                        <p class="text-slate-500 text-sm">
                            Rental Aktif
                        </p>

                        <h3 class="text-3xl font-bold text-slate-800 mt-2">

                            {{ $activeRentals }}

                        </h3>

                    </div>

                    <i class="fa-solid fa-tent text-3xl text-blue-500"></i>

                </div>

            </div>

            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">

                <div class="flex justify-between items-center">

                    <div>

                        <p class="text-slate-500 text-sm">
                            Total Transaksi
                        </p>

                        <h3 class="text-2xl font-bold text-emerald-600 mt-2">

                            Rp {{ number_format($totalSpent,0,',','.') }}

                        </h3>

                    </div>

                    <i class="fa-solid fa-wallet text-3xl text-amber-500"></i>

                </div>

            </div>

        </div>

        <div class="grid lg:grid-cols-2 gap-8">

            {{-- Informasi Akun --}}
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

                <div class="px-8 py-6 border-b border-slate-200">

                    <h2 class="text-2xl font-bold text-slate-800">

                        Informasi Akun

                    </h2>

                </div>

                <form
                    method="POST"
                    action="{{ route('profile.update') }}"
                    class="p-8">

                    @csrf
                    @method('PATCH')

                    <div class="mb-6">

                        <label class="block text-sm font-medium text-slate-700 mb-2">

                            Nama Lengkap

                        </label>

                        <input
                            type="text"
                            name="name"
                            value="{{ old('name', $user->name) }}"
                            class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">

                    </div>

                    <div class="mb-6">

                        <label class="block text-sm font-medium text-slate-700 mb-2">

                            Email

                        </label>

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email', $user->email) }}"
                            class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">

                    </div>

                    <button
                        type="submit"
                        class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl font-medium transition">

                        Simpan Perubahan

                    </button>

                </form>

            </div>

            {{-- Password --}}
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

                <div class="px-8 py-6 border-b border-slate-200">

                    <h2 class="text-2xl font-bold text-slate-800">

                        Ubah Password

                    </h2>

                </div>

                <form
                    method="POST"
                    action="{{ route('password.update') }}"
                    class="p-8">

                    @csrf
                    @method('PUT')

                    <div class="mb-6">

                        <label class="block text-sm font-medium text-slate-700 mb-2">

                            Password Saat Ini

                        </label>

                        <input
                            type="password"
                            name="current_password"
                            class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">

                    </div>

                    <div class="mb-6">

                        <label class="block text-sm font-medium text-slate-700 mb-2">

                            Password Baru

                        </label>

                        <input
                            type="password"
                            name="password"
                            class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">

                    </div>

                    <div class="mb-6">

                        <label class="block text-sm font-medium text-slate-700 mb-2">

                            Konfirmasi Password

                        </label>

                        <input
                            type="password"
                            name="password_confirmation"
                            class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">

                    </div>

                    <button
                        type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-medium transition">

                        Update Password

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection