<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Webinar Sibali</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 antialiased">
    <div class="flex min-h-screen">
        <aside class="w-64 bg-gray-900 text-white flex-shrink-0 sticky top-0 h-screen overflow-y-auto">
            <div class="p-6">
                <h2 class="text-xl font-black tracking-tighter text-indigo-400">SIBALI ADMIN</h2>
                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mt-1">Management System</p>
            </div>

            <nav class="mt-4 px-4 space-y-2">
                <x-admin-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    💳 Verifikasi Bayar
                </x-admin-nav-link>

                <x-admin-nav-link :href="route('admin.participants')" :active="request()->routeIs('admin.participants')">
                    👥 List Peserta
                </x-admin-nav-link>

                <x-admin-nav-link :href="route('admin.materials')" :active="request()->routeIs('admin.materials')">
                    📚 Materi & Link
                </x-admin-nav-link>

                <x-admin-nav-link :href="route('admin.questions')" :active="request()->routeIs('admin.questions')">
                    ✍️ Bank Soal TOEFL
                </x-admin-nav-link>

                <hr class="border-gray-800 my-4">
                
                <a href="/dashboard" class="flex items-center p-3 text-sm font-medium text-gray-400 hover:text-white hover:bg-gray-800 rounded-xl transition">
                    ⬅️ Kembali ke Dashboard User
                </a>
            </nav>
        </aside>

        <main class="flex-1">
            <header class="bg-white border-b border-gray-200 p-4 flex justify-end items-center space-x-4">
                <span class="text-sm font-medium text-gray-600">{{ Auth::user()->name }} (Admin)</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-xs font-bold text-red-500 uppercase">Logout</button>
                </form>
            </header>

            <div class="p-8">
                {{ $slot }} {{-- Tempat konten menu akan muncul --}}
            </div>
        </main>
    </div>
</body>
</html>