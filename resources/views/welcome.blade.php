@extends('layouts.frontend')

@section('page-title', 'Home')

@section('content')
<!-- Hero Section -->
<section class="relative overflow-hidden bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 text-white">
    <div class="absolute inset-0 bg-grid opacity-10"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="animate-fade-in">
                <h1 class="text-4xl lg:text-6xl font-bold leading-tight mb-6">
                    Catering Premium untuk <span class="text-blue-200">Acara Spesial</span> Anda
                </h1>
                <p class="text-lg lg:text-xl text-blue-100 mb-8 leading-relaxed">
                    Mamamia Lezat menyajikan hidangan autentik dengan bahan segar pilihan.
                    Percayakan momen berharga Anda pada kami.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('pakets.index') }}"
                       class="inline-flex items-center justify-center px-8 py-4 bg-white text-blue-700 font-semibold rounded-xl hover:bg-blue-50 transition shadow-lg hover:shadow-xl">
                        <i class="fas fa-shopping-cart mr-2"></i> Pesan Sekarang
                    </a>
                    <a href="#about"
                       class="inline-flex items-center justify-center px-8 py-4 border-2 border-white/30 text-white font-semibold rounded-xl hover:bg-white/10 transition">
                        <i class="fas fa-play-circle mr-2"></i> Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>
            <div class="relative animate-fade-in" style="animation-delay: 0.2s">
                <div class="bg-white/10 backdrop-blur-sm rounded-3xl p-2">
                    <img src="https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=600&h=400&fit=crop"
                         alt="Catering Mamamia Lezat"
                         class="rounded-2xl shadow-2xl w-full object-cover">
                </div>
                <!-- Floating badges -->
                <div class="absolute -top-4 -right-4 bg-white text-blue-700 px-4 py-2 rounded-full font-semibold shadow-lg">
                    <i class="fas fa-star text-yellow-400 mr-1"></i> 4.9/5 Rating
                </div>
                <div class="absolute -bottom-4 -left-4 bg-white text-blue-700 px-4 py-2 rounded-full font-semibold shadow-lg">
                    <i class="fas fa-check-circle text-green-500 mr-1"></i> 500+ Pesanan
                </div>
            </div>
        </div>
    </div>

    <!-- Wave divider -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 120L60 110C120 100 240 80 360 70C480 60 600 60 720 65C840 70 960 80 1080 85C1200 90 1320 90 1380 90L1440 90V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="white"/>
        </svg>
    </div>
</section>

<!-- Features Section -->
<section id="about" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Mengapa Memilih Kami?</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Kami berkomitmen memberikan pengalaman catering terbaik untuk setiap acara Anda</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="card-hover bg-white rounded-2xl p-8 border border-blue-100 text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-leaf text-blue-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Bahan Segar</h3>
                <p class="text-gray-600">Kami hanya menggunakan bahan-bahan segar pilihan yang dibeli setiap hari dari pasar lokal.</p>
            </div>

            <!-- Feature 2 -->
            <div class="card-hover bg-white rounded-2xl p-8 border border-blue-100 text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-chef-hat text-blue-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Chef Berpengalaman</h3>
                <p class="text-gray-600">Tim chef profesional dengan pengalaman bertahun-tahun dalam menyiapkan hidangan istimewa.</p>
            </div>

            <!-- Feature 3 -->
            <div class="card-hover bg-white rounded-2xl p-8 border border-blue-100 text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-truck text-blue-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Pengiriman Tepat Waktu</h3>
                <p class="text-gray-600">Pesanan Anda akan tiba tepat waktu dengan kondisi terbaik, dijamin hangat dan segar.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl lg:text-4xl font-bold mb-6">Siap Membuat Acara Anda Berkesan?</h2>
        <p class="text-lg text-blue-100 mb-8">Pilih paket catering favorit Anda dan biarkan kami yang mengurus sisanya.</p>
        <a href="{{ route('pakets.index') }}"
           class="inline-flex items-center px-8 py-4 bg-white text-blue-700 font-semibold rounded-xl hover:bg-blue-50 transition shadow-lg">
            <i class="fas fa-box-open mr-2"></i> Lihat Paket Catering
        </a>
    </div>
</section>
@endsection
