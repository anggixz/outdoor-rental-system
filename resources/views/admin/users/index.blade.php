@extends('layouts.admin')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div>

        <h1 class="text-3xl font-bold text-slate-800">
            Manajemen User
        </h1>

        <p class="text-slate-500 mt-2">
            Kelola akun pengguna dan hak akses sistem.
        </p>

    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-slate-500 text-sm">
                        Total User
                    </p>

                    <h3 class="text-3xl font-bold text-slate-800 mt-2">
                        {{ $totalUsers }}
                    </h3>

                </div>

                <div class="w-14 h-14 rounded-xl bg-blue-100 flex items-center justify-center">

                    <i class="fa-solid fa-users text-blue-600 text-xl"></i>

                </div>

            </div>

        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-slate-500 text-sm">
                        Administrator
                    </p>

                    <h3 class="text-3xl font-bold text-emerald-600 mt-2">
                        {{ $totalAdmins }}
                    </h3>

                </div>

                <div class="w-14 h-14 rounded-xl bg-emerald-100 flex items-center justify-center">

                    <i class="fa-solid fa-user-shield text-emerald-600 text-xl"></i>

                </div>

            </div>

        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-slate-500 text-sm">
                        Customer
                    </p>

                    <h3 class="text-3xl font-bold text-amber-600 mt-2">
                        {{ $totalCustomers }}
                    </h3>

                </div>

                <div class="w-14 h-14 rounded-xl bg-amber-100 flex items-center justify-center">

                    <i class="fa-solid fa-user text-amber-600 text-xl"></i>

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

    {{-- Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

        <div class="px-6 py-5 border-b border-slate-200">

            <h2 class="font-semibold text-slate-800">
                Daftar Pengguna
            </h2>

            <p class="text-sm text-slate-500 mt-1">
                Total User: {{ $totalUsers }}
            </p>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full min-w-[950px]">

                <thead class="bg-slate-50">

                    <tr>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-500">
                            Pengguna
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-500">
                            Email
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-500">
                            Role
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-slate-500">
                            Simpan
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-slate-500">
                            Hapus
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($users as $user)

                        <tr class="hover:bg-slate-50">

                            {{-- User --}}
                            <td class="px-6 py-4">

                                <div class="flex items-center gap-4">

                                    <div class="w-12 h-12 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold">

                                        {{ strtoupper(substr($user->name, 0, 1)) }}

                                    </div>

                                    <div>

                                        <div class="font-semibold text-slate-800">
                                            {{ $user->name }}
                                        </div>

                                        <div class="text-xs text-slate-500">
                                            ID #{{ $user->id }}
                                        </div>

                                    </div>

                                </div>

                            </td>

                            {{-- Email --}}
                            <td class="px-6 py-4 text-slate-700">
                                {{ $user->email }}
                            </td>

                            {{-- Role --}}
                            <td class="px-6 py-4">

                                <form
                                    action="/admin/users/{{ $user->id }}"
                                    method="POST"
                                    class="flex items-center gap-3">

                                    @csrf
                                    @method('PATCH')

                                    <select
                                        name="role"
                                        class="rounded-xl border-slate-300">

                                        <option value="customer"
                                            {{ $user->role == 'customer' ? 'selected' : '' }}>
                                            Customer
                                        </option>

                                        <option value="admin"
                                            {{ $user->role == 'admin' ? 'selected' : '' }}>
                                            Admin
                                        </option>

                                    </select>

                            </td>

                            {{-- Simpan --}}
                            <td class="px-6 py-4 text-center">

                                    <button
                                        type="submit"
                                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">

                                        <i class="fa-solid fa-floppy-disk"></i>

                                    </button>

                                </form>

                            </td>

                            {{-- Hapus --}}
                            <td class="px-6 py-4 text-center">

                                @if(auth()->id() != $user->id)

                                    <form
                                        action="/admin/users/{{ $user->id }}"
                                        method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            onclick="return confirm('Yakin ingin menghapus user ini?')"
                                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg">

                                            <i class="fa-solid fa-trash"></i>

                                        </button>

                                    </form>

                                @else

                                    <span class="text-slate-400 text-sm font-medium">
                                        Akun Anda
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5" class="py-16 text-center">

                                <div class="flex flex-col items-center">

                                    <i class="fa-solid fa-users text-5xl text-slate-300 mb-4"></i>

                                    <h3 class="text-lg font-semibold text-slate-700">
                                        Belum Ada User
                                    </h3>

                                    <p class="text-slate-500 mt-1">
                                        Data pengguna akan muncul di sini.
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