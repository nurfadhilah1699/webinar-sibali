<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-black text-gray-900 tracking-tight">Buat Akun</h2>
        <p class="text-gray-500 font-medium mt-2 text-sm">Lengkapi data untuk memulai sertifikasi.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2 ml-1">Nama Lengkap</label>
                <x-text-input id="name" class="block w-full !rounded-2xl border-gray-100 bg-gray-50 py-3" type="text" name="name" :value="old('name')" required autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2 ml-1">WhatsApp (Aktif)</label>
                <x-text-input id="phone" class="block w-full !rounded-2xl border-gray-100 bg-gray-50 py-3" type="text" name="phone" :value="old('phone')" required />
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>
        </div>

        <div>
            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2 ml-1">Email</label>
            <x-text-input id="email" class="block w-full !rounded-2xl border-gray-100 bg-gray-50 py-3" type="email" name="email" :value="old('email')" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2 ml-1">Password</label>
                <x-text-input id="password" class="block w-full !rounded-2xl border-gray-100 bg-gray-50 py-3" type="password" name="password" required />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div>
                <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2 ml-1">Konfirmasi Password</label>
                <x-text-input id="password_confirmation" class="block w-full !rounded-2xl border-gray-100 bg-gray-50 py-3" type="password" name="password_confirmation" required />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2 ml-1">Kategori</label>
                <select name="user_category" class="w-full !rounded-2xl border-gray-100 bg-gray-50 focus:ring-blue-900 focus:border-blue-900 py-3 text-sm font-bold">
                    <option value="Umum">Umum</option>
                    <option value="Mahasiswa">Mahasiswa</option>
                    <option value="Siswa">Siswa</option>
                </select>
            </div>

            <div>
                <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2 ml-1">Pilih Paket</label>
                <select name="package" class="w-full !rounded-2xl border-gray-100 bg-gray-50 focus:ring-blue-900 focus:border-blue-900 py-3 text-sm font-bold shadow-sm">
                    <option value="reguler" {{ request('package') == 'reguler' ? 'selected' : '' }}>Reguler</option>
                    <option value="vip1" {{ request('package') == 'vip1' ? 'selected' : '' }}>VIP</option>
                    <option value="vip2" {{ request('package') == 'vip2' ? 'selected' : '' }}>VIP Plus+</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2 ml-1">Institusi/Sekolah</label>
            <x-text-input id="institution" class="block w-full !rounded-2xl border-gray-100 bg-gray-50 py-3" type="text" name="institution" :value="old('institution')" required />
        </div>

        <div>
            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2 ml-1">Alamat Lengkap</label>
            <textarea name="address" rows="2" class="w-full !rounded-2xl border-gray-100 bg-gray-50 focus:ring-blue-900 focus:border-blue-900 py-3 text-sm font-bold">{{ old('address') }}</textarea>
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full bg-blue-900 hover:bg-black text-white font-black py-4 rounded-2xl shadow-xl transition-all uppercase tracking-widest text-xs">
                {{ __('Daftar Sekarang') }}
            </button>
        </div>

        <div class="text-center mt-4">
            <a class="text-[11px] font-black text-blue-900 hover:text-black transition-colors uppercase tracking-widest" href="{{ route('login') }}">
                {{ __('Sudah punya akun? Login') }}
            </a>
        </div>
    </form>
</x-guest-layout>