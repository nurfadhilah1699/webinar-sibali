<x-app-layout>
    <div class="min-h-screen bg-[#F0F2F5] py-12">
        <div class="max-w-4xl mx-auto px-6">
            
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-slate-500 font-bold mb-6 hover:text-indigo-600 transition group">
                <i data-lucide="arrow-left" class="w-4 h-4 group-hover:-translate-x-1 transition"></i> KEMBALI KE DASHBOARD
            </a>

            <div class="bg-white rounded-[2.5rem] shadow-xl border-2 border-white overflow-hidden">
                <div class="p-8 md:p-12">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                        <div>
                            <h1 class="text-3xl font-black text-slate-800 uppercase italic leading-tight">
                                @if($registration->event->parent) 
                                    {{-- Jika ada parent (berarti ini Episode), tampilkan Nama Parent di atasnya --}}
                                    <span class="block text-[10px] not-italic font-medium text-indigo-500 tracking-widest mb-1 opacity-80">
                                        {{ $registration->event->parent->title }}
                                    </span>
                                    {{ $registration->event->title }}
                                @else
                                    {{-- Jika event mandiri (seperti LCC), langsung tampilkan judulnya --}}
                                    {{ $registration->event->title }}
                                @endif
                            </h1>
                            <span class="inline-block mt-2 px-4 py-1 bg-indigo-600 text-white rounded-lg text-[10px] font-black italic uppercase">PAKET {{ $registration->package_type }}</span>
                        </div>
                    </div>

                    {{-- CASE 1: SUDAH DISETUJUI --}}
                    @if($registration->status === 'verified')
                        <div class="space-y-6">
                            <div class="p-6 bg-emerald-50 rounded-3xl border-2 border-emerald-100 flex items-center gap-4">
                                <div class="bg-emerald-500 p-3 rounded-2xl text-white shadow-lg shadow-emerald-200">
                                    <i data-lucide="check-circle" class="w-6 h-6"></i>
                                </div>
                                <div>
                                    <h2 class="font-black text-emerald-800 uppercase italic text-sm">Akses Terbuka</h2>
                                    <p class="text-xs text-emerald-600">Pembayaran tervalidasi. Silakan akses konten di bawah.</p>
                                </div>
                            </div>

                            <div class="grid gap-4">
                                @foreach($contents as $content)
                                    <div class="p-6 bg-slate-50 rounded-[2rem] border-2 border-slate-100 flex justify-between items-center group hover:border-indigo-300 transition-all">
                                        <div>
                                            <h3 class="font-black text-slate-800 uppercase italic text-sm">{{ $content->title }}</h3>
                                            <p class="text-[11px] text-slate-500 mt-1">{{ $content->description }}</p>
                                        </div>
                                        <a href="{{ $content->link }}" target="_blank" class="px-6 py-2 bg-slate-900 text-white text-[10px] font-black rounded-xl uppercase hover:bg-indigo-600 transition shadow-md">Buka Materi</a>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    {{-- CASE 2: BELUM KIRIM BUKTI ATAU DITOLAK (Tampilkan Form Langsung) --}}
                    @elseif(is_null($registration->payment_proof) || $registration->status === 'rejected')
                        <div class="max-w-md mx-auto py-4">
                            <div class="text-center mb-8">
                                <div class="bg-blue-50 w-20 h-20 rounded-[2rem] flex items-center justify-center mx-auto mb-4 text-blue-600">
                                    <i data-lucide="upload-cloud" class="w-10 h-10"></i>
                                </div>
                                <h2 class="text-xl font-black text-slate-800 uppercase italic">Konfirmasi Pembayaran</h2>
                                <p class="text-xs text-slate-500 mt-2 font-bold uppercase tracking-tight">Unggah bukti transfer untuk mendapatkan akses</p>
                            </div>

                            @if($registration->status === 'rejected')
                                <div class="mb-6 p-4 bg-rose-50 border-2 border-rose-100 rounded-2xl text-rose-600 text-xs font-bold italic">
                                    <span class="block uppercase font-black mb-1">DITOLAK:</span>
                                    {{ $registration->rejection_message ?? 'Bukti tidak valid atau tidak terbaca.' }}
                                </div>
                            @endif

                            <form action="{{ route('payment.confirm', $registration->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                <div class="relative group">
                                    <input type="file" name="payment_proof" accept="image/*" required 
                                        class="w-full p-4 bg-slate-50 border-2 border-dashed border-slate-200 rounded-3xl text-xs font-bold text-slate-400 file:hidden cursor-pointer hover:border-indigo-400 transition"
                                        onchange="document.getElementById('file-name').textContent = this.files[0].name">
                                    <p id="file-name" class="text-[10px] text-slate-400 mt-2 text-center uppercase font-black italic tracking-widest">Klik untuk pilih gambar</p>
                                </div>
                                <button type="submit" class="w-full py-4 bg-indigo-600 text-white font-black rounded-[1.5rem] shadow-xl shadow-indigo-100 hover:bg-indigo-700 hover:-translate-y-1 transition-all uppercase tracking-widest text-xs">
                                    KIRIM BUKTI SEKARANG
                                </button>
                            </form>
                        </div>

                    {{-- CASE 3: SUDAH KIRIM, TINGGAL TUNGGU --}}
                    @elseif($registration->status === 'pending')
                        <div class="text-center py-10 px-6 bg-slate-50 rounded-[3rem] border-2 border-slate-100">
                            <div class="bg-amber-400 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6 text-white animate-bounce shadow-lg shadow-amber-100">
                                <i data-lucide="clock" class="w-8 h-8"></i>
                            </div>
                            <h2 class="text-2xl font-black text-slate-800 uppercase italic">Sedang Diverifikasi</h2>
                            <p class="text-xs text-slate-500 mt-3 font-bold uppercase leading-relaxed max-w-xs mx-auto">Admin sedang mengecek pembayaranmu. Mohon tunggu maksimal 1x24 jam.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>