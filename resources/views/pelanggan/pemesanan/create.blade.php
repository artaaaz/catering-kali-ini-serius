<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Form Pemesanan Paket') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('pelanggan.pesan.store') }}"
                          method="POST"
                          enctype="multipart/form-data"
                          class="space-y-6">
                        @csrf

                        <!-- Pilih Paket -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Pilih Paket *</label>
                            <select name="paket_id" id="paket_id" required
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg"
                                onchange="hitungTotal()">
                                <option value="">-- Pilih Paket --</option>
                                @foreach($pakets as $paket)
                                    <option value="{{ $paket->id }}"
                                        data-harga="{{ $paket->harga_paket }}">
                                        {{ $paket->nama_paket }} - Rp {{ number_format($paket->harga_paket, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Jumlah Pax & Tanggal -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jumlah Pax *</label>
                                <input type="number" name="jumlah_pax" value="1" min="1" required
                                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg"
                                    onchange="hitungTotal()">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal Acara *</label>
                                <input type="date" name="tgl_acara" required min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg">
                            </div>
                        </div>

                        <!-- Alamat -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Alamat Acara *</label>
                            <textarea name="alamat1" rows="3" required
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg"></textarea>
                        </div>

                        <!-- Metode Pembayaran -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Metode Pembayaran *</label>
                            <select name="metode_bayar" required
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg">
                                <option value="">-- Pilih Metode --</option>
                                @foreach($methods as $method)
                                    <option value="{{ $method->id }}">{{ $method->metode_pembayaran }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Upload Bukti Bayar -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Upload Bukti Bayar *</label>
                            <input type="file" name="bukti_bayar" accept="image/*" required
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-orange-50 file:text-orange-700">
                        </div>

                        <!-- Total -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex justify-between">
                                <span class="text-lg font-semibold">Total:</span>
                                <span id="total_harga" class="text-2xl font-bold text-orange-600">Rp 0</span>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end gap-3">
                            <a href="{{ route('pelanggan.dashboard') }}" class="px-6 py-2 border rounded-lg">Batal</a>
                            <button type="submit" class="px-6 py-2 bg-orange-600 text-white rounded-lg">Konfirmasi</button>
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
        document.addEventListener('DOMContentLoaded', hitungTotal);
    </script>
</x-app-layout>
