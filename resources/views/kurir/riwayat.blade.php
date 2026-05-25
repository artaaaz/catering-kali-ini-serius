@extends('layouts.kurir')

@section('page-title', 'Riwayat Pengiriman')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <h1 class="text-2xl font-bold text-gray-800">Riwayat Pengiriman</h1>
            <p class="text-gray-500 mt-1">Daftar semua pengiriman yang telah Anda lakukan</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if($pengirimans->count() > 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Resi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pelanggan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Alamat</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Kirim</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bukti</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($pengirimans as $pengiriman)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                    {{ $pengiriman->pemesanan->no_resi ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ $pengiriman->pemesanan->pelanggan->name ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ Str::limit($pengiriman->pemesanan->alamat_pengiriman ?? '-', 40) }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                                        @if($pengiriman->status_kirim == 'Sedang Dikirim') bg-blue-100 text-blue-700
                                        @elseif($pengiriman->status_kirim == 'Tiba Ditujuan') bg-green-100 text-green-700
                                        @else bg-gray-100 text-gray-700 @endif">
                                        {{ $pengiriman->status_kirim }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ $pengiriman->tgl_kirim ? \Carbon\Carbon::parse($pengiriman->tgl_kirim)->format('d M Y') : '-' }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    @if($pengiriman->bukti_foto)
                                        <a href="{{ asset('storage/' . $pengiriman->bukti_foto) }}"
                                           target="_blank"
                                           class="text-blue-600 hover:text-blue-800">
                                            <i class="fas fa-image"></i> Lihat
                                        </a>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                <i class="fas fa-history text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Belum Ada Riwayat</h3>
                <p class="text-gray-500 mb-6">Anda belum memiliki riwayat pengiriman</p>
                <a href="{{ route('kurir.pengiriman') }}"
                   class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-truck"></i>
                    Lihat Tugas Pengiriman
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

