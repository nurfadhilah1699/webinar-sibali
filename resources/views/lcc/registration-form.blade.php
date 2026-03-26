@extends('layouts.landing-page')

@section('content')
<div class="max-w-2xl mx-auto py-20 px-4">
    <div class="bg-white p-10 rounded-[3rem] border-2 border-slate-900 shadow-[10px_10px_0px_0px_rgba(15,23,42,1)]">
        <div class="mb-8">
            <h1 class="text-3xl font-black text-slate-900 uppercase italic leading-none">Data Anggota Tim</h1>
            <p class="text-slate-500 mt-2 font-bold text-sm uppercase tracking-tight">{{ $event->title }}</p>
        </div>

        <form action="{{ route('register.post') }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="event_id" value="{{ $event->id }}">
            <input type="hidden" name="package_type" value="lcc_team">
            <input type="hidden" name="amount" value="85000">

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="text-[10px] font-black text-slate-400 uppercase ml-2">Nama Tim</label>
                    <input type="text" name="team_name" required placeholder="Contoh: Tim Macan" 
                        class="w-full mt-1 p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-blue-500 focus:ring-0 transition font-bold">
                </div>
                <div>
                    <label class="text-[10px] font-black text-slate-400 uppercase ml-2">Asal Sekolah</label>
                    <input type="text" name="school_name" required placeholder="Contoh: SMPN 1 Majene" 
                        class="w-full mt-1 p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-blue-500 focus:ring-0 transition font-bold">
                </div>
            </div>

            <div class="space-y-4">
                <p class="text-[10px] font-black text-slate-400 uppercase ml-2">Daftar Anggota (Max 3)</p>
                <input type="text" name="members[]" required placeholder="Nama Ketua" class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-blue-500 font-bold">
                <input type="text" name="members[]" placeholder="Nama Anggota 2 (Opsional)" class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-blue-500 font-bold">
                <input type="text" name="members[]" placeholder="Nama Anggota 3 (Opsional)" class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-blue-500 font-bold">
            </div>

            <button type="submit" class="w-full py-5 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-[2rem] transition-all shadow-lg uppercase tracking-widest text-sm">
                Simpan & Lanjut Pembayaran
            </button>
        </form>
    </div>
</div>
@endsection