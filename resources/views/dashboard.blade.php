<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/lucide@latest"></script>

<x-app-layout>
    <div class="min-h-screen bg-[#F0F2F5] pb-12">
        
        {{-- HEADER PENGGANTI BREADCRUMB (Gaya Dicoding) --}}
        <div class="max-w-7xl mx-auto px-6 pt-10 mb-8">
            <h1 class="text-2xl font-bold text-gray-800">My Dashboard</h1>
            <p class="text-sm text-gray-500 mt-1">Selamat datang kembali, {{ Auth::user()->name }}.</p>
        </div>

        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-12 gap-6">

                {{-- SIDEBAR KIRI (Status & Profile) --}}
                <div class="col-span-12 lg:col-span-4 space-y-6">
                    
                    {{-- Admin Quick Access --}}
                    @if(Auth::user()->role === 'admin')
                    <div class="bg-blue-900 rounded-xl p-6 text-white shadow-lg">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="p-3 bg-white/10 rounded-lg">
                                <i data-lucide="shield-check" class="w-6 h-6"></i>
                            </div>
                            <h3 class="font-bold">Panel Admin</h3>
                        </div>
                        <a href="{{ route('admin.dashboard') }}" class="block w-full py-2.5 bg-white text-blue-900 text-center rounded-lg font-bold text-sm hover:bg-gray-100 transition">
                            Buka Dashboard Admin
                        </a>
                    </div>
                    @endif

                    {{-- Profile Card --}}
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

                    {{-- Certificate Card (Red Accent) --}}
                    @php $isCertReady = DB::table('settings')->where('key', 'is_certificate_ready')->value('value'); @endphp
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="p-2 bg-red-50 text-red-600 rounded-lg">
                                <i data-lucide="award" class="w-5 h-5"></i>
                            </div>
                            <h4 class="font-bold text-sm text-gray-800 uppercase tracking-tight">E-Sertifikat</h4>
                        </div>
                        @if($isCertReady == '1')
                            <p class="text-xs text-gray-500 mb-4 font-medium">Sertifikat sudah tersedia untuk diunduh.</p>
                            <a href="{{ route('certificate.download') }}" class="block w-full text-center py-2.5 bg-red-600 text-white rounded-lg text-xs font-bold hover:bg-red-700 transition shadow-md">Download PDF</a>
                        @else
                            <div class="p-3 bg-gray-50 rounded-lg border border-gray-100">
                                <p class="text-[10px] text-gray-400 leading-relaxed italic text-center font-medium">Sertifikat terbuka otomatis setelah program selesai.</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- KONTEN UTAMA (Kanan) --}}
                <div class="col-span-12 lg:col-span-8 space-y-6">

                    {{-- Jika Ada Pesan Penolakan --}}
                    @if(Auth::user()->rejection_message)
                    <div class="bg-red-50 border-l-4 border-red-600 p-4 rounded-r-xl flex gap-3">
                        <i data-lucide="alert-circle" class="w-5 h-5 text-red-600 shrink-0"></i>
                        <div>
                            <h4 class="text-sm font-bold text-red-800">Pembayaran Ditolak</h4>
                            <p class="text-xs text-red-700 mt-1 italic">{{ Auth::user()->rejection_message }}</p>
                        </div>
                    </div>
                    @endif

                    {{-- AREA PEMBAYARAN (Belum Verifikasi) --}}
                    @if(!Auth::user()->is_verified)
                        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                            <div class="p-6 bg-amber-50 border-b border-amber-100 flex items-center justify-between">
                                <h4 class="font-bold text-amber-800 text-sm uppercase">Selesaikan Pembayaran</h4>
                                <span class="text-[10px] bg-amber-200 text-amber-800 px-2 py-1 rounded font-black tracking-widest">URGENT</span>
                            </div>
                            <div class="p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                                    <div class="space-y-4">
                                        <div>
                                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1">Tagihan Kamu</p>
                                            <p class="text-3xl font-black text-gray-900 font-mono">
                                                @if(Auth::user()->package == 'reguler') Rp 20.000
                                                @elseif(Auth::user()->package == 'vip1') Rp 50.000
                                                @else Rp 100.000 @endif
                                            </p>
                                        </div>
                                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                                            <p class="text-[9px] text-gray-400 font-bold uppercase mb-2">Transfer ke Rekening</p>
                                            <p class="text-xs font-bold text-gray-700 uppercase">Bank Mandiri (008)</p>
                                            <p class="text-lg font-black text-blue-900 font-mono">123-456-7890</p>
                                            <p class="text-[10px] text-gray-500 font-medium mt-1 uppercase italic">A.N: Beasiswa Camy Official</p>
                                        </div>
                                    </div>
                                    <div class="flex flex-col justify-center">
                                        @if(!Auth::user()->payment_proof)
                                            <form action="{{ route('payment.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                                                @csrf
                                                <div class="relative">
                                                    <input type="file" name="payment_proof" class="block w-full text-xs text-gray-500 border border-gray-200 rounded-lg bg-gray-50 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-900 file:text-white hover:file:bg-black transition cursor-pointer" required>
                                                </div>
                                                <button type="submit" class="w-full bg-blue-900 text-white py-2.5 rounded-lg text-xs font-bold hover:bg-blue-800 transition shadow-md uppercase tracking-widest">Kirim Konfirmasi</button>
                                            </form>
                                        @else
                                            <div class="text-center py-6 bg-blue-50 rounded-xl border border-blue-100">
                                                <i data-lucide="clock" class="w-8 h-8 text-blue-900 mx-auto mb-2 opacity-50"></i>
                                                <p class="text-xs font-bold text-blue-900 uppercase">Menunggu Verifikasi</p>
                                                <p class="text-[10px] text-blue-700 mt-1 px-4 italic font-medium leading-relaxed">Admin akan mengecek bukti bayar kamu dalam waktu maksimal 1x24 jam.</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                    {{-- AREA MATERI (Sudah Verifikasi) --}}
                    @else
                        {{-- Zoom Live --}}
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

                        {{-- Grid WA & TOEFL --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($myContents->where('type', 'link_wa') as $wa)
                            <div class="bg-white rounded-xl border border-gray-200 p-6 flex flex-col justify-between hover:shadow-md transition">
                                <div>
                                    <div class="w-10 h-10 bg-green-50 text-green-600 rounded-lg flex items-center justify-center mb-4">
                                        <i data-lucide="message-square" class="w-5 h-5 text-sm"></i>
                                    </div>
                                    <h4 class="font-bold text-gray-900 text-sm uppercase tracking-tight">{{ $wa->title }}</h4>
                                    <p class="text-[11px] text-gray-500 mt-1 font-medium">Grup diskusi interaktif bersama peserta lainnya.</p>
                                </div>
                                <a href="{{ $wa->link }}" target="_blank" class="mt-6 block text-center py-2 bg-green-600 text-white rounded-lg text-xs font-bold hover:bg-green-700 transition shadow-sm">Gabung Grup</a>
                            </div>
                            @endforeach

                            @if(Auth::user()->package == 'vip2')
                            <div class="bg-white rounded-xl border border-gray-200 p-6 flex flex-col justify-between hover:shadow-md transition">
                                <div>
                                    <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center mb-4">
                                        <i data-lucide="edit-3" class="w-5 h-5"></i>
                                    </div>
                                    <h4 class="font-bold text-gray-900 text-sm uppercase tracking-tight">Simulasi TOEFL ITP</h4>
                                    <p class="text-[11px] text-gray-500 mt-1 font-medium italic">Uji kemampuanmu untuk mendapatkan skor sertifikat.</p>
                                </div>
                                <a href="{{ route('toefl.index') }}" class="mt-6 block text-center py-2 bg-blue-900 text-white rounded-lg text-xs font-bold hover:bg-blue-800 transition shadow-sm">
                                    {{ Auth::user()->toefl_score ? 'Ulangi Tes' : 'Mulai Sekarang' }}
                                </a>
                            </div>
                            @endif
                        </div>

                        {{-- Daftar Materi (Dicoding List Style) --}}
                        @if(Auth::user()->package != 'reguler')
                        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
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
                                    <div class="p-8 text-center">
                                        <p class="text-xs text-gray-400 font-medium italic">Belum ada materi yang tersedia saat ini.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // 1. Inisialisasi Ikon Lucide (Perbaikan agar tidak error)
        lucide.createIcons();

        // 2. Logika SweetAlert2 (Notifikasi Sukses/Error)
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success') || session('status'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') ?? session('status') }}",
                    confirmButtonColor: '#1e3a8a',
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Waduh!',
                    text: "{{ session('error') }}",
                    confirmButtonColor: '#ef4444',
                });
            @endif

            @if ($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal',
                    text: "{{ $errors->first() }}",
                    confirmButtonColor: '#ef4444',
                });
            @endif
        });
    </script>
</x-app-layout>