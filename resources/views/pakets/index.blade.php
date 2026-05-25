@extends('layouts.frontend')

@section('page-title', 'Katalog Paket')

@section('content')
<div class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Paket Catering Mamamia Lezat</h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Pilih paket terbaik untuk acara spesial Anda. Semua paket menggunakan bahan segar dan dimasak oleh chef berpengalaman.</p>
        </div>

        @if($pakets->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
               @foreach($pakets as $paket)
    <div class="bg-white rounded-2xl overflow-hidden border border-blue-100 hover:border-blue-400 transition-all duration-300 hover:-translate-y-1 group">
        <!-- Foto / Placeholder -->
        <div class="relative h-48 overflow-hidden bg-blue-50">
            @if($paket->foto1)
                <img src="{{ asset('storage/' . $paket->foto1) }}"
                     alt="{{ $paket->nama_paket }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            @else
                <div class="w-full h-full flex items-center justify-center">
                    <i class="fas fa-utensils text-4xl text-blue-300"></i>
                </div>
            @endif

            <!-- Badge -->
            <span class="absolute top-3 right-3 px-3 py-1 bg-white/90 backdrop-blur text-blue-700 text-xs font-semibold rounded-full border border-blue-100">
                {{ $paket->jenis }}
            </span>
        </div>

        <!-- Info -->
        <div class="p-5">
            <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $paket->nama_paket }}</h3>
            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $paket->deskripsi ?? 'Hidangan lezat untuk acara Anda' }}</p>

            <!-- Specs -->
            <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                <span class="flex items-center gap-1.5">
                    <i class="fas fa-users text-blue-500"></i> {{ $paket->jumlah_pax }} Pax
                </span>
                <span class="flex items-center gap-1.5">
                    <i class="fas fa-tag text-blue-500"></i> {{ $paket->kategori }}
                </span>
            </div>

            <!-- Price & Button -->
            <div class="flex items-center justify-between pt-4 border-t border-blue-50">
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wide">Harga per Paket</p>
                    <p class="text-xl font-bold text-blue-700">Rp {{ number_format($paket->harga_paket, 0, ',', '.') }}</p>
                </div>

                @auth
                    <a href="{{ route('pelanggan.pesan.create', $paket->id) }}"
                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition-all duration-300 shadow-sm hover:shadow-md">
                        <i class="fas fa-cart-plus mr-2"></i> Pesan
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition-all duration-300 shadow-sm hover:shadow-md">
                        <i class="fas fa-cart-plus mr-2"></i> Pesan
                    </a>
                @endauth
            </div>
        </div>
    </div>
@endforeach
            </div>

            <!-- Pagination -->
            @if($pakets->hasPages())
                <div class="mt-12 flex justify-center">
                    {{ $pakets->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-20">
                <i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-700">Paket Segera Tersedia</h3>
                <p class="text-gray-500 mt-2">Kami sedang menyiapkan paket-paket terbaik untuk Anda.</p>
            </div>
        @endif
    </div>
</div>
@endsection
