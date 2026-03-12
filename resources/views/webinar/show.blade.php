{{-- PRICING --}}
    <section id="pricing" class="py-16 sm:py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl sm:text-4xl font-black text-blue-900">Kategori Paket</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Reguler --}}
                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-200 flex flex-col">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest">Reguler</h3>
                    <div class="my-4 text-3xl font-black text-blue-900">Rp 20rb</div>
                    <ul class="space-y-4 mb-8 flex-grow text-xs sm:text-sm font-bold text-slate-600">
                        <li class="flex items-center gap-3"><i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-500"></i> Link Zoom & WA Group</li>
                        <li class="flex items-center gap-3"><i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-500"></i> E-Sertifikat Peserta</li>
                    </ul>
                    <a href="{{ route('register', ['package' => 'reguler']) }}" class="w-full py-4 rounded-2xl bg-slate-100 text-center font-black text-[10px] uppercase tracking-widest">Pilih Reguler</a>
                </div>

                {{-- VIP Plus+--}}
                <div class="bg-white p-8 rounded-[2.5rem] border-4 border-blue-600 flex flex-col shadow-2xl relative md:-translate-y-6">
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-red-600 text-white px-6 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest">Recommend</div>
                    <h3 class="text-xs font-black text-blue-600 uppercase tracking-widest">VIP Plus+</h3>
                    <div class="my-4 text-4xl font-black text-blue-900">Rp 100rb</div>
                    <ul class="space-y-4 mb-8 flex-grow text-xs sm:text-sm font-bold text-slate-700">
                        <li class="flex items-center gap-3"><i data-lucide="star" class="w-4 h-4 fill-yellow-400 text-yellow-400"></i> Benefit VIP</li>
                        <li class="flex items-center gap-3"><i data-lucide="star" class="w-4 h-4 fill-yellow-400 text-yellow-400"></i> TOEFL Prediction Test & E-Sertifikat Test</li>
                    </ul>
                    <a href="{{ route('register', ['package' => 'vip2']) }}" class="w-full py-4 rounded-2xl gradient-blue text-white text-center font-black text-[10px] uppercase tracking-widest">Pilih VIP Plus+</a>
                </div>

                {{-- VIP --}}
                <div class="bg-slate-900 p-8 rounded-[2.5rem] flex flex-col text-white">
                    <h3 class="text-xs font-black text-blue-400 uppercase tracking-widest">VIP</h3>
                    <div class="my-4 text-3xl font-black">Rp 50rb</div>
                    <ul class="space-y-4 mb-8 flex-grow text-xs sm:text-sm font-bold">
                        <li class="flex items-center gap-3"><i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600"></i> Benefit Reguler</li>
                        <li class="flex items-center gap-3"><i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600"></i> Materi PDF & Rekaman</li>
                    </ul>
                    <a href="{{ route('register', ['package' => 'vip1']) }}" class="w-full py-4 rounded-2xl bg-white text-slate-900 text-center font-black text-[10px] uppercase tracking-widest">Pilih VIP</a>
                </div>
            </div>
        </div>
    </section>