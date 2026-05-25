@extends('layouts.admin')

@section('page-title', 'Daftar Pesanan')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <!-- Header & Filter -->
    <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
        <h2 class="text-lg font-semibold text-gray-800">Transaksi Pesanan</h2>
        <div class="flex gap-3 w-full md:w-auto">
            <input type="text" id="searchPesanan" placeholder="Cari no resi / pelanggan..." class="px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition w-full md:w-64">
            <select id="filterStatus" class="px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 bg-white text-gray-700">
                <option value="">Semua Status</option>
                <option value="Menunggu Konfirmasi">Menunggu Konfirmasi</option>
                <option value="Sedang Diproses">Sedang Diproses</option>
                <option value="Menunggu Kurir">Menunggu Kurir</option>
                <option value="Selesai">Selesai</option>
            </select>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-600 text-sm uppercase tracking-wider">
                    <th class="px-6 py-4 font-semibold">No. Resi</th>
                    <th class="px-6 py-4 font-semibold">Pelanggan</th>
                    <th class="px-6 py-4 font-semibold">Paket</th>
                    <th class="px-6 py-4 font-semibold">Total</th>
                    <th class="px-6 py-4 font-semibold text-center">Status</th>
                    <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                @forelse($pemesanans as $pemesanan)
                    <tr class="hover:bg-gray-50 transition" data-status="{{ $pemesanan->status_pesan }}">
                        <td class="px-6 py-4 font-mono font-bold text-gray-800">{{ $pemesanan->no_resi }}</td>
                        <td class="px-6 py-4">
                            <div class="font-semibold text-gray-900">{{ $pemesanan->pelanggan->nama_pelanggan ?? 'Umum' }}</div>
                            <div class="text-xs text-gray-500">{{ $pemesanan->pelanggan->email ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 max-w-xs truncate">
                            @foreach($pemesanan->pakets as $p)
                                <span class="block">{{ $p->nama_paket }}</span>
                            @endforeach
                        </td>
                        <td class="px-6 py-4 font-bold text-gray-900">Rp {{ number_format($pemesanan->total_bayar, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $class = 'bg-gray-100 text-gray-600';
                                $status = $pemesanan->status_pesan;
                                if(str_contains($status, 'Menunggu')) $class = 'bg-yellow-100 text-yellow-700';
                                if(str_contains($status, 'Diproses')) $class = 'bg-blue-100 text-blue-700';
                                if(str_contains($status, 'Kurir')) $class = 'bg-purple-100 text-purple-700';
                                if($status == 'Selesai') $class = 'bg-green-100 text-green-700';
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $class }}">
                                {{ $status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('admin.pemesanans.show', $pemesanan->id) }}" class="p-2 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.pemesanans.edit', $pemesanan->id) }}" class="p-2 bg-yellow-100 text-yellow-600 rounded-lg hover:bg-yellow-200 transition" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-clipboard-list text-4xl mb-3 text-gray-300"></i>
                            <p>Belum ada transaksi pesanan</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const searchInput = document.getElementById('searchPesanan');
    const filterSelect = document.getElementById('filterStatus');

    function filterTable() {
        const term = searchInput.value.toLowerCase();
        const status = filterSelect.value;

        document.querySelectorAll('tbody tr').forEach(row => {
            const textMatch = row.textContent.toLowerCase().includes(term);
            const statusMatch = !status || row.dataset.status === status;
            row.style.display = (textMatch && statusMatch) ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', filterTable);
    filterSelect.addEventListener('change', filterTable);
</script>
@endpush
