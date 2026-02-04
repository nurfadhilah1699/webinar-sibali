<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        Silakan masukkan 6 digit kode verifikasi yang kami kirim ke email Anda.
    </div>

    <div class="mb-6 p-3 bg-amber-50 border border-amber-200 rounded-lg">
        <div class="flex gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="id-circle-check" /> {{-- Atau icon warning --}}
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <div>
                <p class="text-[11px] font-bold text-amber-800 uppercase leading-none mb-1">PENTING:</p>
                <p class="text-[11px] text-amber-700 leading-tight">
                    Jika kode belum masuk dalam 2 menit, mohon periksa folder <b>Spam</b> atau tab <b>Promosi</b> di email Anda.
                </p>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('otp.verify') }}">
        @csrf
        <div>
            <x-input-label for="otp" value="Kode OTP" />
            <x-text-input id="otp" class="block mt-1 w-full text-center text-2xl tracking-widest font-bold" type="text" name="otp" required autofocus />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                Verifikasi Akun
            </x-primary-button>
        </div>
    </form>

    <div class="mt-6 text-center">
        <p class="text-xs text-gray-500 mb-2">Tidak menerima kode?</p>
        <form method="POST" action="{{ route('otp.resend') }}">
            @csrf
            <button type="submit" class="text-sm text-indigo-600 font-bold hover:underline">
                Kirim Ulang OTP
            </button>
        </form>
    </div>

    {{-- Tambahkan notifikasi jika sukses kirim ulang --}}
    @if (session('status'))
        <div class="mt-4 text-sm font-medium text-green-600 text-center">
            {{ session('status') }}
        </div>
    @endif
</x-guest-layout>