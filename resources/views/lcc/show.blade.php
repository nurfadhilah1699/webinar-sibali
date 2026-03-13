@extends('layouts.landing-page')

@section('content')
    @include('layouts.partials.event-header', [
        'type' => $event->type ?? 'Lomba',
        'title' => $event->title,
        'description' => $event->description,
        'slug' => $event->slug,
        'buttons' => '
            <a href="#" class="px-8 py-4 bg-white text-slate-900 font-black rounded-2xl uppercase tracking-widest text-xs">Daftar Tim</a>
            <a href="#" class="px-8 py-4 border border-white/30 text-white font-black rounded-2xl uppercase tracking-widest text-xs inline-flex items-center gap-2 hover:bg-white/10 transition">
                Unduh Juknis
            </a>
        '
    ])

    {{-- Lanjut ke konten Timeline Lomba --}}
    <main class="py-20">
        ...
    </main>

    @include('layouts.partials.footer')
@endsection