<x-admin-layout>
    <div class="mb-8">
        <h1 class="text-3xl font-black text-slate-800 tracking-tight">Bank Soal TOEFL</h1>
        <p class="text-slate-500 text-sm mt-1">Tambahkan materi ujian baru untuk peserta webinar.</p>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-200 overflow-hidden">
        {{-- Header Form --}}
        <div class="p-8 border-b border-slate-100 bg-slate-50/50 flex items-center gap-4">
            <div class="p-3 bg-indigo-600 rounded-2xl shadow-lg shadow-indigo-200">
                <i data-lucide="database-backup" class="w-6 h-6 text-white"></i>
            </div>
            <div>
                <h3 class="text-xl font-black text-slate-800">Tambah Soal Baru</h3>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Master Data Question</p>
            </div>
        </div>
        
        <form action="{{ route('admin.questions.store') }}" method="POST" enctype="multipart/form-data" class="p-8 lg:p-10">
            @csrf
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-12">
                
                {{-- Kolom Kiri: Konten Soal --}}
                <div class="space-y-6">
                    <div class="group">
                        <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Kategori Section</label>
                        <select name="category" class="w-full border-slate-200 rounded-2xl focus:ring-indigo-500 focus:border-indigo-500 text-sm p-4 bg-slate-50/50 font-semibold text-slate-700 transition-all">
                            <option value="listening">🎧 Section 1: Listening Comprehension</option>
                            <option value="structure">📝 Section 2: Structure & Written Expression</option>
                            <option value="reading">📖 Section 3: Reading Comprehension</option>
                        </select>
                    </div>

                    <div class="p-6 bg-indigo-50/50 rounded-[2rem] border border-indigo-100 border-dashed">
                        <label class="block text-[11px] font-black text-indigo-400 uppercase tracking-widest mb-3 flex items-center gap-2">
                            <i data-lucide="mic-2" class="w-3 h-3"></i>
                            File Audio (MP3)
                        </label>
                        <input type="file" name="audio_file" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 cursor-pointer">
                        <p class="text-[9px] text-indigo-400 mt-2 font-medium italic">*Wajib diisi jika memilih kategori Listening</p>
                    </div>

                    <div>
                        <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Teks Pertanyaan / Narasi</label>
                        <textarea name="question_text" rows="6" class="w-full border-slate-200 rounded-[2rem] focus:ring-indigo-500 focus:border-indigo-500 text-sm p-6 bg-slate-50/50 placeholder:text-slate-300 font-medium" placeholder="Tuliskan teks pertanyaan atau passage di sini..." required></textarea>
                    </div>
                </div>

                {{-- Kolom Kanan: Pilihan Jawaban --}}
                <div class="space-y-4">
                    <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-4 ml-1">Pilihan Ganda & Kunci</p>
                    
                    @foreach(['A', 'B', 'C', 'D'] as $opt)
                    <div class="relative group">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 w-8 h-8 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-xs font-black text-slate-400 group-focus-within:border-indigo-500 group-focus-within:text-indigo-600 transition-all">
                            {{ $opt }}
                        </span>
                        <input type="text" name="option_{{ strtolower($opt) }}" class="w-full border-slate-200 rounded-2xl focus:ring-indigo-500 focus:border-indigo-500 text-sm p-4 pl-16 bg-slate-50/50 font-medium" placeholder="Opsi {{ $opt }}..." required>
                    </div>
                    @endforeach

                    <div class="mt-8 p-6 bg-emerald-50 rounded-[2rem] border border-emerald-100">
                        <label class="block text-[11px] font-black text-emerald-600 uppercase tracking-widest mb-3 ml-1 flex items-center gap-2">
                            <i data-lucide="check-circle" class="w-4 h-4"></i>
                            Tentukan Jawaban Benar
                        </label>
                        <div class="grid grid-cols-4 gap-3">
                            @foreach(['A', 'B', 'C', 'D'] as $ans)
                            <label class="cursor-pointer">
                                <input type="radio" name="correct_answer" value="{{ $ans }}" class="peer hidden" {{ $ans == 'A' ? 'checked' : '' }}>
                                <div class="p-3 text-center rounded-xl border-2 border-emerald-100 bg-white text-emerald-600 font-black text-sm peer-checked:bg-emerald-600 peer-checked:text-white peer-checked:border-emerald-600 transition-all shadow-sm">
                                    {{ $ans }}
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer Action --}}
            <div class="mt-12 pt-8 border-t border-slate-100 flex flex-col sm:flex-row justify-end items-center gap-4">
                <button type="reset" class="text-slate-400 hover:text-slate-600 text-xs font-black uppercase tracking-widest px-6 transition-colors">
                    Reset Form
                </button>
                <button type="submit" class="group relative flex items-center gap-3 bg-slate-900 text-white px-10 py-4 rounded-2xl font-black text-xs uppercase tracking-[0.2em] hover:bg-indigo-600 transition-all shadow-xl shadow-slate-200 active:scale-95">
                    <i data-lucide="save" class="w-4 h-4 group-hover:animate-bounce"></i>
                    Simpan ke Bank Soal
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>