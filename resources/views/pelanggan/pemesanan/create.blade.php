<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Form Pemesanan Paket') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('error'))
                <div class="bg-red-500 text-white px-6 py-4 rounded-lg mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('pelanggan.pesan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- Pilih Paket -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Pilih Paket <span class="text-red-500">*</span>
                            </label>
                            <select name="paket_id" id="paket_id" required 
                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500"
                                onchange="updateHarga()">
                                <option value="">-- Pilih Paket --</option>
                                @foreach($pakets as $paket)
                                    <option value="{{ $paket->id }}" 
                                        data-harga="{{ $paket->harga_paket }}"
                                        {{ (request('paket') == $paket->id) ? 'selected' : '' }}>
                                        {{ $paket->nama_paket }} - Rp {{ number_format($paket->harga_paket, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Jumlah Pax & Tanggal -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Pax *</label>
                                <input type="number" name="jumlah_pax" value="1" min="1" required
                                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg"
                                    onchange="hitungTotal()">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Acara *</label>
                                <input type="date" name="tgl_acara" required min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg">
                            </div>
                        </div>

                        <!-- Alamat -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Acara *</label>
                            <textarea name="alamat1" rows="3" required
                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg"></textarea>
                        </div>

                        <!-- Metode Pembayaran -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Metode Pembayaran *</label>
                            <select name="metode_bayar" required
                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg">
                                <option value="">-- Pilih Metode --</option>
                                @foreach($methods as $method)
                                    <option value="{{ $method->id }}">
                                        {{ $method->metode_pembayaran ?? 'Metode '.$method->id }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Upload Bukti -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Upload Bukti Bayar *</label>
                            <input type="file" name="bukti_bayar" accept="image/*" required
                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg"
                                onchange="previewBukti(this)">
                            <img id="preview_bukti" class="mt-3 w-48 h-48 object-cover rounded-lg hidden">
                        </div>

                        <!-- Total -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex justify-between">
                                <span class="text-lg font-semibold">Total:</span>
                                <span id="total_harga" class="text-2xl font-bold text-orange-600">Rp 0</span>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end gap-3 pt-4">
                            <a href="{{ route('pelanggan.pakets.index') }}" class="px-6 py-3 border rounded-lg">Batal</a>
                            <button type="submit" class="px-6 py-3 bg-orange-600 text-white rounded-lg">Konfirmasi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function hitungTotal() {
            const select = document.getElementById('paket_id');
            const pax = document.querySelector('[name="jumlah_pax"]').value || 1;
            const opt = select.options[select.selectedIndex];
            const harga = parseInt(opt.dataset.harga) || 0;
            document.getElementById('total_harga').textContent = 'Rp ' + (harga * pax).toLocaleString('id-ID');
        }
        function previewBukti(input) {
            const img = document.getElementById('preview_bukti');
            if(input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => { img.src = e.target.result; img.classList.remove('hidden'); }
                reader.readAsDataURL(input.files[0]);
            }
        }
        document.addEventListener('DOMContentLoaded', hitungTotal);
    </script>
</x-app-layout>