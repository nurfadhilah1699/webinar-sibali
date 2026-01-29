<x-admin-layout>
    {{-- Header Section --}}
    <div class="mb-8">
        <h1 class="text-3xl font-black text-slate-800 tracking-tight">Materi & Akses Webinar</h1>
        <p class="text-slate-500 text-sm mt-1">Kelola link streaming, grup diskusi, dan modul pembelajaran di sini.</p>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        
        {{-- FORM TAMBAH MATERI --}}
        <div class="xl:col-span-1">
            <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-200 sticky top-28">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg">
                        <i data-lucide="plus-circle" class="w-5 h-5"></i>
                    </div>
                    <h3 class="font-bold text-slate-800">Tambah Konten</h3>
                </div>

                <form action="{{ route('admin.materials.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Judul Materi / Link</label>
                        <input type="text" name="title" class="w-full border-slate-200 rounded-2xl focus:ring-indigo-500 focus:border-indigo-500 text-sm p-3.5 bg-slate-50/50" placeholder="Contoh: Link Zoom Day 1" required>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Kategori</label>
                            <select name="type" class="w-full border-slate-200 rounded-2xl focus:ring-indigo-500 focus:border-indigo-500 text-sm p-3.5 bg-slate-50/50">
                                <option value="link_zoom">Zoom</option>
                                <option value="link_wa">WhatsApp</option>
                                <option value="materi">PDF/Drive</option>
                                <option value="rekaman">YouTube</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Target</label>
                            <select name="package" class="w-full border-slate-200 rounded-2xl focus:ring-indigo-500 focus:border-indigo-500 text-sm p-3.5 bg-slate-50/50">
                                <option value="all">Semua</option>
                                <option value="reguler">Reguler</option>
                                <option value="vip1">VIP 1</option>
                                <option value="vip2">VIP 2</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">URL Tujuan</label>
                        <input type="url" name="link" class="w-full border-slate-200 rounded-2xl focus:ring-indigo-500 focus:border-indigo-500 text-sm p-3.5 bg-slate-50/50" placeholder="https://..." required>
                    </div>

                    <button type="submit" class="w-full bg-slate-900 text-white py-4 rounded-2xl font-black text-xs uppercase tracking-[0.2em] hover:bg-indigo-600 transition-all shadow-lg shadow-slate-200 active:scale-95">
                        Publish Sekarang
                    </button>
                </form>
            </div>
        </div>

        {{-- DAFTAR KONTEN --}}
        <div class="xl:col-span-2">
            <div class="bg-white rounded-[2rem] shadow-sm border border-slate-200 overflow-hidden min-h-[500px]">
                <div class="p-8 border-b border-slate-50 flex justify-between items-center">
                    <h3 class="font-bold text-slate-800">Daftar Konten Terbit</h3>
                    <span class="px-3 py-1 bg-slate-100 text-slate-500 rounded-full text-[10px] font-bold">{{ count($contents) }} Item</span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-100">
                                <th class="p-6 text-[11px] font-black text-slate-400 uppercase tracking-widest">Konten</th>
                                <th class="p-6 text-[11px] font-black text-slate-400 uppercase tracking-widest">Tipe & Akses</th>
                                <th class="p-6 text-[11px] font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($contents as $c)
                            <tr class="group hover:bg-slate-50/50 transition-colors">
                                <td class="p-6">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-slate-800 group-hover:text-indigo-600 transition-colors">{{ $c->title }}</span>
                                        <span class="text-[10px] text-slate-400 mt-1 font-medium truncate max-w-[200px]">{{ $c->link }}</span>
                                    </div>
                                </td>
                                <td class="p-6">
                                    <div class="flex items-center gap-2">
                                        @php
                                            $typeColors = [
                                                'link_zoom' => 'bg-blue-50 text-blue-600 border-blue-100',
                                                'link_wa' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                                'materi' => 'bg-amber-50 text-amber-600 border-amber-100',
                                                'rekaman' => 'bg-rose-50 text-rose-600 border-rose-100'
                                            ];
                                            $colorClass = $typeColors[$c->type] ?? 'bg-slate-50 text-slate-600 border-slate-100';
                                        @endphp
                                        <span class="px-3 py-1 rounded-lg border text-[10px] font-black uppercase tracking-tighter {{ $colorClass }}">
                                            {{ str_replace('link_', '', $c->type) }}
                                        </span>
                                        <span class="text-slate-300">/</span>
                                        <span class="text-[11px] font-bold text-slate-500 uppercase tracking-widest italic">
                                            {{ $c->package == 'all' ? 'Public' : $c->package }}
                                        </span>
                                    </div>
                                </td>
                                <td class="p-6">
                                    <div class="flex justify-end items-center gap-4">
                                        <a href="{{ $c->link }}" target="_blank" class="p-2 text-slate-400 hover:text-indigo-500 transition-colors">
                                            <i data-lucide="external-link" class="w-4 h-4"></i>
                                        </a>
                                        <form action="{{ route('admin.materials.delete', $c->id) }}" method="POST" onsubmit="return confirm('Hapus konten ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 text-slate-400 hover:text-rose-500 transition-colors">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach

                            @if($contents->isEmpty())
                            <tr>
                                <td colspan="3" class="p-20 text-center">
                                    <p class="text-slate-400 text-sm italic font-medium">Belum ada materi yang diterbitkan.</p>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>