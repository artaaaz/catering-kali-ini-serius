<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Pesanan #{{ $pemesanan->no_resi }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="mb-6">
                        <h3 class="text-lg font-bold mb-4">Informasi Pesanan</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-gray-600">No. Resi:</p>
                                <p class="font-semibold">{{ $pemesanan->no_resi }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Status:</p>
                                <p class="font-semibold">{{ $pemesanan->status_pesan }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Tanggal Pesan:</p>
                                <p class="font-semibold">{{ $pemesanan->tgl_pesan }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Total Bayar:</p>
                                <p class="font-semibold text-orange-600">Rp {{ number_format($pemesanan->total_bayar, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-bold mb-4">Data Pelanggan</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-gray-600">Nama:</p>
                                <p class="font-semibold">{{ $pemesanan->pelanggan->nama_pelanggan ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Email:</p>
                                <p class="font-semibold">{{ $pemesanan->pelanggan->email ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-bold mb-4">Update Status</h3>
                        <form action="{{ route('admin.pemesanans.updateStatus', $pemesanan->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="flex gap-3">
                                <select name="status_pesan" class="flex-1 border border-gray-300 rounded-lg px-4 py-2">
                                    <option value="Menunggu Konfirmasi" {{ $pemesanan->status_pesan == 'Menunggu Konfirmasi' ? 'selected' : '' }}>
                                        Menunggu Konfirmasi
                                    </option>
                                    <option value="Sedang Diproses" {{ $pemesanan->status_pesan == 'Sedang Diproses' ? 'selected' : '' }}>
                                        Sedang Diproses
                                    </option>
                                    <option value="Menunggu Kurir" {{ $pemesanan->status_pesan == 'Menunggu Kurir' ? 'selected' : '' }}>
                                        Menunggu Kurir
                                    </option>
                                </select>
                                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                                    Update
                                </button>
                            </div>
                        </form>
                    </div>

                    <a href="{{ route('admin.pemesanans.index') }}" class="text-blue-600 hover:underline">
                        ← Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>