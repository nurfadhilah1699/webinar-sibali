<x-app-layout>
    <div class="p-6 bg-white rounded-2xl shadow-sm border">
        <h3 class="text-xl font-bold mb-6">Tambah Soal TOEFL Baru</h3>
        
        <form action="{{ route('admin.questions.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold mb-2">Kategori Section</label>
                        <select name="category" class="w-full border-gray-300 rounded-lg">
                            <option value="listening">Section 1: Listening</option>
                            <option value="structure">Section 2: Structure</option>
                            <option value="reading">Section 3: Reading</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-2">File Audio (Khusus Listening)</label>
                        <input type="file" name="audio_file" class="w-full text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-2">Teks Pertanyaan</label>
                        <textarea name="question_text" rows="4" class="w-full border-gray-300 rounded-lg" required></textarea>
                    </div>
                </div>

                <div class="space-y-3">
                    <div>
                        <label class="text-xs font-bold text-gray-500 uppercase">Pilihan A</label>
                        <input type="text" name="option_a" class="w-full border-gray-300 rounded-lg" required>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-500 uppercase">Pilihan B</label>
                        <input type="text" name="option_b" class="w-full border-gray-300 rounded-lg" required>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-500 uppercase">Pilihan C</label>
                        <input type="text" name="option_c" class="w-full border-gray-300 rounded-lg" required>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-500 uppercase">Pilihan D</label>
                        <input type="text" name="option_d" class="w-full border-gray-300 rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-indigo-600">Jawaban Benar</label>
                        <select name="correct_answer" class="w-full border-indigo-300 rounded-lg font-bold text-indigo-600">
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                        </select>
                    </div>
                </div>
            </div>

            <button type="submit" class="mt-8 bg-indigo-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-indigo-700">
                Simpan Soal ke Bank Soal
            </button>
        </form>
    </div>
</x-app-layout>