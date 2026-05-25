<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mamamia Lezat - @yield('page-title', 'Catering Premium')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @stack('styles')
</head>
<body class="bg-grid font-['Inter'] antialiased text-gray-800">

    <!-- Navbar -->
    <nav class="bg-white/90 backdrop-blur-md border-b border-blue-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl flex items-center justify-center">
                        <i class="fas fa-utensils text-white text-lg"></i>
                    </div>
                    <span class="text-xl font-bold brand-blue">Mamamia Lezat</span>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center gap-6">
                    <a href="{{ url('/') }}" class="text-gray-600 hover:text-blue-600 font-medium transition">Beranda</a>
                    <a href="{{ route('pakets.index') }}" class="text-gray-600 hover:text-blue-600 font-medium transition">Paket</a>
                    <a href="#about" class="text-gray-600 hover:text-blue-600 font-medium transition">Tentang</a>
                    <a href="#contact" class="text-gray-600 hover:text-blue-600 font-medium transition">Kontak</a>
                </div>

                <!-- Auth Buttons -->
                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ route('pelanggan.riwayat') }}"
                           class="hidden sm:inline-flex items-center gap-2 px-4 py-2 text-blue-600 font-medium hover:bg-blue-50 rounded-lg transition">
                            <i class="fas fa-user"></i> {{ Auth::user()->name }}
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit"
                                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition shadow-sm">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                           class="text-gray-600 hover:text-blue-600 font-medium transition hidden sm:block">
                            Login
                        </a>
                        <a href="{{ route('register') }}"
                           class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition shadow-sm">
                            Daftar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="fixed top-20 right-4 z-50 animate-fade-in">
            <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-4 rounded-lg shadow-lg max-w-sm">
                <div class="flex items-center gap-3">
                    <i class="fas fa-check-circle text-xl"></i>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="fixed top-20 right-4 z-50 animate-fade-in">
            <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 rounded-lg shadow-lg max-w-sm">
                <div class="flex items-center gap-3">
                    <i class="fas fa-exclamation-circle text-xl"></i>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-blue-100 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl flex items-center justify-center">
                            <i class="fas fa-utensils text-white text-lg"></i>
                        </div>
                        <span class="text-xl font-bold brand-blue">Mamamia Lezat</span>
                    </div>
                    <p class="text-gray-600 leading-relaxed">
                        Catering premium untuk acara spesial Anda.
                        Bahan segar, rasa autentik, pelayanan terbaik.
                    </p>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900 mb-4">Layanan</h4>
                    <ul class="space-y-2 text-gray-600">
                        <li><a href="{{ route('pakets.index') }}" class="hover:text-blue-600 transition">Paket Catering</a></li>
                        <li><a href="#" class="hover:text-blue-600 transition">Pernikahan</a></li>
                        <li><a href="#" class="hover:text-blue-600 transition">Rapat & Kantor</a></li>
                        <li><a href="#" class="hover:text-blue-600 transition">Acara Pribadi</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900 mb-4">Kontak</h4>
                    <ul class="space-y-2 text-gray-600">
                        <li><i class="fas fa-phone mr-2"></i> +62 812-3456-7890</li>
                        <li><i class="fas fa-envelope mr-2"></i> halo@mamamialezat.com</li>
                        <li><i class="fas fa-map-marker-alt mr-2"></i> Jakarta, Indonesia</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-blue-100 mt-8 pt-8 text-center text-gray-500 text-sm">
                &copy; {{ date('Y') }} Mamamia Lezat. All rights reserved.
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
