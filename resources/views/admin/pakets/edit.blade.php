<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Paket') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.pakets.update', $paket->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Nama Paket -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Paket <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_paket" value="{{ old('nama_paket', $paket->nama_paket) }}" required
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 @error('nama_paket') border-red-500 @enderror">
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
                                    <option value="Prasmanan" {{ old('jenis', $paket->jenis) == 'Prasmanan' ? 'selected' : '' }}>Prasmanan</option>
                                    <option value="Box" {{ old('jenis', $paket->jenis) == 'Box' ? 'selected' : '' }}>Box</option>
                                </select>
                                @error('jenis')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Kategori <span class="text-red-500">*</span></label>
                                <select name="kategori" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 @error('kategori') border-red-500 @enderror">
                                    <option value="">Pilih Kategori</option>
                                    <option value="Pernikahan" {{ old('kategori', $paket->kategori) == 'Pernikahan' ? 'selected' : '' }}>Pernikahan</option>
                                    <option value="Selamatan" {{ old('kategori', $paket->kategori) == 'Selamatan' ? 'selected' : '' }}>Selamatan</option>
                                    <option value="Ulang Tahun" {{ old('kategori', $paket->kategori) == 'Ulang Tahun' ? 'selected' : '' }}>Ulang Tahun</option>
                                    <option value="Studi Tour" {{ old('kategori', $paket->kategori) == 'Studi Tour' ? 'selected' : '' }}>Studi Tour</option>
                                    <option value="Rapat" {{ old('kategori', $paket->kategori) == 'Rapat' ? 'selected' : '' }}>Rapat</option>
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
                                <input type="number" name="jumlah_pax" value="{{ old('jumlah_pax', $paket->jumlah_pax) }}" min="1" required
                                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 @error('jumlah_pax') border-red-500 @enderror">
                                @error('jumlah_pax')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Harga Paket (Rp) <span class="text-red-500">*</span></label>
                                <input type="number" name="harga_paket" value="{{ old('harga_paket', $paket->harga_paket) }}" min="0" required
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
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi', $paket->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Upload Foto dengan Preview Existing -->
                        <div class="space-y-4">
                            <h4 class="text-md font-semibold text-gray-800">Upload Foto Paket (Kosongkan jika tidak ingin mengganti)</h4>
                            
                            @foreach(['foto1', 'foto2', 'foto3'] as $index => $foto)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">
                                    {{ $index === 0 ? 'Foto Utama' : ($index === 1 ? 'Foto 2' : 'Foto 3') }}
                                </label>
                                
                                @if($paket->$foto)
                                    <div class="mb-2">
                                        <p class="text-xs text-gray-500 mb-1">Foto saat ini:</p>
                                        <img src="{{ Storage::url($paket->$foto) }}" class="w-32 h-32 object-cover rounded-lg">
                                    </div>
                                @endif
                                
                                <input type="file" name="{{ $foto }}" id="{{ $foto }}" accept="image/*" 
                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 @error($foto) border-red-500 @enderror"
                                    onchange="previewImage(this, 'preview{{ $index }}')">
                                <img id="preview{{ $index }}" class="mt-2 w-32 h-32 object-cover rounded-lg hidden">
                                @error($foto)
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            @endforeach
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end gap-3 pt-4">
                            <a href="{{ route('admin.pakets.index') }}" 
                                class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                                Batal
                            </a>
                            <button type="submit" 
                                class="px-6 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition">
                                Update Paket
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