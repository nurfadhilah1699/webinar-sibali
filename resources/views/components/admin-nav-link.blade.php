@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center gap-3 px-4 py-3 bg-indigo-500/10 text-indigo-400 rounded-xl transition-all duration-300 group border-l-4 border-indigo-500 shadow-inner'
            : 'flex items-center gap-3 px-4 py-3 text-slate-400 hover:text-white hover:bg-slate-800/50 rounded-xl transition-all duration-200 group border-l-4 border-transparent';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{-- Container untuk ikon agar ukurannya tetap terjaga --}}
    <div class="shrink-0 {{ ($active ?? false) ? 'text-indigo-400' : 'text-slate-500 group-hover:text-indigo-400' }} transition-colors">
        {{ $slot }}
    </div>
</a>