<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Pemuda Berkelana
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body class="bg-slate-50 min-h-screen flex flex-col">

    <div x-data="{ mobileMenu: false }">

        {{-- Navbar --}}
        <nav class="sticky top-0 z-50 bg-white border-b border-slate-200 shadow-sm">

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="flex justify-between items-center h-20">

                    {{-- Logo --}}
                    <a href="/"
                        class="flex items-center gap-3">

                        <div
                            class="w-11 h-11 rounded-xl bg-emerald-600 text-white flex items-center justify-center">

                            <i class="fa-solid fa-tent text-lg"></i>

                        </div>

                        <div>

                            <h1 class="font-bold text-slate-800">
                                Pemuda Berkelana
                            </h1>

                            <p class="text-xs text-slate-500">
                                Outdoor Rental
                            </p>

                        </div>

                    </a>

                    {{-- Desktop Menu --}}
                    <div class="hidden lg:flex items-center gap-2">

                        <a href="/"
                            class="px-4 py-2 rounded-xl transition
                            {{ request()->is('/') ? 'bg-emerald-100 text-emerald-700 font-semibold' : 'text-slate-600 hover:bg-slate-100' }}">

                            Home

                        </a>

                        <a href="/products"
                            class="px-4 py-2 rounded-xl transition
                            {{ request()->is('products*') ? 'bg-emerald-100 text-emerald-700 font-semibold' : 'text-slate-600 hover:bg-slate-100' }}">

                            Produk

                        </a>

                        @auth

                            @if(auth()->user()->role === 'customer')

                                <a href="/cart"
                                    class="px-4 py-2 rounded-xl transition
                                    {{ request()->is('cart*') ? 'bg-emerald-100 text-emerald-700 font-semibold' : 'text-slate-600 hover:bg-slate-100' }}">

                                    Keranjang

                                </a>

                                <a href="/orders"
                                    class="px-4 py-2 rounded-xl transition
                                    {{ request()->is('orders*') ? 'bg-emerald-100 text-emerald-700 font-semibold' : 'text-slate-600 hover:bg-slate-100' }}">

                                    Pesanan

                                </a>

                                <a href="/profile"
                                    class="px-4 py-2 rounded-xl transition
                                    {{ request()->is('profile*') ? 'bg-emerald-100 text-emerald-700 font-semibold' : 'text-slate-600 hover:bg-slate-100' }}">

                                    Profil

                                </a>

                                <form
                                    action="{{ route('logout') }}"
                                    method="POST">

                                    @csrf

                                    <button
                                        type="submit"
                                        class="ml-3 px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-xl transition">

                                        Logout

                                    </button>

                                </form>

                            @endif

                            @if(auth()->user()->role === 'admin')

                                <a href="/admin/dashboard"
                                    class="ml-4 px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl">

                                    Dashboard Admin

                                </a>

                            @endif

                        @else

                            <a href="/login"
                                class="px-4 py-2 text-slate-600 hover:bg-slate-100 rounded-xl">

                                Login

                            </a>

                            <a href="/register"
                                class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl">

                                Register

                            </a>

                        @endauth

                    </div>

                    {{-- Mobile Button --}}
                    <button
                        @click="mobileMenu = !mobileMenu"
                        class="lg:hidden w-10 h-10 flex items-center justify-center rounded-lg hover:bg-slate-100">

                        <i class="fa-solid fa-bars"></i>

                    </button>

                </div>

            </div>

            {{-- Mobile Menu --}}
            <div
                x-show="mobileMenu"
                x-transition
                class="lg:hidden border-t border-slate-200 bg-white">

                <div class="px-4 py-4 space-y-2">

                    <a href="/"
                        class="block px-4 py-3 rounded-xl hover:bg-slate-100">

                        Home

                    </a>

                    <a href="/products"
                        class="block px-4 py-3 rounded-xl hover:bg-slate-100">

                        Produk

                    </a>

                    @auth

                        @if(auth()->user()->role === 'customer')

                            <a href="/cart"
                                class="block px-4 py-3 rounded-xl hover:bg-slate-100">

                                Keranjang

                            </a>

                            <a href="/orders"
                                class="block px-4 py-3 rounded-xl hover:bg-slate-100">

                                Pesanan

                            </a>

                            <a href="/profile"
                                class="block px-4 py-3 rounded-xl hover:bg-slate-100">

                                Profil

                            </a>

                            <form
                                action="{{ route('logout') }}"
                                method="POST">

                                @csrf

                                <button
                                    class="w-full mt-2 px-4 py-3 bg-red-500 text-white rounded-xl">

                                    Logout

                                </button>

                            </form>

                        @endif

                        @if(auth()->user()->role === 'admin')

                            <a href="/admin/dashboard"
                                class="block px-4 py-3 bg-emerald-600 text-white rounded-xl">

                                Dashboard Admin

                            </a>

                        @endif

                    @else

                        <a href="/login"
                            class="block px-4 py-3 rounded-xl hover:bg-slate-100">

                            Login

                        </a>

                        <a href="/register"
                            class="block px-4 py-3 bg-emerald-600 text-white rounded-xl">

                            Register

                        </a>

                    @endauth

                </div>

            </div>

        </nav>

        {{-- Main --}}
        <main class="flex-1">

            @yield('content')

        </main>

        {{-- Footer --}}
        <footer class="bg-slate-900 text-slate-300 mt-20">

            <div class="max-w-7xl mx-auto px-6 lg:px-8 py-12">

                <div class="grid md:grid-cols-3 gap-10">

                    <div>

                        <h3 class="text-white font-bold text-lg mb-4">

                            Pemuda Berkelana

                        </h3>

                        <p class="text-slate-400">

                            Penyedia jasa rental alat camping dan outdoor
                            terpercaya untuk mendukung petualanganmu.

                        </p>

                    </div>

                    <div>

                        <h3 class="text-white font-bold mb-4">

                            Menu

                        </h3>

                        <ul class="space-y-2">

                            <li>
                                <a href="/" class="hover:text-white">
                                    Home
                                </a>
                            </li>

                            <li>
                                <a href="/products" class="hover:text-white">
                                    Produk
                                </a>
                            </li>

                        </ul>

                    </div>

                    <div>

                        <h3 class="text-white font-bold mb-4">

                            Kontak

                        </h3>

                        <div class="space-y-2">

                            <p>
                                <i class="fa-solid fa-phone mr-2"></i>
                                +62 85806242705
                            </p>

                            <p>
                                <i class="fa-solid fa-envelope mr-2"></i>
                                info@pemudaberkelana.my.id
                            </p>

                        </div>

                    </div>

                </div>

                <div class="border-t border-slate-800 mt-10 pt-6 text-center text-sm text-slate-500">

                    © {{ date('Y') }} Pemuda Berkelana.
                    All Rights Reserved.

                </div>

            </div>

        </footer>

    </div>

</body>

</html>