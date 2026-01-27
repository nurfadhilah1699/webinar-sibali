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
                    
                    @foreach($questions as $index => $q)
                        <div class="mb-10 p-6 bg-white rounded-2xl border shadow-sm">
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-xs font-bold px-3 py-1 bg-indigo-100 text-indigo-600 rounded-full uppercase">
                                    {{ $q->category }}
                                </span>
                                <span class="text-gray-400 text-sm">Soal No. {{ $index + 1 }}</span>
                            </div>

                            {{-- Jika ada audio (Listening) --}}
                            @if($q->audio_path)
                                <div class="mb-4 p-4 bg-gray-50 rounded-xl">
                                    <audio controls class="w-full">
                                        <source src="{{ asset('storage/' . $q->audio_path) }}" type="audio/mpeg">
                                        Your browser does not support the audio element.
                                    </audio>
                                </div>
                            @endif

                            <p class="font-bold text-gray-800 mb-4">{{ $q->question_text }}</p>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                                <label class="flex items-center gap-2 p-3 border rounded-xl hover:bg-indigo-50 cursor-pointer transition">
                                    <input type="radio" name="answers[{{ $q->id }}]" value="A" required> A. {{ $q->option_a }}
                                </label>
                                <label class="flex items-center gap-2 p-3 border rounded-xl hover:bg-indigo-50 cursor-pointer transition">
                                    <input type="radio" name="answers[{{ $q->id }}]" value="B"> B. {{ $q->option_b }}
                                </label>
                                <label class="flex items-center gap-2 p-3 border rounded-xl hover:bg-indigo-50 cursor-pointer transition">
                                    <input type="radio" name="answers[{{ $q->id }}]" value="C"> C. {{ $q->option_c }}
                                </label>
                                <label class="flex items-center gap-2 p-3 border rounded-xl hover:bg-indigo-50 cursor-pointer transition">
                                    <input type="radio" name="answers[{{ $q->id }}]" value="D"> D. {{ $q->option_d }}
                                </label>
                            </div>
                        </div>
                    @endforeach

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