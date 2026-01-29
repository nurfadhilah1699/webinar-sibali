<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-black text-gray-900 tracking-tight">Selamat Datang</h2>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2 ml-1">Email Address</label>
            <x-text-input id="email" class="block w-full !rounded-2xl border-gray-100 bg-gray-50 focus:bg-white focus:ring-blue-900 focus:border-blue-900 transition-all py-3" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2 ml-1">Password</label>
            <x-text-input id="password" class="block w-full !rounded-2xl border-gray-100 bg-gray-50 focus:bg-white focus:ring-blue-900 focus:border-blue-900 transition-all py-3" type="password" name="password" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded-lg border-gray-200 text-blue-900 shadow-sm focus:ring-blue-900 w-5 h-5" name="remember">
                <span class="ms-2 text-[11px] font-black text-gray-500 uppercase tracking-widest">{{ __('Ingat Saya') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-[11px] font-black text-blue-900 hover:text-black transition-colors uppercase tracking-widest" href="{{ route('password.request') }}">
                    {{ __('Lupa Password?') }}
                </a>
            @endif
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full bg-blue-900 hover:bg-black text-white font-black py-4 rounded-2xl shadow-xl shadow-blue-100 transition-all transform hover:scale-[1.01] active:scale-[0.98] uppercase tracking-widest text-xs">
                {{ __('Masuk Sekarang') }}
            </button>
        </div>

        <div class="text-center mt-6">
            <p class="text-xs text-gray-500 font-bold uppercase tracking-widest">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-blue-900 hover:underline">Daftar Akun</a>
            </p>
        </div>
    </form>
</x-guest-layout>