<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Paket Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.pakets.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- Nama Paket -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Paket <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_paket" value="{{ old('nama_paket') }}" required
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('nama_paket') border-red-500 @enderror">
                            @error('nama_paket')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jenis & Kategori -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jenis <span class="text-red-500">*</span></label>
                                <select name="jenis" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 @error('jenis') border-red-500 @enderror">
                                    <option value="">Pilih Jenis</option>
                                    <option value="Prasmanan" {{ old('jenis') == 'Prasmanan' ? 'selected' : '' }}>Prasmanan</option>
                                    <option value="Box" {{ old('jenis') == 'Box' ? 'selected' : '' }}>Box</option>
                                </select>
                                @error('jenis')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Kategori <span class="text-red-500">*</span></label>
                                <select name="kategori" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 @error('kategori') border-red-500 @enderror">
                                    <option value="">Pilih Kategori</option>
                                    <option value="Pernikahan" {{ old('kategori') == 'Pernikahan' ? 'selected' : '' }}>Pernikahan</option>
                                    <option value="Selamatan" {{ old('kategori') == 'Selamatan' ? 'selected' : '' }}>Selamatan</option>
                                    <option value="Ulang Tahun" {{ old('kategori') == 'Ulang Tahun' ? 'selected' : '' }}>Ulang Tahun</option>
                                    <option value="Studi Tour" {{ old('kategori') == 'Studi Tour' ? 'selected' : '' }}>Studi Tour</option>
                                    <option value="Rapat" {{ old('kategori') == 'Rapat' ? 'selected' : '' }}>Rapat</option>
                                </select>
                                @error('kategori')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Jumlah Pax & Harga -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jumlah Pax <span class="text-red-500">*</span></label>
                                <input type="number" name="jumlah_pax" value="{{ old('jumlah_pax') }}" min="1" required
                                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 @error('jumlah_pax') border-red-500 @enderror">
                                @error('jumlah_pax')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Harga Paket (Rp) <span class="text-red-500">*</span></label>
                                <input type="number" name="harga_paket" value="{{ old('harga_paket') }}" min="0" required
                                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 @error('harga_paket') border-red-500 @enderror">
                                @error('harga_paket')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                            <textarea name="deskripsi" rows="4"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Upload Foto -->
                        <div class="space-y-4">
                            <h4 class="text-md font-semibold text-gray-800">Upload Foto Paket</h4>

                            <!-- Foto 1 -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Foto Utama</label>
                                <input type="file" name="foto1" id="foto1" accept="image/*"
                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 @error('foto1') border-red-500 @enderror"
                                    onchange="previewImage(this, 'preview1')">
                                <img id="preview1" class="mt-2 w-32 h-32 object-cover rounded-lg hidden">
                                @error('foto1')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Foto 2 -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Foto 2</label>
                                <input type="file" name="foto2" id="foto2" accept="image/*"
                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 @error('foto2') border-red-500 @enderror"
                                    onchange="previewImage(this, 'preview2')">
                                <img id="preview2" class="mt-2 w-32 h-32 object-cover rounded-lg hidden">
                                @error('foto2')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Foto 3 -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Foto 3</label>
                                <input type="file" name="foto3" id="foto3" accept="image/*"
                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 @error('foto3') border-red-500 @enderror"
                                    onchange="previewImage(this, 'preview3')">
                                <img id="preview3" class="mt-2 w-32 h-32 object-cover rounded-lg hidden">
                                @error('foto3')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end gap-3 pt-4">
                            <a href="{{ route('admin.pakets.index') }}"
                                class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                                Batal
                            </a>
                            <button type="submit"
                                class="px-6 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition">
                                Simpan Paket
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Image Preview Script -->
    <script>
        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-app-layout>
