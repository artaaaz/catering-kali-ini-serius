<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Paket Catering') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Hero Section -->
            <div class="hero-header rounded-lg mb-8">
                <h1>Pilih Paket Catering Terbaik</h1>
                <p>Untuk acara pernikahan, ulang tahun, rapat, dan lainnya</p>
            </div>

            <!-- Grid Paket -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($pakets as $paket)
                    <div class="paket-card">
                        <!-- Foto Paket -->
                        <div class="mb-4">
                            @if($paket->foto1)
                                <img src="{{ asset('storage/' . $paket->foto1) }}" alt="{{ $paket->nama_paket }}">
                            @else
                                <div class="w-full h-48 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400">
                                    <span>No Image</span>
                                </div>
                            @endif
                        </div>

                        <!-- Badge Jenis -->
                        <span class="paket-badge">{{ $paket->jenis }}</span>

                        <!-- Nama Paket -->
                        <h3 class="paket-title">{{ $paket->nama_paket }}</h3>
                        
                        <!-- Info -->
                        <p class="paket-info">
                            {{ $paket->kategori }} • {{ $paket->jumlah_pax }} Pax
                        </p>
                        
                        <!-- Deskripsi -->
                        <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                            {{ $paket->deskripsi }}
                        </p>

                        <!-- Harga -->
                        <div class="paket-price">
                            Rp {{ number_format($paket->harga_paket, 0, ',', '.') }}
                        </div>

                        <!-- Tombol Pesan -->
                        <a href="{{ route('pelanggan.pesan.create', ['paket' => $paket->id]) }}" 
                           class="btn-primary-blue">
                            Pesan Sekarang
                        </a>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-12">
                        <p class="text-gray-500 text-lg">Belum ada paket catering tersedia.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>