{{-- Ini hanya contoh konten untuk halaman list peserta --}}
<x-admin-layout>
    <div class="p-6">
        <h2 class="text-2xl font-bold mb-6">Daftar Peserta Webinar</h2>
        <table class="w-full text-left">
            <thead>
                <tr class="text-gray-400 border-b">
                    <th class="pb-4">Nama</th>
                    <th class="pb-4">Paket</th>
                    <th class="pb-4">Status</th>
                    <th class="pb-4">Skor TOEFL</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr class="border-b">
                    <td class="py-4 font-medium">{{ $user->name }}</td>
                    <td class="py-4 uppercase text-xs">{{ $user->package }}</td>
                    <td class="py-4">
                        <span class="{{ $user->is_verified ? 'text-green-600' : 'text-amber-600' }} font-bold text-xs">
                            {{ $user->is_verified ? 'TERVERIFIKASI' : 'PENDING' }}
                        </span>
                    </td>
                    <td class="py-4 font-mono">{{ $user->toefl_score ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
</x-admin-layout>
