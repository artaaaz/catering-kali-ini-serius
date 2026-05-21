<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Dashboard Owner</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-3 gap-4 mb-6">
                <div class="bg-white p-4 rounded shadow">
                    <p class="text-gray-500">Total Pesanan</p>
                    <p class="text-2xl font-bold">{{ $stats['total_pesanan'] }}</p>
                </div>
                <div class="bg-white p-4 rounded shadow">
                    <p class="text-gray-500">Pendapatan Bulan Ini</p>
                    <p class="text-2xl font-bold text-green-600">Rp {{ number_format($stats['pendapatan_bulan_ini'], 0, ',', '.') }}</p>
                </div>
                <div class="bg-white p-4 rounded shadow">
                    <p class="text-gray-500">Paket Terlaris</p>
                    <p class="text-lg font-bold">{{ $stats['paket_terlaris']->nama_paket ?? '-' }}</p>
                </div>
            </div>
            <a href="{{ route('owner.laporan.pdf') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Export Laporan PDF</a>
        </div>
    </div>
</x-app-layout>
