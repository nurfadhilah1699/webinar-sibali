<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        Silakan masukkan 6 digit kode verifikasi yang kami kirim ke email Anda.
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
</x-guest-layout>