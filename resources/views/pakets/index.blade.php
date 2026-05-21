<x-app-layout>
    <!-- Panggil CSS Custom -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pilih Paket Catering') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Container Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                @foreach($pakets as $paket)
                    <!-- INI CARD PAKET -->
                    <div class="paket-card p-6 hover:shadow-lg transition-shadow duration-300">
                        
                        <!-- Foto Paket (Kalau ada) -->
                        <div class="h-48 w-full bg-gray-200 rounded-lg mb-4 overflow-hidden">
                            @if($paket->foto1)
                                <img src="{{ asset('storage/' . $paket->foto1) }}" class="w-full h-full object-cover">
                            @else
                                <div class="flex items-center justify-center h-full text-gray-400">No Image</div>
                            @endif
                        </div>

                        <!-- Badge Jenis (Biru) -->
                        <span class="inline-block px-3 py-1 mb-2 text-xs font-semibold text-white rounded-full"
                              style="background-color: var(--primary-blue);">
                            {{ $paket->jenis }}
                        </span>

                        <!-- Nama & Harga -->
                        <h3 class="text-lg font-bold text-gray-800 mb-1">{{ $paket->nama_paket }}</h3>
                        <p class="text-sm text-gray-500 mb-4">{{ $paket->kategori }} • {{ $paket->jumlah_pax }} Pax</p>
                        <p class="text-xl font-bold mb-4" style="color: var(--primary-blue);">
                            Rp {{ number_format($paket->harga_paket, 0, ',', '.') }}
                        </p>

                        <!-- Tombol Pesan (Biru) -->
                        <a href="{{ route('pelanggan.pesan.create', ['paket' => $paket->id]) }}" 
                           class="block w-full text-center py-2 px-4 rounded-lg font-semibold text-white transition-colors duration-300"
                           style="background-color: var(--primary-blue);"
                           onmouseover="this.style.backgroundColor='var(--primary-hover)'"
                           onmouseout="this.style.backgroundColor='var(--primary-blue)'">
                            Pesan Sekarang
                        </a>
                    </div>
                    <!-- AKHIR CARD PAKET -->

                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>
