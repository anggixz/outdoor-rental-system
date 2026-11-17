<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | Pemuda Berkelana</title>

    {{-- Font Awesome --}}
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100">

    <div
        x-data="{ sidebarOpen: false }"
        class="min-h-screen lg:flex">

        {{-- Overlay Mobile --}}
        <div
            x-show="sidebarOpen"
            x-transition.opacity
            class="fixed inset-0 bg-black/50 z-40 lg:hidden"
            @click="sidebarOpen = false">
        </div>

        {{-- Sidebar --}}
        <aside
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed lg:sticky top-0 left-0 z-50 h-screen w-72 bg-slate-900 text-white transform transition-transform duration-300 lg:translate-x-0 flex flex-col">

            {{-- Logo --}}
            <div class="px-6 py-6 border-b border-slate-800">

                <div class="flex items-center gap-4">

                    <div class="w-12 h-12 rounded-xl bg-emerald-600 flex items-center justify-center">

                        <i class="fa-solid fa-campground text-xl"></i>

                    </div>

                    <div>

                        <h1 class="text-xl font-bold">
                            Pemuda Berkelana
                        </h1>

                        <p class="text-sm text-slate-400">
                            Admin Dashboard
                        </p>

                    </div>

                </div>

            </div>

            {{-- Navigation --}}
            <nav class="flex-1 px-4 py-6 space-y-2">

                {{-- Dashboard --}}
                <a
                    href="/admin/dashboard"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition
                    {{ request()->is('admin/dashboard*')
                        ? 'bg-emerald-600 text-white shadow-lg'
                        : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">

                    <i class="fa-solid fa-chart-line w-5"></i>

                    <span>Dashboard</span>

                </a>

                {{-- Produk --}}
                <a
                    href="/admin/products"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition
                    {{ request()->is('admin/products*')
                        ? 'bg-emerald-600 text-white shadow-lg'
                        : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">

                    <i class="fa-solid fa-campground w-5"></i>

                    <span>Produk</span>

                </a>

                {{-- Rental --}}
                <a
                    href="/admin/orders"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition
                    {{ request()->is('admin/orders*')
                        ? 'bg-emerald-600 text-white shadow-lg'
                        : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">

                    <i class="fa-solid fa-box-open w-5"></i>

                    <span>Rental</span>

                </a>

                {{-- Pengguna --}}
                <a
                    href="/admin/users"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition
                    {{ request()->is('admin/users*')
                        ? 'bg-emerald-600 text-white shadow-lg'
                        : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">

                    <i class="fa-solid fa-users w-5"></i>

                    <span>Pengguna</span>

                </a>

                {{-- Laporan --}}
                <a
                    href="/admin/reports"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition
                    {{ request()->is('admin/reports*')
                        ? 'bg-emerald-600 text-white shadow-lg'
                        : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">

                    <i class="fa-solid fa-file-pdf w-5"></i>

                    <span>Laporan</span>

                </a>

            </nav>

            {{-- Footer --}}
            <div class="p-4 border-t border-slate-800">

                <form
                    action="{{ route('logout') }}"
                    method="POST">

                    @csrf

                    <button
                        type="submit"
                        class="w-full py-3 rounded-xl bg-red-500 hover:bg-red-600 transition font-semibold">

                        <i class="fa-solid fa-right-from-bracket mr-2"></i>

                        Logout

                    </button>

                </form>

            </div>

        </aside>

        {{-- Content --}}
        <div class="flex-1 flex flex-col min-h-screen">

            {{-- Header --}}
            <header class="bg-white border-b border-slate-200">

                <div class="px-6 lg:px-10 py-4 flex justify-between items-center">

                    <div class="flex items-center gap-4">

                        {{-- Mobile Toggle --}}
                        <button
                            @click="sidebarOpen = true"
                            class="lg:hidden p-2 rounded-lg hover:bg-slate-100">

                            <i class="fa-solid fa-bars"></i>

                        </button>

                        <div>

                            <h2 class="text-xl font-bold text-slate-800">
                                Pemuda Berkelana
                            </h2>

                            <p class="text-sm text-slate-500">
                                Sistem Manajemen Persewaan Outdoor
                            </p>

                        </div>

                    </div>

                    <div class="flex items-center gap-3">

                        <div class="text-right">

                            <p class="font-semibold text-slate-800">
                                {{ auth()->user()->name }}
                            </p>

                            <p class="text-sm text-slate-500">
                                Administrator
                            </p>

                        </div>

                        <div
                            class="w-10 h-10 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold">

                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                        </div>

                    </div>

                </div>

            </header>

            {{-- Main --}}
            <main class="flex-1 p-6 lg:p-8">

                @yield('content')

            </main>

        </div>

    </div>

</body>

</html>