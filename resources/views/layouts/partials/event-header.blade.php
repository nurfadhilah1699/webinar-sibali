<section class="relative bg-slate-900 pt-32 pb-24 text-white overflow-hidden min-h-[550px] flex items-center">
    {{-- Container Utama --}}
    <div class="max-w-7xl mx-auto px-4 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 items-center mx-[30px]">
            
            {{-- KIRI: KONTEN TEKS --}}
            <div class="lg:col-span-7 order-2 lg:order-1">
                <div class="space-y-6">
                    <span class="inline-block bg-red-600 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest mb-2">
                        {{ $type ?? 'Event' }}
                    </span>
                    
                    <h1 class="text-5xl md:text-7xl font-black mt-6 leading-tight max-w-4xl uppercase tracking-tighter">
                        {!! $title !!}
                    </h1>

                    @if(isset($description))
                        <p class="text-slate-400 text-lg md:text-xl max-w-lg leading-relaxed font-light border-l-4 border-white/10 pl-6">
                            {{ $description }}
                        </p>
                    @endif

                    @if(isset($buttons))
                        <div class="flex flex-wrap items-center gap-4 pt-6">
                            {!! $buttons !!}
                        </div>
                    @endif
                </div>
            </div>

            {{-- KANAN: LOGO DENGAN GLOW PUTIH --}}
            @if(isset($logo))
                <div class="lg:col-span-5 order-1 lg:order-2 flex justify-center lg:justify-end group">
                    <div class="relative">
                        {{-- Aksen Lingkaran Putih/Silver di Belakang --}}
                        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[120%] h-[120%] bg-white/10 blur-[100px] rounded-full group-hover:bg-white/20 transition-all duration-700"></div>
                        
                        {{-- Ring Ornamen Tipis (Optional untuk kesan futuristik) --}}
                        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[110%] h-[110%] border border-white/5 rounded-full animate-spin-slow"></div>

                        {{-- Image Logo --}}
                        <img src="{{ asset('img/' . $logo) }}" 
                            alt="Logo Event" 
                            class="relative w-50 h-50 md:w-80 md:h-80 lg:w-[450px] lg:h-[450px] object-contain drop-shadow-[0_0_50px_rgba(255,255,255,0.2)] transition-all duration-500 group-hover:scale-105 group-hover:brightness-125"
                            onerror="this.style.display='none'">
                    </div>
                </div>
            @endif
            
        </div>
    </div>

    {{-- LAYER BACKGROUND --}}
    {{-- Gradasi Putih Halus dari Kanan --}}
    <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-white/[0.03] to-transparent pointer-events-none"></div>

    {{-- BG Image --}}
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('img/' . ($slug ?? 'default') . '.jpg') }}" 
             class="w-full h-full object-cover opacity-5 grayscale blur-[3px]"
             onerror="this.style.display='none'">
        {{-- Overlay Vignette --}}
        <div class="absolute inset-0 bg-radial-gradient from-transparent to-slate-950/90"></div>
    </div>
</section>

<style>
    /* Tambahan untuk animasi putar halus pada ring */
    .animate-spin-slow {
        animation: spin 10s linear infinite;
    }
    @keyframes spin {
        from { transform: translate(-50%, -50%) rotate(0deg); }
        to { transform: translate(-50%, -50%) rotate(360deg); }
    }
    .bg-radial-gradient {
        background: radial-gradient(circle, transparent 20%, #020617 85%);
    }
</style>