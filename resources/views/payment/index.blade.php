<x-app-layout>
    <div class="max-w-2xl mx-auto py-20 px-4 text-center">
        <div class="bg-white p-8 rounded-[3rem] shadow-xl border border-slate-100">
            <div class="w-20 h-20 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-6">
                <i data-lucide="check" class="w-10 h-10"></i>
            </div>
            
            <h1 class="text-3xl font-black text-slate-900 mb-2">Pendaftaran Berhasil!</h1>
            <p class="text-slate-500 mb-8">Satu langkah lagi untuk mengamankan slot kamu. Silakan lakukan pembayaran sesuai detail di bawah ini:</p>
            <div class="bg-slate-50 p-6 rounded-3xl border border-slate-100 text-left mb-8">
                <div class="mb-4 pb-4 border-b border-dashed border-slate-200">
                    <span class="text-[10px] font-black text-slate-400 uppercase">Event yang didaftar:</span>
                    <h2 class="text-sm font-black text-slate-800">{{ $registration->event->title }}</h2>
                </div>
                <div class="flex justify-between mb-4">
                    <span class="text-slate-500 font-medium">Total Tagihan:</span>
                    <span class="text-xl font-black text-blue-600">Rp{{ number_format($registration->amount, 0, ',', '.') }}</span>
                </div>
                <div class="border-t border-dashed border-slate-200 pt-4">
                    <p class="text-xs text-slate-400 uppercase font-bold mb-2">Transfer Ke Rekening:</p>
                    <p class="font-black text-slate-800 text-lg">{{ config('services.payment.bank') }} ({{ config('services.payment.code') }})</p>
                    <p class="text-2xl font-mono text-blue-900 font-bold">{{ config('services.payment.norek') }}</p>
                    <p class="text-sm text-slate-600">a.n. {{ config('services.payment.penerima') }}</p>
                </div>
            </div>

            {{-- Form Upload Bukti (Nanti kita buat logic-nya) --}}
            <form action="{{ route('payment.confirm', $registration->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label class="block text-left text-sm font-bold text-slate-700 mb-2">Upload Bukti Transfer:</label>
                <input type="file" name="payment_proof" class="w-full p-3 border-2 border-dashed border-slate-200 rounded-2xl mb-6">
                
                <button type="submit" class="w-full py-4 bg-slate-900 text-white font-black rounded-2xl hover:bg-black transition">
                    Konfirmasi Pembayaran
                </button>
            </form>
        </div>
    </div>
</x-app-layout>