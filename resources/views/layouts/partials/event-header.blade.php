<section class="relative bg-slate-900 pt-32 pb-24 text-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 relative z-10">
        {{-- Badge Tipe --}}
        <span class="inline-block bg-red-600 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest mb-2">
            {{ $type ?? 'Event' }}
        </span>
        
        {{-- Judul Dinamis (Mendukung HTML agar bisa diwarnai sebagian) --}}
        <h1 class="text-4xl md:text-6xl font-black mt-6 leading-tight max-w-4xl uppercase tracking-tighter">
            {!! $title !!}
        </h1>
        
        {{-- Deskripsi Singkat --}}
        @if(isset($description))
        <p class="mt-6 text-slate-400 text-lg max-w-2xl leading-relaxed">
            {{ $description }}
        </p>
        @endif

        {{-- Slot untuk Tombol/Informasi Tambahan (Opsional) --}}
        @if(isset($buttons))
            <div class="mt-10">
                {!! $buttons !!}
            </div>
        @endif
    </div>

    {{-- Aksen Gradasi --}}
    <div class="absolute top-0 right-0 w-1/3 h-full bg-gradient-to-l from-blue-600/20 to-transparent"></div>
    
    {{-- Gambar latar tipis --}}
    <img src="{{ asset('img/' . ($slug ?? 'default') . '.jpg') }}" 
         class="absolute inset-0 w-full h-full object-cover opacity-10 blur-sm -z-0"
         onerror="this.style.display='none'">
</section>