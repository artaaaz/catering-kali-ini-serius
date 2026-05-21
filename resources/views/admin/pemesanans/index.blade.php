<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Pemesanan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
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
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Resi
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Pelanggan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Paket
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pemesanans as $item)
                                    <tr class="border-b">
                                        <td class="py-4">{{ $loop->iteration }}</td>

                                        <td>{{ $item->no_resi }}</td>

                                        <td>
                                            {{ $item->pelanggan->nama ?? '-' }}
                                        </td>

                                        <td>
                                            @foreach ($item->pakets as $paket)
                                                <span>
                                                    {{ $paket->nama_paket }}
                                                </span><br>
                                            @endforeach
                                        </td>

                                        <td>
                                            {{ $item->tgl_pesan }}
                                        </td>

                                        <td>
                                            Rp {{ number_format($item->total_bayar) }}
                                        </td>

                                        <td>
                                            {{ $item->status_pesan }}
                                        </td>

                                        <td>
                                            <a href="{{ route('admin.pemesanans.show', $item->id) }}">
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-6">
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
