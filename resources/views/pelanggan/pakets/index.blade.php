<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Paket - Catering Premium</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-orange-600">
                        🍽️ Catering Premium
                    </a>
                </div>
                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ route('pelanggan.dashboard') }}" class="text-gray-700 hover:text-orange-600">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-orange-600">Login</a>
                        <a href="{{ route('register') }}" class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-orange-500 to-red-600 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold mb-4">Paket Catering Terbaik</h1>
            <p class="text-xl">Pilih paket sesuai kebutuhan acara Anda</p>
        </div>
    </div>

    <!-- Katalog Paket -->
    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($pakets as $paket)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition">
                <!-- Foto Paket -->
                <div class="h-48 overflow-hidden">
                    @if($paket->foto1)
                        <img src="{{ Storage::url($paket->foto1) }}" alt="{{ $paket->nama_paket }}" 
                            class="w-full h-full object-cover hover:scale-110 transition">
                    @else
                        <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                            <span class="text-gray-400">No Image</span>
                        </div>
                    @endif
                </div>

                <!-- Info Paket -->
                <div class="p-6">
                    <div class="flex gap-2 mb-3">
                        <span class="px-3 py-1 text-xs rounded-full {{ $paket->jenis == 'Prasmanan' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                            {{ $paket->jenis }}
                        </span>
                        <span class="px-3 py-1 text-xs rounded-full bg-purple-100 text-purple-800">
                            {{ $paket->kategori }}
                        </span>
                    </div>

                    <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $paket->nama_paket }}</h3>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $paket->deskripsi }}</p>

                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <p class="text-sm text-gray-500">Harga</p>
                            <p class="text-2xl font-bold text-orange-600">Rp {{ number_format($paket->harga_paket, 0, ',', '.') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500">Kapasitas</p>
                            <p class="text-lg font-semibold text-gray-800">{{ $paket->jumlah_pax }} Pax</p>
                        </div>
                    </div>

                    <!-- Tombol Pesan -->
                    <a href="{{ route('pelanggan.pesan.create', ['paket' => $paket->id]) }}" 
                        class="block w-full bg-orange-600 text-white text-center py-3 rounded-lg hover:bg-orange-700 transition font-semibold">
                        🛒 Pesan Sekarang
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-12">
                <p class="text-gray-500 text-lg">Belum ada paket tersedia.</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $pakets->links() }}
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p>&copy; {{ date('Y') }} Catering Premium. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>