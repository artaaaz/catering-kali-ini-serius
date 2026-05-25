@extends('layouts.frontend')

@section('page-title', 'Riwayat Pesanan')

@section('content')
<div class="min-h-screen bg-grid py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Riwayat Pesanan</h1>
                    <p class="text-gray-600">Pantau status pesanan catering Anda dengan mudah</p>
                </div>
                <a href="{{ route('pakets.index') }}"
                   class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition shadow-sm hover:shadow-md">
                    <i class="fas fa-plus mr-2"></i> Pesan Baru
                </a>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg animate-fade-in">
                <div class="flex items-center gap-3">
                    <i class="fas fa-check-circle text-green-500 text-xl"></i>
                    <span class="text-green-800 font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <!-- Orders List -->
        @if($pemesanans->count() > 0)
            <div class="space-y-6">
                @foreach($pemesanans as $pemesanan)
                    <div class="bg-white rounded-2xl border border-blue-100 overflow-hidden hover:border-blue-300 transition-all duration-300 hover:shadow-lg">
                        <!-- Card Header -->
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-blue-100">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-receipt text-white"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-900">{{ $pemesanan->no_resi }}</h3>
                                        <p class="text-sm text-gray-600">
                                            <i class="far fa-clock mr-1"></i>
                                            {{ \Carbon\Carbon::parse($pemesanan->created_at)->format('d M Y, H:i') }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Status Badge -->
                                <span class="px-4 py-2 rounded-full text-xs font-bold
                                    @if($pemesanan->status_pesan == 'Menunggu Konfirmasi')
                                        bg-yellow-100 text-yellow-700 border border-yellow-300
                                    @elseif($pemesanan->status_pesan == 'Sedang Diproses')
                                        bg-blue-100 text-blue-700 border border-blue-300
                                    @elseif($pemesanan->status_pesan == 'Menunggu Kurir')
                                        bg-purple-100 text-purple-700 border border-purple-300
                                    @elseif($pemesanan->status_pesan == 'Sedang Dikirim')
                                        bg-orange-100 text-orange-700 border border-orange-300
                                    @elseif($pemesanan->status_pesan == 'Selesai')
                                        bg-green-100 text-green-700 border border-green-300
                                    @else
                                        bg-gray-100 text-gray-700 border border-gray-300
                                    @endif">
                                    @if($pemesanan->status_pesan == 'Menunggu Konfirmasi')
                                        <i class="far fa-clock mr-1"></i> Menunggu Konfirmasi
                                    @elseif($pemesanan->status_pesan == 'Sedang Diproses')
                                        <i class="fas fa-cog fa-spin mr-1"></i> Sedang Diproses
                                    @elseif($pemesanan->status_pesan == 'Menunggu Kurir')
                                        <i class="fas fa-user-clock mr-1"></i> Menunggu Kurir
                                    @elseif($pemesanan->status_pesan == 'Sedang Dikirim')
                                        <i class="fas fa-shipping-fast mr-1"></i> Sedang Dikirim
                                    @elseif($pemesanan->status_pesan == 'Selesai')
                                        <i class="fas fa-check-circle mr-1"></i> Selesai
                                    @else
                                        {{ $pemesanan->status_pesan }}
                                    @endif
                                </span>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                                <!-- Total Pembayaran -->
                                <div class="bg-blue-50 rounded-xl p-4 border border-blue-100">
                                    <p class="text-sm text-gray-600 mb-1">
                                        <i class="fas fa-wallet mr-1"></i> Total Pembayaran
                                    </p>
                                    <p class="text-2xl font-bold text-blue-700">
                                        Rp {{ number_format($pemesanan->total_bayar, 0, ',', '.') }}
                                    </p>
                                </div>

                                <!-- Tanggal Acara -->
                                <div class="bg-indigo-50 rounded-xl p-4 border border-indigo-100">
                                    <p class="text-sm text-gray-600 mb-1">
                                        <i class="far fa-calendar-alt mr-1"></i> Tanggal Acara
                                    </p>
                                    <p class="text-lg font-semibold text-indigo-700">
                                        {{ \Carbon\Carbon::parse($pemesanan->tgl_acara)->format('d M Y') }}
                                    </p>
                                </div>

                                <!-- Jumlah Pax -->
                                <div class="bg-purple-50 rounded-xl p-4 border border-purple-100">
                                    <p class="text-sm text-gray-600 mb-1">
                                        <i class="fas fa-users mr-1"></i> Jumlah Pax
                                    </p>
                                    <p class="text-lg font-semibold text-purple-700">
                                        {{ $pemesanan->jumlah_pax }} Orang
                                    </p>
                                </div>
                            </div>

                            <!-- Alamat -->
                            <div class="mb-6">
                                <p class="text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-map-marker-alt text-red-500 mr-1"></i> Alamat Pengiriman
                                </p>
                                <p class="text-gray-600 bg-gray-50 rounded-lg p-3 border border-gray-200">
                                    {{ $pemesanan->alamat_pengiriman }}
                                </p>
                            </div>

                            <!-- Paket Details (if available) -->
                            @if($pemesanan->pakets->count() > 0)
                                <div class="mb-6">
                                    <p class="text-sm font-semibold text-gray-700 mb-3">
                                        <i class="fas fa-box text-blue-500 mr-1"></i> Paket yang Dipesan
                                    </p>
                                    <div class="space-y-2">
                                        @foreach($pemesanan->pakets as $paket)
                                            <div class="flex items-center justify-between bg-blue-50/50 rounded-lg p-3 border border-blue-100">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                                        <i class="fas fa-utensils text-blue-600 text-sm"></i>
                                                    </div>
                                                    <span class="font-medium text-gray-900">{{ $paket->nama_paket }}</span>
                                                </div>
                                                <span class="text-sm font-semibold text-blue-700">
                                                    Rp {{ number_format($paket->harga_paket, 0, ',', '.') }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Actions -->
                            <div class="flex gap-3 pt-4 border-t border-blue-100">
                                <a href="{{ route('pelanggan.pemesanan.show', $pemesanan->id) }}"
                                   class="inline-flex items-center px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition shadow-sm hover:shadow-md">
                                    <i class="fas fa-eye mr-2"></i> Lihat Detail Pesanan
                                </a>

                                @if($pemesanan->status_pesan == 'Menunggu Konfirmasi')
                                    <button class="inline-flex items-center px-6 py-2.5 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-xl transition shadow-sm hover:shadow-md">
                                        <i class="fas fa-edit mr-2"></i> Edit Pesanan
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($pemesanans->hasPages())
                <div class="mt-8 flex justify-center">
                    {{ $pemesanans->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-2xl border border-blue-100 p-12 text-center">
                <div class="w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-clipboard-list text-5xl text-blue-500"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Belum Ada Pesanan</h3>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">
                    Anda belum memiliki pesanan. Yuk, pesan catering untuk acara spesial Anda sekarang!
                </p>
                <a href="{{ route('pakets.index') }}"
                   class="inline-flex items-center px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition shadow-sm hover:shadow-md">
                    <i class="fas fa-shopping-cart mr-2"></i> Lihat Paket Catering
                </a>
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
    .animate-fade-in {
        animation: fadeIn 0.5s ease-in;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endpush
@endsection
