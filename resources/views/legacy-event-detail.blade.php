<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/lucide@latest"></script>

<x-app-layout>
    <div class="min-h-screen bg-slate-50/50 py-12 px-6">
        <div class="max-w-4xl mx-auto">

            {{-- Tombol Kembali - Glassmorphism Premium --}}
            <a href="{{ route('dashboard') }}" 
            class="inline-flex items-center gap-2 px-4 py-2 bg-white/40 backdrop-blur-md rounded-xl text-slate-600 border border-white/60 shadow-lg shadow-slate-200/50 hover:bg-white/60 hover:text-indigo-600 hover:border-indigo-300/50 transition-all duration-300 group mb-8">
                
                <i data-lucide="chevron-left" class="w-5 h-5 transition-transform group-hover:-translate-x-1"></i>
                
                <span class="text-sm font-medium">Kembali ke Dashboard</span>
            </a>
            
            {{-- HEADER SECTION --}}
            <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h1 class="text-4xl font-black text-slate-900 leading-none italic uppercase tracking-tighter">
                        Webinar <span class="text-blue-600">Unlocked</span>
                    </h1>
                    <p class="text-slate-500 font-medium mt-2">Arsip & Akses Materi Beasiswa 2026</p>
                </div>
                <div class="px-4 py-2 bg-white rounded-2xl border border-slate-200 shadow-sm flex items-center gap-2">
                    <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                    <span class="text-[10px] font-black text-slate-600 uppercase tracking-widest">Legacy Access</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                {{-- STATUS PEMBAYARAN --}}
                <div class="md:col-span-2 bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100 relative overflow-hidden">
                    <div class="relative z-10">
                        <h2 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Status Pendaftaran</h2>
                        
                        @if($user->is_verified)
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center shadow-inner">
                                    <i data-lucide="shield-check" class="w-8 h-8"></i>
                                </div>
                                <div>
                                    <div class="text-2xl font-black text-slate-800 tracking-tight">Terverifikasi</div>
                                    <div class="px-2 py-0.5 bg-slate-100 text-slate-600 text-[10px] font-bold rounded-md inline-block uppercase">
                                        Paket: {{ $user->package }}
                                    </div>
                                </div>
                            </div>
                        @elseif($user->payment_proof)
                            <div class="flex items-center gap-4 text-amber-600">
                                <div class="w-14 h-14 bg-amber-50 rounded-2xl flex items-center justify-center">
                                    <i data-lucide="loader-2" class="w-8 h-8 animate-spin"></i>
                                </div>
                                <span class="text-lg font-bold">Menunggu Verifikasi</span>
                            </div>
                        @else
                            <div class="flex items-center gap-4 text-rose-600">
                                <div class="w-14 h-14 bg-rose-50 rounded-2xl flex items-center justify-center">
                                    <i data-lucide="alert-circle" class="w-8 h-8"></i>
                                </div>
                                <span class="text-lg font-bold">Belum Ada Pembayaran</span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- TOMBOL TEST (Khusus VIP) --}}
                @if(Auth::user()->package == 'vip2' || Auth::user()->package == 'vip_plus')
                    <div class="bg-blue-600 rounded-[2.5rem] p-6 text-white shadow-xl shadow-blue-200 relative overflow-hidden group">
                        <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:scale-125 transition-transform duration-500">
                            <i data-lucide="edit-3" class="w-24 h-24 text-white"></i>
                        </div>
                        
                        <div class="relative z-10 h-full flex flex-col justify-between">
                            <div>
                                <h4 class="font-black text-xs uppercase tracking-widest opacity-80 mb-1 italic">Simulation</h4>
                                <h3 class="text-xl font-black leading-tight">TOEFL ITP Test</h3>
                            </div>

                            <div class="mt-6">
                                @if($isTestOpen)
                                    <a href="{{ route('toefl.index') }}" 
                                       class="block w-full text-center py-3 bg-white text-blue-600 rounded-2xl text-xs font-black hover:bg-slate-50 transition shadow-lg uppercase tracking-widest">
                                        {{ Auth::user()->toefl_score ? 'Ulangi Ujian' : 'Mulai Sekarang' }}
                                    </a>
                                @else
                                    <div class="flex flex-col gap-2">
                                        <button disabled class="w-full py-3 bg-blue-700/50 text-blue-200 rounded-2xl text-xs font-black cursor-not-allowed flex items-center justify-center gap-2 border border-blue-400/30">
                                            <i data-lucide="lock" class="w-3 h-3"></i> CLOSED
                                        </button>
                                        <p class="text-[9px] text-blue-100 text-center font-medium italic opacity-80">Tunggu instruksi admin</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- MATERI SECTION --}}
            @if($user->is_verified)
                <div class="mb-12">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="h-6 w-1.5 bg-blue-600 rounded-full"></div>
                        <h2 class="text-xl font-black text-slate-800 uppercase italic tracking-tight">Materi & Resource</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 gap-4">
                        @foreach($contents as $content)
                            <div class="group bg-white p-5 rounded-[1.5rem] border border-slate-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 hover:border-blue-200 hover:shadow-md transition-all duration-300">
                                <div class="flex items-start gap-4">
                                    <div class="p-3 bg-slate-50 text-slate-400 group-hover:bg-blue-50 group-hover:text-blue-600 rounded-xl transition-colors">
                                        <i data-lucide="file-text" class="w-6 h-6"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-slate-800 group-hover:text-blue-700 transition-colors">{{ $content->title }}</h3>
                                        <p class="text-xs text-slate-500 max-w-md line-clamp-1">{{ $content->description }}</p>
                                    </div>
                                </div>
                                <a href="{{ $content->link }}" target="_blank" class="w-full md:w-auto px-6 py-2.5 bg-slate-900 text-white rounded-xl text-xs font-black hover:bg-blue-600 transition-colors flex items-center justify-center gap-2 shadow-sm">
                                    BUKA AKSES <i data-lucide="external-link" class="w-3 h-3 text-white/50"></i>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- SERTIFIKAT SECTION --}}
            <div class="pt-6 border-t border-slate-200">
                <div class="flex items-center gap-3 mb-6">
                    <div class="h-6 w-1.5 bg-indigo-600 rounded-full"></div>
                    <h2 class="text-xl font-black text-slate-800 uppercase italic tracking-tight text-indigo-900">E-Certificate</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- 1. Webinar --}}
                    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm relative overflow-hidden group">
                        <div class="flex items-center gap-4 mb-6 relative z-10">
                            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-2xl group-hover:scale-110 transition-transform">
                                <i data-lucide="award" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <h3 class="font-black text-slate-800 text-sm">Sertifikat Peserta</h3>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Webinar Unlocked</p>
                            </div>
                        </div>

                        @if($isCertReady && Auth::user()->is_verified)
                            <a href="{{ route('certificate.webinar') }}" class="block w-full text-center py-3 bg-indigo-600 text-white rounded-2xl text-xs font-black hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-100 transition shadow-sm uppercase tracking-widest">
                                Download PDF
                            </a>
                        @else
                            <button disabled class="w-full py-3 bg-slate-50 text-slate-400 rounded-2xl text-[10px] font-black cursor-not-allowed flex items-center justify-center gap-2 border border-slate-100 uppercase">
                                <i data-lucide="lock" class="w-3 h-3"></i> {{ !$isCertReady ? 'BELUM TERSEDIA' : 'LOCKED' }}
                            </button>
                        @endif
                    </div>

                    {{-- 2. TOEFL --}}
                    @if(Auth::user()->package === 'vip2' || Auth::user()->package === 'vip_plus')
                    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm relative overflow-hidden group">
                        <div class="flex items-center gap-4 mb-6 relative z-10">
                            <div class="p-3 bg-emerald-50 text-emerald-600 rounded-2xl group-hover:scale-110 transition-transform">
                                <i data-lucide="file-check" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <h3 class="font-black text-slate-800 text-sm">Sertifikat TOEFL</h3>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Skor: {{ Auth::user()->toefl_score ?? '0' }}</p>
                            </div>
                        </div>

                        @if($isCertReady && Auth::user()->toefl_score)
                            <a href="{{ route('certificate.toefl') }}" class="block w-full text-center py-3 bg-emerald-600 text-white rounded-2xl text-xs font-black hover:bg-emerald-700 hover:shadow-lg hover:shadow-emerald-100 transition shadow-sm uppercase tracking-widest">
                                Download Hasil
                            </a>
                        @elseif(!$isCertReady)
                            <button disabled class="w-full py-3 bg-slate-50 text-slate-400 rounded-2xl text-[10px] font-black cursor-not-allowed flex items-center justify-center gap-2 border border-slate-100 uppercase">
                                <i data-lucide="lock" class="w-3 h-3"></i> Belum Tersedia
                            </button>
                        @else
                            <button disabled class="w-full py-3 bg-slate-50 text-slate-400 rounded-2xl text-[10px] font-black cursor-not-allowed uppercase border border-slate-100">
                                Skor Belum Terbit
                            </button>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</x-app-layout>