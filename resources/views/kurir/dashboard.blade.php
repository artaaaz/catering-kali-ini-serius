<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Kurir') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Alert Messages -->
            @if(session('success'))
                <div class="bg-green-500 text-white px-6 py-4 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-500 text-white px-6 py-4 rounded-lg mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-blue-500">
                    <p class="text-gray-500 text-sm">Total Pengiriman</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $pengirimans->total() }}</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-yellow-500">
                    <p class="text-gray-500 text-sm">Sedang Dikirim</p>
                    <p class="text-2xl font-bold text-gray-800">
                        {{ $pengirimans->where('status_kirim', 'Sedang Dikirim')->count() }}
                    </p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-green-500">
                    <p class="text-gray-500 text-sm">Selesai</p>
                    <p class="text-2xl font-bold text-gray-800">
                        {{ $pengirimans->where('status_kirim', 'Tiba Ditujukan')->count() }}
                    </p>
                </div>
            </div>

            <!-- Table Pengiriman -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Daftar Pengiriman</h3>

                    @if($pengirimans->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Resi</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pelanggan</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Alamat</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Kirim</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($pengirimans as $index => $pengiriman)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $pengirimans->firstItem() + $index }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap font-medium">
                                            {{ $pengiriman->pemesanan->no_resi ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $pengiriman->pemesanan->pelanggan->nama_pelanggan ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            {{ Str::limit($pengiriman->pemesanan->alamat1 ?? '-', 30) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 text-xs rounded-full 
                                                {{ $pengiriman->status_kirim == 'Sedang Dikirim' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $pengiriman->status_kirim == 'Tiba Ditujukan' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $pengiriman->status_kirim == 'Menunggu Kurir' ? 'bg-blue-100 text-blue-800' : '' }}">
                                                {{ $pengiriman->status_kirim }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            {{ $pengiriman->tgl_kirim ? $pengiriman->tgl_kirim->format('d/m/Y') : '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <!-- Tombol Update Status -->
                                            <button onclick="openStatusModal({{ $pengiriman->id }}, '{{ $pengiriman->status_kirim }}')" 
                                                class="text-blue-600 hover:text-blue-900 mr-3">
                                                Update Status
                                            </button>
                                            
                                            <!-- Tombol Upload Bukti -->
                                            <button onclick="openUploadModal({{ $pengiriman->id }})" 
                                                class="text-green-600 hover:text-green-900">
                                                Upload Bukti
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $pengirimans->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-500 text-lg">Belum ada data pengiriman.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Update Status -->
    <div id="statusModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
            <h3 class="text-lg font-semibold mb-4">Update Status Pengiriman</h3>
            <form id="statusForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" id="statusSelect" required class="w-full px-4 py-2 border rounded-lg">
                        <option value="Menunggu Kurir">Menunggu Kurir</option>
                        <option value="Sedang Dikirim">Sedang Dikirim</option>
                        <option value="Tiba Ditujukan">Tiba Ditujukan</option>
                    </select>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeStatusModal()" class="px-4 py-2 border rounded-lg">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Upload Bukti -->
    <div id="uploadModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
            <h3 class="text-lg font-semibold mb-4">Upload Bukti Pengiriman</h3>
            <form id="uploadForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Foto Bukti</label>
                    <input type="file" name="bukti_foto" accept="image/*" required class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeUploadModal()" class="px-4 py-2 border rounded-lg">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg">Upload</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openStatusModal(id, currentStatus) {
            document.getElementById('statusForm').action = '/kurir/pengiriman/' + id + '/update-status';
            document.getElementById('statusSelect').value = currentStatus;
            document.getElementById('statusModal').classList.remove('hidden');
        }

        function closeStatusModal() {
            document.getElementById('statusModal').classList.add('hidden');
        }

        function openUploadModal(id) {
            document.getElementById('uploadForm').action = '/kurir/pengiriman/' + id + '/upload-bukti';
            document.getElementById('uploadModal').classList.remove('hidden');
        }

        function closeUploadModal() {
            document.getElementById('uploadModal').classList.add('hidden');
        }
    </script>
</x-app-layout>