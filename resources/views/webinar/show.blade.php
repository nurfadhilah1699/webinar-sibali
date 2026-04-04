@extends('layouts.landing-page')

@section('content')
    @include('layouts.partials.event-header', [
        'type' => $event->type ?? 'Webinar',
        'title' => $event->title,
        'logo' => 'logo-webinar-karier.png', // Ganti dengan nama file logo yang sesuai di folder public/img
        'description' => 'Bangun citra profesional yang kuat untuk memenangkan persaingan kerja di tahun 2026.',
        'slug' => $event->slug
    ])

    <div class="max-w-6xl mx-auto px-4 mt-20 mb-20">
        <div class="grid lg:grid-cols-3 gap-8">
            
            {{-- KIRI: Deskripsi Kurikulum & Benefit --}}
            <div class="lg:col-span-2 space-y-8">
                {{-- Benefit Cards Utama --}}
                <div class="grid md:grid-cols-2 gap-4">
                    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                        <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center mb-4">
                            <i data-lucide="award" class="w-5 h-5"></i>
                        </div>
                        <h4 class="font-bold text-slate-900">E-Sertifikat Eksklusif</h4>
                        <p class="text-xs text-slate-500 mt-1">Dapatkan sertifikat per episode atau Full Series untuk portofolio Anda.</p>
                    </div>
                    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                        <div class="w-10 h-10 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center mb-4">
                            <i data-lucide="message-circle" class="w-5 h-5"></i>
                        </div>
                        <h4 class="font-bold text-slate-900">Direct Feedback</h4>
                        <p class="text-xs text-slate-500 mt-1">Khusus paket Premium: Umpan balik langsung dalam sesi coaching 90 menit.</p>
                    </div>
                </div>

                {{-- List Episode --}}
                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
                    <h3 class="text-xl font-black text-slate-900 mb-6 italic underline decoration-blue-500">Silabus Webinar Series</h3>
                    <div class="space-y-4">
                        @foreach($event->children as $episode)
                        <div class="flex items-start gap-4 p-5 rounded-2xl bg-slate-50 border border-slate-100 group hover:border-blue-300 transition-colors">
                            <span class="flex-shrink-0 w-10 h-10 bg-white rounded-xl flex items-center justify-center text-sm font-black shadow-sm group-hover:bg-blue-600 group-hover:text-white transition-all">
                                {{ $loop->iteration }}
                            </span>
                            <div>
                                <h5 class="font-bold text-slate-800 text-sm">{{ $episode->title }}</h5>
                                <span class="text-[10px] font-black text-blue-600 bg-blue-50 px-2 py-1 rounded-md uppercase">{{ $episode->start_time->format('l, d F Y / H:i') }} WITA</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- KANAN: Form Pendaftaran & Harga (Sticky) --}}
            <div class="lg:col-span-1">
                <div class="sticky top-24 bg-white p-8 rounded-[2.5rem] border-2 border-slate-900 shadow-[8px_8px_0px_0px_rgba(15,23,42,1)]">
                    <h3 class="text-xl font-black text-slate-900 mb-6 uppercase tracking-tighter">Pilih Paket Webinar</h3>
                    
                    @php
                        $user = auth()->user();
                        $userRegistrations = $user ? $user->registrations->pluck('event_id')->toArray() : [];
                        // Cek pendaftaran untuk paket Full/Premium (ID Parent)
                        $isRegisteredFull = in_array($event->id, $userRegistrations);
                    @endphp

                    <form action="{{ route('register.post') }}" method="POST"
                        x-data="{ 
                            mode: 'full', 
                            prices: { basic: 35000, full: 100000, premium: 150000 },
                            selectedEpisodes: [],
                            get total() {
                                if(this.mode === 'basic') return this.selectedEpisodes.length * this.prices.basic;
                                return this.prices[this.mode];
                            }
                        }">
                        @csrf
                        <input type="hidden" name="event_id" value="{{ $event->id }}">
                        <input type="hidden" name="package_type" :value="mode">
                        <input type="hidden" name="amount" :value="total">
                        <input type="hidden" name="episodes" :value="JSON.stringify(selectedEpisodes)">

                        {{-- Category Selector --}}
                        <div class="space-y-3 mb-8">
                            <label class="relative block p-4 border-2 rounded-2xl cursor-pointer transition-all"
                                :class="mode === 'basic' ? 'border-blue-600 bg-blue-50' : 'border-slate-100 hover:border-slate-300'">
                                <input type="radio" name="cat" value="basic" x-model="mode" class="absolute top-4 right-4 text-blue-600">
                                <span class="block text-xs font-black text-slate-900 uppercase">Kategori Basic</span>
                                <span class="block text-lg font-black text-blue-700">Rp35.000<span class="text-[10px] text-slate-400 font-normal">/eps</span></span>
                            </label>

                            <label class="relative block p-4 border-2 rounded-2xl cursor-pointer transition-all"
                                :class="mode === 'full' ? 'border-blue-600 bg-blue-50' : 'border-slate-100 hover:border-slate-300'">
                                <div class="absolute -top-2 -left-2 bg-emerald-500 text-white text-[9px] font-black px-2 py-1 rounded-md rotate-[-5deg] shadow-sm uppercase">Best Value</div>
                                <input type="radio" name="cat" value="full" x-model="mode" class="absolute top-4 right-4 text-blue-600">
                                <span class="block text-xs font-black text-slate-900 uppercase">Full Series</span>
                                <span class="block text-lg font-black text-blue-700">Rp100.000</span>
                            </label>

                            <label class="relative block p-4 border-2 rounded-2xl cursor-pointer transition-all"
                                :class="mode === 'premium' ? 'border-blue-600 bg-blue-50' : 'border-slate-100 hover:border-slate-300'">
                                <input type="radio" name="cat" value="premium" x-model="mode" class="absolute top-4 right-4 text-blue-600">
                                <span class="block text-xs font-black text-slate-900 uppercase">Paket Premium</span>
                                <span class="block text-lg font-black text-blue-700">Rp150.000</span>
                            </label>
                        </div>

                        {{-- Benefit List Dinamis Sesuai TOR --}}
                        <div class="mb-8 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                            <p class="text-[10px] font-black text-slate-400 uppercase mb-3 tracking-widest">Fasilitas yang didapat:</p>
                            <ul class="space-y-2">
                                {{-- Basic Benefit --}}
                                <li class="flex items-center gap-2 text-[11px] font-bold text-slate-600">
                                    <i data-lucide="check" class="w-3 h-3 text-blue-500"></i>
                                    <span x-text="mode === 'basic' ? 'Akses 1 Episode' : 'Akses Seluruh 5 Episode'"></span>
                                </li>
                                <li class="flex items-center gap-2 text-[11px] font-bold text-slate-600">
                                    <i data-lucide="check" class="w-3 h-3 text-blue-500"></i> 
                                    <span x-text="mode === 'basic' ? 'E-Sertifikat per Episode' : (mode === 'premium' ? 'E-Sertifikat Premium' : 'E-Sertifikat Full Series')"></span>
                                </li>
                                <li class="flex items-center gap-2 text-[11px] font-bold text-slate-600">
                                    <i data-lucide="check" class="w-3 h-3 text-blue-500"></i> 
                                    <span x-text="mode === 'basic' ? 'Ringkasan Materi dan Poin Tindak Lanjut dari Narasumber' : 'Lembar refleksi dan Perencanaan Karir'"></span>
                                </li>
                                
                                {{-- Full & Premium Only --}}
                                <template x-if="mode !== 'basic'">
                                    <li class="flex items-center gap-2 text-[11px] font-bold text-slate-600 animate-fadeIn">
                                        <i data-lucide="check" class="w-3 h-3 text-blue-500"></i> Akses Rekaman Webinar
                                    </li>
                                </template>

                                {{-- Premium Only --}}
                                <template x-if="mode === 'premium'">
                                    <li class="flex items-center gap-2 text-[11px] font-bold text-blue-700 animate-fadeIn">
                                        <i data-lucide="star" class="w-3 h-3 fill-blue-500 text-blue-500"></i> 2x Sesi Coaching (90 Menit)
                                    </li>
                                </template>
                            </ul>
                        </div>

                        {{-- Episode Selector (Hanya muncul jika mode BASIC) --}}
                        <div x-show="mode === 'basic'" class="mb-8 animate-fadeIn text-left">
                            <p class="text-[10px] font-black text-slate-400 uppercase mb-3 tracking-widest">Pilih Satu Episode:</p>
                            <div class="grid grid-cols-1 gap-2">
                                @foreach($event->children as $episode)
                                    @php $isRegisteredThisEps = in_array($episode->id, $userRegistrations); @endphp
                                    
                                    <label class="flex items-center justify-between p-3 border rounded-xl transition-all
                                        {{ $isRegisteredThisEps ? 'bg-gray-50 opacity-60 cursor-not-allowed' : 'cursor-pointer hover:bg-white' }}"
                                        :class="selectedEpisodes.includes('{{ $episode->title }}') ? 'border-blue-600 bg-blue-50/50' : 'border-slate-100'">
                                        
                                        <div class="flex flex-col">
                                            <span class="text-[11px] font-black {{ $isRegisteredThisEps ? 'text-gray-400' : 'text-slate-900' }}">
                                                {{ $episode->title }}
                                            </span>
                                            @if($isRegisteredThisEps)
                                                <span class="text-[9px] font-black text-emerald-600 uppercase">Sudah Terdaftar</span>
                                            @else
                                                <span class="text-[9px] font-bold uppercase text-slate-500">{{ $episode->start_time->format('d M Y') }}</span>
                                            @endif
                                        </div>

                                        @if(!$isRegisteredThisEps)
                                        <input type="checkbox" 
                                            value="{{ $episode->title }}" 
                                            x-model="selectedEpisodes"
                                            @click="selectedEpisodes = ['{{ $episode->title }}']" 
                                            class="rounded-full text-blue-600">
                                        @else
                                        <i data-lucide="check-circle" class="w-4 h-4 text-emerald-500"></i>
                                        @endif
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Total & Button --}}
                        <div class="pt-6 border-t border-slate-100 mb-6">
                            <p class="text-[10px] font-black text-slate-400 uppercase mb-1">Total Bayar</p>
                            <p class="text-3xl font-black text-slate-900" x-text="'Rp' + total.toLocaleString('id-ID')"></p>
                        </div>

                        @auth
                            @if($isRegisteredFull)
                                <div class="bg-emerald-50 border border-emerald-100 p-4 rounded-2xl text-center">
                                    <p class="text-xs font-black text-emerald-700 uppercase">Anda Sudah Terdaftar (Full Series / Premium)</p>
                                    <a href="{{ route('dashboard') }}" class="text-[10px] font-bold text-blue-600 underline uppercase mt-1 inline-block">Buka Dashboard</a>
                                </div>
                            @else
                                <button type="submit" 
                                    x-show="mode !== 'basic' || (mode === 'basic' && selectedEpisodes.length > 0)"
                                    class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-2xl shadow-lg transition-all active:scale-95 uppercase text-sm tracking-widest">
                                    DAFTAR SEKARANG
                                </button>
                                <p x-show="mode === 'basic' && selectedEpisodes.length === 0" class="text-[10px] text-center text-rose-500 font-bold uppercase">
                                    Silakan pilih salah satu episode
                                </p>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="block w-full py-4 bg-slate-900 text-white text-center font-black rounded-2xl shadow-lg hover:bg-slate-800 transition uppercase text-sm tracking-widest">
                                Login untuk Daftar
                            </a>
                        @endauth
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- @include('layouts.partials.sponsor') --}}
@endsection