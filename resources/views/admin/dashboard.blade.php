<x-admin-layout>
    <div class="flex min-h-screen bg-gray-100">
        <div class="flex-1 p-10">
            {{-- Header Statis --}}
            <div class="mb-8 flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-800">Manajemen Sistem</h1>
                <div class="bg-white p-4 rounded-xl shadow-sm border">
                    <p class="text-xs text-gray-500 uppercase font-bold">Status Sertifikat</p>
                    <form action="{{ route('admin.toggle-certificate') }}" method="POST" class="mt-2">
                        @csrf
                        <button type="submit" class="px-4 py-1 rounded-full text-xs font-bold text-white {{ $isCertReady ? 'bg-red-500' : 'bg-green-500' }}">
                            {{ $isCertReady ? 'MATIKAN DOWNLOAD' : 'AKTIFKAN DOWNLOAD' }}
                        </button>
                    </form>
                </div>
            </div>

            {{-- Slot Konten Dinamis --}}
            <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100">
                @yield('admin_content') {{-- Kita gunakan yield agar konten bisa berganti-ganti --}}
                
                <div class="py-12">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                            
                            @if(session('status'))
                                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b bg-gray-50">
                                        <th class="p-3 text-sm">Nama / Email</th>
                                        <th class="p-3 text-sm">Paket</th>
                                        <th class="p-3 text-sm">Bukti Bayar</th>
                                        <th class="p-3 text-sm">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pendingUsers as $user)
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="p-3 text-sm">
                                                <strong>{{ $user->name }}</strong><br>
                                                <span class="text-gray-500">{{ $user->email }}</span>
                                            </td>
                                            <td class="p-3 text-sm italic">{{ strtoupper($user->package) }}</td>
                                            <td class="p-3 text-sm">
                                                <a href="{{ asset('storage/' . $user->payment_proof) }}" target="_blank" class="text-indigo-600 underline">
                                                    Lihat Gambar
                                                </a>
                                            </td>
                                            <td class="p-3 text-sm flex gap-2">
                                                <form action="{{ route('admin.approve', $user->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded text-xs font-bold hover:bg-green-700">
                                                        APPROVE
                                                    </button>
                                                </form>

                                                <form action="{{ route('admin.reject', $user->id) }}" method="POST" class="flex gap-1">
                                                    @csrf
                                                    <input type="text" name="reason" placeholder="Alasan tolak..." class="text-xs border-gray-300 rounded p-1 w-32" required>
                                                    <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded text-xs font-bold hover:bg-red-700">
                                                        REJECT
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="p-6 text-center text-gray-500">Tidak ada pembayaran yang menunggu verifikasi.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>