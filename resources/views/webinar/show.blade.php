@extends('layouts.landing-page')

@section('content')
    @include('layouts.partials.event-header', [
        'type' => $event->type ?? 'Webinar',
        'title' => $event->title,
        'description' => $event->description,
        'slug' => $event->slug
    ])

    {{-- Lanjut ke konten jadwal & harga (masukan BD) --}}
    <main class="py-20 bg-white">
        ...
    </main>

    @include('layouts.partials.footer')
@endsection