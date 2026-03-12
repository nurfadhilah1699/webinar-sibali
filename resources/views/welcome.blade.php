<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sibali Event</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo-sibali.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; scroll-behavior: smooth; }
        .bg-pattern { background-image: radial-gradient(#e5e7eb 1px, transparent 1px); background-size: 20px 20px; }
        .gradient-blue { background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); }
        .animate-float { animation: float 6s ease-in-out infinite; }
        @keyframes float { 0% { transform: translateY(0px); } 50% { transform: translateY(-20px); } 100% { transform: translateY(0px); } }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-white text-slate-900 antialiased">

    {{-- NAVBAR --}}
    <nav x-data="{ open: false }" class="bg-white/90 backdrop-blur-md sticky top-0 z-[100] border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('img/logo-sibali.png') }}" alt="Logo" class="h-8 sm:h-10 w-auto">
                    <span class="text-lg sm:text-xl font-extrabold tracking-tighter text-blue-900">Sibali<span class="text-red-600">Event</span></span>
                </div>
                
                <div class="hidden md:flex space-x-8">
                    <a href="#events" class="text-sm font-bold text-slate-600 hover:text-blue-600 transition">Event</a>
                    <a href="#features" class="text-sm font-bold text-slate-600 hover:text-blue-600 transition">Fitur</a>
                    <a href="#about" class="text-sm font-bold text-slate-600 hover:text-blue-600 transition">Tentang</a>
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
            <a href="#events" @click="open = false" class="block font-bold text-slate-600 hover:text-blue-600 transition">Event</a>
            <a href="#features" @click="open = false" class="block font-bold text-slate-600 hover:text-blue-600 transition">Fitur</a>
            <a href="#about" @click="open = false" class="block font-bold text-slate-600 hover:text-blue-600 transition">Tentang</a>
            
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

    {{-- HERO SECTION --}}
    <section class="relative pt-8 sm:pt-12 pb-20 sm:pb-24 overflow-hidden bg-pattern">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-10 items-center text-center lg:text-left">
                <div class="z-10">
                    <span class="inline-flex items-center px-4 py-1.5 rounded-full text-[10px] sm:text-xs font-black bg-red-50 text-red-600 border border-red-100 mb-6 tracking-widest uppercase">
                        🚀 PLATFORM EVENT TERINTEGRASI - EDISI 2026
                    </span>
                    <h1 class="text-4xl sm:text-5xl lg:text-7xl font-extrabold text-blue-900 leading-[1.1] tracking-tight">
                        Temukan <br class="hidden sm:block">
                        <span class="text-red-600">Event Terbaik</span> <br> Untuk Masa Depan
                        <span class="underline decoration-blue-200">Gemilang</span>
                    </h1>
                    
                    {{-- <div class="mt-8 flex justify-center lg:justify-start gap-2 sm:gap-4">
                        <div class="text-center">
                            <div id="days" class="text-xl sm:text-3xl font-black text-blue-900 bg-white shadow-sm border border-slate-100 w-12 h-12 sm:w-16 sm:h-16 flex items-center justify-center rounded-xl sm:rounded-2xl">00</div>
                            <span class="text-[8px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-2 block">Hari</span>
                        </div>
                        <div class="text-center">
                            <div id="hours" class="text-xl sm:text-3xl font-black text-blue-900 bg-white shadow-sm border border-slate-100 w-12 h-12 sm:w-16 sm:h-16 flex items-center justify-center rounded-xl sm:rounded-2xl">00</div>
                            <span class="text-[8px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-2 block">Jam</span>
                        </div>
                        <div class="text-center">
                            <div id="minutes" class="text-xl sm:text-3xl font-black text-blue-900 bg-white shadow-sm border border-slate-100 w-12 h-12 sm:w-16 sm:h-16 flex items-center justify-center rounded-xl sm:rounded-2xl">00</div>
                            <span class="text-[8px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-2 block">Menit</span>
                        </div>
                        <div class="text-center">
                            <div id="seconds" class="text-xl sm:text-3xl font-black text-red-600 bg-white shadow-sm border border-slate-100 w-12 h-12 sm:w-16 sm:h-16 flex items-center justify-center rounded-xl sm:rounded-2xl">00</div>
                            <span class="text-[8px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-2 block">Detik</span>
                        </div>
                    </div> --}}

                    <p class="mt-8 text-base sm:text-lg text-slate-500 max-w-xl mx-auto lg:mx-0 font-medium px-2">
                        Sibali.Id menghadirkan platform pengembangan diri terlengkap untukmu.
                    </p>
                    <div class="mt-8 sm:mt-10 flex flex-col sm:flex-row gap-4 justify-center lg:justify-start px-4 sm:px-0">
                        <a href="#events" class="px-8 py-4 gradient-blue text-white font-black rounded-2xl shadow-xl shadow-blue-200 text-center uppercase text-[10px] sm:text-xs tracking-widest">Pilih Event Sekarang</a>
                    </div>
                </div>
                <div class="relative hidden lg:block">
                    <img src="{{ asset('img/logo-sibali.png') }}" class="relative z-10 w-full max-w-md mx-auto drop-shadow-2xl animate-float">
                </div>
            </div>
        </div>
    </section>

    {{-- FEATURES SECTION --}}
    <section id="features" class="py-16 sm:py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-2xl sm:text-3xl font-black text-blue-900">Keunggulan Sibali Event</h2>
                <div class="h-1 w-16 bg-red-600 mx-auto mt-4 rounded-full"></div>
            </div>
            <div class="grid md:grid-cols-3 gap-6 sm:gap-10">
                <div class="p-8 rounded-[2rem] bg-white border border-slate-100 shadow-sm hover:shadow-lg transition-all">
                    <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center mb-6 text-white shadow-lg">
                        <i data-lucide="shield-check"></i>
                    </div>
                    <h3 class="text-lg font-black text-slate-800 mb-2">Terpercaya & Profesional</h3>
                    <p class="text-slate-500 text-sm font-medium">Platform resmi dari PT Siap Belajar Indonesia yang telah mengelola berbagai event.</p>
                </div>
                <div class="p-8 rounded-[2rem] bg-white border border-slate-100 shadow-sm hover:shadow-lg transition-all">
                    <div class="w-12 h-12 bg-red-600 rounded-xl flex items-center justify-center mb-6 text-white shadow-lg">
                        <i data-lucide="zap"></i>
                    </div>
                    <h3 class="text-lg font-black text-slate-800 mb-2">Sistem Terintegrasi</h3>
                    <p class="text-slate-500 text-sm font-medium">Mulai dari pendaftaran, CBT, hingga unduh sertifikat semua dilakukan dalam satu dashboard.</p>
                </div>
                <div class="p-8 rounded-[2rem] bg-white border border-slate-100 shadow-sm hover:shadow-lg transition-all">
                    <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center mb-6 text-white shadow-lg">
                        <i data-lucide="trending-up"></i>
                    </div>
                    <h3 class="text-lg font-black text-slate-800 mb-2">Kurikulum Terupdate</h3>
                    <p class="text-slate-500 text-sm font-medium">Materi disusun berdasarkan tren industri dan kebutuhan akademik terbaru untuk masa depanmu.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ABOUT SECTION --}}
    <section id="about" class="py-16 sm:py-24 bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-950 relative overflow-hidden">
        <div class="absolute right-0 top-0 w-1/2 h-full bg-blue-800/20 -skew-x-12 translate-x-1/4"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="text-white text-center lg:text-left">
                    <span class="text-red-500 font-black uppercase tracking-[0.3em] text-[10px] sm:text-xs">Tentang Kami</span>
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black mt-4 mb-6 leading-tight">Solusi Digital untuk Event Kamu.</h2>
                    <p class="text-blue-100 leading-relaxed mb-8 font-medium text-base sm:text-lg">Sibali Event hadir untuk memudahkan akses edukasi dan kompetisi berkualitas bagi seluruh anak muda Indonesia melalui teknologi yang user-friendly.</p>
                    <a href="#events" class="inline-flex items-center gap-3 px-8 py-4 bg-white text-blue-900 font-black rounded-2xl hover:bg-red-600 hover:text-white transition-all uppercase text-[10px] tracking-widest mx-auto lg:mx-0">
                        Eksplor Event <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>

                <div class="mt-10 lg:mt-0">
                    <div class="bg-white/10 backdrop-blur-md p-6 sm:p-10 rounded-[2.5rem] border border-white/20 shadow-2xl">
                        <h3 class="text-xl font-black text-white mb-8 flex items-center justify-center lg:justify-start gap-3">
                            <span class="w-8 h-1 bg-red-500 rounded-full"></span>
                            Cara Bergabung
                        </h3>
                        <div class="space-y-6 sm:space-y-8">
                            <div class="flex gap-4 items-start">
                                <div class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12 bg-red-600 text-white rounded-xl flex items-center justify-center font-bold">1</div>
                                <div class="text-left">
                                    <h4 class="font-bold text-white text-base">Pilih Event Favorit</h4>
                                    <p class="text-xs text-blue-100/70 mt-1">Cari webinar atau lomba yang kamu inginkan di katalog kami.</p>
                                </div>
                            </div>
                            <div class="flex gap-4 items-start">
                                <div class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12 bg-red-600 text-white rounded-xl flex items-center justify-center font-bold">2</div>
                                <div class="text-left">
                                    <h4 class="font-bold text-white text-base">Registrasi Cepat</h4>
                                    <p class="text-xs text-blue-100/70 mt-1">Isi data diri dan selesaikan pembayaran.</p>
                                </div>
                            </div>
                            <div class="flex gap-4 items-start">
                                <div class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12 bg-red-600 text-white rounded-xl flex items-center justify-center font-bold">3</div>
                                <div class="text-left">
                                    <h4 class="font-bold text-white text-base">Mulai Belajar/Lomba</h4>
                                    <p class="text-xs text-blue-100/70 mt-1">Pantau progres dan akses semua fitur melalui dashboard peserta kamu.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- EVENT LIST SECTION --}}
    <section id="events" class="py-16 sm:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl sm:text-4xl font-black text-blue-900">Jelajahi Event Kami</h2>
                <div class="h-1 w-16 bg-red-600 mx-auto mt-4 rounded-full"></div>
                <p class="mt-4 text-slate-500 font-medium">Pilih program yang sesuai dengan kebutuhan pengembangan dirimu.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse($events as $event)
                    <div class="bg-white rounded-[2.5rem] overflow-hidden border border-slate-200 shadow-sm hover:shadow-xl transition-all group">
                        <div class="relative">
                            {{-- Placeholder gambar jika belum ada upload foto --}}
                            <img src="{{ asset('img/' . $event->slug . '.jpg') }}" 
                                onerror="this.src='https://placehold.co/600x400?text=Event+Sibali'"
                                class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500">
                            
                            {{-- Label Status Dinamis --}}
                            <div class="absolute top-4 right-4">
                                @if(!$event->is_active)
                                    <span class="px-4 py-1.5 bg-slate-500 text-white text-[10px] font-black rounded-full uppercase">Selesai</span>
                                @elseif($event->start_time > now())
                                    <span class="px-4 py-1.5 bg-blue-600 text-white text-[10px] font-black rounded-full uppercase">Mendatang</span>
                                @else
                                    <span class="px-4 py-1.5 bg-emerald-500 text-white text-[10px] font-black rounded-full uppercase">Aktif</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="p-8">
                            <span class="text-[10px] font-black text-red-600 uppercase tracking-widest">{{ $event->type }}</span>
                            <h3 class="text-xl font-extrabold text-blue-900 mt-2 mb-4 h-14 overflow-hidden">{{ $event->title }}</h3>
                            
                            <div class="flex items-center gap-3 text-slate-500 text-sm mb-6 font-medium">
                                <i data-lucide="calendar" class="w-4 h-4"></i>
                                {{ \Carbon\Carbon::parse($event->start_time)->translatedFormat('d F Y') }}
                            </div>

                            {{-- Button logic --}}
                            <a href="{{ $event->is_active ? route('webinar.show', $event->slug) : '#' }}" 
                            class="block w-full py-4 text-center rounded-2xl font-black text-[10px] uppercase tracking-widest transition-all {{ $event->is_active ? 'gradient-blue text-white shadow-lg' : 'bg-slate-100 text-slate-400 cursor-not-allowed' }}">
                            {{ $event->is_active ? 'Lihat Detail' : 'Pendaftaran Ditutup' }}
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-20">
                        <p class="text-slate-400 font-bold uppercase tracking-widest">Belum ada event tersedia.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- STATS SECTION --}}
    <section class="py-12 bg-blue-900 text-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-3xl font-black text-white">5.000+</div>
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Alumni Peserta</div>
                </div>
                <div>
                    <div class="text-3xl font-black text-white">20+</div>
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Event Sukses</div>
                </div>
                <div>
                    <div class="text-3xl font-black text-white">50+</div>
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Mentor Ahli</div>
                </div>
                <div>
                    <div class="text-3xl font-black text-white">100%</div>
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Sistem Digital</div>
                </div>
            </div>
        </div>
    </section>

    {{-- FAQ SECTION --}}
    <section id="faq" class="py-16 sm:py-24 bg-slate-50">
        <div class="max-w-3xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-2xl sm:text-3xl font-black text-blue-900">Sering Ditanyakan</h2>
                <div class="h-1 w-16 bg-red-600 mx-auto mt-4 rounded-full"></div>
            </div>
            
            <div x-data="{ active: null }" class="space-y-4">
                {{-- Question 1 --}}
                <div class="border border-slate-200 rounded-2xl overflow-hidden">
                    <button @click="active = (active === 1 ? null : 1)" class="w-full p-6 text-left flex justify-between items-center bg-slate-50 hover:bg-slate-100 transition">
                        <span class="font-bold text-slate-800">Bagaimana cara mendapatkan sertifikat?</span>
                        <i data-lucide="chevron-down" class="transition-transform" :class="active === 1 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="active === 1" x-cloak class="p-6 text-slate-500 text-sm border-t border-slate-200">
                        Sertifikat dapat diunduh melalui Dashboard Peserta maksimal 3 hari setelah event berakhir, dengan syarat mengikuti acara sampai selesai.
                    </div>
                </div>

                {{-- Question 2 --}}
                <div class="border border-slate-200 rounded-2xl overflow-hidden">
                    <button @click="active = (active === 2 ? null : 2)" class="w-full p-6 text-left flex justify-between items-center bg-slate-50 hover:bg-slate-100 transition">
                        <span class="font-bold text-slate-800">Apakah ada rekaman jika saya absen?</span>
                        <i data-lucide="chevron-down" class="transition-transform" :class="active === 2 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="active === 2" x-cloak class="p-6 text-slate-500 text-sm border-t border-slate-200">
                        Ya, untuk paket VIP dan VIP Plus, link rekaman webinar akan tersedia di dashboard peserta.
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="bg-slate-950 pt-16 pb-8 text-white border-t border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
                
                {{-- Kolom 1: Brand & Sosmed --}}
                <div class="col-span-1 md:col-span-1">
                    <div class="flex items-center gap-2 mb-6">
                        <img src="{{ asset('img/logo-sibali.png') }}" class="h-9 w-auto brightness-0 invert"> {{-- Invert agar logo putih --}}
                        <span class="text-xl font-black tracking-tighter text-white">Sibali<span class="text-red-500">Event</span></span>
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed mb-8">
                        Solusi terintegrasi untuk pengembangan diri, webinar karir, dan kompetisi nasional bagi masa depan gemilangmu.
                    </p>
                    <div class="flex gap-4">
                        <a href="https://www.instagram.com/sibaliid/" class="w-10 h-10 bg-white/5 text-slate-400 rounded-xl flex items-center justify-center hover:bg-red-600 hover:text-white transition-all duration-300">
                            <i data-lucide="instagram" class="w-5 h-5"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white/5 text-slate-400 rounded-xl flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all duration-300">
                            <i data-lucide="twitter" class="w-5 h-5"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white/5 text-slate-400 rounded-xl flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all duration-300">
                            <i data-lucide="linkedin" class="w-5 h-5"></i>
                        </a>
                    </div>
                </div>

                {{-- Kolom 2: Link Cepat --}}
                <div>
                    <h4 class="text-xs font-black text-slate-200 uppercase tracking-[0.2em] mb-8">Menu Utama</h4>
                    <ul class="space-y-4 text-sm font-bold text-slate-400">
                        <li><a href="#events" class="hover:text-white transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 bg-red-600 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></span> Jelajahi Event</a></li>
                        <li><a href="#features" class="hover:text-white transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 bg-red-600 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></span> Fitur Unggulan</a></li>
                        <li><a href="#about" class="hover:text-white transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 bg-red-600 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></span> Tentang Kami</a></li>
                        <li><a href="#faq" class="hover:text-white transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 bg-red-600 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></span> Pusat Bantuan</a></li>
                    </ul>
                </div>

                {{-- Kolom 3: Kontak --}}
                <div>
                    <h4 class="text-xs font-black text-slate-200 uppercase tracking-[0.2em] mb-8">Hubungi Kami</h4>
                    <ul class="space-y-5 text-sm font-medium text-slate-400">
                        {{-- Link Email --}}
                        <li>
                            <a href="mailto:sibaliid@gmail.com?subject=Tanya%20Seputar%20Sibali%20Event" class="flex items-start gap-4 group">
                                <div class="w-8 h-8 bg-blue-600/10 text-blue-500 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-blue-600 group-hover:text-white transition-all">
                                    <i data-lucide="mail" class="w-4 h-4"></i>
                                </div>
                                <span class="pt-1 group-hover:text-white transition-colors">sibaliid@gmail.com</span>
                            </a>
                        </li>

                        {{-- Link WhatsApp --}}
                        <li>
                            <a href="https://wa.me/+6285397467461" target="_blank" class="flex items-start gap-4 group">
                                <div class="w-8 h-8 bg-red-600/10 text-red-500 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-red-600 group-hover:text-white transition-all">
                                    <i data-lucide="phone" class="w-4 h-4"></i>
                                </div>
                                <span class="pt-1 group-hover:text-white transition-colors">+62 853-9746-7461</span>
                            </a>
                        </li>

                        {{-- Lokasi (Tetap) --}}
                        <li class="flex items-start gap-4 px-0.5">
                            <div class="w-8 h-8 bg-emerald-600/10 text-emerald-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i data-lucide="map-pin" class="w-4 h-4"></i>
                            </div>
                            <span class="pt-1 leading-relaxed">Majene, Sulawesi Barat,<br>Indonesia</span>
                        </li>
                    </ul>
                </div>
                {{-- Kolom 3: Kontak --}}
                {{-- <div>
                    <h4 class="text-xs font-black text-slate-200 uppercase tracking-[0.2em] mb-8">Hubungi Kami</h4>
                    <ul class="space-y-5 text-sm font-medium text-slate-400">
                        <li class="flex items-start gap-4">
                            <div class="w-8 h-8 bg-blue-600/10 text-blue-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i data-lucide="mail" class="w-4 h-4"></i>
                            </div>
                            <span class="pt-1">sibaliid@gmail.com</span>
                        </li>
                        <li class="flex items-start gap-4">
                            <div class="w-8 h-8 bg-red-600/10 text-red-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i data-lucide="phone" class="w-4 h-4"></i>
                            </div>
                            <span class="pt-1">+62 853-9746-7461</span>
                        </li>
                        <li class="flex items-start gap-4">
                            <div class="w-8 h-8 bg-emerald-600/10 text-emerald-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i data-lucide="map-pin" class="w-4 h-4"></i>
                            </div>
                            <span class="pt-1 leading-relaxed">Majene, Sulawesi Barat,<br>Indonesia</span>
                        </li>
                    </ul>
                </div> --}}

                {{-- Kolom 4: Info Tambahan/Visi --}}
                <div class="bg-white/5 p-6 rounded-[2rem] border border-white/10">
                    <h4 class="text-xs font-black text-white uppercase tracking-[0.2em] mb-4">Siap Belajar?</h4>
                    <p class="text-xs text-slate-400 leading-relaxed mb-6">Gabung dengan ribuan peserta lainnya dalam ekosistem belajar digital terbaik.</p>
                    <a href="{{ route('register') }}" class="block w-full py-3 bg-red-600 hover:bg-red-700 text-white text-[10px] font-black uppercase text-center tracking-widest rounded-xl transition-all shadow-lg shadow-red-900/20">
                        Daftar Sekarang
                    </a>
                </div>
            </div>

            <div class="h-[1px] w-full bg-gradient-to-r from-transparent via-white/10 to-transparent mb-8"></div>

            {{-- Bottom Footer --}}
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="text-center md:text-left">
                    <p class="text-slate-500 text-[10px] font-black uppercase tracking-[0.2em]">
                        &copy; 2026 PT Siap Belajar Indonesia. <span class="text-slate-700 mx-2">|</span> <span class="text-slate-400 font-bold tracking-widest">Built with Passion</span>
                    </p>
                </div>
                <div class="flex gap-8 text-[10px] font-bold text-slate-500 uppercase tracking-[0.15em]">
                    <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition-colors">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Tetap simpan ini agar ikon Lucide (calendar, check, dll) muncul
        lucide.createIcons();
    </script>
    {{-- <script>
        lucide.createIcons();
        function updateTimer() {
            const targetDate = new Date("2026-02-15T09:00:00").getTime();
            setInterval(() => {
                const now = new Date().getTime();
                const distance = targetDate - now;
                if (distance < 0) return;
                document.getElementById("days").innerText = Math.floor(distance / (1000 * 60 * 60 * 24)).toString().padStart(2, '0');
                document.getElementById("hours").innerText = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)).toString().padStart(2, '0');
                document.getElementById("minutes").innerText = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)).toString().padStart(2, '0');
                document.getElementById("seconds").innerText = Math.floor((distance % (1000 * 60)) / 1000).toString().padStart(2, '0');
            }, 1000);
        }
        updateTimer();
    </script> --}}
</body>
</html>