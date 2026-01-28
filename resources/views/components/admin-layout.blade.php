<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Webinar Sibali</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F1F3F6] antialiased" x-data="{ sidebarOpen: false }">
    <div class="flex min-h-screen">
        
        {{-- OVERLAY MOBILE --}}
        <div x-show="sidebarOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false" 
             class="fixed inset-0 bg-slate-900/60 z-40 lg:hidden backdrop-blur-sm">
        </div>

        {{-- SIDEBAR --}}
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
               class="fixed lg:sticky top-0 left-0 z-50 w-72 bg-[#0F172A] h-screen overflow-y-auto transition-transform duration-300 ease-in-out shadow-2xl flex flex-col">
            
            <div class="p-8">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-indigo-500 rounded-lg shadow-lg shadow-indigo-500/20">
                            <i data-lucide="layout-grid" class="w-6 h-6 text-white"></i>
                        </div>
                        <h2 class="text-xl font-black tracking-tight text-white font-sans">SIBALI <span class="text-indigo-400">ADMIN</span></h2>
                    </div>
                    {{-- Close Button Mobile --}}
                    <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white">
                        <i data-lucide="x" class="w-6 h-6"></i>
                    </button>
                </div>
                <p class="text-[10px] text-slate-500 font-bold uppercase tracking-[0.2em] ml-1">Management System</p>
            </div>

            <nav class="mt-2 px-6 space-y-1 flex-1">
                <div class="pb-2">
                    <p class="px-3 text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-4">Menu Utama</p>
                    
                    <x-admin-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        <i data-lucide="check-circle" class="w-5 h-5"></i>
                        <span class="font-semibold text-sm">Verifikasi Bayar</span>
                    </x-admin-nav-link>

                    <x-admin-nav-link :href="route('admin.participants')" :active="request()->routeIs('admin.participants')">
                        <i data-lucide="users" class="w-5 h-5"></i>
                        <span class="font-semibold text-sm">List Peserta</span>
                    </x-admin-nav-link>

                    <x-admin-nav-link :href="route('admin.materials')" :active="request()->routeIs('admin.materials')">
                        <i data-lucide="book-open" class="w-5 h-5"></i>
                        <span class="font-semibold text-sm">Materi & Link</span>
                    </x-admin-nav-link>

                    <x-admin-nav-link :href="route('admin.questions')" :active="request()->routeIs('admin.questions')">
                        <i data-lucide="database" class="w-5 h-5"></i>
                        <span class="font-semibold text-sm">Bank Soal TOEFL</span>
                    </x-admin-nav-link>
                </div>

                <div class="pt-6 mt-4 border-t border-slate-800">
                    <p class="px-3 text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-4">Akses Lainnya</p>
                    
                    <a href="/dashboard" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold text-slate-400 hover:text-white hover:bg-slate-800/50 rounded-xl transition-all group">
                        <i data-lucide="arrow-left-circle" class="w-5 h-5 group-hover:-translate-x-1 transition-transform"></i>
                        <span>Dashboard User</span>
                    </a>
                </div>
            </nav>

            {{-- Admin Profile Card --}}
            <div class="p-6">
                <div class="p-4 bg-slate-800/40 rounded-2xl border border-slate-800 backdrop-blur-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-indigo-500 flex items-center justify-center text-white font-bold text-xs shadow-inner shrink-0">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-xs font-bold text-white truncate">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] text-slate-400 font-medium">Administrator</p>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        {{-- MAIN CONTENT --}}
        <main class="flex-1 min-w-0 overflow-x-hidden">
            <header class="bg-white/70 backdrop-blur-md border-b border-gray-200 p-4 sticky top-0 z-30 flex justify-between lg:justify-end items-center px-6 lg:px-8">
                {{-- Hamburger Button --}}
                <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-lg bg-slate-900 text-white">
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>

                <div class="flex items-center gap-4 lg:gap-6">
                    <div class="hidden sm:flex flex-col items-end border-r border-gray-200 pr-6">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Login Session</span>
                        <span class="text-sm font-bold text-slate-700">{{ now()->format('d M Y') }}</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 px-4 lg:px-5 py-2 lg:py-2.5 bg-slate-900 text-white rounded-xl text-[10px] lg:text-xs font-bold uppercase tracking-widest hover:bg-indigo-600 transition-all duration-300">
                            <i data-lucide="log-out" class="w-4 h-4 text-indigo-400"></i>
                            <span class="hidden xs:inline">Logout</span>
                        </button>
                    </form>
                </div>
            </header>

            <div class="p-4 lg:p-10 max-w-6xl mx-auto">
                {{ $slot }}
            </div>
        </main>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>