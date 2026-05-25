@extends('layouts.kurir')

@section('page-title', 'Dashboard Kurir')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <h1 class="text-2xl font-bold text-gray-800">Dashboard Kurir</h1>
            <p class="text-gray-500 mt-1">Selamat datang, {{ Auth::user()->name }}</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total Pengiriman -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Pengiriman</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalPengiriman }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-truck text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Sedang Dikirim -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Sedang Dikirim</p>
                        <p class="text-3xl font-bold text-blue-600 mt-2">{{ $sedangDikirim }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-shipping-fast text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Selesai -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Selesai</p>
                        <p class="text-3xl font-bold text-green-600 mt-2">{{ $selesai }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Aksi Cepat</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('kurir.pengiriman') }}"
                   class="flex items-center gap-4 p-4 bg-blue-50 hover:bg-blue-100 rounded-lg transition border border-blue-200">
                    <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-tasks text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900">Tugas Pengiriman</h3>
                        <p class="text-sm text-gray-600">Lihat & update status pengiriman</p>
                    </div>
                </a>

                <a href="{{ route('kurir.riwayat') }}"
                   class="flex items-center gap-4 p-4 bg-green-50 hover:bg-green-100 rounded-lg transition border border-green-200">
                    <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-history text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900">Riwayat Pengiriman</h3>
                        <p class="text-sm text-gray-600">Lihat riwayat pengiriman Anda</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Recent Deliveries -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Pengiriman Terbaru</h2>

            @if($recentPengiriman->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Resi</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pelanggan</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Alamat</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($recentPengiriman as $pengiriman)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                    {{ $pengiriman->pemesanan->no_resi ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700">
                                    {{ $pengiriman->pemesanan->pelanggan->name ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700">
                                    {{ Str::limit($pengiriman->pemesanan->alamat_pengiriman ?? '-', 30) }}
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                                        @if($pengiriman->status_kirim == 'Sedang Dikirim') bg-blue-100 text-blue-700
                                        @elseif($pengiriman->status_kirim == 'Tiba Ditujuan') bg-green-100 text-green-700
                                        @else bg-gray-100 text-gray-700 @endif">
                                        {{ $pengiriman->status_kirim }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700">
                                    {{ $pengiriman->tgl_kirim ? \Carbon\Carbon::parse($pengiriman->tgl_kirim)->format('d M Y') : '-' }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-inbox text-4xl text-gray-300 mb-2"></i>
                    <p>Belum ada data pengiriman</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

