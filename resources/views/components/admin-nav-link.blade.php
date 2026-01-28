@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center p-3 text-sm font-bold bg-indigo-600 text-white rounded-xl shadow-lg shadow-indigo-900/50 transition'
            : 'flex items-center p-3 text-sm font-medium text-gray-400 hover:text-white hover:bg-gray-800 rounded-xl transition';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>