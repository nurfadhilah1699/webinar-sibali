<x-app-layout>
    {{-- 1. ELEMEN TIMER (Sticky di pojok kanan atas) --}}
    <div class="fixed top-20 right-10 z-50">
        <div class="bg-red-600 text-white px-6 py-3 rounded-2xl shadow-2xl border-4 border-white flex flex-col items-center">
            <span class="text-xs uppercase font-bold tracking-widest">Sisa Waktu</span>
            <span id="timer-display" class="text-2xl font-mono font-black">120:00</span>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-2xl shadow-sm border relative">
                
                <div class="mb-8 text-center border-b pb-6">
                    <h2 class="text-2xl font-bold">Simulasi TOEFL - VIP 2</h2>
                    <p class="text-gray-500 text-sm">Pilih jawaban yang paling tepat. Jangan merefresh halaman!</p>
                </div>

                <form id="toefl-form" action="{{ route('toefl.submit') }}" method="POST">
                    @csrf
                    
                    {{-- SEKSI LISTENING --}}
                    <div class="mb-10 p-6 bg-indigo-50 rounded-2xl border border-indigo-100">
                        <h3 class="font-bold text-indigo-900 mb-4 flex items-center gap-2">
                            <span>🎧</span> Section 1: Listening Comprehension
                        </h3>
                        <div class="mb-6 p-4 bg-white rounded-xl border">
                            <p class="text-sm font-bold mb-3">Soal No. 1</p>
                            <audio controls onended="this.classList.add('opacity-50')" class="w-full mb-4">
                                {{-- Pastikan file ini ada di public/audio/soal-1.mp3 --}}
                                <source src="{{ asset('audio/soal-1.mp3') }}" type="audio/mpeg">
                                Browser tidak mendukung audio.
                            </audio>
                            <p class="font-medium mb-3">What does the man imply?</p>
                            <div class="space-y-2 text-sm">
                                <label class="flex items-center gap-2 cursor-pointer p-2 hover:bg-gray-50 rounded"><input type="radio" name="q1" value="A"> A. He is too tired to continue</label>
                                <label class="flex items-center gap-2 cursor-pointer p-2 hover:bg-gray-50 rounded"><input type="radio" name="q1" value="B"> B. He wants to take a break</label>
                                <label class="flex items-center gap-2 cursor-pointer p-2 hover:bg-gray-50 rounded"><input type="radio" name="q1" value="C"> C. He will finish it later</label>
                            </div>
                        </div>
                    </div>

                    {{-- SEKSI STRUCTURE --}}
                    <div class="mb-10 p-6 bg-emerald-50 rounded-2xl border border-emerald-100">
                        <h3 class="font-bold text-emerald-900 mb-4 flex items-center gap-2">
                            <span>📝</span> Section 2: Structure & Written Expression
                        </h3>
                        <div class="mb-6 p-4 bg-white rounded-xl border">
                            <p class="font-medium mb-3">2. The water _______ at 100 degrees Celsius.</p>
                            <div class="space-y-2 text-sm">
                                <label class="flex items-center gap-2 cursor-pointer p-2 hover:bg-gray-50 rounded"><input type="radio" name="q2" value="A"> A. Boils</label>
                                <label class="flex items-center gap-2 cursor-pointer p-2 hover:bg-gray-50 rounded"><input type="radio" name="q2" value="B"> B. Boiling</label>
                                <label class="flex items-center gap-2 cursor-pointer p-2 hover:bg-gray-50 rounded"><input type="radio" name="q2" value="C"> C. Boiled</label>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-gray-900 text-white py-4 rounded-2xl font-bold hover:bg-black transition shadow-lg">
                        Kirim Semua Jawaban
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Script dipindahkan ke dalam x-app-layout agar ter-render dengan baik --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let timeInMinutes = 120;
            let currentTime = timeInMinutes * 60;
            const timerElement = document.getElementById('timer-display');
            const form = document.getElementById('toefl-form');

            function updateTimer() {
                let minutes = Math.floor(currentTime / 60);
                let seconds = currentTime % 60;
                seconds = seconds < 10 ? '0' + seconds : seconds;
                
                timerElement.innerHTML = `${minutes}:${seconds}`;
                
                if (currentTime <= 0) {
                    clearInterval(interval);
                    alert("Waktu habis! Jawaban kamu akan dikirim otomatis.");
                    form.submit();
                } else {
                    currentTime--;
                }
            }

            const interval = setInterval(updateTimer, 1000);
        });
    </script>
</x-app-layout>