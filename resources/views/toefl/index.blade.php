<x-app-layout>
    {{-- ELEMEN TIMER --}}
    <div class="fixed top-20 right-10 z-50">
        <div class="bg-red-600 text-white px-6 py-3 rounded-2xl shadow-2xl border-4 border-white flex flex-col items-center">
            <span class="text-xs uppercase font-bold tracking-widest">Sisa Waktu</span>
            <span id="timer-display" class="text-2xl font-mono font-black">120:00</span>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-3xl shadow-xl border relative min-h-[500px]">
                
                <form id="toefl-form" action="{{ route('toefl.submit') }}" method="POST">
                    @csrf
                    
                    @foreach($questions as $index => $q)
                        {{-- Setiap soal dibungkus div 'question-step' --}}
                        <div class="question-step {{ $index == 0 ? '' : 'hidden' }}" data-step="{{ $index }}">
                            <div class="flex justify-between items-center mb-6">
                                <span class="px-4 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-bold uppercase tracking-wider">
                                    Section: {{ $q->category }}
                                </span>
                                <span class="text-gray-400 font-medium">Soal {{ $index + 1 }} dari {{ count($questions) }}</span>
                            </div>

                            <div class="progress-bar w-full bg-gray-100 h-2 rounded-full mb-8">
                                <div class="bg-indigo-600 h-2 rounded-full transition-all duration-500" style="width: {{ (($index + 1) / count($questions)) * 100 }}%"></div>
                            </div>

                            @if($q->audio_path)
                                <div class="mb-6 p-4 bg-gray-50 rounded-2xl border border-dashed border-gray-300">
                                    <p class="text-xs font-bold text-gray-500 mb-2 uppercase italic">Klik play untuk mendengarkan:</p>
                                    <audio controls class="w-full">
                                        <source src="{{ asset('storage/' . $q->audio_path) }}" type="audio/mpeg">
                                    </audio>
                                </div>
                            @endif

                            <h3 class="text-xl font-semibold text-gray-800 mb-8 leading-relaxed">
                                {{ $q->question_text }}
                            </h3>

                            <div class="space-y-4">
                                @foreach(['A', 'B', 'C', 'D'] as $opt)
                                    @php $optField = 'option_'.strtolower($opt); @endphp
                                    <label class="flex items-center gap-4 p-4 border-2 border-gray-100 rounded-2xl hover:border-indigo-500 hover:bg-indigo-50 cursor-pointer transition-all group">
                                        <input type="radio" name="answers[{{ $q->id }}]" value="{{ $opt }}" class="w-5 h-5 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                        <span class="text-gray-700 group-hover:text-indigo-900 font-medium">
                                            <strong class="mr-2">{{ $opt }}.</strong> {{ $q->$optField }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                    {{-- NAVIGASI TOMBOL --}}
                    <div class="mt-12 flex justify-between items-center pt-6 border-t border-gray-100">
                        <button type="button" id="prev-btn" class="hidden px-8 py-3 bg-gray-100 text-gray-600 rounded-xl font-bold hover:bg-gray-200 transition">
                            Sebelumnya
                        </button>
                        
                        <div class="flex-1"></div> {{-- Spacer --}}

                        <button type="button" id="next-btn" class="px-8 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition">
                            Berikutnya
                        </button>

                        <button type="submit" id="submit-btn" class="hidden px-10 py-3 bg-gray-900 text-white rounded-xl font-bold hover:bg-black shadow-lg transition">
                            Selesai & Kirim
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentStep = 0;
            const steps = document.querySelectorAll('.question-step');
            const totalSteps = steps.length;
            
            const nextBtn = document.getElementById('next-btn');
            const prevBtn = document.getElementById('prev-btn');
            const submitBtn = document.getElementById('submit-btn');

            function updateStep() {
                steps.forEach((step, index) => {
                    step.classList.toggle('hidden', index !== currentStep);
                });

                // Atur visibilitas tombol Prev
                prevBtn.classList.toggle('hidden', currentStep === 0);

                // Atur visibilitas tombol Next vs Submit
                if (currentStep === totalSteps - 1) {
                    nextBtn.classList.add('hidden');
                    submitBtn.classList.remove('hidden');
                } else {
                    nextBtn.classList.remove('hidden');
                    submitBtn.classList.add('hidden');
                }
            }

            nextBtn.addEventListener('click', () => {
                if (currentStep < totalSteps - 1) {
                    currentStep++;
                    updateStep();
                    window.scrollTo(0, 0);
                }
            });

            prevBtn.addEventListener('click', () => {
                if (currentStep > 0) {
                    currentStep--;
                    updateStep();
                    window.scrollTo(0, 0);
                }
            });

            // TIMER LOGIC (sama seperti sebelumnya)
            let timeInMinutes = 120;
            let currentTime = timeInMinutes * 60;
            const timerElement = document.getElementById('timer-display');

            setInterval(() => {
                let minutes = Math.floor(currentTime / 60);
                let seconds = currentTime % 60;
                timerElement.innerHTML = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
                if (currentTime <= 0) { document.getElementById('toefl-form').submit(); }
                currentTime--;
            }, 1000);
        });
    </script>
</x-app-layout>