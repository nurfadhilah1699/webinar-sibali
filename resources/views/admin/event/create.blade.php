<x-admin-layout>
    <div class="mb-8">
        <h1 class="text-3xl font-black text-slate-800 uppercase italic tracking-tighter">Buat Event Baru</h1>
        <p class="text-slate-500 text-sm">Sistem otomatis akan menyesuaikan form berdasarkan tipe event.</p>
    </div>

    <div class="max-w-4xl" x-data="{ eventType: 'webinar' }">
        <form action="{{ route('admin.events.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="bg-white p-8 rounded-[2.5rem] border-2 border-slate-900 shadow-[10px_10px_0px_0px_rgba(15,23,42,1)]">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Judul --}}
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-2">Nama Event</label>
                        <input type="text" name="title" required placeholder="CONTOH: WEBINAR NASIONAL TEKNOLOGI" 
                            class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-indigo-600 focus:ring-0 transition font-bold uppercase">
                    </div>

                    {{-- Tipe Event --}}
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-2">Jenis Kegiatan</label>
                        <select name="type" x-model="eventType" class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-indigo-600 transition font-black uppercase">
                            <option value="webinar">WEBINAR (INDIVIDU)</option>
                            <option value="lcc">LCC / COMPETITION (TIM)</option>
                        </select>
                    </div>

                    {{-- Waktu --}}
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-2">Tanggal & Waktu</label>
                        <input type="datetime-local" name="start_time" required 
                            class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-indigo-600 transition font-bold">
                    </div>
                </div>

                {{-- FORM DINAMIS UNTUK WEBINAR --}}
                <div x-show="eventType === 'webinar'" x-transition class="mt-8 p-6 bg-indigo-50 rounded-[2rem] border-2 border-dashed border-indigo-200">
                    <h3 class="font-black text-indigo-900 uppercase italic text-sm mb-4">Pengaturan Paket Webinar</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-[9px] font-black text-indigo-400 uppercase">Harga Basic (IDR)</label>
                            <input type="number" name="price_basic" placeholder="0" class="w-full mt-1 p-3 rounded-xl border-none font-bold">
                        </div>
                        <div>
                            <label class="text-[9px] font-black text-indigo-400 uppercase">Harga Premium (IDR)</label>
                            <input type="number" name="price_premium" placeholder="35000" class="w-full mt-1 p-3 rounded-xl border-none font-bold">
                        </div>
                    </div>
                </div>

                {{-- FORM DINAMIS UNTUK LCC --}}
                <div x-show="eventType === 'lcc'" x-transition class="mt-8 p-6 bg-rose-50 rounded-[2rem] border-2 border-dashed border-rose-200">
                    <h3 class="font-black text-rose-900 uppercase italic text-sm mb-4">Pengaturan Kompetisi (Tim)</h3>
                    <div>
                        <label class="text-[9px] font-black text-rose-400 uppercase">Biaya Pendaftaran Per Tim</label>
                        <input type="number" name="price_team" placeholder="100000" class="w-full mt-1 p-3 rounded-xl border-none font-bold">
                    </div>
                </div>

                <div class="mt-10">
                    <button type="submit" class="w-full py-5 bg-slate-900 text-white rounded-[2rem] font-black uppercase italic tracking-widest hover:bg-indigo-600 transition-all shadow-xl active:scale-95">
                        Terbitkan Event Sekarang
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-admin-layout>