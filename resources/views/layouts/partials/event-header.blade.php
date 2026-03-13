{{-- resources/views/layouts/partials/event-header.blade.php --}}
<section class="relative bg-slate-900 pt-32 pb-20 text-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 relative z-10">
        {{-- Badge Tipe --}}
        <span class="bg-red-600 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest">
            {{ $type ?? 'Event' }}
        </span>
        
        {{-- Judul Dinamis --}}
        <h1 class="text-4xl md:text-6xl font-black mt-6 leading-tight max-w-4xl uppercase">
            {{ $title }}
        </h1>
        
        {{-- Deskripsi Singkat --}}
        <p class="mt-6 text-slate-400 text-lg max-w-2xl leading-relaxed">
            {{ $description }}
        </p>

        {{-- Slot untuk Tombol Tambahan (Opsional) --}}
        @if(isset($buttons))
            <div class="mt-10 flex flex-wrap gap-4">
                {!! $buttons !!}
            </div>
        @endif
    </div>

    {{-- Background Image/Aksen --}}
    <div class="absolute top-0 right-0 w-1/3 h-full bg-gradient-to-l from-blue-600/20 to-transparent"></div>
    
    {{-- Gambar latar tipis (opsional) --}}
    <img src="{{ asset('img/' . ($slug ?? 'default') . '.jpg') }}" 
         class="absolute inset-0 w-full h-full object-cover opacity-10 blur-sm -z-0"
         onerror="this.style.display='none'">
</section>