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

        function updateStep() {
            // Update Soal yang tampil
            steps.forEach((step, index) => {
                step.classList.toggle('hidden', index !== currentStep);
            });

            // Update Style Grid Nomor
            for(let i = 0; i < totalSteps; i++) {
                const btn = document.getElementById(`grid-btn-${i}`);
                if (i === currentStep) {
                    btn.classList.add('border-indigo-600', 'bg-indigo-50', 'text-indigo-600');
                } else {
                    btn.classList.remove('border-indigo-600', 'bg-indigo-50', 'text-indigo-600');
                }
            }

            // Atur tombol nav
            document.getElementById('prev-btn').classList.toggle('hidden', currentStep === 0);
            if (currentStep === totalSteps - 1) {
                document.getElementById('next-btn').classList.add('hidden');
                document.getElementById('submit-btn').classList.remove('hidden');
            } else {
                document.getElementById('next-btn').classList.remove('hidden');
                document.getElementById('submit-btn').classList.add('hidden');
            }
        }

        function jumpToStep(n) {
            currentStep = n;
            updateStep();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function markAsAnswered(index) {
            // Beri warna hijau pada grid jika sudah dijawab
            const btn = document.getElementById(`grid-btn-${index}`);
            btn.classList.add('bg-green-500', 'text-white', 'border-green-500');
            btn.classList.remove('text-gray-400');
        }

        document.getElementById('next-btn').addEventListener('click', () => {
            if (currentStep < totalSteps - 1) { currentStep++; updateStep(); }
        });

        document.getElementById('prev-btn').addEventListener('click', () => {
            if (currentStep > 0) { currentStep--; updateStep(); }
        });

        // TIMER LOGIC
        let timeInMinutes = 120;
        let currentTime = timeInMinutes * 60;
        const timerDisplay = document.getElementById('timer-display');
        setInterval(() => {
            let min = Math.floor(currentTime / 60);
            let sec = currentTime % 60;
            timerDisplay.innerHTML = `${min}:${sec < 10 ? '0' : ''}${sec}`;
            if (currentTime <= 0) document.getElementById('toefl-form').submit();
            currentTime--;
        }, 1000);

        function confirmSubmit() {
            // Menghitung berapa soal yang sudah diisi
            const answeredCount = document.querySelectorAll('input[type="radio"]:checked').length;
            const totalCount = {{ count($questions) }};

            Swal.fire({
                title: 'Yakin ingin mengakhiri tes?',
                text: `Kamu baru menjawab ${answeredCount} dari ${totalCount} soal. Soal yang tidak dijawab akan dianggap salah.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4F46E5', // Indigo-600
                cancelButtonColor: '#EF4444', // Red-500
                confirmButtonText: 'Ya, Kirim Sekarang!',
                cancelButtonText: 'Belum, Lanjutkan Tes'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('toefl-form').submit();
                }
            })
        }
    </script>
</x-app-layout>
