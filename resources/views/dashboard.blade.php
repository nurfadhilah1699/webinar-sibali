<x-app-layout>
    <div class="p-6">
        @if(Auth::user()->role === 'admin')
            {{-- TAMPILAN KHUSUS ADMIN --}}
            <div class="bg-indigo-600 p-8 rounded-3xl text-white mb-6 shadow-xl shadow-indigo-100 flex justify-between items-center">
                <div>
                    <h3 class="text-2xl font-bold">Halo Admin! 👋</h3>
                    <p class="opacity-80">Kelola peserta, bank soal, dan materi dalam satu panel.</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="bg-white text-indigo-600 px-6 py-3 rounded-xl font-bold hover:bg-indigo-50 transition">
                    Buka Dashboard Admin
                </a>
            </div>
        @else
            {{-- TAMPILAN USER BIASA --}}
            
            {{-- 1. HEADER STATUS --}}
            <div class="mb-8 flex items-center justify-between bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                <div>
                    <h3 class="text-2xl font-bold text-gray-800">Halo, {{ Auth::user()->name }}!</h3>
                    <p class="text-gray-500 text-sm">Paket: 
                        <span class="font-bold text-indigo-600 uppercase">{{ Auth::user()->package }}</span>
                    </p>
                </div>
                @if(Auth::user()->is_verified)
                    <div class="flex flex-col items-end">
                        <span class="bg-green-100 text-green-700 px-4 py-1 rounded-full text-xs font-bold border border-green-200">
                            ✅ TERVERIFIKASI
                        </span>
                        @if(Auth::user()->toefl_score)
                            <span class="text-[10px] text-gray-400 mt-1 uppercase font-bold tracking-widest">Skor TOEFL: {{ Auth::user()->toefl_score }}</span>
                        @endif
                    </div>
                @else
                    <span class="bg-amber-100 text-amber-700 px-4 py-1 rounded-full text-xs font-bold border border-amber-200">
                        ⏳ MENUNGGU VERIFIKASI
                    </span>
                @endif
            </div>

            {{-- 2. KONDISI BELUM VERIFIKASI --}}
            @if(!Auth::user()->is_verified)
                {{-- (Bagian upload bukti transfer tetap sama seperti kodemu sebelumnya) --}}
                @if(Auth::user()->rejection_message)
                    <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-r-xl">
                        <p class="font-bold">❌ Pembayaran Ditolak</p>
                        <p class="text-sm">Alasan: {{ Auth::user()->rejection_message }}</p>
                    </div>
                @endif
                <div class="bg-white border rounded-3xl shadow-sm overflow-hidden">
                    <div class="p-6 bg-amber-50 border-b border-amber-100">
                        <h4 class="font-bold text-amber-800 tracking-tight">Selesaikan Pembayaran</h4>
                        <p class="text-sm text-amber-700">Silakan melakukan transfer sesuai nominal paket kamu:</p>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <div class="space-y-4">
                                <div class="flex justify-between items-end">
                                    <span class="text-gray-500 text-sm italic underline">Total Tagihan:</span>
                                    <span class="font-black text-2xl text-gray-900">
                                        @if(Auth::user()->package == 'reguler') Rp 20.000
                                        @elseif(Auth::user()->package == 'vip1') Rp 50.000
                                        @else Rp 100.000 @endif
                                    </span>
                                </div>
                                <div class="p-4 bg-gray-50 rounded-2xl border border-dashed border-gray-300">
                                    <p class="text-[10px] text-gray-400 uppercase font-bold mb-2">Rekening Pembayaran</p>
                                    <p class="text-sm font-bold text-gray-700 uppercase">Bank Mandiri</p>
                                    <p class="text-xl font-mono font-bold text-indigo-600">123-456-7890</p>
                                    <p class="text-xs text-gray-500 mt-1">A.N: Admin Beasiswa Camy</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col justify-center">
                            @if(!Auth::user()->payment_proof)
                                <form action="{{ route('payment.upload') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <label class="block text-sm font-bold text-gray-700 mb-3 text-center uppercase tracking-widest">Upload Bukti Transfer</label>
                                    <input type="file" name="payment_proof" class="block w-full text-sm text-gray-500 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:bg-gray-900 file:text-white hover:file:bg-black cursor-pointer" required>
                                    <button type="submit" class="mt-4 w-full bg-indigo-600 text-white py-3 rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">Kirim Bukti Pembayaran</button>
                                </form>
                            @else
                                <div class="text-center py-6 bg-green-50 rounded-2xl border border-green-100">
                                    <div class="text-4xl mb-2">📩</div>
                                    <p class="text-sm font-bold text-green-800 uppercase">Bukti sudah terkirim!</p>
                                    <p class="text-xs text-green-600 px-4">Admin akan memverifikasi dalam 1x24 jam. Kamu akan mendapat notifikasi jika sudah aktif.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            {{-- 3. KONDISI SUDAH VERIFIKASI --}}
            @else
                {{-- AREA DINAMIS MATERI & LINK --}}
                <div class="space-y-6">
                    
                    {{-- TOMBOL ZOOM (JIKA ADA) --}}
                    @foreach($myContents->where('type', 'link_zoom') as $zoom)
                    <div class="bg-indigo-600 p-6 rounded-3xl shadow-xl shadow-indigo-100 flex flex-col md:flex-row items-center justify-between text-white">
                        <div class="flex items-center gap-4 mb-4 md:mb-0">
                            <div class="bg-white/20 p-3 rounded-2xl text-2xl">📹</div>
                            <div>
                                <h4 class="font-bold text-lg leading-tight">{{ $zoom->title }}</h4>
                                <p class="text-indigo-100 text-xs mt-1 italic">Link Webinar Live sedang berlangsung.</p>
                            </div>
                        </div>
                        <a href="{{ $zoom->link }}" target="_blank" class="w-full md:w-auto bg-white text-indigo-600 px-8 py-3 rounded-2xl font-bold hover:bg-indigo-50 transition text-center">Masuk Zoom</a>
                    </div>
                    @endforeach

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        
                        {{-- LINK GRUP WA (DINAMIS) --}}
                        @foreach($myContents->where('type', 'link_wa') as $wa)
                        <div class="bg-white p-6 rounded-3xl border shadow-sm flex flex-col justify-between">
                            <div>
                                <div class="w-10 h-10 bg-green-100 text-green-600 rounded-xl flex items-center justify-center mb-4 text-xl">💬</div>
                                <h4 class="font-bold mb-1">{{ $wa->title }}</h4>
                                <p class="text-xs text-gray-500 mb-6 italic text-pretty">Grup diskusi peserta webinar</p>
                            </div>
                            <a href="{{ $wa->link }}" target="_blank" class="block text-center py-3 bg-green-600 text-white rounded-xl text-sm font-bold hover:bg-green-700 transition">Gabung Grup WA</a>
                        </div>
                        @endforeach

                        {{-- MATERI & REKAMAN (DINAMIS) --}}
                        @if(Auth::user()->package != 'reguler')
                        <div class="bg-white p-6 rounded-3xl border shadow-sm flex flex-col h-full">
                            <div class="w-10 h-10 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center mb-4 text-xl">📚</div>
                            <h4 class="font-bold mb-3 uppercase text-xs tracking-widest text-gray-400">Materi & Rekaman</h4>
                            <div class="space-y-2 flex-grow">
                                @forelse($myContents->whereIn('type', ['materi', 'rekaman']) as $m)
                                    <a href="{{ $m->link }}" target="_blank" class="flex items-center justify-between p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition border border-gray-100">
                                        <span class="text-xs font-medium text-gray-700">{{ $m->title }}</span>
                                        <span class="text-[9px] bg-purple-100 text-purple-600 px-2 py-0.5 rounded-full font-black uppercase">{{ $m->type }}</span>
                                    </a>
                                @empty
                                    <p class="text-gray-400 text-[11px] italic">Belum ada materi diupload admin.</p>
                                @endforelse
                            </div>
                        </div>
                        @endif

                        {{-- SIMULASI TOEFL (HANYA VIP 2) --}}
                        @if(Auth::user()->package == 'vip2')
                        <div class="bg-white p-6 rounded-3xl border shadow-sm flex flex-col justify-between">
                            <div>
                                <div class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center mb-4 text-xl">✍️</div>
                                <h4 class="font-bold mb-1 uppercase text-xs tracking-widest text-gray-400">Exam Center</h4>
                                <p class="text-sm font-bold text-gray-800">Simulasi TOEFL ITP</p>
                                <p class="text-[11px] text-gray-500 mt-1 italic">Kerjakan simulasi untuk mendapatkan skor sertifikat.</p>
                            </div>
                            <a href="{{ route('toefl.index') }}" class="mt-6 block text-center py-3 bg-indigo-600 text-white rounded-xl text-sm font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">
                                {{ Auth::user()->toefl_score ? 'Ulangi Tes (Terakhir: '.Auth::user()->toefl_score.')' : 'Mulai Sekarang' }}
                            </a>
                        </div>
                        @endif

                    </div>

                    {{-- 4. AREA SERTIFIKAT --}}
                    @php
                        $isCertReady = DB::table('settings')->where('key', 'is_certificate_ready')->value('value');
                    @endphp

                    @if($isCertReady == '1')
                        <div class="mt-4 p-6 bg-gradient-to-r from-indigo-600 to-indigo-800 rounded-3xl text-white flex flex-col md:flex-row items-center justify-between gap-4">
                            <div>
                                <h4 class="font-bold text-xl">🎉 E-Sertifikat Tersedia!</h4>
                                <p class="text-indigo-100 text-sm">Terima kasih telah mengikuti rangkaian webinar beasiswa.</p>
                            </div>
                            <a href="{{ route('certificate.download') }}" class="bg-white text-indigo-600 px-8 py-3 rounded-2xl font-bold shadow-xl hover:scale-105 transition">
                                Download Sertifikat (PDF)
                            </a>
                        </div>
                    @else
                        <div class="mt-4 p-6 bg-gray-50 rounded-3xl border border-gray-200 text-center">
                            <p class="text-xs text-gray-400 font-medium tracking-wide">
                                🔒 SERTIFIKAT AKAN TERBUKA OTOMATIS SETELAH SELURUH RANGKAIAN ACARA SELESAI
                            </p>
                        </div>
                    @endif
                </div>

            @endif {{-- Penutup is_verified --}}
        @endif {{-- Penutup Role Admin --}}
    </div>
</x-app-layout>