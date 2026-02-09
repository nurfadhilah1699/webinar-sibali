<x-admin-layout>
    {{-- Header & Statistik --}}
    <div class="mb-10 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">Daftar Peserta</h1>
            <div class="flex items-center gap-2 text-slate-500 text-sm mt-1">
                <i data-lucide="users" class="w-4 h-4"></i>
                <span>Total <span class="font-bold text-slate-800">{{ count($users) }}</span> Peserta Terdaftar</span>
            </div>
        </div>
        

        {{-- Filter Paket (Tab Style) --}}
        <div class="bg-slate-200/50 p-1.5 rounded-2xl flex flex-wrap gap-1">
            <a href="{{ route('admin.participants') }}" 
               class="px-5 py-2 rounded-xl text-xs font-black transition-all {{ !request('package') ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
               SEMUA
            </a>
            <a href="{{ route('admin.participants', ['package' => 'reguler']) }}" 
               class="px-5 py-2 rounded-xl text-xs font-black transition-all {{ request('package') == 'reguler' ? 'bg-white text-slate-700 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
               REGULER
            </a>
            <a href="{{ route('admin.participants', ['package' => 'vip1']) }}" 
               class="px-5 py-2 rounded-xl text-xs font-black transition-all {{ request('package') == 'vip1' ? 'bg-white text-purple-600 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
               VIP 1
            </a>
            <a href="{{ route('admin.participants', ['package' => 'vip2']) }}" 
               class="px-5 py-2 rounded-xl text-xs font-black transition-all {{ request('package') == 'vip2' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
               VIP 2
            </a>
            <a href="{{ route('admin.participants.export') }}" class="bg-emerald-500 text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-emerald-600 transition shadow-sm flex items-center gap-2">
                <i data-lucide="download" class="w-4 h-4"></i> EXPORT CSV
            </a>
        </div>
    </div>

    {{-- Tabel Section --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-8 py-5 text-[11px] font-black text-slate-400 uppercase tracking-widest">Informasi Peserta</th>
                        <th class="px-8 py-5 text-[11px] font-black text-slate-400 uppercase tracking-widest text-center">Paket</th>
                        <th class="px-8 py-5 text-[11px] font-black text-slate-400 uppercase tracking-widest text-center">Pembayaran</th>
                        <th class="px-8 py-5 text-[11px] font-black text-slate-400 uppercase tracking-widest text-center">Status</th>
                        <th class="px-8 py-5 text-[11px] font-black text-slate-400 uppercase tracking-widest text-center">Skor TOEFL</th>
                        <th class="px-8 py-5 text-[11px] font-black text-slate-400 uppercase tracking-widest text-right">Join Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($users as $user)
                    <tr class="group hover:bg-slate-50/50 transition-colors">
                        {{-- Nama, Email & Nomor Handphone --}}
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-500 font-black text-xs group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-colors">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-bold text-slate-800 leading-tight group-hover:text-indigo-600 transition-colors">{{ $user->name }}</div>
                                    <div class="text-[11px] text-slate-400 font-medium mt-0.5">{{ $user->email }}</div>
                                    <div class="text-[10px] text-emerald-600 font-bold mt-1 flex items-center gap-1">
                                        <i data-lucide="phone" class="w-3 h-3"></i>
                                        {{ $user->phone ?? '-' }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        {{-- Paket --}}
                        <td class="px-8 py-5 text-center">
                            @php
                                $pkgColor = [
                                    'reguler' => 'bg-slate-100 text-slate-600 border-slate-200',
                                    'vip1'    => 'bg-purple-50 text-purple-600 border-purple-100',
                                    'vip2'    => 'bg-indigo-50 text-indigo-600 border-indigo-100',
                                ][$user->package] ?? 'bg-slate-100 text-slate-600';
                            @endphp
                            <span class="px-3 py-1 rounded-lg border text-[10px] font-black uppercase tracking-tight {{ $pkgColor }}">
                                {{ $user->package }}
                            </span>
                        </td>

                        {{-- Kolom Bukti Pembayaran (Baru) --}}
                        <td class="px-8 py-5 text-center">
                            @if($user->payment_proof)
                                <a href="{{ asset('storage/' . $user->payment_proof) }}" target="_blank" 
                                class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-[10px] font-black border border-slate-200 uppercase hover:bg-indigo-600 hover:text-white hover:border-indigo-600 transition-all">
                                    <i data-lucide="external-link" class="w-3 h-3"></i>
                                    Bukti
                                </a>
                            @else
                                <span class="text-[10px] font-bold text-slate-300 uppercase italic">No File</span>
                            @endif
                        </td>

                        {{-- Status Akun --}}
                        <td class="px-8 py-5">
                            <div class="flex justify-center">
                                @if($user->is_verified)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-[10px] font-black border border-emerald-100 uppercase tracking-tighter">
                                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full shadow-[0_0_8px_rgba(16,185,129,0.5)]"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 text-amber-600 rounded-full text-[10px] font-black border border-amber-100 uppercase tracking-tighter">
                                        <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span>
                                        Pending
                                    </span>
                                @endif
                            </div>
                        </td>

                        {{-- Skor TOEFL --}}
                        <td class="px-8 py-5 text-center">
                            @if($user->toefl_score)
                                <div class="inline-flex flex-col items-center">
                                    <span class="text-indigo-600 font-black text-lg leading-none">{{ $user->toefl_score }}</span>
                                    <span class="text-[8px] font-bold text-slate-400 uppercase tracking-widest mt-1">Points</span>
                                </div>
                            @else
                                <span class="text-slate-300 text-[10px] font-bold italic tracking-widest uppercase">No Data</span>
                            @endif
                        </td>

                        {{-- Tanggal --}}
                        <td class="px-8 py-5 text-right">
                            <span class="text-slate-400 text-xs font-medium">{{ $user->created_at->format('d M, Y') }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <i data-lucide="user-minus" class="w-12 h-12 text-slate-200 mb-4"></i>
                                <p class="text-slate-400 font-medium italic">Belum ada peserta di kategori ini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>