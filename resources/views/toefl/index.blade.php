<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<x-app-layout>
    {{-- ELEMEN TIMER --}}
    <div class="fixed top-20 right-10 z-50">
        <div class="bg-red-600 text-white px-6 py-3 rounded-2xl shadow-2xl border-4 border-white flex flex-col items-center">
            <span class="text-xs uppercase font-bold tracking-widest">Sisa Waktu</span>
            <span id="timer-display" class="text-2xl font-mono font-black">120:00</span>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            {{-- GRID NOMOR (NAVIGASI CEPAT) --}}
            <div class="bg-white p-6 rounded-3xl shadow-sm border mb-6">
                <h4 class="text-sm font-bold text-gray-700 mb-4 uppercase tracking-wider">Navigasi Soal</h4>
                <div class="flex flex-wrap gap-2" id="number-grid">
                    @foreach($questions as $index => $q)
                        <button type="button" 
                                onclick="jumpToStep({{ $index }})" 
                                id="grid-btn-{{ $index }}"
                                class="w-10 h-10 rounded-lg border-2 border-gray-100 flex items-center justify-center text-sm font-bold transition-all
                                {{ $index == 0 ? 'border-indigo-600 bg-indigo-50 text-indigo-600' : 'text-gray-400' }}">
                            {{ $index + 1 }}
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="bg-white p-8 rounded-3xl shadow-xl border relative min-h-[500px]">
                <form id="toefl-form" action="{{ route('toefl.submit') }}" method="POST">
                    @csrf
                    
                    @foreach($questions as $index => $q)
                        <div class="question-step {{ $index == 0 ? '' : 'hidden' }}" data-step="{{ $index }}">
                            <div class="flex justify-between items-center mb-6">
                                <span class="px-4 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-bold uppercase">
                                    {{ $q->category }}
                                </span>
                                <span class="text-gray-400 font-medium text-sm">Soal {{ $index + 1 }} / {{ count($questions) }}</span>
                            </div>

                            @if($q->audio_path)
                                <div class="mb-6 p-4 bg-gray-50 rounded-2xl border border-gray-200">
                                    <audio controls class="w-full">
                                        <source src="{{ asset('storage/' . $q->audio_path) }}" type="audio/mpeg">
                                    </audio>
                                </div>
                            @endif

                            <h3 class="text-xl font-semibold text-gray-800 mb-8">{{ $q->question_text }}</h3>

                            <div class="space-y-4">
                                @foreach(['A', 'B', 'C', 'D'] as $opt)
                                    @php $optField = 'option_'.strtolower($opt); @endphp
                                    <label class="flex items-center gap-4 p-4 border-2 border-gray-100 rounded-2xl hover:border-indigo-500 hover:bg-indigo-50 cursor-pointer transition-all group">
                                        <input type="radio" 
                                               name="answers[{{ $q->id }}]" 
                                               value="{{ $opt }}" 
                                               onchange="markAsAnswered({{ $index }})"
                                               class="w-5 h-5 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                        <span class="text-gray-700 font-medium group-hover:text-indigo-900">
                                            <strong class="mr-2">{{ $opt }}.</strong> {{ $q->$optField }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                    <div class="mt-12 flex flex-col md:flex-row justify-between items-center pt-6 border-t border-gray-100 gap-4">
                        <div class="flex gap-2">
                            <button type="button" id="prev-btn" class="hidden px-6 py-3 bg-gray-100 text-gray-600 rounded-xl font-bold hover:bg-gray-200 transition">
                                ← Sebelumnya
                            </button>
                            <button type="button" id="next-btn" class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition">
                                Berikutnya →
                            </button>
                        </div>

                        {{-- Tombol Akhiri Tes --}}
                        <button type="button" onclick="confirmSubmit()" class="w-full md:w-auto px-8 py-3 bg-red-100 text-red-600 border border-red-200 rounded-xl font-bold hover:bg-red-600 hover:text-white transition shadow-sm">
                            🚫 Akhiri & Kirim Jawaban
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

        // --- FUNGSI UPDATE TAMPILAN SOAL ---
        function updateStep() {
            steps.forEach((step, index) => {
                step.classList.toggle('hidden', index !== currentStep);
            });

            for(let i = 0; i < totalSteps; i++) {
                const btn = document.getElementById(`grid-btn-${i}`);
                if (i === currentStep) {
                    btn.classList.add('border-indigo-600', 'bg-indigo-50', 'text-indigo-600');
                } else {
                    btn.classList.remove('border-indigo-600', 'bg-indigo-50', 'text-indigo-600');
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
            btn.classList.add('bg-green-500', 'text-white', 'border-green-500');
            btn.classList.remove('text-gray-400');
        }

        // --- LOGIKA TIMER ANTI-LOMPAT ---
        const startedAt = new Date("{{ $user->started_at }}").getTime();
        const duration = 120 * 60 * 1000; 
        const endTime = startedAt + duration;
        const timerDisplay = document.getElementById('timer-display');

        function updateTimer() {
            const now = new Date().getTime();
            const distance = endTime - now;

            if (distance < 0) {
                timerDisplay.innerHTML = "00:00:00";
                document.getElementById('toefl-form').submit();
                return;
            }

            const hours = Math.floor((distance / (1000 * 60 * 60)));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Format agar selalu 2 digit (00:00:00)
            const hDisplay = hours.toString().padStart(2, '0');
            const mDisplay = minutes.toString().padStart(2, '0');
            const sDisplay = seconds.toString().padStart(2, '0');

            timerDisplay.innerHTML = `${hDisplay}:${mDisplay}:${sDisplay}`;
            
            // Bonus: Beri warna kuning jika < 10 menit, merah jika < 2 menit
            if (distance < (2 * 60 * 1000)) {
                timerDisplay.parentElement.classList.add('animate-pulse', 'bg-red-800');
            }
        }

        // PANGGIL SEGERA SAAT LOAD (Agar tidak lompat dari 120:00)
        updateTimer(); 
        // Jalankan interval
        const timerInterval = setInterval(updateTimer, 1000);

        // --- LOGIKA FORM & LOCALSTORAGE ---
        window.onload = () => {
            updateStep(); // Pastikan step awal sinkron
            let savedAnswers = JSON.parse(localStorage.getItem('toefl_answers'));
            if (savedAnswers) {
                Object.keys(savedAnswers).forEach(name => {
                    let value = savedAnswers[name];
                    let rb = document.querySelector(`input[name="${name}"][value="${value}"]`);
                    if (rb) {
                        rb.checked = true;
                        // Ambil index dari nama input "answers[123]"
                        const questionId = name.match(/\d+/)[0];
                        // Cari tombol grid yang sesuai (jika perlu manual, tapi markAsAnswered dipanggil via onchange)
                    }
                });
            }
        };

        document.querySelectorAll('input[type="radio"]').forEach(input => {
            input.addEventListener('change', (e) => {
                let answers = JSON.parse(localStorage.getItem('toefl_answers')) || {};
                answers[e.target.name] = e.target.value;
                localStorage.setItem('toefl_answers', JSON.stringify(answers));
            });
        });

        function confirmSubmit() {
            const answeredCount = document.querySelectorAll('input[type="radio"]:checked').length;
            const totalCount = {{ count($questions) }};

            Swal.fire({
                title: 'Akhiri Tes Sekarang?',
                text: `Terjawab: ${answeredCount} / ${totalCount} soal.`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#4F46E5',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Submit!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('toefl-form').submit();
                }
            });
        }

        document.getElementById('toefl-form').onsubmit = () => {
            localStorage.removeItem('toefl_answers');
            clearInterval(timerInterval);
        };

        document.getElementById('next-btn').addEventListener('click', () => {
            if (currentStep < totalSteps - 1) { currentStep++; updateStep(); }
        });

        document.getElementById('prev-btn').addEventListener('click', () => {
            if (currentStep > 0) { currentStep--; updateStep(); }
        });
    </script>
</x-app-layout>
