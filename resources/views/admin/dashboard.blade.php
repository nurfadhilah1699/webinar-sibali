<x-admin-layout>
    {{-- Header Section --}}
    <div class="mb-10 flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
        <div>
            <nav class="flex mb-2" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-[10px] font-bold uppercase tracking-widest text-slate-400">
                    <li>ADMIN</li>
                    <li><i data-lucide="chevron-right" class="w-3 h-3"></i></li>
                    <li class="text-indigo-500">DASHBOARD</li>
                </ol>
            </nav>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">Verifikasi Pembayaran</h1>
            <p class="text-slate-500 text-sm mt-1">Kelola validasi bukti transfer peserta secara real-time.</p>
        </div>

        {{-- Toggle Sertifikat --}}
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-200 flex items-center gap-5">
            <div class="flex flex-col">
                <span class="text-[10px] text-slate-400 uppercase font-black tracking-widest">Akses Sertifikat</span>
                <span class="text-xs font-bold {{ $isCertReady ? 'text-emerald-600' : 'text-rose-500' }}">
                    {{ $isCertReady ? '● SEDANG AKTIF' : '● NON-AKTIF' }}
                </span>
            </div>
            <form action="{{ route('admin.toggle-certificate') }}" method="POST">
                @csrf
                <button type="submit" class="group flex items-center gap-2 px-5 py-2.5 rounded-xl text-[11px] font-black text-white transition-all duration-300 {{ $isCertReady ? 'bg-rose-500 hover:bg-rose-600 shadow-rose-200' : 'bg-emerald-600 hover:bg-emerald-700 shadow-emerald-200' }} shadow-lg">
                    <i data-lucide="{{ $isCertReady ? 'shield-off' : 'shield-check' }}" class="w-4 h-4 transition-transform group-hover:scale-110"></i>
                    {{ $isCertReady ? 'NONAKTIFKAN' : 'AKTIFKAN SEKARANG' }}
                </button>
            </form>
        </div>
    </div>

    {{-- Notifikasi Sukses --}}
    @if(session('status'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" 
             class="mb-8 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 rounded-xl flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3 font-bold text-sm">
                <i data-lucide="check-circle-2" class="w-5 h-5"></i>
                {{ session('status') }}
            </div>
            <button @click="show = false"><i data-lucide="x" class="w-4 h-4"></i></button>
        </div>
    @endif

    {{-- Tabel Verifikasi --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-200 overflow-hidden transition-all hover:shadow-md">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="p-6 text-[11px] font-black text-slate-400 uppercase tracking-[0.15em]">Informasi Peserta</th>
                        <th class="p-6 text-[11px] font-black text-slate-400 uppercase tracking-[0.15em]">Paket Dipilih</th>
                        <th class="p-6 text-[11px] font-black text-slate-400 uppercase tracking-[0.15em]">Lampiran</th>
                        <th class="p-6 text-[11px] font-black text-slate-400 uppercase tracking-[0.15em] text-center">Tindakan Cepat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($pendingUsers as $user)
                        <tr class="group hover:bg-slate-50/80 transition-colors">
                            <td class="p-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-sm border border-slate-200 group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-colors">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-800 leading-tight">{{ $user->name }}</div>
                                        <div class="text-xs text-slate-400 mt-0.5">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="p-6">
                                <span class="inline-flex items-center px-3 py-1 bg-indigo-50 text-indigo-600 rounded-lg text-[10px] font-black uppercase tracking-tight border border-indigo-100">
                                    {{ $user->package }}
                                </span>
                            </td>
                            <td class="p-6">
                                <a href="{{ asset('storage/' . $user->payment_proof) }}" target="_blank" class="inline-flex items-center gap-2 text-indigo-500 font-bold text-xs hover:text-indigo-700 group/link transition-colors">
                                    <span class="p-2 bg-indigo-50 rounded-lg group-hover/link:bg-indigo-100 transition-colors">
                                        <i data-lucide="image" class="w-4 h-4"></i>
                                    </span>
                                    <span>LIHAT BUKTI</span>
                                </a>
                            </td>
                            <td class="p-6">
                                <div class="flex justify-center gap-3">
                                    {{-- Tombol Approve --}}
                                    <form action="{{ route('admin.approve', $user->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-emerald-50 text-emerald-600 px-4 py-2.5 rounded-xl text-[11px] font-black uppercase tracking-widest hover:bg-emerald-600 hover:text-white transition-all shadow-sm hover:shadow-emerald-200 active:scale-95">
                                            Approve
                                        </button>
                                    </form>

                                    {{-- Form Reject --}}
                                    <form action="{{ route('admin.reject', $user->id) }}" method="POST" class="flex items-center gap-2 bg-slate-50 p-1.5 rounded-2xl border border-slate-100 focus-within:border-rose-300 transition-all">
                                        @csrf
                                        <input type="text" name="reason" placeholder="Alasan..." class="text-[11px] bg-transparent border-none focus:ring-0 p-1 w-24 sm:w-32 placeholder:text-slate-400 font-medium" required>
                                        <button type="submit" class="bg-rose-50 text-rose-600 px-4 py-2 rounded-xl text-[11px] font-black uppercase tracking-widest hover:bg-rose-600 hover:text-white transition-all active:scale-95">
                                            Reject
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                        <i data-lucide="party-popper" class="w-10 h-10 text-slate-300"></i>
                                    </div>
                                    <h3 class="text-slate-800 font-bold">Semua Beres!</h3>
                                    <p class="text-slate-400 text-sm mt-1">Tidak ada antrean pembayaran saat ini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>