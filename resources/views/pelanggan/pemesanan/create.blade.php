@extends('layouts.frontend')

@section('page-title', 'Konfirmasi Pesanan')

@section('content')
<div class="min-h-screen bg-grid py-12">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('pakets.index') }}"
               class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-medium transition group">
                <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
                Kembali ke Katalog
            </a>
        </div>

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Konfirmasi Pesanan</h1>
            <p class="text-gray-600">Lengkapi data pemesanan Anda untuk melanjutkan</p>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-5 rounded-xl animate-fade-in">
                <div class="flex items-start gap-3">
                    <i class="fas fa-exclamation-circle text-red-500 text-xl mt-0.5"></i>
                    <div>
                        <h3 class="text-red-800 font-semibold mb-2">Ada kesalahan pada form:</h3>
                        <ul class="text-red-700 text-sm space-y-1 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
            <!-- Left: Order Form -->
            <div class="lg:col-span-3">
                <form action="{{ route('pelanggan.pesan.store') }}"
                      method="POST"
                      enctype="multipart/form-data"
                      class="bg-white rounded-2xl border border-blue-100 overflow-hidden hover:border-blue-300 transition-all duration-300">
                    @csrf
                    <input type="hidden" name="paket_id" value="{{ $paket->id }}">

                    <!-- Form Header -->
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                        <h2 class="text-lg font-bold text-white flex items-center gap-2">
                            <i class="fas fa-edit"></i>
                            Data Pemesanan
                        </h2>
                    </div>

                    <!-- Form Fields -->
                    <div class="p-6 space-y-5">
                        <!-- Jumlah Pax -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Jumlah Pax <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <i class="fas fa-users absolute left-4 top-1/2 -translate-y-1/2 text-blue-400"></i>
                                <input type="number"
                                       name="jumlah_pax"
                                       id="jumlah_pax"
                                       value="{{ old('jumlah_pax', $paket->jumlah_pax ?? 1) }}"
                                       min="1"
                                       max="1000"
                                       required
                                       class="w-full pl-11 pr-4 py-3 bg-blue-50/50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-gray-700">
                            </div>
                            <p class="text-xs text-gray-500 mt-1.5">Minimal 1 pax</p>
                        </div>

                        <!-- Tanggal Acara -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Tanggal Acara <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <i class="fas fa-calendar-alt absolute left-4 top-1/2 -translate-y-1/2 text-blue-400"></i>
                                <input type="date"
                                       name="tgl_acara"
                                       value="{{ old('tgl_acara') }}"
                                       min="{{ date('Y-m-d') }}"
                                       required
                                       class="w-full pl-11 pr-4 py-3 bg-blue-50/50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-gray-700">
                            </div>
                            <p class="text-xs text-gray-500 mt-1.5">Acara minimal besok</p>
                        </div>

                        <!-- Alamat Pengiriman -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Alamat Pengiriman <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <i class="fas fa-map-marker-alt absolute left-4 top-4 text-blue-400"></i>
                                <textarea name="alamat_pengiriman"
                                          rows="3"
                                          required
                                          placeholder="Masukkan alamat lengkap pengiriman..."
                                          class="w-full pl-11 pr-4 py-3 bg-blue-50/50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-gray-700 resize-none">{{ old('alamat_pengiriman') }}</textarea>
                            </div>
                            <p class="text-xs text-gray-500 mt-1.5">Pastikan alamat lengkap & mudah ditemukan</p>
                        </div>

                        <!-- Metode Pembayaran -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Metode Pembayaran <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <i class="fas fa-credit-card absolute left-4 top-1/2 -translate-y-1/2 text-blue-400"></i>
                                <select name="metode_bayar"
                                        required
                                        class="w-full pl-11 pr-4 py-3 bg-blue-50/50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-gray-700 appearance-none cursor-pointer">
                                    <option value="">Pilih Metode Pembayaran</option>
                                    @foreach($jenisPembayarans as $jp)
                                        <option value="{{ $jp->id }}" {{ old('metode_bayar') == $jp->id ? 'selected' : '' }}>
                                            {{ $jp->metode_pembayaran }}
                                        </option>
                                    @endforeach
                                </select>
                                <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                            </div>
                        </div>

                        <!-- Upload Bukti Bayar -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Upload Bukti Pembayaran <span class="text-red-500">*</span>
                            </label>
                            <div class="relative border-2 border-dashed border-blue-300 rounded-xl p-6 text-center hover:border-blue-500 transition cursor-pointer bg-blue-50/30"
                                 onclick="document.getElementById('bukti_bayar').click()">
                                <input type="file"
                                       name="bukti_bayar"
                                       id="bukti_bayar"
                                       accept="image/*"
                                       required
                                       class="hidden"
                                       onchange="previewFile(this)">

                                <div id="upload_placeholder">
                                    <i class="fas fa-cloud-upload-alt text-4xl text-blue-400 mb-3"></i>
                                    <p class="text-gray-700 font-medium mb-1">Klik untuk upload bukti pembayaran</p>
                                    <p class="text-xs text-gray-500">Format: JPG, PNG (Maks. 2MB)</p>
                                </div>

                                <div id="upload_preview" class="hidden">
                                    <img id="preview_img" src="#" alt="Preview" class="max-h-40 mx-auto rounded-lg mb-2">
                                    <p class="text-sm text-blue-600 font-medium" id="file_name"></p>
                                </div>
                            </div>
                            @error('bukti_bayar')
                                <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Form Footer -->
                    <div class="bg-gray-50 px-6 py-4 border-t border-blue-100 flex gap-3">
                        <a href="{{ route('pakets.index') }}"
                           class="px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-100 transition">
                            Batal
                        </a>
                        <button type="submit"
                                class="flex-1 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-all duration-300 shadow-sm hover:shadow-md flex items-center justify-center gap-2">
                            <i class="fas fa-check-circle"></i>
                            Konfirmasi Pesanan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Right: Order Summary -->
            <div class="lg:col-span-2">
                <div class="sticky top-24">
                    <!-- Paket Info Card -->
                    <div class="bg-white rounded-2xl border border-blue-100 overflow-hidden mb-6 hover:border-blue-300 transition-all duration-300">
                        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                            <h2 class="text-lg font-bold text-white flex items-center gap-2">
                                <i class="fas fa-box-open"></i>
                                Detail Paket
                            </h2>
                        </div>

                        <div class="p-6">
                            <div class="flex gap-4 mb-4">
                                @if($paket->foto1)
                                    <img src="{{ asset('storage/' . $paket->foto1) }}"
                                         alt="{{ $paket->nama_paket }}"
                                         class="w-24 h-24 rounded-xl object-cover border-2 border-blue-100">
                                @else
                                    <div class="w-24 h-24 rounded-xl bg-blue-100 flex items-center justify-center border-2 border-blue-100">
                                        <i class="fas fa-utensils text-3xl text-blue-400"></i>
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <h3 class="font-bold text-gray-900 text-lg">{{ $paket->nama_paket }}</h3>
                                    <p class="text-sm text-gray-600 mt-1 line-clamp-2">{{ $paket->deskripsi ?? 'Hidangan lezat untuk acara Anda' }}</p>
                                    <div class="flex items-center gap-3 mt-2 text-xs text-gray-500">
                                        <span class="flex items-center gap-1">
                                            <i class="fas fa-users"></i> {{ $paket->jumlah_pax }} Pax
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <i class="fas fa-tag"></i> {{ $paket->jenis }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="border-t border-blue-100 pt-4">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm text-gray-600">Harga per Paket</span>
                                    <span class="font-semibold text-gray-900">Rp {{ number_format($paket->harga_paket, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Summary Card -->
                    <div class="bg-white rounded-2xl border border-blue-100 overflow-hidden hover:border-blue-300 transition-all duration-300">
                        <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                            <h2 class="text-lg font-bold text-white flex items-center gap-2">
                                <i class="fas fa-calculator"></i>
                                Ringkasan Pembayaran
                            </h2>
                        </div>

                        <div class="p-6">
                            <div class="space-y-3 mb-4">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span class="font-medium text-gray-900" id="subtotal_display">Rp {{ number_format($paket->harga_paket, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Jumlah Pax</span>
                                    <span class="font-medium text-gray-900" id="pax_display">× {{ $paket->jumlah_pax ?? 1 }}</span>
                                </div>
                                <div class="border-t border-blue-100 pt-3">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm font-semibold text-gray-700">Total Pembayaran</span>
                                        <span class="text-2xl font-bold text-green-600" id="total_display">Rp {{ number_format($paket->harga_paket * ($paket->jumlah_pax ?? 1), 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Info Box -->
                            <div class="bg-blue-50 rounded-xl p-4 border border-blue-200">
                                <div class="flex items-start gap-3">
                                    <i class="fas fa-info-circle text-blue-500 mt-0.5"></i>
                                    <div class="text-xs text-gray-600">
                                        <p class="font-semibold text-gray-700 mb-1">Informasi Penting:</p>
                                        <ul class="space-y-1 list-disc list-inside">
                                            <li>Pesanan akan diproses setelah pembayaran diverifikasi</li>
                                            <li>Bukti pembayaran wajib diupload</li>
                                            <li>Pesanan tidak dapat dibatalkan setelah dikonfirmasi</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // File preview
    function previewFile(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview_img').src = e.target.result;
                document.getElementById('upload_placeholder').classList.add('hidden');
                document.getElementById('upload_preview').classList.remove('hidden');
                document.getElementById('file_name').textContent = input.files[0].name;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Auto calculate total
    const hargaPaket = {{ $paket->harga_paket }};
    const jumlahPaxInput = document.getElementById('jumlah_pax');
    const subtotalDisplay = document.getElementById('subtotal_display');
    const paxDisplay = document.getElementById('pax_display');
    const totalDisplay = document.getElementById('total_display');

    jumlahPaxInput.addEventListener('input', function() {
        const pax = parseInt(this.value) || 1;
        const total = hargaPaket * pax;

        subtotalDisplay.textContent = 'Rp ' + hargaPaket.toLocaleString('id-ID');
        paxDisplay.textContent = '× ' + pax;
        totalDisplay.textContent = 'Rp ' + total.toLocaleString('id-ID');
    });

    // Fade in animation
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.rounded-2xl');
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

@push('styles')
<style>
    .animate-fade-in {
        animation: fadeIn 0.5s ease-in;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Custom select styling */
    select {
        background-image: none;
    }

    /* File upload hover effect */
    .border-dashed:hover {
        background-color: rgba(59, 130, 246, 0.05);
    }
</style>
@endpush
@endsection 
