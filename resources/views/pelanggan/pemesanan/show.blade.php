@extends('layouts.frontend')

@section('page-title', 'Detail Pesanan ' . $pemesanan->no_resi)

@section('content')
<div class="min-h-screen bg-grid py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Navigation & Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <a href="{{ route('pelanggan.riwayat') }}"
                   class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-medium mb-2 transition group">
                    <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
                    Kembali ke Riwayat
                </a>
                <h1 class="text-3xl font-bold text-gray-900">Detail Pesanan</h1>
                <p class="text-gray-600 mt-1">Nomor Resi: <span class="font-mono font-bold text-blue-700">{{ $pemesanan->no_resi }}</span></p>
            </div>

            <!-- Status Badge -->
            <div class="flex-shrink-0">
                <span class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-bold shadow-sm
                    @if($pemesanan->status_pesan == 'Menunggu Konfirmasi') bg-yellow-100 text-yellow-700 border border-yellow-200
                    @elseif($pemesanan->status_pesan == 'Sedang Diproses') bg-blue-100 text-blue-700 border border-blue-200
                    @elseif($pemesanan->status_pesan == 'Menunggu Kurir') bg-purple-100 text-purple-700 border border-purple-200
                    @elseif($pemesanan->status_pesan == 'Sedang Dikirim') bg-orange-100 text-orange-700 border border-orange-200
                    @elseif($pemesanan->status_pesan == 'Selesai') bg-green-100 text-green-700 border border-green-200
                    @else bg-gray-100 text-gray-700 border border-gray-200 @endif">
                    @if($pemesanan->status_pesan == 'Sedang Diproses')
                        <i class="fas fa-spinner fa-spin"></i>
                    @elseif($pemesanan->status_pesan == 'Selesai')
                        <i class="fas fa-check-circle"></i>
                    @else
                        <i class="far fa-clock"></i>
                    @endif
                    {{ $pemesanan->status_pesan }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Left Column: Order Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Info Card -->
                <div class="bg-white rounded-2xl border border-blue-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-blue-100 bg-blue-50/50 flex items-center gap-2">
                        <i class="fas fa-clipboard-list text-blue-600"></i>
                        <h2 class="font-bold text-gray-900">Informasi Pesanan</h2>
                    </div>
                    <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Tanggal Pesan</p>
                            <p class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($pemesanan->created_at)->format('d M Y, H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Tanggal Acara</p>
                            <p class="font-semibold text-blue-700 bg-blue-50 inline-block px-2 py-1 rounded">
                                {{ \Carbon\Carbon::parse($pemesanan->tgl_acara)->format('d M Y') }}
                            </p>
                        </div>
                        <div class="sm:col-span-2">
                            <p class="text-sm text-gray-500 mb-1">Alamat Pengiriman</p>
                            <div class="flex items-start gap-3 bg-gray-50 p-3 rounded-lg border border-gray-200">
                                <i class="fas fa-map-marker-alt text-red-500 mt-1"></i>
                                <p class="text-gray-700 font-medium leading-relaxed">{{ $pemesanan->alamat_pengiriman }}</p>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Jumlah Pax</p>
                            <p class="font-bold text-xl text-gray-900">{{ $pemesanan->jumlah_pax }} Orang</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Total Pembayaran</p>
                            <p class="font-bold text-xl text-blue-700">Rp {{ number_format($pemesanan->total_bayar, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Paket List -->
                @if($pemesanan->pakets->count() > 0)
                <div class="bg-white rounded-2xl border border-blue-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-blue-100 bg-blue-50/50 flex items-center gap-2">
                        <i class="fas fa-box text-blue-600"></i>
                        <h2 class="font-bold text-gray-900">Item Paket</h2>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @foreach($pemesanan->pakets as $paket)
                        <div class="p-6 flex flex-col sm:flex-row gap-4 items-start sm:items-center">
                            <div class="w-20 h-20 flex-shrink-0 bg-blue-100 rounded-xl overflow-hidden">
                                @if($paket->foto1)
                                    <img src="{{ asset('storage/' . $paket->foto1) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i class="fas fa-utensils text-blue-400"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <h3 class="font-bold text-gray-900 text-lg">{{ $paket->nama_paket }}</h3>
                                <p class="text-sm text-gray-600">{{ $paket->jenis }} • {{ $paket->kategori }}</p>
                                <p class="text-sm text-gray-500 mt-1 line-clamp-1">{{ $paket->deskripsi ?? '-' }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-blue-700">Rp {{ number_format($paket->harga_paket, 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-500">per paket</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Column: Payment & Status -->
            <div class="lg:col-span-1 space-y-6">

                <!-- Payment Proof -->
                <div class="bg-white rounded-2xl border border-blue-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-blue-100 bg-green-50/50 flex items-center gap-2">
                        <i class="fas fa-wallet text-green-600"></i>
                        <h2 class="font-bold text-gray-900">Pembayaran</h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Metode</span>
                            <span class="font-semibold text-gray-900">{{ $pemesanan->jenisPembayaran->metode_pembayaran ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Total Bayar</span>
                            <span class="font-bold text-xl text-green-600">Rp {{ number_format($pemesanan->total_bayar, 0, ',', '.') }}</span>
                        </div>

                        @if($pemesanan->bukti_bayar)
                            <div class="mt-4">
                                <p class="text-sm text-gray-500 mb-2">Bukti Pembayaran:</p>
                                <div class="relative group rounded-xl overflow-hidden border border-gray-200">
                                    <img src="{{ asset('storage/' . $pemesanan->bukti_bayar) }}"
                                         alt="Bukti Bayar"
                                         class="w-full h-auto transition-transform duration-500 group-hover:scale-105">
                                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors"></div>
                                </div>
                            </div>
                        @else
                            <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg text-center">
                                <i class="fas fa-exclamation-circle text-yellow-500 mb-2"></i>
                                <p class="text-sm text-yellow-700 font-medium">Bukti pembayaran belum diupload</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Status Timeline -->
                <div class="bg-white rounded-2xl border border-blue-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-blue-100 bg-blue-50/50 flex items-center gap-2">
                        <i class="fas fa-stream text-blue-600"></i>
                        <h2 class="font-bold text-gray-900">Progress Pesanan</h2>
                    </div>
                    <div class="p-6">
                        <div class="relative pl-8 border-l-2 border-gray-200 space-y-6">

                            <!-- Step 1 -->
                            <div class="relative">
                                <div class="absolute -left-[41px] bg-blue-600 w-6 h-6 rounded-full border-4 border-white shadow-sm flex items-center justify-center">
                                    <i class="fas fa-check text-white text-[10px]"></i>
                                </div>
                                <p class="font-bold text-gray-900">Pesanan Dibuat</p>
                                <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($pemesanan->created_at)->format('d M, H:i') }}</p>
                            </div>

                            <!-- Step 2 -->
                            <div class="relative opacity-50">
                                <div class="absolute -left-[41px] bg-gray-300 w-6 h-6 rounded-full border-4 border-white shadow-sm"></div>
                                <p class="font-bold text-gray-900">Sedang Diproses</p>
                                <p class="text-xs text-gray-500">Menunggu verifikasi admin</p>
                            </div>

                            <!-- Step 3 -->
                            <div class="relative opacity-50">
                                <div class="absolute -left-[41px] bg-gray-300 w-6 h-6 rounded-full border-4 border-white shadow-sm"></div>
                                <p class="font-bold text-gray-900">Pengiriman</p>
                                <p class="text-xs text-gray-500">Kurir dalam perjalanan</p>
                            </div>

                            <!-- Step 4 -->
                            <div class="relative opacity-50">
                                <div class="absolute -left-[41px] bg-gray-300 w-6 h-6 rounded-full border-4 border-white shadow-sm"></div>
                                <p class="font-bold text-gray-900">Selesai</p>
                                <p class="text-xs text-gray-500">Pesanan diterima</p>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
