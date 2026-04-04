@extends('layouts.landing-page')

@section('content')
    @include('layouts.partials.event-header', [
        'type' => 'Lomba Cerdas Cermat',
        'title' => $event->title,
        'logo' => 'logo-lcc.png', // Ganti dengan nama file logo yang sesuai di folder public/img
        'description' => 'Cerdas Digital, Tangkas Berpikir: Menuju Generasi Inovatif dan Kreatif 2026',
        'slug' => $event->slug,
        'buttons' => '
            <a href="#daftar" class="px-8 py-4 bg-white text-slate-900 font-black rounded-2xl uppercase tracking-widest text-xs shadow-lg hover:bg-slate-100 transition">
                Daftar Tim
            </a>
            
            <a href="https://drive.google.com/uc?export=download&id=12uxjdKRwSdZUoWi2hu8UAfhQ10sKZQuP" class="px-8 py-4 border border-white/30 text-white font-black rounded-2xl uppercase tracking-widest text-xs inline-flex items-center gap-2 hover:bg-white/10 transition">
                <i data-lucide="download" class="w-4 h-4"></i> Unduh Juknis
            </a>
            '
        ])

    <div class="max-w-6xl mx-auto px-4 mt-20 mb-20">
        <div class="grid lg:grid-cols-3 gap-8">
            
            {{-- KIRI: Deskripsi & Timeline (Mirip Silabus) --}}
            <div class="lg:col-span-2 space-y-8">
                {{-- Benefit Cards (Sesuai TOR LCC) --}}
                <div class="grid md:grid-cols-2 gap-4">
                    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                        <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center mb-4">
                            <i data-lucide="trophy" class="w-5 h-5"></i>
                        </div>
                        <h4 class="font-bold text-slate-900">Total Hadiah</h4>
                        <p class="text-xs text-slate-500 mt-1">Perebutkan piala, sertifikat juara, dan dana pembinaan untuk pemenang 1, 2, dan 3.</p>
                    </div>
                    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                        <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center mb-4">
                            <i data-lucide="shield-check" class="w-5 h-5"></i>
                        </div>
                        <h4 class="font-bold text-slate-900">Sertifikat Peserta</h4>
                        <p class="text-xs text-slate-500 mt-1">Seluruh anggota tim mendapatkan E-Sertifikat resmi dari Sibali.id.</p>
                    </div>
                </div>

                {{-- Timeline (Menggantikan Silabus) --}}
                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
                    <h3 class="text-xl font-black text-slate-900 mb-6 italic underline decoration-blue-500">Timeline Kompetisi</h3>
                    <div class="space-y-4">
                        @php
                            $timelines = [
                                ['Pendaftaran Tim', '13 April - 14 Mei 2026', 'Pendaftaran nama tim dan daftar anggota melalui website'],
                                ['Pelaksanaan Lomba', '17 Mei 2026', 'Ujian online serentak di website'],
                                ['Pengumuman Pemenang', '17 Mei 2026', 'Pengumuman hasil lomba secara daring di website, media sosial, atau grup WhatsApp'],
                                ['Distribusi E-Sertifikat', '17 Mei 2026', 'E-Sertifikat dapat diunduh melalui website setelah pengumuman pemenang'],
                            ];
                        @endphp
                        @foreach($timelines as $index => $time)
                        <div class="flex items-start gap-4 p-5 rounded-2xl bg-slate-50 border border-slate-100 group hover:border-blue-300 transition-colors">
                            <span class="flex-shrink-0 w-10 h-10 bg-white rounded-xl flex items-center justify-center text-sm font-black shadow-sm group-hover:bg-blue-600 group-hover:text-white transition-all">
                                {{ $index + 1 }}
                            </span>
                            <div>
                                <h5 class="font-bold text-slate-800 text-sm">{{ $time[0] }}</h5>
                                <p class="text-[10px] font-black text-blue-600 bg-blue-50 px-2 py-1 rounded-md uppercase inline-block mt-1">{{ $time[1] }}</p>
                                <p class="text-xs text-slate-500 mt-2">{{ $time[2] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- KANAN: Form Pendaftaran (Sticky) --}}
            <div class="lg:col-span-1" id="daftar">
                <div class="sticky top-24 bg-white p-8 rounded-[2.5rem] border-2 border-slate-900 shadow-[8px_8px_0px_0px_rgba(15,23,42,1)]">
                    <div class="mb-6">
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 text-[10px] font-black rounded-lg uppercase tracking-widest">HTM Per Tim</span>
                        <h3 class="text-3xl font-black text-slate-900 mt-2">Rp85.000</h3>
                    </div>

                    <form action="{{ route('register.post') }}" method="POST">
                        @csrf
                        <input type="hidden" name="event_id" value="{{ $event->id }}">
                        <input type="hidden" name="package_type" value="lcc_team">
                        <input type="hidden" name="amount" value="85000">

                        <div class="space-y-4 mb-8">
                            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                                <p class="text-[10px] font-black text-slate-400 uppercase mb-3 tracking-widest">Informasi Pendaftaran:</p>
                                <ul class="space-y-3">
                                    <li class="flex items-start gap-2 text-[11px] font-bold text-slate-600">
                                        <i data-lucide="users" class="w-3 h-3 text-blue-500 mt-0.5"></i>
                                        <span>Maksimal 3 Anggota per Tim</span>
                                    </li>
                                    <li class="flex items-start gap-2 text-[11px] font-bold text-slate-600">
                                        <i data-lucide="graduation-cap" class="w-3 h-3 text-blue-500 mt-0.5"></i>
                                        <span>Khusus Siswa Tingkat SMP/Sederajat</span>
                                    </li>
                                    <li class="flex items-start gap-2 text-[11px] font-bold text-slate-600">
                                        <i data-lucide="monitor" class="w-3 h-3 text-blue-500 mt-0.5"></i>
                                        <span>Sistem Ujian Online & Pengawasan Zoom</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        @auth
                            {{-- Cek apakah user sudah daftar --}}
                            @php
                                $registration = auth()->user()->registrations()->where('event_id', $event->id)->first();
                            @endphp

                            @if($registration)
                                @if($registration->status == 'verified')
                                    <a href="{{ route('my-event.detail', $registration->id) }}" class="block w-full py-4 bg-emerald-500 text-white text-center font-black rounded-2xl shadow-lg hover:bg-emerald-600 transition">
                                        MASUK HALAMAN EVENT
                                    </a>
                                @else
                                    <div class="p-4 bg-amber-50 border border-amber-200 rounded-2xl text-amber-700 text-center">
                                        <p class="text-xs font-black uppercase">Pembayaran Sedang Diverifikasi</p>
                                        <p class="text-[10px] font-medium mt-1">Mohon tunggu admin memvalidasi bukti transfer Anda.</p>
                                    </div>
                                @endif
                            @else
                                <a href="{{ route('event.registration.form', $event->slug) }}" class="block w-full py-4 bg-blue-600 hover:bg-blue-700 text-white text-center font-black rounded-2xl transition-all shadow-lg shadow-blue-100 hover:scale-[1.02] active:scale-95 uppercase text-sm tracking-widest">
                                    Daftar Tim Sekarang
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="block w-full py-4 bg-slate-900 text-white text-center font-black rounded-2xl shadow-lg hover:bg-slate-800 transition uppercase text-sm tracking-widest">
                                Login untuk Daftar
                            </a>
                        @endauth
                    </form>

                    <p class="text-[9px] text-slate-400 text-center mt-6 font-medium leading-relaxed uppercase">
                        Pastikan Anda telah membaca Juknis sebelum melakukan pendaftaran.
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- @include('layouts.partials.sponsor') --}}
@endsection