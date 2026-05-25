@extends('layouts.admin')

@section('page-content')
<div class="min-h-screen bg-gray-50">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-800 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold">Dashboard Admin</h1>
                    <p class="mt-2 text-blue-100">Kelola sistem catering dengan mudah dan efisien</p>
                </div>
                <div class="text-right hidden md:block">
                    <p class="text-sm text-blue-100">Hari Ini</p>
                    <p class="text-lg font-semibold">{{ \Carbon\Carbon::now()->format('d M Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Paket -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-blue-500 hover:shadow-xl transition transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Total Paket</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $totalPaket }}</p>
                        <p class="text-xs text-green-600 mt-2 flex items-center gap-1">
                            <i class="fas fa-arrow-up"></i> Aktif
                        </p>
                    </div>
                    <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-box text-blue-600 text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Pesanan Baru -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-yellow-500 hover:shadow-xl transition transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Pesanan Baru</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $pesananBaru }}</p>
                        <p class="text-xs text-yellow-600 mt-2 flex items-center gap-1">
                            <i class="fas fa-clock"></i> Menunggu
                        </p>
                    </div>
                    <div class="w-14 h-14 bg-yellow-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-shopping-cart text-yellow-600 text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Total Pelanggan -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-purple-500 hover:shadow-xl transition transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Total Pelanggan</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $totalPelanggan }}</p>
                        <p class="text-xs text-purple-600 mt-2 flex items-center gap-1">
                            <i class="fas fa-users"></i> Terdaftar
                        </p>
                    </div>
                    <div class="w-14 h-14 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user-friends text-purple-600 text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Pendapatan -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-green-500 hover:shadow-xl transition transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Pendapatan</p>
                        <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($pendapatan / 1000000, 1) }}jt</p>
                        <p class="text-xs text-green-600 mt-2 flex items-center gap-1">
                            <i class="fas fa-chart-line"></i> Total
                        </p>
                    </div>
                    <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-wallet text-green-600 text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions & Recent Orders -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <i class="fas fa-bolt text-yellow-500"></i>
                    Aksi Cepat
                </h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.pakets.index') }}"
                       class="flex items-center gap-3 p-3 bg-blue-50 hover:bg-blue-100 rounded-xl transition group">
                        <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition">
                            <i class="fas fa-box text-white"></i>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900">Kelola Paket</p>
                            <p class="text-xs text-gray-600">Tambah/Edit paket</p>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400"></i>
                    </a>

                    <a href="{{ route('admin.pemesanans.index') }}"
                       class="flex items-center gap-3 p-3 bg-yellow-50 hover:bg-yellow-100 rounded-xl transition group">
                        <div class="w-10 h-10 bg-yellow-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition">
                            <i class="fas fa-shopping-cart text-white"></i>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900">Lihat Pesanan</p>
                            <p class="text-xs text-gray-600">{{ $pesananBaru }} pesanan baru</p>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400"></i>
                    </a>

                    <a href="#"
                       class="flex items-center gap-3 p-3 bg-purple-50 hover:bg-purple-100 rounded-xl transition group">
                        <div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition">
                            <i class="fas fa-user-plus text-white"></i>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900">Tambah Pelanggan</p>
                            <p class="text-xs text-gray-600">Daftar pelanggan baru</p>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400"></i>
                    </a>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-clock text-blue-500"></i>
                        Pesanan Terbaru
                    </h3>
                    <a href="{{ route('admin.pemesanans.index') }}"
                       class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                        Lihat Semua →
                    </a>
                </div>

                @if($recentOrders->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 uppercase">No. Resi</th>
                                    <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 uppercase">Pelanggan</th>
                                    <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 uppercase">Total</th>
                                    <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 uppercase">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders->take(5) as $order)
                                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                    <td class="py-3 px-4">
                                        <span class="font-semibold text-gray-900 text-sm">{{ $order->no_resi }}</span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                                {{ strtoupper(substr($order->pelanggan->name ?? 'U', 0, 1)) }}
                                            </div>
                                            <span class="text-sm text-gray-700">{{ Str::limit($order->pelanggan->name ?? 'User', 20) }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="font-semibold text-gray-900">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="px-3 py-1 rounded-full text-xs font-bold
                                            @if($order->status_pesan == 'Menunggu Konfirmasi') bg-yellow-100 text-yellow-700
                                            @elseif($order->status_pesan == 'Sedang Diproses') bg-blue-100 text-blue-700
                                            @elseif($order->status_pesan == 'Selesai') bg-green-100 text-green-700
                                            @else bg-gray-100 text-gray-700 @endif">
                                            {{ $order->status_pesan }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-12 text-gray-500">
                        <i class="fas fa-inbox text-5xl text-gray-300 mb-3"></i>
                        <p>Belum ada pesanan</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Chart Section (Optional - bisa ditambahin nanti) -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-chart-line text-green-500"></i>
                Statistik Pesanan (7 Hari Terakhir)
            </h3>
            <div class="h-64 bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl flex items-center justify-center">
                <div class="text-center text-gray-500">
                    <i class="fas fa-chart-area text-6xl mb-3"></i>
                    <p>Chart akan ditampilkan di sini</p>
                    <p class="text-sm">(Install Chart.js untuk visualisasi)</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Animation on load
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.transform');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            setTimeout(() => {
                card.style.transition = 'all 0.5s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
    });
</script>
@endpush
