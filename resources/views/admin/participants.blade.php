<x-admin-layout>
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Daftar Peserta</h1>
            <p class="text-sm text-gray-500">Total Peserta Terdaftar: {{ count($users) }} orang</p>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('admin.participants') }}" class="px-4 py-2 bg-white border rounded-xl text-xs font-bold hover:bg-gray-50 transition">Semua</a>
            <a href="{{ route('admin.participants', ['package' => 'reguler']) }}" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-xl text-xs font-bold hover:bg-gray-200 transition text-center">Reguler</a>
            <a href="{{ route('admin.participants', ['package' => 'vip1']) }}" class="px-4 py-2 bg-purple-100 text-purple-600 rounded-xl text-xs font-bold hover:bg-purple-200 transition text-center">VIP 1</a>
            <a href="{{ route('admin.participants', ['package' => 'vip2']) }}" class="px-4 py-2 bg-indigo-100 text-indigo-600 rounded-xl text-xs font-bold hover:bg-indigo-200 transition text-center">VIP 2</a>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-100 text-gray-400 text-[10px] uppercase tracking-widest">
                    <tr>
                        <th class="px-6 py-4">Nama & Email</th>
                        <th class="px-6 py-4">Paket</th>
                        <th class="px-6 py-4">Status Akun</th>
                        <th class="px-6 py-4">Skor TOEFL</th>
                        <th class="px-6 py-4 text-right">Terdaftar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-800">{{ $user->name }}</div>
                            <div class="text-xs text-gray-400">{{ $user->email }}</div>
                        </td>
                        <td class="px-6 py-4">
                            @if($user->package == 'reguler')
                                <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-[10px] font-bold">REGULER</span>
                            @elseif($user->package == 'vip1')
                                <span class="px-3 py-1 bg-purple-100 text-purple-600 rounded-full text-[10px] font-bold">VIP 1</span>
                            @else
                                <span class="px-3 py-1 bg-indigo-100 text-indigo-600 rounded-full text-[10px] font-bold">VIP 2</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($user->is_verified)
                                <span class="text-green-500 flex items-center gap-1 text-xs font-bold">
                                    <span class="w-2 h-2 bg-green-500 rounded-full"></span> Aktif
                                </span>
                            @else
                                <span class="text-amber-500 flex items-center gap-1 text-xs font-bold">
                                    <span class="w-2 h-2 bg-amber-500 rounded-full animate-pulse"></span> Belum Bayar
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($user->toefl_score)
                                <div class="text-indigo-600 font-black text-lg">{{ $user->toefl_score }}</div>
                            @else
                                <span class="text-gray-300 text-xs italic">Belum Tes</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right text-gray-400 text-xs">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-400 italic">Belum ada peserta di kategori ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>