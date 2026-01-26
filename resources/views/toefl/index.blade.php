<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-2xl shadow-sm border">
                <div class="mb-8 text-center">
                    <h2 class="text-2xl font-bold">Simulasi TOEFL - VIP 2</h2>
                    <p class="text-gray-500 text-sm">Pilih jawaban yang paling tepat.</p>
                </div>

                <form action="{{ route('toefl.submit') }}" method="POST">
                    @csrf
                    
                    <div class="mb-6 p-4 border rounded-xl">
                        <p class="font-bold mb-3">1. She _______ to the market yesterday.</p>
                        <div class="space-y-2 text-sm">
                            <label class="flex items-center gap-2 cursor-pointer"><input type="radio" name="q1" value="A"> A. Go</label>
                            <label class="flex items-center gap-2 cursor-pointer"><input type="radio" name="q1" value="B"> B. Went</label>
                            <label class="flex items-center gap-2 cursor-pointer"><input type="radio" name="q1" value="C"> C. Gone</label>
                        </div>
                    </div>

                    <div class="mb-6 p-4 border rounded-xl">
                        <p class="font-bold mb-3">2. The water _______ at 100 degrees Celsius.</p>
                        <div class="space-y-2 text-sm">
                            <label class="flex items-center gap-2 cursor-pointer"><input type="radio" name="q2" value="A"> A. Boils</label>
                            <label class="flex items-center gap-2 cursor-pointer"><input type="radio" name="q2" value="B"> B. Boiling</label>
                            <label class="flex items-center gap-2 cursor-pointer"><input type="radio" name="q2" value="C"> C. Boiled</label>
                        </div>
                    </div>

                    {{-- Tambahkan soal 3, 4, 5 dst dengan format yang sama --}}

                    <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-xl font-bold hover:bg-indigo-700 transition">
                        Selesaikan Tes & Simpan Skor
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>