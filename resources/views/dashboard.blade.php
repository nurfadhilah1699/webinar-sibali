<x-app-layout>
    <div class="p-6">
        @if(Auth::user()->role === 'admin')
            {{-- TAMPILAN KHUSUS ADMIN --}}
            <div class="bg-indigo-600 p-6 rounded-2xl text-white mb-6">
                <h3 class="text-xl font-bold">Halo Admin! 👋</h3>
                <p>Anda memiliki kendali penuh atas verifikasi pembayaran peserta.</p>
                <a href="{{ route('admin.dashboard') }}" class="mt-4 inline-block bg-white text-indigo-600 px-6 py-2 rounded-lg font-bold">
                    Buka Panel Verifikasi
                </a>
            </div>
        @else
            {{-- TAMPILAN USER BIASA --}}
            
            {{-- 1. HEADER STATUS --}}
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-bold">Halo, {{ Auth::user()->name }}!</h3>
                    <p class="text-gray-500 text-sm">Paket terpilih: 
                        <span class="font-bold text-indigo-600 uppercase">{{ Auth::user()->package }}</span>
                    </p>
                </div>
                @if(Auth::user()->is_verified)
                    <span class="bg-green-100 text-green-700 px-4 py-1 rounded-full text-xs font-bold border border-green-200">
                        ✅ TERVERIFIKASI
                    </span>
                @else
                    <span class="bg-amber-100 text-amber-700 px-4 py-1 rounded-full text-xs font-bold border border-amber-200">
                        ⏳ MENUNGGU VERIFIKASI
                    </span>
                @endif
            </div>

            {{-- 2. KONDISI BELUM VERIFIKASI --}}
            @if(!Auth::user()->is_verified)
                @if(Auth::user()->rejection_message)
                    <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700">
                        <p class="font-bold">❌ Pembayaran Ditolak</p>
                        <p class="text-sm">Alasan: {{ Auth::user()->rejection_message }}</p>
                        <p class="text-xs mt-1 italic">Silakan upload ulang bukti transfer yang valid.</p>
                    </div>
                @endif
                <div class="bg-white border rounded-2xl shadow-sm overflow-hidden">
                    <div class="p-6 bg-amber-50 border-b border-amber-100">
                        <h4 class="font-bold text-amber-800">Selesaikan Pembayaran</h4>
                        <p class="text-sm text-amber-700">Silakan melakukan transfer sesuai nominal paket kamu:</p>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="space-y-3">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Total Tagihan:</span>
                                    <span class="font-bold text-lg">
                                        @if(Auth::user()->package == 'reguler') Rp 20.000
                                        @elseif(Auth::user()->package == 'vip1') Rp 50.000
                                        @else Rp 100.000 @endif
                                    </span>
                                </div>
                                <div class="p-4 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                                    <p class="text-xs text-gray-500 uppercase font-bold mb-2">Rekening Pembayaran</p>
                                    <p class="text-sm"><strong>Bank Mandiri:</strong> 123-456-7890</p>
                                    <p class="text-sm"><strong>A.N:</strong> Admin Beasiswa Camy</p>
                                </div>
                            </div>
                        </div>
                        <div>
                            @if(!Auth::user()->payment_proof)
                                <form action="{{ route('payment.upload') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Upload Bukti Transfer</label>
                                    <input type="file" name="payment_proof" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 cursor-pointer" required>
                                    <button type="submit" class="mt-4 w-full bg-gray-900 text-white py-2 rounded-lg font-bold hover:bg-black transition">Kirim Bukti Pembayaran</button>
                                </form>
                            @else
                                <div class="text-center py-6">
                                    <div class="text-4xl mb-2">📩</div>
                                    <p class="text-sm font-medium text-gray-800">Bukti sudah terkirim!</p>
                                    <p class="text-xs text-gray-500">Admin akan memverifikasi dalam 1x24 jam.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            {{-- 3. KONDISI SUDAH VERIFIKASI --}}
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {{-- Konten Webinar (Zoom, Materi, TOEFL) --}}
                    <div class="bg-white p-6 rounded-2xl border shadow-sm">
                        <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center mb-4">📹</div>
                        <h4 class="font-bold mb-1">Link Webinar</h4>
                        <a href="#" class="block text-center py-2 bg-blue-600 text-white rounded-lg text-sm font-bold shadow-md">Gabung Sekarang</a>
                    </div>

                    @if(Auth::user()->package == 'vip1' || Auth::user()->package == 'vip2')
                    <div class="bg-white p-6 rounded-2xl border shadow-sm">
                        <div class="w-10 h-10 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center mb-4">📚</div>
                        <h4 class="font-bold mb-1">Materi & Rekaman</h4>
                        <a href="#" class="block text-center py-2 bg-purple-600 text-white rounded-lg text-sm font-bold shadow-md">Akses Materi</a>
                    </div>
                    @endif

                    @if(Auth::user()->package == 'vip2')
                    <div class="bg-white p-6 rounded-2xl border shadow-sm">
                        <div class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center mb-4">📝</div>
                        <h4 class="font-bold mb-1">Simulasi TOEFL</h4>
                        <a href="{{ route('toefl.index') }}" class="block text-center py-2 bg-indigo-600 text-white rounded-lg text-sm font-bold shadow-md">
                            {{ Auth::user()->toefl_score ? 'Ulangi Tes (Skor: '.Auth::user()->toefl_score.')' : 'Mulai Tes' }}
                        </a>
                    </div>
                    @endif
                </div>

                @if(Auth::user()->package == 'reguler' || Auth::user()->package == 'vip1' || Auth::user()->package == 'vip2')
                    @php
                        $isCertReady = DB::table('settings')->where('key', 'is_certificate_ready')->value('value');
                    @endphp

                    @if($isCertReady == '1')
                        <div class="mt-8 p-6 bg-indigo-50 rounded-2xl border border-indigo-100 flex items-center justify-between">
                            <div>
                                <h4 class="font-bold text-indigo-900">E-Sertifikat Tersedia!</h4>
                                <p class="text-sm text-indigo-700 font-medium">Silakan unduh sertifikat resmi Anda.</p>
                            </div>
                            <a href="{{ route('certificate.download') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-xl font-bold shadow-lg">
                                Download PDF
                            </a>
                        </div>
                    @else
                        <div class="mt-8 p-6 bg-gray-50 rounded-2xl border border-gray-200">
                            <p class="text-sm text-gray-500 italic text-center font-medium">
                                🔒 Sertifikat dapat diunduh otomatis setelah rangkaian acara selesai.
                            </p>
                        </div>
                    @endif
                @endif
            @endif {{-- Penutup is_verified --}}
        @endif {{-- Penutup PENTING: Role Admin --}}
    </div>
</x-app-layout>