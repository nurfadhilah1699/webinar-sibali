<x-app-layout>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-3xl shadow-sm border h-fit">
            <h3 class="font-bold mb-4">Tambah Materi / Link</h3>
            <form action="{{ route('admin.materials.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="text-xs font-bold text-gray-400">Judul</label>
                    <input type="text" name="title" class="w-full border-gray-200 rounded-xl" placeholder="Contoh: Grup WA VIP 2" required>
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-400">Tipe</label>
                    <select name="type" class="w-full border-gray-200 rounded-xl">
                        <option value="link_zoom">Link Zoom</option>
                        <option value="link_wa">Link WhatsApp</option>
                        <option value="materi">PDF Materi (Drive)</option>
                        <option value="rekaman">Rekaman (YouTube)</option>
                    </select>
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-400">Tujuan Paket</label>
                    <select name="package" class="w-full border-gray-200 rounded-xl">
                        <option value="all">Semua Peserta</option>
                        <option value="reguler">Hanya Reguler</option>
                        <option value="vip1">Hanya VIP 1</option>
                        <option value="vip2">Hanya VIP 2</option>
                    </select>
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-400">URL Link</label>
                    <input type="url" name="link" class="w-full border-gray-200 rounded-xl" placeholder="https://..." required>
                </div>
                <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-xl font-bold">Simpan</button>
            </form>
        </div>

        <div class="md:col-span-2 bg-white p-6 rounded-3xl shadow-sm border">
            <h3 class="font-bold mb-4">Daftar Konten Terbit</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-gray-400 border-b text-sm">
                            <th class="pb-3">Judul</th>
                            <th class="pb-3">Tipe</th>
                            <th class="pb-3">Paket</th>
                            <th class="pb-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @foreach($contents as $c)
                        <tr class="border-b">
                            <td class="py-3 font-medium">{{ $c->title }}</td>
                            <td class="py-3 uppercase text-[10px]"><span class="bg-gray-100 px-2 py-1 rounded">{{ $c->type }}</span></td>
                            <td class="py-3 uppercase font-bold text-indigo-600">{{ $c->package }}</td>
                            <td class="py-3 text-red-500">
                                <form action="{{ route('admin.materials.delete', $c->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('Hapus?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>