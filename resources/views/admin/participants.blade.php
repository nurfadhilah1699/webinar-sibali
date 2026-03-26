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
    </div>

    <div class="flex flex-col lg:flex-row items-center justify-between gap-4 mb-8">
        {{-- Form Pencarian & Filter --}}
        <form action="{{ route('admin.participants') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full lg:w-auto">
            
            {{-- 1. Search Bar (Nama/Email) --}}
            <div class="relative group w-full md:w-auto">
                <i data-lucide="search" class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-indigo-500 transition-colors"></i>
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Cari nama atau email..." 
                    class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-2xl text-xs font-medium focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all outline-none shadow-sm">
            </div>

            {{-- 2. Filter Status (Ganti Paket) --}}
            <div class="relative w-full md:w-auto">
                <select name="status" onchange="this.form.submit()" 
                        class="w-full appearance-none pl-4 pr-10 py-3 bg-white border border-slate-200 rounded-2xl text-[11px] font-black uppercase tracking-tight focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all outline-none cursor-pointer shadow-sm">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>✅ Verified</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>❌ Rejected</option>
                </select>
                <i data-lucide="filter" class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
            </div>

            {{-- Tombol Reset --}}
            @if(request()->anyFilled(['search', 'status']))
                <a href="{{ route('admin.participants') }}" class="text-[10px] font-black text-rose-500 hover:text-rose-600 uppercase tracking-widest px-2 transition-colors">
                    Clear Filter
                </a>
            @endif
        </form>

        {{-- Export Button --}}
        <div class="w-full lg:w-auto">
            <a href="{{ route('admin.participants.export', request()->all()) }}" 
            class="w-full flex items-center justify-center gap-2 bg-emerald-500 text-white px-6 py-3 rounded-2xl text-[11px] font-black uppercase tracking-widest hover:bg-emerald-600 hover:shadow-lg hover:shadow-emerald-100 transition-all active:scale-95">
                <i data-lucide="download" class="w-4 h-4"></i>
                Export CSV
            </a>
        </div>
    </div>

    {{-- Tabel Section --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Informasi Peserta</th>
                        <th class="px-4 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-center">Event & Paket</th>
                        <th class="px-4 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-center">Status</th>
                        <th class="px-4 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-center">Pembayaran</th>
                        <th class="px-4 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-center">TOEFL</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">Join Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($users as $user)
                    <tr class="group hover:bg-slate-50/50 transition-all duration-300">
                        {{-- Profil & Kontak --}}
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-slate-100 to-slate-200 border border-slate-200 flex items-center justify-center text-slate-500 font-black text-sm group-hover:from-indigo-500 group-hover:to-purple-600 group-hover:text-white group-hover:border-transparent group-hover:shadow-lg group-hover:shadow-indigo-100 transition-all duration-300">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-black text-slate-800 leading-tight tracking-tight group-hover:text-indigo-600 transition-colors">{{ $user->name }}</div>
                                    <div class="text-[11px] text-slate-400 font-medium mt-1 flex items-center gap-1">
                                        <i data-lucide="mail" class="w-3 h-3 text-slate-300"></i>
                                        {{ $user->email }}
                                    </div>
                                    <div class="text-[10px] text-emerald-600 font-bold mt-1 flex items-center gap-1 bg-emerald-50 w-fit px-2 py-0.5 rounded-md">
                                        <i data-lucide="phone" class="w-2.5 h-2.5"></i>
                                        {{ $user->phone ?? '-' }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        {{-- Event & Paket (Digabung agar lebih ringkas) --}}
                        <td class="px-4 py-6 text-center">
                            <div class="flex flex-col items-center gap-1.5">
                                <span class="text-[11px] font-bold text-slate-700 tracking-tight leading-tight max-w-[150px]">
                                    {{ $user->event_title }}
                                </span>
                                @php
                                    $pkgColor = match($user->package) {
                                        'vip1'  => 'bg-purple-50 text-purple-600 border-purple-100',
                                        'vip2'  => 'bg-indigo-50 text-indigo-600 border-indigo-100',
                                        default => 'bg-slate-50 text-slate-500 border-slate-200',
                                    };
                                @endphp
                                <span class="px-2 py-0.5 rounded-md border text-[9px] font-black uppercase tracking-tighter {{ $pkgColor }}">
                                    {{ $user->package ?? 'N/A' }}
                                </span>
                            </div>
                        </td>

                        {{-- Status Badge --}}
                        <td class="px-4 py-6 text-center">
                            <div class="flex justify-center">
                                @php
                                    $statusClasses = match($user->status_label) {
                                        'approved', 'verified' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                        'rejected'             => 'bg-red-50 text-red-600 border-red-100',
                                        default                => 'bg-amber-50 text-amber-600 border-amber-100',
                                    };
                                    $statusText = match($user->status_label) {
                                        'approved', 'verified' => 'Verified',
                                        'rejected'             => 'Rejected',
                                        default                => 'Pending',
                                    };
                                @endphp
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black border uppercase tracking-tighter {{ $statusClasses }} shadow-sm">
                                    <span class="w-1.5 h-1.5 rounded-full {{ ($user->status_label == 'approved' || $user->status_label == 'verified') ? 'bg-emerald-500' : ($user->status_label == 'rejected' ? 'bg-red-500' : 'bg-amber-500 animate-pulse') }}"></span>
                                    {{ $statusText }}
                                </span>
                            </div>
                        </td>

                        {{-- Lampiran Pembayaran --}}
                        <td class="px-4 py-6 text-center">
                            @if(!empty($user->payment_proof))
                                <a href="{{ asset('storage/' . $user->payment_proof) }}" target="_blank" 
                                class="group/link inline-flex items-center gap-1.5 px-3 py-1.5 bg-white text-slate-600 rounded-xl text-[10px] font-black border border-slate-200 uppercase tracking-widest hover:bg-indigo-600 hover:text-white hover:border-indigo-600 transition-all shadow-sm active:scale-95">
                                    <i data-lucide="image" class="w-3.5 h-3.5 group-hover/link:animate-pulse"></i>
                                    Bukti
                                </a>
                            @else
                                <span class="text-[9px] font-black text-slate-300 uppercase italic tracking-widest">Empty</span>
                            @endif
                        </td>

                        {{-- Skor TOEFL --}}
                        <td class="px-4 py-6 text-center">
                            @if($user->toefl_score)
                                <div class="inline-flex flex-col items-center bg-slate-50 px-3 py-1 rounded-xl border border-slate-100 group-hover:bg-white transition-colors">
                                    <span class="text-indigo-600 font-black text-base leading-none tracking-tighter">{{ $user->toefl_score }}</span>
                                    <span class="text-[7px] font-black text-slate-400 uppercase tracking-[0.1em] mt-0.5">Points</span>
                                </div>
                            @else
                                <div class="w-8 h-1 bg-slate-100 mx-auto rounded-full"></div>
                            @endif
                        </td>

                        {{-- Tanggal Join --}}
                        <td class="px-8 py-6 text-right">
                            <div class="flex flex-col items-end">
                                <span class="text-slate-700 text-[11px] font-black tracking-tight">
                                    {{ is_string($user->created_at) ? $user->created_at : $user->created_at->format('d M, Y') }}
                                </span>
                                <span class="text-slate-400 text-[9px] font-medium uppercase tracking-tighter">Registered</span>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-8 py-32 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-20 h-20 bg-slate-50 rounded-[2.5rem] flex items-center justify-center mb-6">
                                    <i data-lucide="user-minus" class="w-10 h-10 text-slate-200"></i>
                                </div>
                                <h3 class="text-slate-800 font-black text-lg tracking-tight">Data Kosong</h3>
                                <p class="text-slate-400 text-sm mt-1 font-medium">Belum ada peserta yang sesuai dengan filter ini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>