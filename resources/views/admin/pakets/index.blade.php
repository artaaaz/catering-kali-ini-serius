@extends('layouts.admin')

@section('page-title', 'Kelola Paket')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <!-- Header & Search -->
    <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
        <h2 class="text-lg font-semibold text-gray-800">Daftar Menu Paket</h2>
        <div class="flex gap-3 w-full md:w-auto">
            <input type="text" id="searchPaket" placeholder="Cari paket..." class="px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition w-full md:w-64">
            <a href="{{ route('admin.pakets.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition flex items-center gap-2 whitespace-nowrap shadow-sm">
                <i class="fas fa-plus"></i> Tambah Paket
            </a>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-600 text-sm uppercase tracking-wider">
                    <th class="px-6 py-4 font-semibold">No</th>
                    <th class="px-6 py-4 font-semibold">Foto</th>
                    <th class="px-6 py-4 font-semibold">Nama Paket</th>
                    <th class="px-6 py-4 font-semibold">Jenis</th>
                    <th class="px-6 py-4 font-semibold">Kategori</th>
                    <th class="px-6 py-4 font-semibold text-center">Pax</th>
                    <th class="px-6 py-4 font-semibold text-right">Harga</th>
                    <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                @forelse($pakets as $index => $paket)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $index + 1 }}</td>
                        <td class="px-6 py-4">
                            @if($paket->foto1)
                                <img src="{{ asset('storage/' . $paket->foto1) }}" alt="{{ $paket->nama_paket }}" class="w-12 h-12 object-cover rounded-lg shadow-sm border border-gray-200">
                            @else
                                <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-800">{{ $paket->nama_paket }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-md text-xs font-semibold bg-blue-100 text-blue-700">{{ $paket->jenis }}</span>
                        </td>
                        <td class="px-6 py-4">{{ $paket->kategori }}</td>
                        <td class="px-6 py-4 text-center">{{ $paket->jumlah_pax }}</td>
                        <td class="px-6 py-4 text-right font-bold text-gray-900">Rp {{ number_format($paket->harga_paket, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('admin.pakets.edit', $paket->id) }}" class="p-2 bg-yellow-100 text-yellow-600 rounded-lg hover:bg-yellow-200 transition" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('admin.pakets.destroy', $paket->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-box-open text-4xl mb-3 text-gray-300"></i>
                            <p>Belum ada data paket</p>
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
    document.getElementById('searchPaket').addEventListener('input', function(e) {
        const val = e.target.value.toLowerCase();
        document.querySelectorAll('tbody tr').forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(val) ? '' : 'none';
        });
    });
</script>
@endpush