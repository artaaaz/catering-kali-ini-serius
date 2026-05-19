<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-orange-500">
                    <div class="text-gray-500 text-sm">Total Paket</div>
                    <div class="text-2xl font-bold text-gray-800">12</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-gray-500 text-sm">Pesanan Baru</div>
                    <div class="text-2xl font-bold text-gray-800">5</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-gray-500 text-sm">Pelanggan</div>
                    <div class="text-2xl font-bold text-gray-800">48</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-purple-500">
                    <div class="text-gray-500 text-sm">Pendapatan</div>
                    <div class="text-2xl font-bold text-gray-800">Rp 15.2Jt</div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Aksi Cepat</h3>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('admin.pakets.index') }}" class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 transition">
                        Kelola Paket
                    </a>
                    <a href="{{ route('admin.pemesanans.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        Lihat Pesanan
                    </a>
                    <a href="#" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                        Tambah Pelanggan
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
