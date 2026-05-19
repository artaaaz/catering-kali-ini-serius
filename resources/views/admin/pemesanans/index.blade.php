<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Pemesanan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-500 text-white px-6 py-4 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Daftar Pemesanan</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Resi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pelanggan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Paket</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($pemesanans as $index => $pemesanan)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $pemesanans->firstItem() + $index }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $pemesanan->no_resi }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $pemesanan->pelanggan->nama_pelanggan ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $pemesanan->paket->nama_paket ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $pemesanan->created_at->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap font-semibold">Rp {{ number_format($pemesanan->total_bayar, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs rounded-full 
                                            {{ $pemesanan->status_pesan == 'Selesai' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $pemesanan->status_pesan == 'Diproses' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $pemesanan->status_pesan == 'Menunggu Konfirmasi' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $pemesanan->status_pesan == 'Dibatalkan' ? 'bg-red-100 text-red-800' : '' }}">
                                            {{ $pemesanan->status_pesan }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.pemesanans.show', $pemesanan->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                        Belum ada data pemesanan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $pemesanans->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>