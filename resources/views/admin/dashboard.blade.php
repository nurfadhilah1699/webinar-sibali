<x-admin-layout>
    {{-- Bagian Atas: Judul & Toggle Sertifikat --}}
    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Verifikasi Pembayaran</h1>
            <p class="text-gray-500">Periksa bukti transfer dan aktifkan akun peserta.</p>
        </div>

        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="text-right">
                <p class="text-[10px] text-gray-400 uppercase font-black tracking-widest">Status Sertifikat</p>
                <p class="text-xs font-bold {{ $isCertReady ? 'text-green-600' : 'text-red-500' }}">
                    {{ $isCertReady ? 'Siap Diunduh' : 'Masih Terkunci' }}
                </p>
            </div>
            <form action="{{ route('admin.toggle-certificate') }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2 rounded-xl text-xs font-bold text-white transition {{ $isCertReady ? 'bg-red-500 hover:bg-red-600' : 'bg-green-600 hover:bg-green-700' }}">
                    {{ $isCertReady ? 'MATIKAN' : 'AKTIFKAN' }}
                </button>
            </form>
        </div>
    </div>

    {{-- Notifikasi Sukses --}}
    @if(session('status'))
        <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-r-xl animate-bounce">
            {{ session('status') }}
        </div>
    @endif

    {{-- Tabel Verifikasi --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="p-4 text-xs font-black text-gray-400 uppercase tracking-widest">Peserta</th>
                    <th class="p-4 text-xs font-black text-gray-400 uppercase tracking-widest">Paket</th>
                    <th class="p-4 text-xs font-black text-gray-400 uppercase tracking-widest">Bukti Transfer</th>
                    <th class="p-4 text-xs font-black text-gray-400 uppercase tracking-widest text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($pendingUsers as $user)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="p-4">
                            <div class="font-bold text-gray-800">{{ $user->name }}</div>
                            <div class="text-xs text-gray-400">{{ $user->email }}</div>
                        </td>
                        <td class="p-4">
                            <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-full text-[10px] font-black uppercase">
                                {{ $user->package }}
                            </span>
                        </td>
                        <td class="p-4">
                            <a href="{{ asset('storage/' . $user->payment_proof) }}" target="_blank" class="inline-flex items-center gap-2 text-indigo-600 font-bold text-xs hover:underline">
                                <span>👁️ Lihat Bukti</span>
                            </a>
                        </td>
                        <td class="p-4">
                            <div class="flex justify-center gap-2">
                                {{-- Tombol Approve --}}
                                <form action="{{ route('admin.approve', $user->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-green-100 text-green-700 px-4 py-2 rounded-xl text-xs font-bold hover:bg-green-600 hover:text-white transition">
                                        APPROVE
                                    </button>
                                </form>

                                {{-- Tombol Reject --}}
                                <form action="{{ route('admin.reject', $user->id) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    <input type="text" name="reason" placeholder="Alasan ditolak..." class="text-xs border-gray-200 rounded-xl focus:ring-red-500 focus:border-red-500 p-2 w-32" required>
                                    <button type="submit" class="bg-red-100 text-red-700 px-4 py-2 rounded-xl text-xs font-bold hover:bg-red-600 hover:text-white transition">
                                        REJECT
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-12 text-center">
                            <div class="text-4xl mb-2">🎉</div>
                            <p class="text-gray-400 italic text-sm">Semua pembayaran sudah diproses. Tidak ada antrean!</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin-layout>