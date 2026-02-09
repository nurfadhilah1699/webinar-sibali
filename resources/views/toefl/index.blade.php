@php
    $isTestOpen = DB::table('settings')->where('key', 'is_test_open')->value('value') == '1';
@endphp

@if(!$isTestOpen)
    <script>
        window.location.href = "{{ route('dashboard') }}";
    </script>
@endif

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<x-app-layout>
    <style>
        [x-cloak] { display: none !important; }
        .toefl-wrapper { display: inline-flex; flex-direction: column; align-items: center; vertical-align: bottom; margin: 0 2px; line-height: 1; }
        .toefl-line { border-bottom: 2px solid #1e293b; padding: 0 4px; font-weight: 700; color: #1e293b; display: inline-block; }
        .toefl-label { font-size: 10px; font-weight: 900; margin-top: 4px; color: black; text-transform: uppercase; }
    </style>

    {{-- ELEMEN TIMER --}}
    <div class="fixed top-20 right-4 md:right-10 z-50">
        <div class="bg-red-600 text-white px-4 py-2 md:px-6 md:py-3 rounded-2xl shadow-2xl border-4 border-white flex flex-col items-center animate-fade-in">
            <span class="text-[10px] uppercase font-bold tracking-widest opacity-80">Sisa Waktu</span>
            <span id="timer-display" class="text-xl md:text-2xl font-mono font-black">00:00:00</span>
        </div>
    </div>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- GRID NOMOR (NAVIGASI CEPAT) --}}
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-200 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest">Navigasi Soal</h4>
                    <span class="text-[10px] bg-gray-100 text-gray-500 px-2 py-1 rounded font-bold" id="completion-status">0/{{ count($questions) }} Terjawab</span>
                </div>
                <div class="flex flex-wrap gap-2" id="number-grid">
                    @foreach($questions as $index => $q)
                        <button type="button" 
                                onclick="jumpToStep({{ $index }})" 
                                id="grid-btn-{{ $index }}"
                                class="w-10 h-10 rounded-xl border-2 border-gray-100 flex items-center justify-center text-sm font-bold transition-all hover:border-blue-600 text-gray-400">
                            {{ $index + 1 }}
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="bg-white p-6 md:p-10 rounded-3xl shadow-xl border border-gray-100 relative min-h-[500px]">
                <form id="toefl-form" action="{{ route('toefl.submit') }}" method="POST">
                    @csrf
                    
                    @foreach($questions as $index => $q)
                        <div class="question-step {{ $index == 0 ? '' : 'hidden' }}" data-step="{{ $index }}">
                            <div class="flex justify-between items-center mb-8">
                                <span class="px-4 py-1 bg-blue-50 text-blue-700 rounded-lg text-[10px] font-black uppercase tracking-wider border border-blue-100">
                                    {{ $q->category }}
                                </span>
                                <span class="text-gray-400 font-bold text-xs uppercase tracking-widest">Soal {{ $index + 1 }} / {{ count($questions) }}</span>
                            </div>

                            @if($q->audio_path)
                                <div class="mb-8 p-6 bg-gray-50 rounded-2xl border border-gray-100 shadow-inner">
                                    <p class="text-[10px] font-bold text-gray-400 uppercase mb-3 flex items-center gap-2">
                                        <span class="w-2 h-2 bg-red-500 rounded-full animate-ping"></span> Audio Listening
                                    </p>
                                    <audio controls class="w-full h-10" preload="none">
                                        <source src="{{ asset('storage/' . $q->audio_path) }}" type="audio/mpeg">
                                        Browser kamu tidak mendukung audio.
                                    </audio>
                                </div>
                            @endif

                            <div class="text-lg md:text-xl font-medium text-gray-800 mb-8 leading-relaxed text-justify">
                                {!! nl2br(preg_replace('/\[([^:]+):([^\]]+)\]/', 
                                    '<span class="inline-flex flex-col items-center mx-1"><span class="border-b-2 border-slate-900 font-bold px-1">$1</span><span class="font-black text-black mt-1">$2</span></span>', 
                                    $q->question_text)) 
                                !!}
                            </div>

                            <div class="grid grid-cols-1 gap-4">
                                @foreach(['A', 'B', 'C', 'D'] as $opt)
                                    @php $optField = 'option_'.strtolower($opt); @endphp
                                    <label class="flex items-center gap-4 p-5 border-2 border-gray-50 rounded-2xl hover:border-blue-600 hover:bg-blue-50 cursor-pointer transition-all group relative overflow-hidden">
                                        <input type="radio" 
                                               name="answers[{{ $q->id }}]" 
                                               value="{{ $opt }}" 
                                               onchange="markAsAnswered({{ $index }})"
                                               class="w-5 h-5 text-blue-900 border-gray-300 focus:ring-blue-900">
                                        <span class="text-gray-700 font-medium group-hover:text-blue-900">
                                            <b class="mr-2 text-blue-900">{{ $opt }}.</b> {{ $q->$optField }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                    {{-- NAVIGASI BUTTON --}}
                    <div class="mt-12 flex flex-col md:flex-row justify-between items-center pt-8 border-t border-gray-100 gap-4">
                        <div class="flex gap-3 w-full md:w-auto">
                            <button type="button" id="prev-btn" class="hidden flex-1 md:flex-none px-8 py-3 bg-gray-100 text-gray-600 rounded-xl font-bold hover:bg-gray-200 transition text-sm">
                                Sebelumnya
                            </button>
                            <button type="button" id="next-btn" class="flex-1 md:flex-none px-8 py-3 bg-blue-900 text-white rounded-xl font-bold hover:bg-black shadow-lg shadow-blue-200 transition text-sm">
                                Berikutnya
                            </button>
                        </div>

                        <button type="button" onclick="confirmSubmit()" class="w-full md:w-auto px-8 py-3 bg-red-50 text-red-600 border border-red-100 rounded-xl font-bold hover:bg-red-600 hover:text-white transition shadow-sm text-sm">
                            Selesaikan Tes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let currentStep = 0;
        const steps = document.querySelectorAll('.question-step');
        const totalSteps = steps.length;
        const form = document.getElementById('toefl-form');
        let isSubmitting = false;

        // --- 1. LOGIKA TIMER ---
        // Pastikan format date dari Laravel valid
        const startedAt = new Date("{{ $user->started_at }}").getTime();
        const duration = 120 * 60 * 1000; 
        const endTime = startedAt + duration;
        const timerDisplay = document.getElementById('timer-display');

        function updateTimer() {
            const now = new Date().getTime();
            const distance = endTime - now;

            if (distance <= 0) {
                clearInterval(timerInterval);
                timerDisplay.innerHTML = "00:00:00";

                if (isSubmitting) return; 
                isSubmitting = true;

                localStorage.removeItem('toefl_answers');
                Swal.fire({
                    title: 'Waktu Habis!',
                    text: 'Jawaban kamu akan otomatis dikirim.',
                    icon: 'warning',
                    timer: 2000,
                    showConfirmButton: false,
                    allowOutsideClick: false
                }).then(() => {
                    form.submit();
                });
                return;
            }

            const hours = Math.floor(distance / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            timerDisplay.innerHTML = `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        }

        // Jalankan timer tepat satu kali setiap detik
        const timerInterval = setInterval(updateTimer, 1000);
        updateTimer(); // Panggil langsung agar tidak menunggu 1 detik pertama

        // --- 2. FUNGSI NAVIGASI ---
        function updateStep() {
            steps.forEach((step, index) => {
                step.classList.toggle('hidden', index !== currentStep);
            });

            for(let i = 0; i < totalSteps; i++) {
                const btn = document.getElementById(`grid-btn-${i}`);
                if (btn) {
                    if (i === currentStep) {
                        btn.classList.add('ring-2', 'ring-blue-900', 'ring-offset-2', 'border-blue-900');
                    } else {
                        btn.classList.remove('ring-2', 'ring-blue-900', 'ring-offset-2', 'border-blue-900');
                    }
                }
            }

            document.getElementById('prev-btn').classList.toggle('hidden', currentStep === 0);
            document.getElementById('next-btn').classList.toggle('hidden', currentStep === totalSteps - 1);
        }

        function jumpToStep(n) {
            currentStep = n;
            updateStep();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function markAsAnswered(index) {
            const btn = document.getElementById(`grid-btn-${index}`);
            if (btn) {
                btn.classList.add('bg-green-600', 'text-white', 'border-green-600');
                btn.classList.remove('text-gray-400');
            }
            updateCompletionCounter();
        }

        function updateCompletionCounter() {
            const answered = document.querySelectorAll('input[type="radio"]:checked').length;
            document.getElementById('completion-status').innerText = `${answered}/${totalSteps} Terjawab`;
        }

        // --- 3. AUTO SAVE & LOAD ---
        window.addEventListener('DOMContentLoaded', () => {
            const savedAnswers = JSON.parse(localStorage.getItem('toefl_answers')) || {};
            
            Object.keys(savedAnswers).forEach(inputName => {
                const value = savedAnswers[inputName];
                const radio = document.querySelector(`input[name="${inputName}"][value="${value}"]`);
                if (radio) {
                    radio.checked = true;
                    const stepDiv = radio.closest('.question-step');
                    if (stepDiv) {
                        markAsAnswered(parseInt(stepDiv.dataset.step));
                    }
                }
            });
            updateStep();
            updateCompletionCounter();
        });

        document.querySelectorAll('input[type="radio"]').forEach(radio => {
            radio.addEventListener('change', (e) => {
                const savedAnswers = JSON.parse(localStorage.getItem('toefl_answers')) || {};
                savedAnswers[e.target.name] = e.target.value;
                localStorage.setItem('toefl_answers', JSON.stringify(savedAnswers));
                
                // Ambil index dari parent div
                const stepIndex = e.target.closest('.question-step').dataset.step;
                markAsAnswered(parseInt(stepIndex));
            });
        });

        // --- 4. SUBMIT LOGIC ---
        function confirmSubmit() {
            Swal.fire({
                title: 'Selesaikan Tes?',
                text: "Pastikan semua jawaban sudah terisi.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#1e3a8a',
                confirmButtonText: 'Ya, Kirim',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    isSubmitting = true;
                    localStorage.removeItem('toefl_answers');
                    form.submit();
                }
            });
        }

        document.getElementById('next-btn').addEventListener('click', () => {
            if (currentStep < totalSteps - 1) { currentStep++; updateStep(); window.scrollTo({top: 0, behavior: 'smooth'}); }
        });

        document.getElementById('prev-btn').addEventListener('click', () => {
            if (currentStep > 0) { currentStep--; updateStep(); window.scrollTo({top: 0, behavior: 'smooth'}); }
        });

        // Kirim ping ke server setiap 5 menit agar session tidak expired
        setInterval(function() {
            fetch('/ping'); // Buat route simple yang tidak melakukan apa-apa
        }, 300000);

        window.onbeforeunload = function() {
            if (!isSubmitting) {
                return "Apakah Anda yakin ingin meninggalkan ujian? Progress mungkin hilang.";
            }
        };
    </script>
</x-app-layout>