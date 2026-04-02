<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/lucide@latest"></script>
<script src="https://unpkg.com/lucide@0.473.0/dist/umd/lucide.js"></script>

<x-app-layout>
    <div class="min-h-screen bg-[#F0F2F5] pb-12">
        
        {{-- HEADER --}}
        <div class="max-w-7xl mx-auto px-6 pt-10 mb-8">
            <h1 class="text-2xl font-bold text-gray-800">My Dashboard</h1>
            <p class="text-sm text-gray-500 mt-1">Selamat datang kembali, {{ Auth::user()->name }}.</p>
        </div>

        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-12 gap-6">

                {{-- 1. AKSES ADMIN (Tampil Paling Atas Jika Role Admin) --}}
                @if(Auth::user()->role === 'admin')
                    <div class="col-span-12 mb-4">
                        <div class="bg-slate-900 rounded-[2rem] p-8 text-white flex justify-between items-center shadow-2xl border-b-4 border-indigo-500">
                            <div>
                                <h2 class="text-2xl font-black italic uppercase">Mode Administrator</h2>
                                <p class="text-slate-400 text-sm mt-1">Kelola pendaftaran dan verifikasi user melalui panel kontrol.</p>
                            </div>
                            <a href="{{ url('/admin') }}" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold transition uppercase tracking-widest text-xs">
                                Buka Admin Panel
                            </a>
                        </div>
                    </div>
                @endif

                {{-- KONTEN UTAMA --}}
                @if (Auth::user()->role !== 'admin')
                    <div class="col-span-12 space-y-8">
                        
                        {{-- SECTION: EVENT SAYA --}}
                        <div>
                            <h2 class="text-xl font-black text-slate-800 mb-4 flex items-center gap-2 uppercase italic">
                                <i data-lucide="layers" class="w-5 h-5 text-indigo-600"></i>
                                Event Yang Saya Ikuti
                            </h2>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                
                                {{-- A. LOOPING EVENT BARU --}}
                                @foreach($myRegistrations as $reg)
                                    <div class="bg-white rounded-[2rem] border-2 border-slate-100 overflow-hidden shadow-sm hover:shadow-md transition">
                                        <div class="p-6">
                                            <div class="flex justify-between items-start mb-4">
                                                <span class="px-3 py-1 {{ in_array($reg->status, ['verified', 'approved']) ? 'bg-emerald-100 text-emerald-600' : 'bg-amber-100 text-amber-600' }} rounded-full text-[10px] font-bold uppercase">
                                                    {{ $reg->status }}
                                                </span>
                                            </div>

                                            {{-- POIN 2: LOGIKA JUDUL EPISODE DI SINI --}}
                                            <h3 class="text-lg font-black text-slate-800 leading-tight mb-2 uppercase italic">
                                                @if($reg->event->parent) 
                                                    {{-- Jika ada parent (berarti ini Episode), tampilkan Nama Parent di atasnya --}}
                                                    <span class="block text-[10px] not-italic font-medium text-indigo-500 tracking-widest mb-1 opacity-80">
                                                        {{ $reg->event->parent->title }}
                                                    </span>
                                                    {{ $reg->event->title }}
                                                @else
                                                    {{-- Jika event mandiri (seperti LCC), langsung tampilkan judulnya --}}
                                                    {{ $reg->event->title }}
                                                @endif
                                            </h3>

                                            <p class="text-xs text-slate-500 mb-6">Paket: <span class="font-bold text-indigo-600">{{ strtoupper($reg->package_type) }}</span></p>

                                            <a href="{{ route('my-event.detail', $reg->id) }}" class="flex items-center justify-center gap-2 w-full py-3 bg-slate-900 text-white rounded-xl font-bold hover:bg-indigo-600 transition uppercase text-xs tracking-wider">
                                                {{ in_array($reg->status, ['verified', 'approved']) ? 'Masuk Event' : 'Cek Status' }}
                                                <i data-lucide="arrow-right" class="w-4 h-4"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach

                                {{-- B. CARD EVENT LAMA (LEGACY) --}}
                                @if($hasLegacyData)
                                    <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-[2rem] p-6 shadow-xl relative overflow-hidden text-white">
                                        <div class="relative z-10">
                                            <span class="px-3 py-1 bg-white/20 rounded-full text-[10px] font-bold uppercase tracking-widest">Selesai</span>
                                            <h3 class="text-lg font-black mt-4 mb-1 uppercase italic text-white">Webinar Beasiswa Unlocked: Dari Mimpi Ke Kampus Impian</h3>
                                            <p class="text-xs text-blue-100 mb-6 font-medium">Status: Terverifikasi</p>
                                            
                                            <a href="{{ route('legacy-event.detail') }}" class="flex items-center justify-center gap-2 w-full py-3 bg-white text-blue-700 rounded-xl font-bold hover:bg-blue-50 transition uppercase text-xs tracking-wider">
                                                Lihat Materi & Sertifikat
                                                <i data-lucide="archive" class="w-4 h-4"></i>
                                            </a>
                                        </div>
                                        <i data-lucide="award" class="absolute -right-4 -bottom-4 w-32 h-32 text-white/10 -rotate-12"></i>
                                    </div>
                                @endif

                            </div>

                            {{-- JIKA TIDAK ADA EVENT SAMA SEKALI --}}
                            @if($myRegistrations->isEmpty() && !$hasLegacyData)
                                <div class="bg-white rounded-[2rem] p-12 text-center border-2 border-dashed border-slate-200">
                                    <i data-lucide="calendar-x" class="w-12 h-12 text-slate-300 mx-auto mb-4"></i>
                                    <p class="text-slate-400 font-medium italic text-sm">Belum ada pendaftaran yang ditemukan.</p>
                                </div>
                            @endif
                        </div>

                        {{-- SECTION: REKOMENDASI --}}
                        @if($availableEvents->count() > 0)
                            <div class="pt-8 border-t border-slate-200">
                                <h2 class="text-xl font-black text-slate-800 mb-4 uppercase italic">Rekomendasi Event</h2>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    @foreach($availableEvents as $event)
                                        <div class="bg-white rounded-[2rem] p-6 border-2 border-slate-100 shadow-sm relative overflow-hidden group">
                                            <h3 class="font-black text-slate-800 mb-4 uppercase italic">{{ $event->title }}</h3>
                                            <a href="{{ route('events.show', $event->slug) }}" class="inline-block px-6 py-2 bg-indigo-50 text-indigo-600 text-xs font-bold rounded-lg group-hover:bg-indigo-600 group-hover:text-white transition uppercase">Daftar Sekarang</a>
                                            <i data-lucide="sparkles" class="absolute -right-2 -bottom-2 w-16 h-16 text-slate-50"></i>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Semua kode yang berhubungan dengan ikon harus di dalam sini
            lucide.createIcons();
            
            console.log("Lucide icons initialized successfully!");
        });

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
            // @if(session('info'))
            //     Swal.fire({
            //         icon: 'info',
            //         title: 'Informasi',
            //         text: "{{ session('info') }}",
            //         confirmButtonColor: '#1e3a8a',
            //     });
            // @endif

            // 3. Alert Skor (Jika ada session score)
            // @if(session('score'))
            //     Swal.fire({
            //         title: 'Hasil Tes Kamu',
            //         html: '<p class="text-sm">Skor Akhir:</p><h2 class="text-4xl font-black text-blue-900">{{ session("score") }}</h2>',
            //         icon: 'success',
            //         confirmButtonColor: '#1e3a8a',
            //     });
            // @endif

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