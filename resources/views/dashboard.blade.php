<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/lucide@latest"></script>

<x-app-layout>
    <div class="min-h-screen bg-[#F0F2F5] pb-12">
        
        {{-- HEADER --}}
        <div class="max-w-7xl mx-auto px-6 pt-10 mb-8">
            <h1 class="text-2xl font-bold text-gray-800">My Dashboard</h1>
            <p class="text-sm text-gray-500 mt-1">Selamat datang kembali, {{ Auth::user()->name }}.</p>
        </div>

        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-12 gap-6">

                {{-- SIDEBAR KIRI --}}
                <div class="col-span-12 lg:col-span-4 space-y-6">
                    
                    {{-- 1. PERBAIKAN: Admin Quick Access (Hanya ini yang tampil jika role admin) --}}
                    @if(Auth::user()->role === 'admin')
                    <div class="bg-blue-900 rounded-2xl p-6 text-white shadow-xl border-4 border-blue-800">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="p-3 bg-white/10 rounded-xl">
                                <i data-lucide="shield-check" class="w-8 h-8 text-amber-400"></i>
                            </div>
                            <div>
                                <h3 class="font-black uppercase tracking-wider">Administrator</h3>
                                <p class="text-xs text-blue-200">Mode Kendali Sistem</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.dashboard') }}" class="block w-full py-3 bg-amber-500 text-white text-center rounded-xl font-bold text-sm hover:bg-amber-600 transition shadow-lg shadow-amber-900/20">
                            MASUK DASHBOARD ADMIN
                        </a>
                    </div>
                    @endif

                    {{-- Profile Card (Hanya muncul jika BUKAN admin) --}}
                    @if(Auth::user()->role !== 'admin')
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                        <div class="h-16 bg-blue-900"></div>
                        <div class="px-6 pb-6 text-center">
                            <div class="relative -mt-8 mb-3">
                                <div class="w-16 h-16 bg-white p-1 rounded-full shadow-md mx-auto">
                                    <div class="w-full h-full bg-gray-100 rounded-full flex items-center justify-center text-gray-400">
                                        <i data-lucide="user" class="w-8 h-8"></i>
                                    </div>
                                </div>
                            </div>
                            <h3 class="font-bold text-gray-900">{{ Auth::user()->name }}</h3>
                            <p class="text-[10px] text-blue-900 font-bold uppercase tracking-widest mt-1">{{ Auth::user()->package }} Member</p>
                            
                            <div class="mt-6 pt-6 border-t border-gray-100 space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-xs text-gray-500 font-medium">Status Akun</span>
                                    @if(Auth::user()->is_verified)
                                        <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded text-[10px] font-bold uppercase">Terverifikasi</span>
                                    @else
                                        <span class="px-2 py-0.5 bg-amber-100 text-amber-700 rounded text-[10px] font-bold uppercase">Pending</span>
                                    @endif
                                </div>
                                @if(Auth::user()->toefl_score)
                                <div class="flex justify-between items-center">
                                    <span class="text-xs text-gray-500 font-medium">Skor TOEFL</span>
                                    <span class="text-sm font-black text-blue-900 font-mono">{{ Auth::user()->toefl_score }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Certificate Card --}}
                    @php
                        // Normalisasi string paket agar tidak error karena perbedaan huruf besar/kecil
                        $userPkg = strtolower(trim(Auth::user()->package));
                        $hasToeflAccess = in_array($userPkg, ['vip2', 'vipplus']); // Tambahkan list paket VIP di sini
                    @endphp

                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="p-2 bg-red-50 text-red-600 rounded-lg">
                                <i data-lucide="award" class="w-5 h-5"></i>
                            </div>
                            <h4 class="font-bold text-sm text-gray-800 uppercase tracking-tight">E-Sertifikat</h4>
                        </div>

                        @if($isCertReady && Auth::user()->is_verified)
                            <div class="space-y-3">
                                {{-- Sertifikat Webinar (Untuk Semua) --}}
                                <a href="{{ route('certificate.webinar') }}" class="block w-full text-center py-2.5 bg-red-600 text-white rounded-lg text-xs font-bold hover:bg-red-700 transition">
                                    Download Sertifikat Peserta
                                </a>

                                {{-- Sertifikat TOEFL (Hanya VIP & Jika sudah ada skor) --}}
                                @if($hasToeflAccess)
                                    @if(Auth::user()->toefl_score)
                                        <a href="{{ route('certificate.toefl') }}" class="block w-full text-center py-2.5 bg-indigo-900 text-white rounded-lg text-xs font-bold hover:bg-black transition">
                                            Download Sertifikat TOEFL
                                        </a>
                                    @else
                                        <div class="p-2 bg-amber-50 border border-amber-100 rounded-lg text-center">
                                            <p class="text-[9px] text-amber-600 font-bold uppercase tracking-tighter">Sertifikat TOEFL: Skor Belum Diinput Admin</p>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        @else
                            <div class="p-3 bg-gray-50 rounded-lg border border-gray-100 text-center">
                                <p class="text-[10px] text-gray-400 italic font-medium">Sertifikat tersedia otomatis setelah program selesai.</p>
                            </div>
                        @endif
                    </div>
                    @endif
                </div>

                {{-- KONTEN UTAMA (Kanan) --}}
                <div class="col-span-12 lg:col-span-8 space-y-6">

                    {{-- 2. PERBAIKAN: Logika Pesan Rejection --}}
                    @if(!Auth::user()->is_verified && Auth::user()->rejection_message)
                        <div class="bg-red-50 border-l-4 border-red-600 p-4 rounded-r-xl flex gap-3 animate-pulse">
                            <i data-lucide="alert-circle" class="w-5 h-5 text-red-600 shrink-0"></i>
                            <div>
                                <h4 class="text-sm font-bold text-red-800">Pembayaran Perlu Diperbaiki</h4>
                                <p class="text-xs text-red-700 mt-1 italic">"{{ Auth::user()->rejection_message }}"</p>
                                <p class="text-[10px] text-red-500 mt-2 font-bold uppercase tracking-tighter">* Silakan upload ulang bukti transfer yang valid di bawah.</p>
                            </div>
                        </div>
                    @endif

                    @if(Auth::user()->role !== 'admin')
                        {{-- AREA PEMBAYARAN --}}
                        @if(!Auth::user()->is_verified)
                            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                                <div class="p-6 bg-amber-50 border-b border-amber-100 flex items-center justify-between">
                                    <h4 class="font-bold text-amber-800 text-sm uppercase">Selesaikan Pembayaran</h4>
                                    <span class="text-[10px] bg-amber-200 text-amber-800 px-2 py-1 rounded font-black tracking-widest uppercase">
                                        {{ Auth::user()->rejection_message ? 'Upload Ulang' : 'Menunggu' }}
                                    </span>
                                </div>
                                <div class="p-6">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                                        <div class="space-y-4">
                                            <div>
                                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1">Tagihan Kamu ({{ Auth::user()->package }})</p>
                                                <p class="text-3xl font-black text-gray-900 font-mono">
                                                    @if(Auth::user()->package == 'reguler') Rp 20.000
                                                    @elseif(Auth::user()->package == 'vip1') Rp 50.000
                                                    @else Rp 100.000 @endif
                                                </p>
                                            </div>
                                            <div class="p-4 bg-gray-50 rounded-xl border border-gray-100 text-sm">
                                                <p class="text-[9px] text-gray-400 font-bold uppercase mb-2">Transfer ke Rekening</p>
                                                <p class="font-bold text-gray-700 uppercase">{{ env('BANK_NAME') }} ({{ env('BANK_CODE') }})</p>
                                                <p class="text-lg font-black text-blue-900 font-mono">{{ env('BANK_ACCOUNT_NUMBER') }}</p>
                                                <p class="text-[10px] text-gray-500 font-medium mt-1 uppercase italic font-bold">A.N: {{ env('BANK_ACCOUNT_NAME') }}</p>
                                            </div>
                                        </div>
                                        <div class="flex flex-col justify-center">
                                            @if(!Auth::user()->payment_proof)
                                                {{-- Kondisi 1: Belum pernah upload sama sekali --}}
                                                <form action="{{ route('payment.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                                                    @csrf
                                                    <div class="relative">
                                                        <input type="file" name="payment_proof" class="block w-full text-xs text-gray-500 border border-gray-200 rounded-lg bg-gray-50 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-900 file:text-white hover:file:bg-black transition cursor-pointer" required>
                                                    </div>
                                                    <button type="submit" class="w-full bg-blue-900 text-white py-3 rounded-xl text-xs font-bold hover:bg-blue-800 transition shadow-md uppercase tracking-widest">Kirim Konfirmasi</button>
                                                </form>

                                            @elseif(Auth::user()->payment_proof && Auth::user()->rejection_message)
                                                {{-- Kondisi 2: Ada bukti tapi ditolak (Tampilkan Form Upload Lagi) --}}
                                                <form action="{{ route('payment.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                                                    @csrf
                                                    <div class="relative">
                                                        <input type="file" name="payment_proof" class="block w-full text-xs text-gray-500 border border-gray-200 rounded-lg bg-gray-50 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-900 file:text-white hover:file:bg-black transition cursor-pointer" required>
                                                    </div>
                                                    <button type="submit" class="w-full bg-blue-900 text-white py-3 rounded-xl text-xs font-bold hover:bg-blue-800 transition shadow-md uppercase tracking-widest">Update Bukti Pembayaran</button>
                                                </form>

                                            @else
                                                {{-- Kondisi 3: Sudah upload dan rejection_message kosong --}}
                                                <div class="text-center py-6 bg-blue-50 rounded-xl border border-blue-100">
                                                    <i data-lucide="clock" class="w-8 h-8 text-blue-900 mx-auto mb-2 opacity-50"></i>
                                                    <p class="text-xs font-bold text-blue-900 uppercase">Sedang Diperiksa</p>
                                                    <p class="text-[10px] text-blue-700 mt-1 px-4 italic font-medium leading-relaxed">Admin akan memverifikasi bukti bayar kamu secepatnya.</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                        {{-- AREA MATERI --}}
                        @else
                            @foreach($myContents->where('type', 'link_zoom') as $zoom)
                            <div class="bg-blue-900 rounded-xl p-6 text-white shadow-lg flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-white/10 rounded-lg flex items-center justify-center">
                                        <i data-lucide="video" class="w-6 h-6"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-lg leading-tight">{{ $zoom->title }}</h4>
                                        <span class="text-[10px] bg-red-600 px-2 py-0.5 rounded font-bold uppercase animate-pulse">Live Webinar</span>
                                    </div>
                                </div>
                                <a href="{{ $zoom->link }}" target="_blank" class="bg-white text-blue-900 px-6 py-2 rounded-lg font-bold text-sm hover:bg-gray-100 transition shadow-sm">Masuk Zoom</a>
                            </div>
                            @endforeach

                            <div class="grid grid-cols-1 {{ Auth::user()->package == 'vip2' ? 'md:grid-cols-2' : '' }} gap-6">
                                @foreach($myContents->where('type', 'link_wa') as $wa)
                                <div class="bg-white rounded-xl border border-gray-200 p-6 flex flex-col justify-between hover:shadow-md transition">
                                    <div class="flex items-center gap-4 mb-4">
                                        <div class="w-10 h-10 bg-green-50 text-green-600 rounded-lg flex items-center justify-center">
                                            <i data-lucide="message-square" class="w-5 h-5"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-900 text-sm uppercase tracking-tight">{{ $wa->title }}</h4>
                                            <p class="text-[11px] text-gray-500 font-medium italic">Grup diskusi peserta</p>
                                        </div>
                                    </div>
                                    <a href="{{ $wa->link }}" target="_blank" class="block text-center py-2.5 bg-green-600 text-white rounded-xl text-xs font-bold hover:bg-green-700 transition">Gabung WhatsApp</a>
                                </div>
                                @endforeach

                                @if(Auth::user()->package == 'vip2')
                                <div class="bg-white rounded-xl border border-gray-200 p-6 flex flex-col justify-between hover:shadow-md transition">
                                    <div class="flex items-center gap-4 mb-4">
                                        <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center">
                                            <i data-lucide="edit-3" class="w-5 h-5"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-900 text-sm uppercase tracking-tight">Tes TOEFL ITP</h4>
                                            <p class="text-[11px] text-gray-500 font-medium">Simulasi skor resmi</p>
                                        </div>
                                    </div>

                                    @php
                                        $isTestOpen = DB::table('settings')->where('key', 'is_test_open')->value('value') == '1';
                                    @endphp

                                    <div class="w-full"> {{-- Pembungkus agar ukuran konsisten --}}
                                        @if($isTestOpen)
                                            <a href="{{ route('toefl.index') }}" 
                                            class="block w-full text-center py-2.5 bg-blue-900 text-white rounded-xl text-xs font-bold hover:bg-blue-800 transition shadow-sm">
                                                {{ Auth::user()->toefl_score ? 'Ulangi Tes' : 'Mulai Sekarang' }}
                                            </a>
                                        @else
                                            <div class="flex flex-col gap-2">
                                                <button type="button" disabled 
                                                        class="w-full py-2.5 bg-slate-100 text-slate-400 rounded-xl text-xs font-bold cursor-not-allowed flex items-center justify-center gap-2 border border-slate-200">
                                                    <i data-lucide="lock" class="w-3 h-3"></i>
                                                    AKSES UJIAN DITUTUP
                                                </button>
                                                <p class="text-[10px] text-rose-500 text-center font-medium italic leading-tight">
                                                    Tunggu instruksi admin untuk memulai
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                @endif
                            </div>

                            @if(Auth::user()->package != 'reguler')
                            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden mt-6">
                                <div class="p-4 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
                                    <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Daftar Materi & Rekaman</h4>
                                    <i data-lucide="folder-open" class="w-4 h-4 text-gray-400"></i>
                                </div>
                                <div class="divide-y divide-gray-100">
                                    @forelse($myContents->whereIn('type', ['materi', 'rekaman']) as $m)
                                        <a href="{{ $m->link }}" target="_blank" class="flex items-center justify-between p-4 hover:bg-blue-50/50 transition-all group">
                                            <div class="flex items-center gap-3">
                                                <i data-lucide="{{ $m->type == 'materi' ? 'file-text' : 'play-circle' }}" class="w-4 h-4 text-gray-300 group-hover:text-blue-900"></i>
                                                <span class="text-xs font-bold text-gray-600 group-hover:text-blue-900 uppercase">{{ $m->title }}</span>
                                            </div>
                                            <span class="text-[9px] px-2 py-0.5 bg-gray-100 text-gray-400 rounded-full font-black uppercase group-hover:bg-blue-900 group-hover:text-white transition-all">{{ $m->type }}</span>
                                        </a>
                                    @empty
                                        <div class="p-8 text-center text-gray-400 text-xs italic">Belum ada materi.</div>
                                    @endforelse
                                </div>
                            </div>
                            @endif
                        @endif
                    @else
                        <div class="bg-white p-12 rounded-3xl border-2 border-dashed border-gray-200 text-center">
                            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i data-lucide="layout-dashboard" class="w-10 h-10 text-gray-300"></i>
                            </div>
                            <h3 class="text-gray-800 font-bold italic">"Anda Login sebagai Admin"</h3>
                            <p class="text-gray-400 text-sm mt-2">Gunakan Panel Admin di samping untuk mengelola data peserta.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();

        document.addEventListener('DOMContentLoaded', function() {
            // 1. Alert Berhasil
            @if(session('success') || session('status'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') ?? session('status') }}",
                    confirmButtonColor: '#1e3a8a',
                });
            @endif

            // 2. Alert Info (Misal: Tes Sudah Diikuti)
            @if(session('info'))
                Swal.fire({
                    icon: 'info',
                    title: 'Informasi',
                    text: "{{ session('info') }}",
                    confirmButtonColor: '#1e3a8a',
                });
            @endif

            // 3. Alert Skor (Jika ada session score)
            @if(session('score'))
                Swal.fire({
                    title: 'Hasil Tes Kamu',
                    html: '<p class="text-sm">Skor Akhir:</p><h2 class="text-4xl font-black text-blue-900">{{ session("score") }}</h2>',
                    icon: 'success',
                    confirmButtonColor: '#1e3a8a',
                });
            @endif

            // 4. Alert Error
            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: "{{ session('error') }}",
                    confirmButtonColor: '#ef4444',
                });
            @endif
        });
    </script>
</x-app-layout>