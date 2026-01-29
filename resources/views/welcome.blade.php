<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webinar Beasiswa Unlocked - Sibali Event</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
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
                    <img src="{{ asset('img/logo.png') }}" alt="Logo" class="h-8 sm:h-10 w-auto">
                    <span class="text-lg sm:text-xl font-extrabold tracking-tighter text-blue-900">Sibali<span class="text-red-600">Event</span></span>
                </div>
                
                <div class="hidden md:flex space-x-8">
                    <a href="#features" class="text-sm font-bold text-slate-600 hover:text-blue-600 transition">Fitur</a>
                    <a href="#about" class="text-sm font-bold text-slate-600 hover:text-blue-600 transition">Tentang</a>
                    <a href="#pricing" class="text-sm font-bold text-slate-600 hover:text-blue-600 transition">Paket</a>
                </div>

                <div class="flex items-center gap-2 sm:gap-3">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-xs sm:text-sm font-bold text-blue-600 px-3 py-2 bg-blue-50 rounded-lg">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="hidden sm:block text-sm font-bold text-slate-600 hover:text-blue-600">Masuk</a>
                        <a href="{{ route('register') }}" class="px-4 sm:px-6 py-2 sm:py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-bold rounded-full transition-all shadow-lg shadow-blue-200">Daftar</a>
                    @endauth
                    
                    <button @click="open = !open" class="md:hidden p-2 text-slate-600 transition-transform" :class="{'rotate-90': open}">
                        <i data-lucide="menu" x-show="!open"></i>
                        <i data-lucide="x" x-show="open"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <div x-show="open" x-cloak x-transition class="md:hidden bg-white border-b px-4 py-6 space-y-4 shadow-xl">
            <a href="#features" @click="open = false" class="block font-bold text-slate-600">Fitur</a>
            <a href="#about" @click="open = false" class="block font-bold text-slate-600">Tentang</a>
            <a href="#pricing" @click="open = false" class="block font-bold text-slate-600">Paket</a>
            <hr>
            <a href="{{ route('login') }}" class="block font-bold text-blue-600">Masuk Peserta</a>
        </div>
    </nav>

    {{-- HERO SECTION --}}
    <section class="relative pt-8 sm:pt-12 pb-20 sm:pb-24 overflow-hidden bg-pattern">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-10 items-center text-center lg:text-left">
                <div class="z-10">
                    <span class="inline-flex items-center px-4 py-1.5 rounded-full text-[10px] sm:text-xs font-black bg-red-50 text-red-600 border border-red-100 mb-6 tracking-widest uppercase">
                        🚀 Limited Slot - Beasiswa 2026
                    </span>
                    <h1 class="text-4xl sm:text-5xl lg:text-7xl font-extrabold text-blue-900 leading-[1.1] tracking-tight">
                        Wujudkan <br class="hidden sm:block">
                        <span class="text-red-600">Mimpi Kampus</span> <br>
                        <span class="underline decoration-blue-200">Impianmu</span>
                    </h1>
                    
                    <div class="mt-8 flex justify-center lg:justify-start gap-2 sm:gap-4">
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
                    </div>

                    <p class="mt-8 text-base sm:text-lg text-slate-500 max-w-xl mx-auto lg:mx-0 font-medium px-2">
                        Persiapkan dirimu menembus Beasiswa LPDP & Luar Negeri bersama mentor berpengalaman.
                    </p>
                    <div class="mt-8 sm:mt-10 flex flex-col sm:flex-row gap-4 justify-center lg:justify-start px-4 sm:px-0">
                        <a href="#pricing" class="px-8 py-4 gradient-blue text-white font-black rounded-2xl shadow-xl shadow-blue-200 text-center uppercase text-[10px] sm:text-xs tracking-widest">Pilih Paket Sekarang</a>
                    </div>
                </div>
                <div class="relative hidden lg:block">
                    <img src="{{ asset('img/logo.png') }}" class="relative z-10 w-full max-w-md mx-auto drop-shadow-2xl animate-float">
                </div>
            </div>
        </div>
    </section>

    {{-- FEATURES SECTION --}}
    <section id="features" class="py-16 sm:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-2xl sm:text-3xl font-black text-blue-900">Kenapa Harus Ikut?</h2>
                <div class="h-1 w-16 bg-red-600 mx-auto mt-4 rounded-full"></div>
            </div>
            <div class="grid md:grid-cols-3 gap-6 sm:gap-10">
                <div class="p-8 rounded-[2rem] bg-slate-50 border border-slate-100">
                    <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center mb-6 text-white shadow-lg">
                        <i data-lucide="graduation-cap"></i>
                    </div>
                    <h3 class="text-lg font-black text-slate-800 mb-2">Awardee Mentorship</h3>
                    <p class="text-slate-500 text-sm font-medium">Insight langsung dari penerima beasiswa LPDP tentang cara membuat essay memikat.</p>
                </div>
                <div class="p-8 rounded-[2rem] bg-slate-50 border border-slate-100">
                    <div class="w-12 h-12 bg-red-600 rounded-xl flex items-center justify-center mb-6 text-white shadow-lg">
                        <i data-lucide="clipboard-check"></i>
                    </div>
                    <h3 class="text-lg font-black text-slate-800 mb-2">Real TOEFL Simulation</h3>
                    <p class="text-slate-500 text-sm font-medium">Uji skor TOEFL-mu dengan sistem CBT yang dilengkapi timer dan hasil instan.</p>
                </div>
                <div class="p-8 rounded-[2rem] bg-slate-50 border border-slate-100">
                    <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center mb-6 text-white shadow-lg">
                        <i data-lucide="users"></i>
                    </div>
                    <h3 class="text-lg font-black text-slate-800 mb-2">Networking Group</h3>
                    <p class="text-slate-500 text-sm font-medium">Bergabung dengan komunitas pejuang beasiswa lainnya.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ABOUT / ROADMAP SECTION (KEMBALI HADIR & RESPONSIVE) --}}
    <section id="about" class="py-16 sm:py-24 bg-blue-900 relative overflow-hidden">
        <div class="absolute right-0 top-0 w-1/2 h-full bg-blue-800/20 -skew-x-12 translate-x-1/4"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                {{-- Text Content - Muncul di Atas pada Mobile --}}
                <div class="text-white text-center lg:text-left">
                    <span class="text-red-500 font-black uppercase tracking-[0.3em] text-[10px] sm:text-xs">Tentang Program</span>
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black mt-4 mb-6 leading-tight">Langkah Nyata Menuju Kampus Impian.</h2>
                    <p class="text-blue-100 leading-relaxed mb-8 font-medium text-base sm:text-lg">Bukan sekadar webinar biasa. Kami memberikan roadmap terukur dari seleksi berkas hingga penguasaan bahasa asing.</p>
                    <a href="#pricing" class="inline-flex items-center gap-3 px-8 py-4 bg-white text-blue-900 font-black rounded-2xl hover:bg-red-600 hover:text-white transition-all uppercase text-[10px] tracking-widest mx-auto lg:mx-0">
                        Amankan Slot Kamu <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>

                {{-- Curriculum Cards --}}
                <div class="mt-10 lg:mt-0">
                    <div class="bg-white/10 backdrop-blur-md p-6 sm:p-10 rounded-[2.5rem] border border-white/20 shadow-2xl">
                        <h3 class="text-xl font-black text-white mb-8 flex items-center justify-center lg:justify-start gap-3">
                            <span class="w-8 h-1 bg-red-500 rounded-full"></span>
                            Kurikulum Webinar
                        </h3>
                        <div class="space-y-6 sm:space-y-8">
                            <div class="flex gap-4">
                                <div class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12 bg-red-600 text-white rounded-xl flex items-center justify-center font-bold">1</div>
                                <div>
                                    <h4 class="font-bold text-white text-base sm:text-lg text-left">Mindset & Administratif</h4>
                                    <p class="text-xs sm:text-sm text-blue-100/70 mt-1 text-left">Mengenal kriteria yang dicari oleh reviewer pada berkas pendaftaran.</p>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12 bg-red-600 text-white rounded-xl flex items-center justify-center font-bold">2</div>
                                <div>
                                    <h4 class="font-bold text-white text-base sm:text-lg text-left">Powerful Essay Writing</h4>
                                    <p class="text-xs sm:text-sm text-blue-100/70 mt-1 text-left">Bedah struktur essay agar mampu menceritakan profilmu secara impresif.</p>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12 bg-red-600 text-white rounded-xl flex items-center justify-center font-bold">3</div>
                                <div>
                                    <h4 class="font-bold text-white text-base sm:text-lg text-left">Language Proficiency</h4>
                                    <p class="text-xs sm:text-sm text-blue-100/70 mt-1 text-left">Strategi menghadapi tes TOEFL/IELTS tanpa kursus jutaan rupiah.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- PRICING --}}
    <section id="pricing" class="py-16 sm:py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl sm:text-4xl font-black text-blue-900">Paket Belajar</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Reguler --}}
                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-200 flex flex-col">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest">Reguler</h3>
                    <div class="my-4 text-3xl font-black text-blue-900">Rp 20rb</div>
                    <ul class="space-y-4 mb-8 flex-grow text-xs sm:text-sm font-bold text-slate-600">
                        <li class="flex items-center gap-3"><i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-500"></i> Link Zoom & WA Group</li>
                        <li class="flex items-center gap-3"><i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-500"></i> E-Sertifikat</li>
                    </ul>
                    <a href="#" class="w-full py-4 rounded-2xl bg-slate-100 text-center font-black text-[10px] uppercase tracking-widest">Pilih Reguler</a>
                </div>

                {{-- VIP --}}
                <div class="bg-white p-8 rounded-[2.5rem] border-4 border-blue-600 flex flex-col shadow-2xl relative md:-translate-y-6">
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-red-600 text-white px-6 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest">Most Popular</div>
                    <h3 class="text-xs font-black text-blue-600 uppercase tracking-widest">VIP</h3>
                    <div class="my-4 text-4xl font-black text-blue-900">Rp 50rb</div>
                    <ul class="space-y-4 mb-8 flex-grow text-xs sm:text-sm font-bold text-slate-700">
                        <li class="flex items-center gap-3"><i data-lucide="check-circle-2" class="w-4 h-4 text-blue-600"></i> Benefit Reguler</li>
                        <li class="flex items-center gap-3"><i data-lucide="check-circle-2" class="w-4 h-4 text-blue-600"></i> Materi PDF & Rekaman</li>
                    </ul>
                    <a href="#" class="w-full py-4 rounded-2xl gradient-blue text-white text-center font-black text-[10px] uppercase tracking-widest">Pilih VIP</a>
                </div>

                {{-- VIP Plus+ --}}
                <div class="bg-slate-900 p-8 rounded-[2.5rem] flex flex-col text-white">
                    <h3 class="text-xs font-black text-blue-400 uppercase tracking-widest">VIP Plus+</h3>
                    <div class="my-4 text-3xl font-black">Rp 100rb</div>
                    <ul class="space-y-4 mb-8 flex-grow text-xs sm:text-sm font-bold">
                        <li class="flex items-center gap-3"><i data-lucide="star" class="w-4 h-4 fill-yellow-400 text-yellow-400"></i> Tes TOEFL CBT</li>
                        <li class="flex items-center gap-3"><i data-lucide="star" class="w-4 h-4 fill-yellow-400 text-yellow-400"></i> Sertifikat TOEFL</li>
                    </ul>
                    <a href="#" class="w-full py-4 rounded-2xl bg-white text-slate-900 text-center font-black text-[10px] uppercase tracking-widest">Pilih VIP Plus+</a>
                </div>
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="bg-white py-12 border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <div class="flex items-center justify-center gap-2 mb-4">
                <img src="{{ asset('img/logo.png') }}" class="h-8 w-auto">
                <span class="text-xl font-black text-blue-900">Sibali<span class="text-red-600">Event</span></span>
            </div>
            <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest">&copy; 2026 Webinar Beasiswa Unlocked</p>
        </div>
    </footer>

    <script>
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
    </script>
</body>
</html>