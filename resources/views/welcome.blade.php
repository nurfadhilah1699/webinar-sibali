<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webinar Sibali</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-50 font-sans antialiased">

    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex-shrink-0 flex items-center">
                    <span class="text-2xl font-bold text-indigo-600">Sibali<span class="text-red-800">Event</span></span>
                </div>
                <div class="hidden space-x-8 sm:flex">
                    <a href="#features" class="text-gray-600 hover:text-indigo-600">Fitur</a>
                    <a href="#pricing" class="text-gray-600 hover:text-indigo-600">Paket</a>
                </div>
                <div class="flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 underline">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-indigo-600">Masuk</a>
                            <a href="{{ route('register') }}" class="ml-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">Daftar</a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <section class="relative bg-white py-20 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100 mb-6 shadow-sm">
                    🎓 Bersama Awardee Beasiswa LPDP
                </span>
                <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                    <span class="block text-red-800">Raih Beasiswa Impian di</span>
                    <span class="block text-indigo-600">Dalam & Luar Negeri</span>
                </h1>
                <p class="mt-3 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                    Kupas tuntas strategi lolos Beasiswa LPDP Dalam dan Luar Negeri. Validasi kemampuan bahasa Inggrismu dengan simulasi TOEFL berstandar untuk lengkapi berkas pendaftaranmu!
                </p>
                <div class="mt-5 max-w-md mx-auto sm:flex sm:justify-center md:mt-8">
                    <div class="rounded-md shadow">
                        <a href="#pricing" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10">
                            Pilih Paket Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-12 bg-indigo-900 text-white relative overflow-hidden">
        <div class="absolute top-0 left-0 w-32 h-32 bg-white/5 rounded-full -translate-x-1/2 -translate-y-1/2"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col md:flex-row items-center justify-between gap-8">
                
                <div class="text-center md:text-left">
                    <span class="bg-indigo-500 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Upcoming Event</span>
                    <h2 class="text-3xl font-extrabold mt-2 italic">Save the Date!</h2>
                    <p class="text-indigo-200 text-lg mt-1">Sabtu, 15 Februari 2026</p>
                    <div class="flex items-center justify-center md:justify-start mt-2 text-sm space-x-4">
                        <span class="flex items-center">🕒 09:00 - 12:00 WITA</span>
                        <span class="flex items-center">📍 Via Zoom Meeting</span>
                    </div>
                </div>

                <div class="flex space-x-3 sm:space-x-4 text-center" id="countdown">
                    <div class="bg-white/10 backdrop-blur-md p-3 sm:p-4 rounded-xl border border-white/20 min-w-[70px] sm:min-w-[90px]">
                        <span id="days" class="text-2xl sm:text-4xl font-bold block">00</span>
                        <span class="text-[10px] sm:text-xs uppercase tracking-widest text-indigo-300">Hari</span>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md p-3 sm:p-4 rounded-xl border border-white/20 min-w-[70px] sm:min-w-[90px]">
                        <span id="hours" class="text-2xl sm:text-4xl font-bold block">00</span>
                        <span class="text-[10px] sm:text-xs uppercase tracking-widest text-indigo-300">Jam</span>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md p-3 sm:p-4 rounded-xl border border-white/20 min-w-[70px] sm:min-w-[90px]">
                        <span id="minutes" class="text-2xl sm:text-4xl font-bold block">00</span>
                        <span class="text-[10px] sm:text-xs uppercase tracking-widest text-indigo-300">Menit</span>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md p-3 sm:p-4 rounded-xl border border-white/20 min-w-[70px] sm:min-w-[90px]">
                        <span id="seconds" class="text-2xl sm:text-4xl font-bold block">00</span>
                        <span class="text-[10px] sm:text-xs uppercase tracking-widest text-indigo-300">Detik</span>
                    </div>
                </div>
                
            </div>
        </div>
    </section>

    <section id="features" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-gray-900">Apa yang Kamu Dapatkan?</h2>
            <div class="mt-12 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    <div class="text-indigo-600 mb-4 text-3xl">🎯</div>
                    <h3 class="text-xl font-bold mb-2">Strategy & Roadmap</h3>
                    <p class="text-gray-600">Panduan lengkap langkah demi langkah lolos beasiswa LPDP dan universitas top dunia dari para Awardee.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    <div class="text-indigo-600 mb-4 text-3xl">📝</div>
                    <h3 class="text-xl font-bold mb-2">Simulasi TOEFL</h3>
                    <p class="text-gray-600">Khusus VIP, uji kemampuan bahasa Inggrismu dengan sistem timer dan skor otomatis.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    <div class="text-indigo-600 mb-4 text-3xl">🎓</div>
                    <h3 class="text-xl font-bold mb-2">Sertifikat Digital</h3>
                    <p class="text-gray-600">E-Sertifikat resmi yang mencantumkan skor TOEFL untuk memperkuat portofolio magang.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="pricing" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Pilih Paket Webinar</h2>
            <p class="text-gray-600 mb-12">Daftar sesuai kebutuhan pengembangan dirimu.</p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="border rounded-2xl p-8 bg-white flex flex-col hover:shadow-xl transition">
                    <h3 class="text-lg font-semibold text-gray-900">Reguler</h3>
                    <p class="mt-4 text-4xl font-bold text-gray-900">Rp 20rb</p>
                    <p class="mt-1 text-gray-500 text-sm">(Basic)</p>
                    <ul class="mt-6 space-y-4 text-left text-sm text-gray-600">
                        <li class="flex items-center">✅ Link Zoom Webinar</li>
                        <li class="flex items-center">✅ E-Sertifikat Basic</li>
                        <li class="flex items-center text-gray-300">❌ Materi & Rekaman</li>
                        <li class="flex items-center text-gray-300">❌ Tes TOEFL & Skor</li>
                    </ul>
                    <a href="{{ route('register', ['package' => 'reguler']) }}" class="mt-8 block w-full bg-gray-100 text-gray-900 text-center py-2 rounded-lg font-semibold hover:bg-gray-200">Reguler</a>
                </div>

                <div class="border-2 border-indigo-600 rounded-2xl p-8 bg-white flex flex-col shadow-lg relative transform md:-translate-y-4">
                    <span class="absolute top-0 right-0 bg-indigo-600 text-white text-xs px-3 py-1 rounded-bl-lg rounded-tr-lg">Populer</span>
                    <h3 class="text-lg font-semibold text-gray-900">VIP 1</h3>
                    <p class="mt-4 text-4xl font-bold text-gray-900">Rp 50rb</p>
                    <ul class="mt-6 space-y-4 text-left text-sm text-gray-600">
                        <li class="flex items-center">✅ Link Zoom & WA Group</li>
                        <li class="flex items-center">✅ E-Sertifikat Eksklusif</li>
                        <li class="flex items-center">✅ Materi & Rekaman Sesi</li>
                        <li class="flex items-center text-gray-300">❌ Tes TOEFL & Skor</li>
                    </ul>
                    <a href="{{ route('register', parameters: ['package' => 'vip1']) }}" class="mt-8 block w-full bg-indigo-600 text-white text-center py-2 rounded-lg font-semibold hover:bg-indigo-700">Pilih VIP 1</a>
                </div>

                <div class="border rounded-2xl p-8 bg-white flex flex-col hover:shadow-xl transition">
                    <h3 class="text-lg font-semibold text-gray-900">VIP 2</h3>
                    <p class="mt-4 text-4xl font-bold text-gray-900">Rp 100rb</p>
                    <ul class="mt-6 space-y-4 text-left text-sm text-gray-600">
                        <li class="flex items-center">✅ Semua Fasilitas VIP 1</li>
                        <li class="flex items-center font-bold text-indigo-600">✅ Tes TOEFL (Timer & Skor)</li>
                        <li class="flex items-center">✅ Skor TOEFL di Sertifikat</li>
                        <li class="flex items-center">✅ Konsultasi Karir</li>
                    </ul>
                    <a href="{{ route('register', ['package' => 'vip2']) }}" class="mt-8 block w-full bg-gray-900 text-white text-center py-2 rounded-lg font-semibold hover:bg-black">Pilih VIP 2</a>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-gray-900 py-12 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; 2026 Sibali.Id</p>
        </div>
    </footer>

    <script>
        function updateTimer() {
            // Format: YYYY-MM-DDTHH:mm:ss+08:00 (Offset +08:00 adalah WITA)
            const targetDate = new Date("2026-02-15T09:00:00+08:00").getTime();
            
            const interval = setInterval(() => {
                const now = new Date().getTime();
                const distance = targetDate - now;

                if (distance < 0) {
                    clearInterval(interval);
                    document.getElementById("countdown").innerHTML = 
                        "<div class='text-2xl font-bold px-6 py-3 bg-white/20 rounded-lg animate-pulse'>Sedang Berlangsung! 🚀</div>";
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                document.getElementById("days").innerText = days.toString().padStart(2, '0');
                document.getElementById("hours").innerText = hours.toString().padStart(2, '0');
                document.getElementById("minutes").innerText = minutes.toString().padStart(2, '0');
                document.getElementById("seconds").innerText = seconds.toString().padStart(2, '0');
            }, 1000);
        }

        updateTimer();
    </script>
</body>
</html>