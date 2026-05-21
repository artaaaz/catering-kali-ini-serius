<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Pesanan #{{ $pemesanan->no_resi }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow space-y-4">
                <p><strong>Status:</strong> {{ $pemesanan->status_pesan }}</p>
                <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($pemesanan->tgl_pesan)->format('d M Y') }}</p>
                <p><strong>Total:</strong> Rp {{ number_format($pemesanan->total_bayar, 0, ',', '.') }}</p>
                
                <div class="border-t pt-4">
                    <h4 class="font-semibold mb-2">Paket:</h4>
                    @foreach($pemesanan->pakets as $pkt)
                        <p>• {{ $pkt->nama_paket }} (Subtotal: Rp {{ number_format($pkt->pivot->subtotal ?? 0, 0, ',', '.') }})</p>
                    @endforeach
                </div>

                <a href="{{ route('pelanggan.riwayat') }}" class="text-blue-600 hover:underline">← Kembali</a>
            </div>
        </div>
    </div>
</x-app-layout>