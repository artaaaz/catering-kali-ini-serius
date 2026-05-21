<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Form Pemesanan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="form-container max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc list-inside text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('pelanggan.pesan.store') }}" 
                  method="POST" 
                  enctype="multipart/form-data"
                  class="space-y-6">
                @csrf

                <!-- Paket yang Dipilih -->
                <div class="form-card">
                    <label class="form-label">
                        <span class="text-2xl">📦</span> Pilih Paket
                    </label>
                    <select name="paket_id" class="form-input" required>
                        <option value="">-- Pilih Paket --</option>
                        @foreach($pakets as $pkt)
                            <option value="{{ $pkt->id }}" 
                                {{ request('paket') == $pkt->id ? 'selected' : '' }}>
                                {{ $pkt->nama_paket }} - Rp {{ number_format($pkt->harga_paket, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Jumlah Pax -->
                <div class="form-card">
                    <label class="form-label">
                        <span class="text-2xl">👥</span> Jumlah Pax
                    </label>
                    <input type="number" 
                           name="jumlah_pax" 
                           value="{{ old('jumlah_pax', 1) }}" 
                           min="1" 
                           class="form-input" 
                           required>
                    <p class="text-sm text-gray-500 mt-2">Minimum 1 pax</p>
                </div>

                <!-- Tanggal Acara -->
                <div class="form-card">
                    <label class="form-label">
                        <span class="text-2xl">📅</span> Tanggal Acara
                    </label>
                    <input type="date" 
                           name="tgl_acara" 
                           value="{{ old('tgl_acara') }}" 
                           min="{{ date('Y-m-d', strtotime('+1 day')) }}" 
                           class="form-input" 
                           required>
                </div>

                <!-- Alamat -->
                <div class="form-card">
                    <label class="form-label">
                        <span class="text-2xl">📍</span> Alamat Lengkap
                    </label>
                    <textarea name="alamat1" 
                              rows="4" 
                              class="form-input form-textarea" 
                              required>{{ old('alamat1') }}</textarea>
                </div>

                <!-- Metode Bayar -->
                <div class="form-card">
                    <label class="form-label">
                        <span class="text-2xl">💳</span> Metode Pembayaran
                    </label>
                    <select name="metode_bayar" class="form-input" required>
                        <option value="">-- Pilih Metode --</option>
                        @foreach($methods as $m)
                            <option value="{{ $m->id }}" {{ old('metode_bayar') == $m->id ? 'selected' : '' }}>
                                {{ $m->metode_pembayaran }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Upload Bukti -->
                <div class="form-card">
                    <label class="form-label">
                        <span class="text-2xl">📸</span> Upload Bukti Pembayaran
                    </label>
                    <input type="file" 
                           name="bukti_bayar" 
                           accept="image/*" 
                           class="form-input" 
                           required>
                    <p class="text-sm text-gray-500 mt-2">Format: JPG, PNG (Max 2MB)</p>
                </div>

                <!-- Total & Submit -->
                <div class="total-box">
                    <h3>Total Pembayaran</h3>
                    <div class="total-amount" id="total-display">Rp 0</div>
                </div>

                <div class="flex gap-4">
                    <a href="{{ route('pakets.index') }}" 
                       class="flex-1 px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-lg text-center font-semibold hover:bg-gray-50">
                        Batal
                    </a>
                    <button type="submit" 
                            class="flex-1 btn-primary-blue">
                        Konfirmasi Pesanan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script Hitung Total -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paketSelect = document.querySelector('select[name="paket_id"]');
            const jumlahInput = document.querySelector('input[name="jumlah_pax"]');
            const totalDisplay = document.getElementById('total-display');
            
            function updateTotal() {
                const selectedOption = paketSelect.options[paketSelect.selectedIndex];
                const harga = parseInt(selectedOption.value ? selectedOption.text.split('Rp ')[1].replace(/\./g, '') : 0);
                const jumlah = parseInt(jumlahInput.value) || 1;
                const total = harga * jumlah;
                
                totalDisplay.textContent = 'Rp ' + total.toLocaleString('id-ID');
            }
            
            paketSelect.addEventListener('change', updateTotal);
            jumlahInput.addEventListener('input', updateTotal);
            
            // Initial calculation
            updateTotal();
        });
    </script>
</x-app-layout>
