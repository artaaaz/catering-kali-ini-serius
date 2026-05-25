@extends('layouts.kurir')

@section('page-title', 'Tugas Pengiriman')

@section('content')
<div class="min-h-screen bg-grid py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">
                    <i class="fas fa-truck-loading text-blue-600 mr-3"></i>
                    Tugas Pengiriman
                </h1>
                <p class="text-gray-500 mt-1 ml-11">Daftar pesanan yang siap diantar hari ini.</p>
            </div>

            <!-- Stats Summary -->
            <div class="flex gap-3">
                <div class="bg-white px-4 py-2 rounded-xl border border-blue-100 shadow-sm flex items-center gap-2">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-list text-blue-600 text-xs"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Total Tugas</p>
                        <p class="font-bold text-gray-900">{{ $pemesanans->count() }}</p>
                    </div>
                </div>
                <div class="bg-white px-4 py-2 rounded-xl border border-yellow-100 shadow-sm flex items-center gap-2">
                    <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-yellow-600 text-xs"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Menunggu</p>
                        <p class="font-bold text-gray-900">{{ $pemesanans->where('status_pesan', 'Menunggu Kurir')->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Task List -->
        <div class="space-y-6">
            @forelse($pemesanans as $pemesanan)
                <!-- Task Card -->
                <div class="bg-white rounded-2xl border border-blue-100 shadow-sm overflow-hidden hover:shadow-md transition-all duration-300 group">

                    <!-- Card Header: Resi & Status -->
                    <div class="bg-gradient-to-r from-gray-50 to-white px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div>
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Nomor Resi</span>
                            <h3 class="text-xl font-bold text-gray-900 font-mono tracking-wide">{{ $pemesanan->no_resi }}</h3>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1.5 rounded-full text-xs font-bold border
                                @if($pemesanan->status_pesan == 'Menunggu Kurir') bg-yellow-50 text-yellow-700 border-yellow-200
                                @elseif($pemesanan->status_pesan == 'Sedang Dikirim') bg-blue-50 text-blue-700 border-blue-200
                                @else bg-gray-50 text-gray-600 border-gray-200 @endif">
                                @if($pemesanan->status_pesan == 'Menunggu Kurir')
                                    <i class="fas fa-hourglass-half mr-1"></i> Menunggu Kurir
                                @elseif($pemesanan->status_pesan == 'Sedang Dikirim')
                                    <i class="fas fa-shipping-fast mr-1"></i> Sedang Dikirim
                                @else
                                    {{ $pemesanan->status_pesan }}
                                @endif
                            </span>
                            <span class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($pemesanan->tgl_acara)->format('d M Y') }}</span>
                        </div>
                    </div>

                    <!-- Card Body: Details -->
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">

                        <!-- Left: Address & Customer -->
                        <div class="space-y-4">
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase mb-1">Tujuan Pengiriman</p>
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                        <i class="fas fa-map-marker-alt text-red-500"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-900 text-lg">{{ $pemesanan->pelanggan->name }}</h4>
                                        <p class="text-gray-600 leading-relaxed mt-1">{{ $pemesanan->alamat_pengiriman }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Button -->
                            <div class="pt-2">
                                <a href="https://wa.me/{{ $pemesanan->pelanggan->phone ?? '628123456789' }}" target="_blank"
                                   class="inline-flex items-center gap-2 px-4 py-2 bg-green-50 text-green-700 rounded-lg text-sm font-medium hover:bg-green-100 transition border border-green-200">
                                    <i class="fab fa-whatsapp text-lg"></i> Hubungi Pelanggan
                                </a>
                            </div>
                        </div>

                        <!-- Right: Order Info -->
                        <div class="space-y-4 bg-blue-50/50 p-4 rounded-xl border border-blue-100/50">
                            <div class="flex justify-between items-center pb-3 border-b border-blue-100">
                                <span class="text-sm text-gray-500">Total Paket</span>
                                <span class="font-bold text-gray-900">{{ $pemesanan->jumlah_pax }} Pax</span>
                            </div>
                            <div class="flex justify-between items-center pb-3 border-b border-blue-100">
                                <span class="text-sm text-gray-500">Total Pembayaran</span>
                                <span class="font-bold text-blue-700 text-lg">Rp {{ number_format($pemesanan->total_bayar, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500">Paket</span>
                                <span class="font-medium text-gray-900 text-sm text-right">
                                    @foreach($pemesanan->pakets as $paket)
                                        {{ $paket->nama_paket }}<br>
                                    @endforeach
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Card Footer: Actions -->
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <p class="text-xs text-gray-500 italic">
                            <i class="fas fa-info-circle mr-1"></i> Pastikan barang sudah lengkap sebelum diantar.
                        </p>

                        <!-- ACTION BUTTONS LOGIC -->
                        @if($pemesanan->status_pesan == 'Menunggu Kurir')
                            <!-- Action 1: Start Delivery -->
                            <form action="{{ route('kurir.pengiriman.status', $pemesanan->id) }}" method="POST" class="w-full sm:w-auto">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status_kirim" value="Sedang Dikirim">
                                <button type="submit"
                                        class="w-full sm:w-auto px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all duration-300 shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                                    <i class="fas fa-motorcycle"></i> Ambil Pesanan (Mulai Kirim)
                                </button>
                            </form>
                        @elseif($pemesanan->status_pesan == 'Sedang Dikirim')
                            <!-- Action 2: Upload Proof -->
                            <div class="w-full">
                                <form action="{{ route('kurir.pengiriman.bukti', $pemesanan->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col sm:flex-row gap-3">
                                    @csrf
                                    <div class="relative flex-1">
                                        <input type="file" name="bukti_foto" id="bukti_{{ $pemesanan->id }}" required class="hidden">
                                        <label for="bukti_{{ $pemesanan->id }}"
                                               class="block w-full px-4 py-3 border-2 border-dashed border-blue-300 rounded-xl text-center cursor-pointer hover:bg-blue-50 hover:border-blue-500 transition bg-white">
                                            <span class="text-sm text-gray-600 font-medium" id="label_{{ $pemesanan->id }}">
                                                <i class="fas fa-camera mr-2"></i> Upload Foto Bukti Pengiriman
                                            </span>
                                        </label>
                                    </div>
                                    <button type="submit"
                                            class="px-8 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition-all duration-300 shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                                        <i class="fas fa-check-circle"></i> Selesai & Upload
                                    </button>
                                </form>
                            </div>
                        @else
                            <span class="px-4 py-2 bg-green-100 text-green-700 rounded-lg font-bold text-sm">
                                <i class="fas fa-flag-checkered mr-2"></i> Pesanan Selesai
                            </span>
                        @endif
                    </div>
                </div>
            @empty
                <!-- Empty State -->
                <div class="bg-white rounded-2xl border border-blue-100 p-16 text-center shadow-sm">
                    <div class="w-24 h-24 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-clipboard-check text-4xl text-blue-300"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Tidak Ada Tugas</h3>
                    <p class="text-gray-500 max-w-md mx-auto">
                        Anda tidak memiliki tugas pengiriman saat ini. Silakan tunggu penugasan dari admin atau cek kembali nanti.
                    </p>
                </div>
            @endforelse
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Script untuk update label saat file dipilih
    document.querySelectorAll('input[type="file"]').forEach(input => {
        input.addEventListener('change', function() {
            const fileName = this.files[0]?.name || 'Upload Foto Bukti Pengiriman';
            const label = document.getElementById('label_' + this.id.split('_')[1]);
            label.innerHTML = `<i class="fas fa-image mr-2"></i> ${fileName}`;
            label.classList.add('text-blue-700', 'border-blue-500');
        });
    });
</script>
@endpush
@endsection
