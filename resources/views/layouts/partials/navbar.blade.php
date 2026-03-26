<nav x-data="{ open: false }" class="bg-white/90 backdrop-blur-md sticky top-0 z-[100] border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
            <div class="flex items-center gap-2">
                <img src="{{ asset('img/logo-sibali.png') }}" alt="Logo" class="h-8 sm:h-10 w-auto">
                <span class="text-lg sm:text-xl font-extrabold tracking-tighter text-blue-900">Sibali<span class="text-red-600">Event</span></span>
            </div>
            
            <div class="hidden md:flex space-x-8">
                <a href="/#events" class="text-sm font-bold text-slate-600 hover:text-blue-600 transition">Event</a>
                <a href="/#features" class="text-sm font-bold text-slate-600 hover:text-blue-600 transition">Fitur</a>
                <a href="/#about" class="text-sm font-bold text-slate-600 hover:text-blue-600 transition">Tentang</a>
            </div>

            <div class="flex items-center gap-2 sm:gap-3">
                <div class="hidden md:flex items-center gap-3">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-xs font-bold text-blue-600 px-3 py-2 bg-blue-50 rounded-lg">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold text-slate-600 hover:text-blue-600">Masuk</a>
                        <a href="{{ route('register') }}" class="px-4 sm:px-6 py-2 sm:py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-bold rounded-full transition-all shadow-lg shadow-blue-200">Daftar</a>
                    @endauth
                </div>
                
                <button @click="open = !open" class="md:hidden p-2 text-slate-600 transition-transform" :class="{'rotate-90': open}">
                    <i data-lucide="menu" x-show="!open"></i>
                    <i data-lucide="x" x-show="open"></i>
                </button>
            </div>
        </div>
    </div>
    
    <div x-show="open" x-cloak x-transition class="md:hidden bg-white border-b px-4 py-6 space-y-4 shadow-xl">
        {{-- Menu Navigasi Utama --}}
        <a href="/#events" @click="open = false" class="block font-bold text-slate-600 hover:text-blue-600 transition">Event</a>
        <a href="/#features" @click="open = false" class="block font-bold text-slate-600 hover:text-blue-600 transition">Fitur</a>
        <a href="/#about" @click="open = false" class="block font-bold text-slate-600 hover:text-blue-600 transition">Tentang</a>
        
        <hr class="border-slate-100">

        {{-- Menu Akun (Menyesuaikan Status Login) --}}
        <div class="space-y-3">
            @auth
                {{-- Tampilan saat sudah login --}}
                <div class="p-4 bg-blue-50 rounded-2xl">
                    <a href="{{ url('/dashboard') }}" class="flex items-center justify-between font-bold text-blue-900">
                        Dashboard
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>
            @else
                {{-- Tampilan saat belum login --}}
                <a href="{{ route('login') }}" class="block w-full py-3 text-center font-bold text-slate-600 border border-slate-200 rounded-xl">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="block w-full py-3 text-center font-bold text-white bg-blue-600 rounded-xl shadow-lg shadow-blue-100">
                    Daftar Sekarang
                </a>
            @endauth
        </div>
    </div>
</nav>