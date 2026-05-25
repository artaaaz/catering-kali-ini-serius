<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Paket;
use App\Models\Pemesanan;
use App\Models\DetailPemesanan;
use App\Models\JenisPembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
// ✅ TAMBAHKAN INI: Import Log Facade
use Illuminate\Support\Facades\Log;

class PemesananController extends Controller
{
    public function create($id)
    {
        $paket = Paket::findOrFail($id);
        $jenisPembayarans = JenisPembayaran::all();

        return view('pelanggan.pemesanan.create', compact('paket', 'jenisPembayarans'));
    }

    public function store(Request $request)
    {
        // 1. Validasi
        $validated = $request->validate([
            'paket_id'          => 'required|exists:pakets,id',
            'jumlah_pax'        => 'required|integer|min:1',
            'tgl_acara'         => 'required|date|after_or_equal:today',
            'alamat_pengiriman' => 'required|string|max:500',
            'metode_bayar'      => 'required|exists:jenis_pembayarans,id',
            'bukti_bayar'       => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            DB::beginTransaction();

            // 2. Upload file
            $buktiPath = $request->file('bukti_bayar')->store('bukti-bayar', 'public');

            // 3. Hitung total
            $paket = Paket::findOrFail($validated['paket_id']);
            $totalBayar = $paket->harga_paket * $validated['jumlah_pax'];

            // 4. Generate resi
            $noResi = 'RESI-' . strtoupper(substr(md5(uniqid()), 0, 8));

            // 5. Insert ke pemesanans
            $pemesanan = Pemesanan::create([
                'id_pelanggan'      => Auth::id(),
                'id_jenis_bayar'    => $validated['metode_bayar'],
                'no_resi'           => $noResi,
                'tgl_acara'         => $validated['tgl_acara'],
                'alamat_pengiriman' => $validated['alamat_pengiriman'],
                'jumlah_pax'        => $validated['jumlah_pax'],
                'status_pesan'      => 'Menunggu Konfirmasi',
                'total_bayar'       => $totalBayar,
                'bukti_bayar'       => $buktiPath,
            ]);

            // 6. Insert ke detail_pemesanans
            DetailPemesanan::create([
                'id_pemesanan' => $pemesanan->id,
                'id_paket'     => $paket->id,
                'subtotal'     => $totalBayar,
                'jumlah_pax'   => $validated['jumlah_pax'],
            ]);

            DB::commit();

            return redirect()->route('pelanggan.riwayat')
                ->with('success', '✅ Pesanan berhasil! No. Resi: ' . $noResi);
        } catch (\Exception $e) {
            DB::rollBack();
            // ✅ PAKAI Log::error() DENGAN IMPORT YANG BENAR
            Log::error('Error create pesanan: ' . $e->getMessage());

            return back()
                ->withErrors(['error' => 'Gagal: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function riwayat()
    {
        $pemesanans = Pemesanan::where('id_pelanggan', Auth::id())
            ->with(['pakets', 'jenisPembayaran'])
            ->latest()
            ->paginate(10);

        return view('pelanggan.riwayat', compact('pemesanans'));
    }

    public function show($id)
    {
        $pemesanan = Pemesanan::where('id_pelanggan', Auth::id())
            ->findOrFail($id);

        return view('pelanggan.pemesanan.show', compact('pemesanan'));
    }
}
