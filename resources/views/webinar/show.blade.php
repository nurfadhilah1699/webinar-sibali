@extends('layouts.landing-page')

@section('content')
    @include('layouts.partials.event-header', [
        'type' => $event->type ?? 'Webinar',
        'title' => $event->title,
        'description' => 'Bangun citra profesional yang kuat untuk memenangkan persaingan kerja di tahun 2026.',
        'slug' => $event->slug
    ])

    <div class="max-w-6xl mx-auto px-4 mt-20 mb-20">
        <div class="grid lg:grid-cols-3 gap-8">
            
            {{-- KIRI: Deskripsi Kurikulum & Benefit --}}
            <div class="lg:col-span-2 space-y-8">
                {{-- Benefit Cards Utama (Sesuai TOR) --}}
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
                            {{-- BASIC --}}
                            <label class="relative block p-4 border-2 rounded-2xl cursor-pointer transition-all"
                                :class="mode === 'basic' ? 'border-blue-600 bg-blue-50' : 'border-slate-100 hover:border-slate-300'">
                                <input type="radio" name="cat" value="basic" x-model="mode" class="absolute top-4 right-4 text-blue-600">
                                <span class="block text-xs font-black text-slate-900 uppercase">Kategori Basic</span>
                                <span class="block text-lg font-black text-blue-700">Rp35.000<span class="text-[10px] text-slate-400 font-normal">/eps</span></span>
                            </label>

                            {{-- FULL SERIES --}}
                            <label class="relative block p-4 border-2 rounded-2xl cursor-pointer transition-all"
                                :class="mode === 'full' ? 'border-blue-600 bg-blue-50' : 'border-slate-100 hover:border-slate-300'">
                                <div class="absolute -top-2 -left-2 bg-emerald-500 text-white text-[9px] font-black px-2 py-1 rounded-md rotate-[-5deg] shadow-sm uppercase">Best Value</div>
                                <input type="radio" name="cat" value="full" x-model="mode" class="absolute top-4 right-4 text-blue-600">
                                <span class="block text-xs font-black text-slate-900 uppercase">Full Series</span>
                                <span class="block text-lg font-black text-blue-700">Rp100.000</span>
                            </label>

                            {{-- PREMIUM --}}
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
                                    <span x-text="mode === 'basic' ? '1 Episode Pilihan' : 'Seluruh 5 Episode'"></span>
                                </li>
                                <li class="flex items-center gap-2 text-[11px] font-bold text-slate-600">
                                    <i data-lucide="check" class="w-3 h-3 text-blue-500"></i> 
                                    <span x-text="mode === 'basic' ? 'E-Sertifikat per Episode' : (mode === 'premium' ? 'E-Sertifikat Premium' : 'E-Sertifikat Full Series')"></span>
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

                        {{-- Episode Selector (Hanya muncul jika BASIC) --}}
                        <div x-show="mode === 'basic'" class="mb-8 animate-fadeIn">
                            <p class="text-[10px] font-black text-slate-400 uppercase mb-3">Pilih Episode Anda:</p>
                            <div class="grid grid-cols-1 gap-2">
                                @foreach(range(1,5) as $i)
                                <label class="flex items-center justify-between p-3 border border-slate-100 rounded-xl cursor-pointer hover:bg-white transition"
                                    :class="selectedEpisodes.includes('Episode {{ $i }}') ? 'bg-blue-50 border-blue-200' : ''">
                                    <span class="text-xs font-bold">Episode {{ $i }}</span>
                                    <input type="checkbox" value="Episode {{ $i }}" x-model="selectedEpisodes" class="rounded text-blue-600">
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="pt-6 border-t border-slate-100 mb-6">
                            <p class="text-[10px] font-black text-slate-400 uppercase mb-1">Total Bayar</p>
                            <p class="text-3xl font-black text-slate-900" x-text="'Rp' + total.toLocaleString('id-ID')"></p>
                        </div>

                        <button type="submit" 
                            class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-2xl transition-all shadow-lg shadow-blue-100 hover:scale-[1.02] active:scale-95">
                            DAFTAR SEKARANG
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection