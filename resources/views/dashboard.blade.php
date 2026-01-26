<x-app-layout>
    <div class="p-6">
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

        {{-- 2. KONDISI BELUM VERIFIKASI (Form Upload) --}}
        @if(!Auth::user()->is_verified)
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

        {{-- 3. KONDISI SUDAH VERIFIKASI (Akses Fitur) --}}
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                {{-- AKSES UNTUK SEMUA (Reguler, VIP1, VIP2) --}}
                <div class="bg-white p-6 rounded-2xl border shadow-sm">
                    <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center mb-4">📹</div>
                    <h4 class="font-bold mb-1">Link Webinar</h4>
                    <p class="text-xs text-gray-500 mb-4">Live via Zoom (Sabtu, 15 Feb 2026)</p>
                    <a href="#" class="block text-center py-2 bg-blue-600 text-white rounded-lg text-sm font-bold shadow-md">Gabung Sekarang</a>
                </div>

                {{-- AKSES MATERI (Hanya VIP 1 & VIP 2) --}}
                @if(Auth::user()->package == 'vip1' || Auth::user()->package == 'vip2')
                <div class="bg-white p-6 rounded-2xl border shadow-sm">
                    <div class="w-10 h-10 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center mb-4">📚</div>
                    <h4 class="font-bold mb-1">Materi & Rekaman</h4>
                    <p class="text-xs text-gray-500 mb-4">Download PDF dan Video Recording</p>
                    <a href="#" class="block text-center py-2 bg-purple-600 text-white rounded-lg text-sm font-bold shadow-md">Akses Materi</a>
                </div>
                @endif

                {{-- AKSES TOEFL (Hanya VIP 2) --}}
                @if(Auth::user()->package == 'vip2')
                <div class="bg-white p-6 rounded-2xl border shadow-sm ring-2 ring-indigo-600 ring-offset-2">
                    <div class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center mb-4">📝</div>
                    <h4 class="font-bold mb-1">Simulasi TOEFL</h4>
                    <p class="text-xs text-gray-500 mb-4">Uji kemampuan dengan timer otomatis</p>
                    <a href="#" class="block text-center py-2 bg-indigo-600 text-white rounded-lg text-sm font-bold shadow-md">Mulai Tes</a>
                </div>
                @endif

            </div>

            {{-- INFO KHUSUS REGULER (Sertifikat Saja) --}}
            @if(Auth::user()->package == 'reguler')
                <div class="mt-6 p-4 bg-blue-50 border border-blue-100 rounded-xl">
                    <p class="text-sm text-blue-700">💡 <strong>Info:</strong> Sebagai peserta <strong>Reguler</strong>, kamu akan mendapatkan E-Sertifikat setelah acara selesai. Ingin akses rekaman? Hubungi Admin untuk upgrade.</p>
                </div>
            @endif
        @endif
    </div>
</x-app-layout>
