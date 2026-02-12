<x-admin-layout>
    {{-- CSS Tambahan: Untuk merender tampilan garis bawah khas TOEFL --}}
    <style>
        [x-cloak] { display: none !important; }
        .toefl-wrapper { display: inline-flex; flex-direction: column; align-items: center; vertical-align: bottom; margin: 0 2px; line-height: 1; }
        .toefl-line { border-bottom: 2px solid #1e293b; padding: 0 4px; font-weight: 700; color: #1e293b; display: inline-block; }
        .toefl-label { font-size: 10px; font-weight: 900; margin-top: 4px; color: black; text-transform: uppercase; }
    </style>

    <div class="mb-8">
        <h1 class="text-3xl font-black text-slate-800 tracking-tight">Bank Soal TOEFL</h1>
        <p class="text-slate-500 text-sm mt-1">Tambahkan materi ujian baru untuk peserta webinar.</p>
    </div>

    {{-- Statistik Soal --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="bg-white p-5 rounded-[2rem] border border-slate-200 flex items-center gap-4 shadow-sm">
            <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center">
                <i data-lucide="headphones" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Listening</p>
                <h4 class="text-xl font-black text-slate-800">{{ $counts['listening'] }} <span class="text-xs font-medium text-slate-400">/ 50</span></h4>
            </div>
        </div>

        <div class="bg-white p-5 rounded-[2rem] border border-slate-200 flex items-center gap-4 shadow-sm">
            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center">
                <i data-lucide="pencil-line" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Structure</p>
                <h4 class="text-xl font-black text-slate-800">{{ $counts['structure'] }} <span class="text-xs font-medium text-slate-400">/ 40</span></h4>
            </div>
        </div>

        <div class="bg-white p-5 rounded-[2rem] border border-slate-200 flex items-center gap-4 shadow-sm">
            <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center">
                <i data-lucide="book-open" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Reading</p>
                <h4 class="text-xl font-black text-slate-800">{{ $counts['reading'] }} <span class="text-xs font-medium text-slate-400">/ 50</span></h4>
            </div>
        </div>
    </div>

    {{-- Form Tambah Soal (Ditambahkan Alpine.js x-data untuk Live Preview) --}}
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-200 overflow-hidden"
         x-data="{ 
            textInput: '',
            parseTOEFL(input) {
                if(!input) return '';

                // Bersihkan HTML tag asli jika ada
                let escaped = input.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');

                // Render format TOEFL [kata:huruf]
                let formatted = escaped.replace(/\[([^:]+):([^\]]+)\]/g, '<span class=&quot;toefl-wrapper&quot;><span class=&quot;toefl-line&quot;>$1</span><span class=&quot;toefl-label&quot;>$2</span></span>');
                
                // Ganti newlines dengan <br> untuk menjaga format paragraf
                return formatted.replace(/\n/g, '<br>');
            }
         }">
        
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
                <div class="space-y-6">
                    <div class="group">
                        <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Kategori Section</label>
                        <select name="category" class="w-full border-slate-200 rounded-2xl focus:ring-indigo-500 focus:border-indigo-500 text-sm p-4 bg-slate-50/50 font-semibold text-slate-700 transition-all">
                            <option value="listening">🎧 Section 1: Listening Comprehension</option>
                            <option value="structure">📝 Section 2: Structure & Written Expression</option>
                            <option value="reading">📖 Section 3: Reading Comprehension</option>
                        </select>
                    </div>

                    {{-- FITUR RE-UPLOAD AUDIO --}}
    <input type="file" name="audio_file" 
           @change="const file = $event.target.files[0]; if (file) { newAudioPreview = URL.createObjectURL(file) }"
           class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:bg-indigo-600 file:text-white">

    {{-- Preview untuk audio baru yang akan menggantikan audio lama --}}
    <div x-show="newAudioPreview" class="mt-3 p-2 bg-white rounded-lg border border-indigo-200" x-cloak>
        <p class="text-[8px] font-bold text-indigo-500 uppercase mb-1">Preview Audio Baru:</p>
        <audio :src="newAudioPreview" controls class="h-7 w-full"></audio>
    </div>

    <p class="text-[9px] text-indigo-400 mt-2 font-medium italic">*Biarkan kosong jika tidak ingin mengganti audio lama.</p>
</div>

                    <div class="p-6 bg-indigo-50/50 rounded-[2rem] border border-indigo-100 border-dashed" 
     x-data="{ audioPreview: null }"> {{-- Tambahkan x-data di sini --}}
    <label class="block text-[11px] font-black text-indigo-400 uppercase tracking-widest mb-3 flex items-center gap-2">
        <i data-lucide="mic-2" class="w-3 h-3"></i> File Audio (MP3)
    </label>
    {{-- Tambahkan @change untuk mendeteksi file baru --}}
    <input type="file" name="audio_file" 
           @change="const file = $event.target.files[0]; if (file) { audioPreview = URL.createObjectURL(file) }"
           class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 cursor-pointer">

    {{-- Box Preview Audio yang akan muncul setelah file dipilih --}}
    <div x-show="audioPreview" class="mt-4 p-3 bg-white rounded-xl border border-indigo-100 shadow-sm" x-cloak>
        <p class="text-[9px] font-black text-indigo-400 uppercase mb-2 tracking-widest">Preview Audio Terpilih:</p>
        <audio :src="audioPreview" controls class="h-8 w-full"></audio>
    </div>

    <p class="text-[9px] text-indigo-400 mt-2 font-medium italic">*Wajib diisi jika memilih kategori Listening</p>
</div>

                    <div>
                        <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Teks Pertanyaan / Narasi</label>
                        <textarea name="question_text" x-model="textInput" rows="6" class="w-full border-slate-200 rounded-[2rem] focus:ring-indigo-500 focus:border-indigo-500 text-sm p-6 bg-slate-50/50 placeholder:text-slate-300 font-medium" placeholder="Gunakan format [kata:huruf], contoh: The [sun:A] is [hot:B]..." required></textarea>
                        
                        {{-- Fitur Baru: Live Preview Box --}}
                        <div class="mt-4 p-6 bg-slate-900 rounded-[2rem] shadow-xl" x-show="textInput.length > 0" x-cloak x-transition>
                            <p class="text-[9px] font-black text-indigo-400 uppercase mb-3 tracking-widest">Live Preview Tampilan Soal:</p>
                            <div class="text-white text-base leading-loose" x-html="parseTOEFL(textInput)"></div>
                        </div>
                    </div>
                </div>

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
                            <i data-lucide="check-circle" class="w-4 h-4"></i> Tentukan Jawaban Benar
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

            <div class="mt-12 pt-8 border-t border-slate-100 flex flex-col sm:flex-row justify-end items-center gap-4">
                <button type="reset" class="text-slate-400 hover:text-slate-600 text-xs font-black uppercase tracking-widest px-6 transition-colors">Reset Form</button>
                <button type="submit" class="group relative flex items-center gap-3 bg-slate-900 text-white px-10 py-4 rounded-2xl font-black text-xs uppercase tracking-[0.2em] hover:bg-indigo-600 transition-all shadow-xl shadow-slate-200 active:scale-95">
                    <i data-lucide="save" class="w-4 h-4 group-hover:animate-bounce"></i> Simpan ke Bank Soal
                </button>
            </div>
        </form>
    </div>

    {{-- DAFTAR SOAL TERINPUT --}}
    <div class="mt-12 bg-white rounded-[2.5rem] shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-8 border-b border-slate-100 bg-slate-50/50 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-slate-800 rounded-2xl shadow-lg">
                    <i data-lucide="list" class="w-6 h-6 text-white"></i>
                </div>
                <div>
                    <h3 class="text-xl font-black text-slate-800">Daftar Soal Terkini</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Manage Your Database</p>
                </div>
            </div>

            <form action="{{ route('admin.questions') }}" method="GET" class="flex items-center gap-2">
                <select name="category" onchange="this.form.submit()" class="text-[10px] font-black uppercase tracking-widest border-slate-200 rounded-xl bg-white focus:ring-indigo-500 focus:border-indigo-500 py-2.5 px-4 shadow-sm">
                    <option value="">Semua Kategori</option>
                    <option value="listening" {{ request('category') == 'listening' ? 'selected' : '' }}>🎧 Listening</option>
                    <option value="structure" {{ request('category') == 'structure' ? 'selected' : '' }}>📝 Structure</option>
                    <option value="reading" {{ request('category') == 'reading' ? 'selected' : '' }}>📖 Reading</option>
                </select>

    {{-- Tampilkan Nama File Audio Lama --}}
    <template x-if="audioPath">
        <div class="flex items-center gap-3 p-3 bg-white rounded-xl border border-indigo-100 shadow-sm">
            <div class="p-2 bg-indigo-600 rounded-lg">
                <i data-lucide="music" class="w-4 h-4 text-white"></i>
            </div>
            <div class="overflow-hidden">
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-tight">File Saat Ini:</p>
                <p class="text-[11px] font-bold text-indigo-600 truncate" x-text="audioPath.split('/').pop()"></p>
            </div>
        </div>
    </template>

    {{-- Input untuk Re-upload --}}
    <div class="space-y-2">
        <p class="text-[9px] font-bold text-slate-500 uppercase">Ganti Audio (Opsional):</p>
        <input type="file" name="audio_file" 
               @change="const file = $event.target.files[0]; if (file) { newPreview = URL.createObjectURL(file) }"
               class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 cursor-pointer">
    </div>

    {{-- Preview Audio Baru --}}
    <div x-show="newPreview" class="p-3 bg-white rounded-xl border border-emerald-200" x-cloak>
        <p class="text-[8px] font-black text-emerald-500 uppercase mb-2 tracking-widest">Pratinjau File Baru:</p>
        <audio :src="newPreview" controls class="h-8 w-full"></audio>
    </div>
</div>
                @if(request('category'))
                    <a href="{{ route('admin.questions') }}" class="p-2.5 text-slate-400 hover:text-red-500 bg-white border border-slate-200 rounded-xl transition-colors shadow-sm"><i data-lucide="filter-x" class="w-4 h-4"></i></a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50">
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Kategori</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Pertanyaan (TOEFL Preview)</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Kunci</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($questions as $q)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-tighter 
                                {{ $q->category == 'listening' ? 'bg-indigo-100 text-indigo-600' : '' }}
                                {{ $q->category == 'structure' ? 'bg-emerald-100 text-emerald-600' : '' }}
                                {{ $q->category == 'reading' ? 'bg-amber-100 text-amber-600' : '' }}">
                                {{ $q->category }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
    <div class="text-sm text-slate-600 font-medium leading-loose">
        {!! nl2br(preg_replace('/\[([^:]+):([^\]]+)\]/', 
            '<span class="inline-flex flex-col items-center mx-1"><span class="border-b-2 border-slate-900 font-bold px-1">$1</span><span class="font-black text-black mt-1">$2</span></span>', 
            Str::limit($q->question_text, 150))) 
        !!}
    </div>
    {{-- Tampilan Nama File Audio (Hanya muncul jika kategori Listening) --}}
    @if($q->category == 'listening')
        <div class="flex flex-col gap-2 mt-2 w-full max-w-[240px]">
            @if($q->audio_path)
                {{-- Label Nama File (Di Atas) --}}
                <div class="flex items-center gap-2 px-2.5 py-1.5 bg-indigo-50 border border-indigo-100 rounded-xl w-fit shadow-sm">
                    <i data-lucide="music" class="w-3.5 h-3.5 text-indigo-600"></i>
                    <span class="text-[10px] font-bold text-indigo-700 truncate max-w-[160px]">
                        {{ basename($q->audio_path) }}
                    </span>
                    <span class="text-[8px] font-black text-emerald-500 uppercase tracking-tighter">Saved</span>
                </div>

                {{-- Audio Player (Tepat di Bawah Nama File) --}}
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden p-1">
                    <audio controls class="h-8 w-full block">
                        <source src="{{ asset('storage/' . $q->audio_path) }}" type="audio/mpeg">
                        Browser tidak mendukung audio.
                    </audio>
                </div>
            @else
                {{-- Status Jika Audio Belum Diunggah --}}
                <div class="flex items-center gap-2 px-3 py-2 bg-red-50 border border-red-100 rounded-xl w-fit">
                    <i data-lucide="alert-circle" class="w-4 h-4 text-red-500"></i>
                    <span class="text-[10px] font-black text-red-600 uppercase tracking-widest">Audio Kosong</span>
                </div>
            @endif
        </div>
    @endif
</td>

                        <td class="px-6 py-4 text-center">
                            <span class="w-7 h-7 inline-flex items-center justify-center rounded-lg bg-slate-100 text-slate-800 font-black text-xs">
                                {{ $q->correct_answer }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2" x-data="{}">
                                <button @click="$dispatch('open-edit-modal', {{ 
                                    json_encode([
                                        'id' => (string)$q->id,
                                        'text' => $q->question_text,
                                        'cat' => $q->category,
                                        'a' => $q->option_a,
                                        'b' => $q->option_b,
                                        'c' => $q->option_c,
                                        'd' => $q->option_d,
                                        'ans' => $q->correct_answer,
                                        'audio_path' => $q ->audio_path
                                    ]) 
                                }})" class="p-2 text-slate-300 hover:text-indigo-600 transition-colors">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </button>

                                <form action="{{ route('admin.questions.delete', $q->id) }}" method="POST" onsubmit="return confirm('Hapus soal ini?')">
                                    @csrf @method('DELETE')
                                    <button class="p-2 text-slate-300 hover:text-red-600 transition-colors"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center gap-2 opacity-30">
                                <i data-lucide="folder-search" class="w-12 h-12"></i>
                                <p class="text-xs font-bold uppercase">Belum ada soal di database</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($questions->hasPages())
        <div class="p-6 bg-slate-50 border-t border-slate-100">
            {{ $questions->appends(['category' => request('category')])->links() }}
        </div>
        @endif
    </div>

    {{-- MODAL EDIT (Juga ditambahkan fungsi Preview) --}}
    <div x-data="{ 
            show: false, id: '', text: '', cat: '', a: '', b: '', c: '', d: '', ans: '', actionUrl: '',
            parseTOEFL(input) {
                if(!input) return '';

                // Bersihkan HTML tag asli jika ada
                let escaped = input.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');

                // Render format TOEFL [kata:huruf]
                let formatted = escaped.replace(/\[([^:]+):([^\]]+)\]/g, '<span class=&quot;toefl-wrapper&quot;><span class=&quot;toefl-line&quot;>$1</span><span class=&quot;toefl-label&quot;>$2</span></span>');
                
                // Ganti newlines dengan <br> untuk menjaga format paragraf
                return formatted.replace(/\n/g, '<br>');
            }
        }" 
        x-show="show" 
        @open-edit-modal.window="
            show = true; 
            id = $event.detail.id; 
            text = $event.detail.text; 
            cat = $event.detail.cat; 
            a = $event.detail.a; 
            b = $event.detail.b; 
            c = $event.detail.c; 
            d = $event.detail.d; 
            ans = $event.detail.ans; 
            actionUrl = '/admin/questions/' + id + '/update';
        "
        class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
        
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="show = false"></div>

            <div class="relative bg-white rounded-[2.5rem] shadow-2xl max-w-2xl w-full overflow-hidden transform transition-all">
                <form :action="actionUrl" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT') {{-- Pastikan ada method PUT untuk update --}}

    </form>
                    <div class="p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-black text-slate-800 flex items-center gap-2"><i data-lucide="edit-3" class="w-5 h-5 text-indigo-600"></i> Edit Pertanyaan</h3>
                            <button type="button" @click="show = false" class="text-slate-400 hover:text-slate-600"><i data-lucide="x" class="w-5 h-5"></i></button>
                        </div>
                        <div class="space-y-6">
                            {{-- Kategori --}}
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Kategori Section</label>
                                <select name="category" x-model="cat" class="w-full border-slate-200 rounded-xl text-sm p-3 bg-slate-50 font-semibold">
                                    <option value="listening">Listening</option>
                                    <option value="structure">Structure</option>
                                    <option value="reading">Reading</option>
                                </select>
                            </div>

                            

    {{-- Menampilkan Nama File Audio yang Sudah Ada --}}
    <template x-if="audioPath">
        <div class="flex items-center gap-3 p-3 bg-white rounded-xl border border-indigo-100 shadow-sm">
            <div class="p-2 bg-indigo-600 rounded-lg">
                <i data-lucide="music" class="w-4 h-4 text-white"></i>
            </div>
            <div class="overflow-hidden">
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-tight">File Saat Ini:</p>
                <p class="text-[11px] font-bold text-indigo-600 truncate" x-text="audioPath.split('/').pop()"></p>
            </div>
        </div>
    </template>

    {{-- Input Re-upload --}}
    <div class="space-y-2">
        <p class="text-[9px] font-bold text-slate-500 uppercase">Ganti Audio (Opsional):</p>
        <input type="file" name="audio_file" 
               @change="const file = $event.target.files[0]; if (file) { newPreview = URL.createObjectURL(file) }"
               class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 cursor-pointer">
    </div>

    {{-- Preview Audio Baru sebelum disimpan --}}
    <div x-show="newPreview" class="p-3 bg-white rounded-xl border border-emerald-200" x-cloak>
        <p class="text-[8px] font-black text-emerald-500 uppercase mb-2 tracking-widest">Pratinjau File Baru:</p>
        <audio :src="newPreview" controls class="h-8 w-full"></audio>
    </div>
</div>

                            {{-- Teks Pertanyaan dengan Live Preview --}}
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Teks Pertanyaan</label>
                                <textarea name="question_text" x-model="text" rows="4" class="w-full border-slate-200 rounded-xl text-sm p-4 bg-slate-50 font-medium overflow-y-auto max-h-[300px]"></textarea>
                                {{-- Preview di Modal --}}
                                <div class="mt-3 p-4 bg-slate-900 rounded-xl text-white text-sm" x-html="parseTOEFL(text)"></div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <input type="text" name="option_a" x-model="a" class="border-slate-200 rounded-xl p-3 text-sm bg-slate-50">
                                <input type="text" name="option_b" x-model="b" class="border-slate-200 rounded-xl p-3 text-sm bg-slate-50">
                                <input type="text" name="option_c" x-model="c" class="border-slate-200 rounded-xl p-3 text-sm bg-slate-50">
                                <input type="text" name="option_d" x-model="d" class="border-slate-200 rounded-xl p-3 text-sm bg-slate-50">
                            </div>
                            <div class="p-5 bg-emerald-50 rounded-2xl border border-emerald-100">
                                <label class="block text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-3">Kunci Jawaban</label>
                                <div class="grid grid-cols-4 gap-2">
                                    <template x-for="choice in ['A', 'B', 'C', 'D']">
                                        <label class="cursor-pointer">
                                            <input type="radio" name="correct_answer" :value="choice" x-model="ans" class="peer hidden">
                                            <div class="p-2 text-center rounded-lg border-2 border-emerald-100 bg-white text-emerald-600 font-black text-xs peer-checked:bg-emerald-600 peer-checked:text-white transition-all" x-text="choice"></div>
                                        </label>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
                        <button type="button" @click="show = false" class="px-6 py-3 text-xs font-black uppercase text-slate-400 tracking-widest hover:text-slate-600">Batal</button>
                        <button type="submit" class="px-8 py-3 bg-indigo-600 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-slate-900 transition-all shadow-lg shadow-indigo-200 active:scale-95">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>