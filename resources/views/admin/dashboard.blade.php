<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin - Verifikasi Pembayaran') }}
        </h2>
    </x-slot>

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
                                <td class="p-3 text-sm">
                                    <form action="{{ route('admin.approve', $user->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-green-600 text-white px-4 py-1 rounded text-xs font-bold hover:bg-green-700">
                                            APPROVE
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
</x-app-layout>