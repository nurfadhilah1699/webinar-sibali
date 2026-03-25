<x-admin-layout>
    {{-- Header Section --}}
    <div class="mb-10 flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6">
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

        <div class="flex flex-wrap gap-4 w-full xl:w-auto">
            {{-- Toggle Sertifikat --}}
            <div class="flex-1 xl:flex-none bg-white p-4 rounded-2xl shadow-sm border border-slate-200 flex items-center gap-5">
                <div class="flex flex-col">
                    <span class="text-[10px] text-slate-400 uppercase font-black tracking-widest">Akses Sertifikat</span>
                    <span class="text-xs font-bold {{ $isCertReady ? 'text-emerald-600' : 'text-rose-500' }}">
                        {{ $isCertReady ? '● AKTIF' : '● OFF' }}
                    </span>
                </div>
                <form action="{{ route('admin.toggle-certificate') }}" method="POST">
                    @csrf
                    <button type="submit" class="group flex items-center gap-2 px-4 py-2.5 rounded-xl text-[10px] font-black text-white transition-all {{ $isCertReady ? 'bg-rose-500 hover:bg-rose-600' : 'bg-emerald-600 hover:bg-emerald-700' }} shadow-lg">
                        <i data-lucide="{{ $isCertReady ? 'shield-off' : 'shield-check' }}" class="w-4 h-4"></i>
                        {{ $isCertReady ? 'MATIKAN' : 'AKTIFKAN' }}
                    </button>
                </form>
            </div>

            {{-- Toggle Ujian TOEFL (BARU) --}}
            <div class="flex-1 xl:flex-none bg-slate-900 p-4 rounded-2xl shadow-sm border border-slate-800 flex items-center gap-5">
                <div class="flex flex-col">
                    <span class="text-[10px] text-slate-500 uppercase font-black tracking-widest italic">Akses Ujian</span>
                    <span class="text-xs font-bold {{ $isTestOpen ? 'text-emerald-400' : 'text-amber-500' }}">
                        {{ $isTestOpen ? '● TERBUKA' : '● TERKUNCI' }}
                    </span>
                </div>
                <form action="{{ route('admin.test.toggle') }}" method="POST">
                    @csrf
                    <button type="submit" class="group flex items-center gap-2 px-4 py-2.5 rounded-xl text-[10px] font-black text-white transition-all {{ $isTestOpen ? 'bg-rose-600 hover:bg-rose-700' : 'bg-indigo-600 hover:bg-indigo-700' }} shadow-lg">
                        <i data-lucide="{{ $isTestOpen ? 'lock' : 'play' }}" class="w-4 h-4"></i>
                        {{ $isTestOpen ? 'LOCK TEST' : 'OPEN TEST' }}
                    </button>
                </form>
            </div>
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
                    <tr class="bg-slate-50/80 border-b border-slate-100">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Informasi Peserta</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Event & Paket</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Pembayaran</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-center">Aksi Verifikasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($pendingRegistrations as $reg)
                        <tr class="group hover:bg-slate-50/50 transition-all duration-300">
                            {{-- Profil Peserta --}}
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="relative">
                                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-black text-sm shadow-lg shadow-indigo-100 group-hover:scale-110 transition-transform duration-300">
                                            {{ strtoupper(substr($reg->user->name, 0, 1)) }}
                                        </div>
                                        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-500 border-2 border-white rounded-full"></div>
                                    </div>
                                    <div>
                                        <div class="font-black text-slate-800 leading-tight tracking-tight group-hover:text-indigo-600 transition-colors">{{ $reg->user->name }}</div>
                                        <div class="text-[11px] text-slate-400 font-medium mt-1 flex items-center gap-1">
                                            <i data-lucide="mail" class="w-3 h-3"></i>
                                            {{ $reg->user->email }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Detail Event & Paket --}}
                            <td class="px-6 py-6">
                                <div class="flex flex-col gap-2">
                                    <span class="text-[12px] font-bold text-slate-700 tracking-tight leading-tight">
                                        {{ $reg->event->title ?? 'Webinar Legacy' }}
                                    </span>
                                    <div class="flex items-center gap-2">
                                        @php
                                            $pkgColor = match($reg->package_type) {
                                                'vip1' => 'bg-purple-50 text-purple-600 border-purple-100',
                                                'vip2' => 'bg-blue-50 text-blue-600 border-blue-100',
                                                default => 'bg-slate-50 text-slate-600 border-slate-100',
                                            };
                                        @endphp
                                        <span class="px-2 py-0.5 rounded-md border text-[9px] font-black uppercase tracking-tighter {{ $pkgColor }}">
                                            {{ $reg->package_type }}
                                        </span>
                                    </div>
                                </div>
                            </td>

                            {{-- Status Pembayaran --}}
                            <td class="px-6 py-6">
                                <div class="flex flex-col gap-1.5">
                                    <div class="text-sm font-black text-slate-800 tracking-tighter">
                                        Rp {{ number_format($reg->amount, 0, ',', '.') }}
                                    </div>
                                    <a href="{{ asset('storage/' . $reg->payment_proof) }}" target="_blank" 
                                    class="inline-flex items-center gap-1.5 text-[10px] font-black text-indigo-600 hover:text-indigo-800 transition-colors uppercase tracking-widest">
                                        <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                        Cek Lampiran
                                    </a>
                                </div>
                            </td>

                            {{-- Tombol Aksi --}}
                            <td class="px-6 py-6">
                                <div class="flex items-center justify-center gap-2">
                                    {{-- Verified Button --}}
                                    <button type="button" 
                                        onclick="triggerVerified({{ $reg->id }}, '{{ $reg->user->name }}', {{ isset($reg->is_legacy) ? 'true' : 'false' }})"
                                        class="group/btn h-10 px-5 rounded-xl bg-emerald-500 text-white text-[11px] font-bold uppercase tracking-widest hover:bg-emerald-600 hover:shadow-lg hover:shadow-emerald-100 transition-all active:scale-95 flex items-center gap-2">
                                        <i data-lucide="check-circle" class="w-4 h-4"></i>
                                        Verify
                                    </button>

                                    {{-- Reject Area --}}
                                    <div class="flex items-center bg-white border border-slate-200 rounded-xl p-1 shadow-sm focus-within:ring-2 focus-within:ring-rose-100 focus-within:border-rose-300 transition-all duration-300">
                                        <input type="text" id="reject-reason-{{ $reg->id }}" 
                                            placeholder="Alasan ditolak..." 
                                            class="text-[11px] bg-transparent border-none focus:ring-0 w-28 px-2 placeholder:text-slate-300 font-medium">
                                        <button type="button" 
                                            onclick="triggerReject({{ $reg->id }}, '{{ $reg->user->name }}', {{ isset($reg->is_legacy) ? 'true' : 'false' }})"
                                            class="w-8 h-8 flex items-center justify-center bg-rose-50 text-rose-600 rounded-lg hover:bg-rose-600 hover:text-white transition-all">
                                            <i data-lucide="x" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-24">
                                <div class="flex flex-col items-center justify-center text-center">
                                    <div class="w-20 h-20 bg-indigo-50 rounded-[2.5rem] flex items-center justify-center mb-6 animate-bounce">
                                        <i data-lucide="sparkles" class="w-10 h-10 text-indigo-500"></i>
                                    </div>
                                    <h3 class="text-xl font-black text-slate-800 tracking-tight">Semua Pendaftaran Bersih!</h3>
                                    <p class="text-slate-400 text-sm mt-2 max-w-xs mx-auto font-medium">Belum ada pendaftaran baru yang perlu ditinjau hari ini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- FORM HIDDEN (Taruh di luar tabel atau di bawah) --}}
    <form id="global-verify-form" method="POST" class="hidden">
        @csrf
        <input type="hidden" name="reason" id="hidden-reason">
    </form>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const globalForm = document.getElementById('global-verify-form');
        const hiddenReason = document.getElementById('hidden-reason');

        // --- FUNGSI VERIFIED ---
        function triggerVerified(id, userName, isLegacy) {
            Swal.fire({
                title: 'Verifikasi Pembayaran?',
                text: `Setujui bukti transfer dari ${userName}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#059669',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Setujui',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // LOGIKA PENENTUAN ROUTE
                    let actionUrl = isLegacy 
                        ? `{{ url('/admin/approve-legacy') }}/${id}` 
                        : `{{ url('/admin/verified') }}/${id}`;
                    
                    globalForm.action = actionUrl;
                    globalForm.submit();
                }
            });
        }

        // --- FUNGSI REJECT ---
        function triggerReject(id, userName, isLegacy) { 
            const reasonValue = document.getElementById(`reject-reason-${id}`).value;

            if (!reasonValue || reasonValue.trim() === "") {
                Swal.fire({
                    title: 'Alasan Kosong',
                    text: 'Harap isi alasan penolakan terlebih dahulu.',
                    icon: 'warning',
                    confirmButtonColor: '#e11d48'
                });
                return;
            }

            Swal.fire({
                title: 'Tolak Pembayaran?',
                text: `Yakin ingin menolak bukti dari ${userName}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Tolak',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // LOGIKA PENENTUAN ROUTE
                    let actionUrl = isLegacy 
                        ? `{{ url('/admin/reject-legacy') }}/${id}` 
                        : `{{ url('/admin/reject') }}/${id}`;
                    
                    hiddenReason.value = reasonValue;
                    globalForm.action = actionUrl;
                    globalForm.submit();
                }
            });
        }
    </script>
</x-admin-layout>