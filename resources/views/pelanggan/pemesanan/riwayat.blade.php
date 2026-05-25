<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Pesanan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    @forelse($pemesanans as $p)
                        <div class="border rounded-lg p-4 mb-4 hover:shadow-md transition">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-bold text-lg">📦 {{ $p->no_resi }}</h3>
                                    <p class="text-sm text-gray-500">Tanggal: {{ \Carbon\Carbon::parse($p->tgl_pesan)->format('d M Y') }}</p>
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $p->status_pesan == 'Menunggu Konfirmasi' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $p->status_pesan == 'Sedang Diproses' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $p->status_pesan == 'Menunggu Kurir' ? 'bg-purple-100 text-purple-800' : '' }}">
                                    {{ $p->status_pesan }}
                                </span>
                            </div>

                            <div class="mt-3 space-y-2 text-sm">
                                @foreach($p->pakets as $paket)
                                    <p><strong>Paket:</strong> {{ $paket->nama_paket }}</p>
                                    <p><strong>Subtotal:</strong> Rp {{ number_format($paket->pivot->subtotal ?? $p->total_bayar, 0, ',', '.') }}</p>
                                @endforeach
                                <p class="font-bold text-orange-600">Total: Rp {{ number_format($p->total_bayar, 0, ',', '.') }}</p>
                            </div>

                            <div class="mt-4">
                                <a href="{{ route('pelanggan.pemesanan.show', $p->id) }}" class="text-blue-600 hover:underline text-sm">
                                    Lihat Detail →
                                </a>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-8">Belum ada riwayat pesanan.</p>
                    @endforelse

                    <div class="mt-6">
                        {{ $pemesanans->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
