<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/lucide@latest"></script>

@php
    // Ubah ke 'true' jika ingin mensimulasikan tombol sudah aktif/dibuka admin
    $is_quiz_opened = false; 
    $is_certificate_released = false;
@endphp

<x-app-layout>
    {{-- Background diganti ke Slate-100 agar lebih teduh dari putih --}}
    <div class="min-h-screen bg-[#E2E8F0] py-8 md:py-12">
        <div class="max-w-4xl mx-auto px-6">
            
            {{-- Tombol Kembali - Glassmorphism Premium --}}
            <a href="{{ route('dashboard') }}" 
            class="inline-flex items-center gap-2 px-4 py-2 bg-white/40 backdrop-blur-md rounded-xl text-slate-600 border border-white/60 shadow-lg shadow-slate-200/50 hover:bg-white/60 hover:text-indigo-600 hover:border-indigo-300/50 transition-all duration-300 group mb-8">
                
                <i data-lucide="chevron-left" class="w-5 h-5 transition-transform group-hover:-translate-x-1"></i>
                
                <span class="text-sm font-medium">Kembali ke Dashboard</span>
            </a>

            {{-- Main Card - Background menggunakan Slate-50 (Putih Abu-abu) bukan Putih Murni --}}
            <div class="bg-[#F8FAFC]/90 backdrop-blur-2xl rounded-[3rem] shadow-[0_32px_64px_-16px_rgba(15,23,42,0.1)] border border-white overflow-hidden">
                <div class="p-8 md:p-14">
                    
                    {{-- HEADER SECTION --}}
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-8 mb-16">
                        <div class="flex-1 text-center md:text-left">
                            @if($registration->event->parent) 
                                <span class="inline-block px-4 py-1.5 bg-indigo-100 text-indigo-600 text-[10px] font-bold uppercase tracking-[0.15em] rounded-full mb-4 border border-indigo-200">
                                    {{ $registration->event->parent->title }}
                                </span>
                            @endif
                            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-800 tracking-tight leading-tight uppercase italic">
                                {{ $registration->event->title }}
                            </h1>
                            <div class="flex items-center justify-center md:justify-start gap-3 mt-5">
                                <span class="px-4 py-1 bg-slate-200/50 border border-slate-200 text-slate-600 shadow-sm rounded-full text-[9px] font-bold uppercase tracking-widest">
                                    Paket {{ $registration->package_type }}
                                </span>
                            </div>
                        </div>

                        {{-- Action Button --}}
                        @if($registration->event->type === 'lcc' && $registration->status === 'verified')
                            <div class="w-full md:w-auto">
                                @if($is_quiz_opened)
                                    <a href="#" class="flex items-center justify-center gap-3 px-8 py-4 bg-slate-800 text-white rounded-[2rem] font-bold text-sm shadow-xl shadow-slate-300 hover:bg-indigo-600 hover:-translate-y-1 transition-all uppercase tracking-widest">
                                        <i data-lucide="play" class="w-4 h-4 fill-current"></i> Mulai Ujian
                                    </a>
                                @else
                                    <button disabled class="w-full md:w-auto flex items-center justify-center gap-3 px-8 py-4 bg-slate-200 text-red-700/70 rounded-[2rem] font-bold text-sm cursor-not-allowed uppercase tracking-widest border border-slate-300">
                                        <i data-lucide="lock" class="w-4 h-4"></i> Ujian Belum Tersedia
                                    </button>
                                @endif
                            </div>
                        @endif
                    </div>

                    {{-- MAIN CONTENT (Verified) --}}
                    @if($registration->status === 'verified')
                        <div class="space-y-16">
                            
                            {{-- MATERI SECTION --}}
                            <div class="animate-fade-in">
                                <h2 class="text-[11px] font-black text-blue-600/70 uppercase tracking-[0.3em] mb-8 flex items-center gap-4">
                                    Materi Pembelajaran <div class="h-[1px] flex-1 bg-slate-200"></div>
                                </h2>
                                <div class="grid gap-5">
                                    @foreach($contents as $content)
                                        {{-- Item Card menggunakan BG Slate-100/50 --}}
                                        <div class="p-6 bg-slate-100/50 rounded-[2rem] border border-slate-200/50 flex justify-between items-center group hover:bg-white hover:shadow-xl hover:shadow-indigo-100/50 transition-all duration-500">
                                            <div class="flex items-center gap-5">
                                                <div class="w-12 h-12 bg-white text-indigo-500 rounded-2xl flex items-center justify-center group-hover:bg-indigo-600 group-hover:text-white transition-all shadow-sm">
                                                    <i data-lucide="file-text" class="w-6 h-6"></i>
                                                </div>
                                                <div>
                                                    <h3 class="font-bold text-slate-700 text-base leading-none">{{ $content->title }}</h3>
                                                    <p class="text-[11px] text-slate-400 mt-2 font-bold uppercase tracking-wide">{{ $content->description }}</p>
                                                </div>
                                            </div>
                                            <a href="{{ $content->link }}" target="_blank" class="w-10 h-10 flex items-center justify-center bg-slate-200/50 text-slate-500 rounded-full hover:bg-indigo-600 hover:text-white transition-all">
                                                <i data-lucide="arrow-right" class="w-4 h-4"></i>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- SERTIFIKAT SECTION --}}
                            <div class="pt-10 border-t border-slate-200">
                                <h2 class="text-[11px] font-black text-emerald-600/70 uppercase tracking-[0.3em] mb-8 flex items-center gap-4">
                                    E-Certificate <div class="h-[1px] flex-1 bg-slate-200"></div>
                                </h2>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @if($is_certificate_released)
                                        {{-- Tampilan saat sudah bisa didownload (Gunakan kode loop @for kamu di sini) --}}
                                        @if($registration->event->type === 'webinar' && ($registration->package_type === 'premium' || $registration->package_type === 'full'))
                                            @for($i = 1; $i <= 5; $i++)
                                                <div class="p-5 bg-slate-100/50 border border-slate-200/50 rounded-[1.5rem] flex items-center justify-between hover:bg-white hover:shadow-lg transition-all">
                                                    <div class="flex items-center gap-4">
                                                        <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center shadow-sm">
                                                            <i data-lucide="award" class="w-5 h-5"></i>
                                                        </div>
                                                        <span class="text-[10px] font-black text-slate-600 uppercase tracking-widest italic">Episode 0{{ $i }}</span>
                                                    </div>
                                                    <button class="p-2 text-emerald-600 hover:bg-emerald-50 rounded-lg transition">
                                                        <i data-lucide="download" class="w-4 h-4"></i>
                                                    </button>
                                                </div>
                                            @endfor
                                        @else
                                            {{-- Empty State dengan Gradient yang lebih "Deep" --}}
                                            <div class="p-8 bg-gradient-to-br from-slate-100 to-slate-200/50 border border-slate-200/60 rounded-[2.5rem] flex flex-col items-center text-center gap-5 col-span-full">
                                                <div class="w-16 h-16 bg-white text-emerald-500 rounded-[1.5rem] flex items-center justify-center shadow-xl shadow-slate-200">
                                                    <i data-lucide="award" class="w-8 h-8"></i>
                                                </div>
                                                <div>
                                                    <h3 class="font-bold text-slate-800 text-lg uppercase italic tracking-tight">Sertifikat Kelulusan</h3>
                                                    <p class="text-xs text-slate-500 font-medium mt-1">Akses download sudah tersedia untuk kamu.</p>
                                                </div>
                                                <a href="#" class="px-10 py-3 bg-emerald-600 text-white rounded-full text-[10px] font-black uppercase tracking-widest hover:bg-emerald-700 shadow-lg shadow-emerald-100 transition-all">Download Sekarang</a>
                                            </div>
                                        @endif
                                    @else
                                        {{-- Tampilan saat MASIH TERKUNCI (Manual Lock) --}}
                                        <div class="p-8 bg-slate-100/50 border border-dashed border-slate-300 rounded-[2.5rem] flex flex-col items-center text-center gap-4 col-span-full opacity-70">
                                            <div class="w-12 h-12 bg-slate-200 text-red-600 rounded-full flex items-center justify-center">
                                                <i data-lucide="clock" class="w-6 h-6"></i>
                                            </div>
                                            <div>
                                                <h3 class="font-bold text-slate-800 text-sm uppercase tracking-widest leading-none">Sertifikat Belum Rilis</h3>
                                                <p class="text-[10px] text-slate-400 font-bold uppercase mt-2">Akan tersedia setelah acara berakhir</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                    {{-- CASE 2: BELUM KIRIM BUKTI --}}
                    @elseif(is_null($registration->payment_proof) || $registration->status === 'rejected')
                        <div class="max-w-sm mx-auto text-center">
                            <div class="w-24 h-24 bg-slate-200/80 text-indigo-600 rounded-[2.5rem] flex items-center justify-center mx-auto mb-8 shadow-inner">
                                <i data-lucide="upload-cloud" class="w-10 h-10"></i>
                            </div>
                            <h2 class="text-2xl font-black text-slate-800 tracking-tight uppercase italic">Verifikasi Pembayaran</h2>
                            <p class="text-xs text-slate-400 mt-2 font-bold uppercase tracking-widest">Silakan unggah bukti transfer.</p>

                            <form action="{{ route('payment.confirm', $registration->id) }}" method="POST" enctype="multipart/form-data" class="mt-10 space-y-5">
                                @csrf
                                <label class="block">
                                    <div class="w-full py-10 px-4 bg-slate-100 border-2 border-dashed border-slate-300 rounded-[2rem] cursor-pointer hover:bg-white hover:border-indigo-400 transition-all group">
                                        <i data-lucide="image" class="w-6 h-6 mx-auto text-slate-400 group-hover:text-indigo-500 mb-2"></i>
                                        <p id="file-name" class="text-[10px] text-slate-500 font-black uppercase tracking-[0.2em]">Pilih Berkas</p>
                                        <input type="file" name="payment_proof" accept="image/*" required class="hidden" onchange="document.getElementById('file-name').textContent = this.files[0].name">
                                    </div>
                                </label>
                                <button type="submit" class="w-full py-4 bg-slate-800 text-white font-black rounded-full shadow-xl shadow-slate-200 hover:bg-indigo-600 transition-all text-[10px] uppercase tracking-[0.2em]">
                                    Kirim Sekarang
                                </button>
                            </form>
                        </div>

                    {{-- CASE 3: PENDING --}}
                    @elseif($registration->status === 'pending')
                        <div class="text-center py-24">
                            <div class="w-24 h-24 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center mx-auto mb-8 relative shadow-sm">
                                <div class="absolute inset-0 rounded-full bg-amber-200 animate-ping opacity-25"></div>
                                <i data-lucide="refresh-cw" class="w-10 h-10 animate-spin-slow"></i>
                            </div>
                            <h2 class="text-2xl font-black text-slate-800 tracking-tight uppercase italic">Validasi Data</h2>
                            <p class="text-xs text-slate-400 mt-3 font-bold uppercase tracking-[0.2em] max-w-[240px] mx-auto leading-relaxed">Admin Sibali sedang memproses pembayaranmu.</p>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <style>
        .animate-spin-slow { animation: spin 3s linear infinite; }
        @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
    </style>

    <script>
        lucide.createIcons();

        document.addEventListener('DOMContentLoaded', function() {
            const status = "{{ $registration->status }}";
            
            const softAlert = {
                popup: 'rounded-[2.5rem] p-10 border border-slate-100 bg-[#F8FAFC] shadow-2xl',
                title: 'text-xl font-black text-slate-800 tracking-tight uppercase italic',
                htmlContainer: 'text-sm font-medium text-slate-500',
                confirmButton: 'bg-slate-800 text-white px-10 py-3 rounded-full font-bold text-[10px] uppercase tracking-widest hover:bg-indigo-600 transition-all border-none',
            };

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                background: '#F1F5F9',
                customClass: {
                    popup: 'rounded-2xl shadow-xl border border-white p-4',
                    title: 'text-[10px] font-black text-slate-700 uppercase tracking-widest ml-2',
                }
            });

            if (status === 'verified') {
                Toast.fire({ icon: 'success', iconColor: '#10b981', title: 'Terverifikasi' });
            } else if (status === 'pending') {
                Toast.fire({ icon: 'info', iconColor: '#3b82f6', title: 'Pending' });
            } else if (status === 'rejected') {
                Swal.fire({
                    title: 'Ditolak',
                    text: "{{ $registration->rejection_message ?? 'Cek kembali bukti pembayaran.' }}",
                    icon: 'warning',
                    iconColor: '#f59e0b',
                    confirmButtonText: 'SAYA MENGERTI',
                    customClass: softAlert,
                    buttonsStyling: false
                });
            }
        });
    </script>
</x-app-layout>