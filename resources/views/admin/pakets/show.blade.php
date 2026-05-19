<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Paket') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Header -->
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800">{{ $paket->nama_paket }}</h3>
                            <div class="flex gap-2 mt-2">
                                <span class="px-3 py-1 text-sm rounded-full {{ $paket->jenis == 'Prasmanan' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $paket->jenis }}
                                </span>
                                <span class="px-3 py-1 text-sm rounded-full bg-purple-100 text-purple-800">
                                    {{ $paket->kategori }}
                                </span>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-orange-600">Rp {{ number_format($paket->harga_paket, 0, ',', '.') }}</p>
                            <p class="text-sm text-gray-500">{{ $paket->jumlah_pax }} Pax</p>
                        </div>
                    </div>

                    <!-- Foto Gallery -->
                    <div class="grid grid-cols-3 gap-4 mb-6">
                        @foreach(['foto1', 'foto2', 'foto3'] as $foto)
                            @if($paket->$foto)
                                <div class="relative group">
                                    <img src="{{ Storage::url($paket->$foto) }}" 
                                        class="w-full h-48 object-cover rounded-lg">
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-6">
                        <h4 class="text-lg font-semibold mb-2">Deskripsi</h4>
                        <p class="text-gray-600">{{ $paket->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                    </div>

                    <!-- Info -->
                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Dibuat</p>
                                <p class="font-medium">{{ $paket->created_at->format('d M Y, H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Terakhir Diupdate</p>
                                <p class="font-medium">{{ $paket->updated_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('admin.pakets.index') }}" 
                            class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                            Kembali
                        </a>
                        <a href="{{ route('admin.pakets.edit', $paket->id) }}" 
                            class="px-6 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition">
                            Edit Paket
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
