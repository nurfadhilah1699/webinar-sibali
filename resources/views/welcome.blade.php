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
    </style>
</head>
<body class="bg-white text-slate-900 antialiased">

    {{-- NAVBAR --}}
    <nav x-data="{ open: false }" class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo" class="h-10 w-auto">
                    <span class="text-xl font-extrabold tracking-tighter text-blue-900">Sibali<span class="text-red-600">Event</span></span>
                </div>
                
                <div class="hidden md:flex space-x-10">
                    <a href="#features" class="text-sm font-bold text-slate-600 hover:text-blue-600 transition">Fitur</a>
                    <a href="#about" class="text-sm font-bold text-slate-600 hover:text-blue-600 transition">Tentang</a>
                    <a href="#pricing" class="text-sm font-bold text-slate-600 hover:text-blue-600 transition">Paket</a>
                </div>

                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-bold text-blue-600 px-4 py-2 bg-blue-50 rounded-lg">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="hidden sm:block text-sm font-bold text-slate-600 hover:text-blue-600">Masuk</a>
                        <a href="{{ route('register') }}" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-full transition-all shadow-lg shadow-blue-200">Daftar</a>
                    @endauth
                    
                    <button @click="open = !open" class="md:hidden p-2 text-slate-600 transition-transform" :class="{'rotate-90': open}">
                        <i data-lucide="menu" x-show="!open"></i>
                        <i data-lucide="x" x-show="open"></i>
                    </button>
                </div>
            </div>
        </div>
        
        {{-- Mobile Menu --}}
        <div x-show="open" x-transition.opacity class="md:hidden bg-white border-b px-4 py-6 space-y-4 shadow-xl">
            <a href="#features" @click="open = false" class="block font-bold text-slate-600">Fitur</a>
            <a href="#about" @click="open = false" class="block font-bold text-slate-600">Tentang</a>
            <a href="#pricing" @click="open = false" class="block font-bold text-slate-600">Paket</a>
            <hr>
            <a href="{{ route('login') }}" class="block font-bold text-blue-600">Masuk Peserta</a>
        </div>
    </nav>

    {{-- HERO SECTION --}}
    <section class="relative pt-12 pb-24 overflow-hidden bg-pattern">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center text-center lg:text-left">
                <div>
                    <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-black bg-red-50 text-red-600 border border-red-100 mb-6 tracking-widest uppercase">
                        🚀 Limited Slot - Beasiswa 2026
                    </span>
                    <h1 class="text-5xl lg:text-7xl font-extrabold text-blue-900 leading-[1.1] tracking-tight">
                        Wujudkan <br>
                        <span class="text-red-600">Mimpi Kampus</span> <br>
                        <span class="underline decoration-blue-200">Impianmu</span>
                    </h1>
                    <p class="mt-6 text-lg text-slate-500 leading-relaxed max-w-xl mx-auto lg:mx-0 font-medium">
                        Persiapkan dirimu menembus Beasiswa LPDP & Luar Negeri bersama mentor berpengalaman dan ukur kemampuanmu dengan simulasi TOEFL eksklusif.
                    </p>
                    <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="#pricing" class="px-8 py-4 gradient-blue text-white font-black rounded-2xl shadow-xl shadow-blue-200 hover:scale-105 transition-all text-center uppercase text-xs tracking-widest">
                            Pilih Paket Sekarang
                        </a>
                        <a href="#features" class="px-8 py-4 bg-white text-slate-600 font-black rounded-2xl border border-slate-200 hover:bg-slate-50 transition-all text-center uppercase text-xs tracking-widest">
                            Lihat Fasilitas
                        </a>
                    </div>
                </div>
                <div class="relative">
                    <div class="absolute inset-0 bg-blue-400/20 blur-[100px] rounded-full"></div>
                    <img src="{{ asset('img/logo.png') }}" alt="Hero Image" class="relative z-10 w-full max-w-md mx-auto drop-shadow-2xl animate-float">
                </div>
            </div>
        </div>
    </section>

    {{-- FEATURES SECTION --}}
    <section id="features" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-black text-blue-900">Kenapa Harus Ikut Webinar Ini?</h2>
                <div class="h-1.5 w-20 bg-red-600 mx-auto mt-4 rounded-full"></div>
            </div>
            <div class="grid md:grid-cols-3 gap-10">
                <div class="p-10 rounded-[2.5rem] bg-slate-50 border border-slate-100 hover:shadow-2xl hover:shadow-blue-100 transition-all group">
                    <div class="w-14 h-14 bg-blue-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-blue-200 group-hover:rotate-6 transition-transform">
                        <i data-lucide="graduation-cap" class="text-white"></i>
                    </div>
                    <h3 class="text-xl font-black text-slate-800 mb-3">Awardee Mentorship</h3>
                    <p class="text-slate-500 leading-relaxed text-sm font-medium">Dapatkan insight langsung dari penerima beasiswa LPDP tentang cara membuat essay yang memikat reviewer.</p>
                </div>
                <div class="p-10 rounded-[2.5rem] bg-slate-50 border border-slate-100 hover:shadow-2xl hover:shadow-blue-100 transition-all group">
                    <div class="w-14 h-14 bg-red-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-red-200 group-hover:rotate-6 transition-transform">
                        <i data-lucide="clipboard-check" class="text-white"></i>
                    </div>
                    <h3 class="text-xl font-black text-slate-800 mb-3">Real TOEFL Simulation</h3>
                    <p class="text-slate-500 leading-relaxed text-sm font-medium">Uji skor TOEFL-mu dengan sistem computer-based test (CBT) yang dilengkapi timer dan hasil instan.</p>
                </div>
                <div class="p-10 rounded-[2.5rem] bg-slate-50 border border-slate-100 hover:shadow-2xl hover:shadow-blue-100 transition-all group">
                    <div class="w-14 h-14 bg-emerald-500 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-emerald-200 group-hover:rotate-6 transition-transform">
                        <i data-lucide="users" class="text-white"></i>
                    </div>
                    <h3 class="text-xl font-black text-slate-800 mb-3">Networking Group</h3>
                    <p class="text-slate-500 leading-relaxed text-sm font-medium">Bergabung dengan komunitas pejuang beasiswa lainnya untuk saling berbagi informasi dan semangat.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ABOUT SECTION --}}
    <section id="about" class="py-24 bg-blue-900 relative overflow-hidden">
        <div class="absolute right-0 top-0 w-1/3 h-full bg-blue-800/30 -skew-x-12 translate-x-1/2"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col lg:flex-row items-center gap-16 text-white">
                <div class="lg:w-1/2">
                    <h2 class="text-4xl font-black mb-8 leading-tight">Tentang Program <br> Webinar Unlocked</h2>
                    <p class="text-blue-100 mb-6 leading-relaxed font-medium">
                        Program ini diinisiasi oleh <span class="font-bold underline decoration-red-500">Sibali Event</span> untuk menjembatani kesenjangan informasi mengenai akses pendidikan tinggi. Kami percaya bahwa setiap anak bangsa berhak mendapatkan pendidikan terbaik.
                    </p>
                    <p class="text-blue-200 leading-relaxed font-medium">
                        Hingga tahun 2026, kami telah membantu ribuan peserta untuk memetakan roadmap beasiswa mereka, meningkatkan skor bahasa Inggris, dan menghubungkan mereka dengan mentor-mentor berkualitas dari berbagai negara.
                    </p>
                </div>
                <div class="lg:w-1/2 grid grid-cols-2 gap-4">
                    <div class="bg-white/10 backdrop-blur-md p-8 rounded-3xl border border-white/20 text-center">
                        <span class="text-4xl font-black block mb-2">1500+</span>
                        <span class="text-xs font-bold uppercase tracking-widest text-blue-300">Peserta Lulus</span>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md p-8 rounded-3xl border border-white/20 text-center">
                        <span class="text-4xl font-black block mb-2">12+</span>
                        <span class="text-xs font-bold uppercase tracking-widest text-blue-300">Awardee Mentor</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- PRICING --}}
    <section id="pricing" class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-black text-blue-900 tracking-tight">Investasi Masa Depanmu</h2>
                <p class="text-slate-500 mt-4 font-semibold italic">Daftar sekarang sebelum kuota penuh!</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-stretch">
                {{-- Reguler --}}
                <div class="bg-white p-10 rounded-[3rem] border border-slate-200 flex flex-col hover:-translate-y-2 transition-all">
                    <h3 class="text-lg font-black text-slate-400 uppercase tracking-widest">Reguler</h3>
                    <div class="my-6 flex items-baseline gap-1">
                        <span class="text-4xl font-black text-blue-900">Rp 20rb</span>
                    </div>
                    <ul class="space-y-4 mb-10 flex-grow text-sm font-bold text-slate-600">
                        <li class="flex items-center gap-3"><i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-500"></i> Link Zoom Webinar</li>
                        <li class="flex items-center gap-3"><i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-500"></i> WA Group Sharing</li>
                        <li class="flex items-center gap-3"><i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-500"></i> E-Sertifikat Basic</li>
                        <li class="flex items-center gap-3 text-slate-300 italic"><i data-lucide="x-circle" class="w-5 h-5"></i> Materi & Rekaman</li>
                        <li class="flex items-center gap-3 text-slate-300 italic"><i data-lucide="x-circle" class="w-5 h-5"></i> Tes TOEFL & Skor</li>
                    </ul>
                    <a href="{{ route('register', ['package' => 'reguler']) }}" class="w-full py-4 rounded-2xl bg-slate-100 text-slate-800 font-black text-xs uppercase tracking-[0.2em] hover:bg-slate-200 transition text-center">Daftar Reguler</a>
                </div>

                {{-- VIP (DB: vip1) --}}
                <div class="bg-white p-10 rounded-[3rem] border-4 border-blue-600 flex flex-col shadow-2xl shadow-blue-100 relative transform md:-translate-y-8">
                    <div class="absolute -top-5 left-1/2 -translate-x-1/2 bg-red-600 text-white px-8 py-2 rounded-full text-[10px] font-black uppercase tracking-[0.3em] whitespace-nowrap shadow-lg">Most Recommended</div>
                    <h3 class="text-lg font-black text-blue-600 uppercase tracking-widest">VIP</h3>
                    <div class="my-6 text-center">
                        <span class="text-5xl font-black text-blue-900">Rp 50rb</span>
                    </div>
                    <ul class="space-y-4 mb-10 flex-grow text-sm font-bold text-slate-700">
                        <li class="flex items-center gap-3"><i data-lucide="check-circle-2" class="w-5 h-5 text-blue-600"></i> Semua Benefit Reguler</li>
                        <li class="flex items-center gap-3"><i data-lucide="check-circle-2" class="w-5 h-5 text-blue-600"></i> WA Group Exclusive</li>
                        <li class="flex items-center gap-3"><i data-lucide="check-circle-2" class="w-5 h-5 text-blue-600"></i> Materi PDF & Rekaman</li>
                        <li class="flex items-center gap-3"><i data-lucide="check-circle-2" class="w-5 h-5 text-blue-600"></i> E-Sertifikat Eksklusif</li>
                        <li class="flex items-center gap-3 text-slate-300 italic"><i data-lucide="x-circle" class="w-5 h-5"></i> Tes TOEFL & Skor</li>
                    </ul>
                    <a href="{{ route('register', ['package' => 'vip1']) }}" class="w-full py-4 rounded-2xl gradient-blue text-white font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-blue-200 transition text-center hover:scale-105">Daftar VIP</a>
                </div>

                {{-- VIP Plus+ (DB: vip2) --}}
                <div class="bg-slate-900 p-10 rounded-[3rem] flex flex-col shadow-xl text-white">
                    <h3 class="text-lg font-black text-blue-400 uppercase tracking-widest">VIP Plus+</h3>
                    <div class="my-6">
                        <span class="text-4xl font-black">Rp 100rb</span>
                    </div>
                    <ul class="space-y-4 mb-10 flex-grow text-sm font-bold">
                        <li class="flex items-center gap-3 text-blue-200"><i data-lucide="star" class="w-5 h-5 fill-yellow-400 text-yellow-400"></i> Semua Fasilitas VIP</li>
                        <li class="flex items-center gap-3 text-blue-200"><i data-lucide="star" class="w-5 h-5 fill-yellow-400 text-yellow-400"></i> Tes TOEFL (CBT & Timer)</li>
                        <li class="flex items-center gap-3 text-blue-200"><i data-lucide="star" class="w-5 h-5 fill-yellow-400 text-yellow-400"></i> Skor TOEFL di Sertifikat</li>
                        <li class="flex items-center gap-3 text-blue-200"><i data-lucide="star" class="w-5 h-5 fill-yellow-400 text-yellow-400"></i> Prioritas Sesi Q&A</li>
                    </ul>
                    <a href="{{ route('register', ['package' => 'vip2']) }}" class="w-full py-4 rounded-2xl bg-white text-slate-900 font-black text-xs uppercase tracking-[0.2em] hover:bg-blue-50 transition text-center">Daftar VIP Plus+</a>
                </div>
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="bg-white py-16 border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <div class="flex items-center justify-center gap-2 mb-6">
                <img src="{{ asset('img/logo.png') }}" class="h-8 w-auto">
                <span class="text-xl font-black text-blue-900 tracking-tighter">Sibali<span class="text-red-600">Event</span></span>
            </div>
            <p class="text-slate-400 text-sm font-bold uppercase tracking-widest mb-2">&copy; 2026 Webinar Beasiswa Unlocked</p>
            <p class="text-slate-300 text-[10px] font-medium">Bekerja sama dengan Awardee LPDP & English Test Center</p>
        </div>
    </footer>

    <script>
        lucide.createIcons();

        function updateTimer() {
            const targetDate = new Date("2026-02-15T09:00:00+08:00").getTime();
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