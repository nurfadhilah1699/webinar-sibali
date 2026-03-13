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