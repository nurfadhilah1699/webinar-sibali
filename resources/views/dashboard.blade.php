<x-app-layout>
    @php
        $hour = (int)date('H');

        if ($hour >= 4 && $hour <= 10) {
            $greeting = 'Selamat Pagi';
        } elseif ($hour >= 11 && $hour <= 14) { // 11 AM - 2 PM
            $greeting = 'Selamat Siang';
        } elseif ($hour >= 15 && $hour <= 17) { // 3 PM - 5 PM
            $greeting = 'Selamat Sore';
        } else { 
            // Mencakup jam 18 (6 PM) sampai jam 03 pagi
            $greeting = 'Selamat Malam';
        }
    @endphp

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $greeting . ', ' . Auth::user()->name }}!
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
