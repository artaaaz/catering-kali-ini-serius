<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Models\Paket;
use App\Models\JenisPembayaran;
use App\Models\DetailPemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PemesananController extends Controller
{
    // Form order
    public function create()
    {
        $pakets = Paket::all();
        $methods = JenisPembayaran::all();
        return view('pelanggan.pemesanan.create', compact('pakets', 'methods'));
    }

    // Process order
    public function store(Request $request)
    {
        $validated = $request->validate([
            'paket_id' => 'required|exists:pakets,id',
            'jumlah_pax' => 'required|integer|min:1',
            'tgl_acara' => 'required|date|after:today',
            'alamat1' => 'required|string|max:255',
            'metode_bayar' => 'required|exists:jenis_pembayarans,id',
            'bukti_bayar' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if (!Auth::check()) return redirect()->route('login');

        $pelanggan = Auth::user();
        $paket = Paket::findOrFail($request->paket_id);
        $subtotal = $paket->harga_paket * $request->jumlah_pax;

        DB::beginTransaction();
        try {
            // Simpan ke pemesanans (Master)
            $pemesanan = Pemesanan::create([
                'id_pelanggan' => $pelanggan->id,
                'id_jenis_bayar' => $request->metode_bayar,
                'no_resi' => 'RESI-' . strtoupper(uniqid()),
                'tgl_pesan' => now(),
                'status_pesan' => 'Menunggu Konfirmasi',
                'total_bayar' => $subtotal,
            ]);

            // Simpan ke detail_pemesanans (Detail)
            DetailPemesanan::create([
                'id_pemesanan' => $pemesanan->id,
                'id_paket' => $paket->id,
                'subtotal' => $subtotal,
            ]);

            // Upload bukti bayar
            if ($request->hasFile('bukti_bayar')) {
                $path = $request->file('bukti_bayar')->store('bukti-bayar', 'public');
                // Kalau tabel pemesanans punya kolom bukti_bayar:
                // $pemesanan->update(['bukti_bayar' => $path]);
            }

            DB::commit();
            return redirect()->route('pelanggan.riwayat')->with('success', 'Pesanan berhasil!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    // Riwayat pesanan pelanggan
    public function riwayat()
    {
        $pemesanans = Pemesanan::where('id_pelanggan', Auth::id())
            ->with(['pakets', 'jenisPembayaran'])
            ->latest()
            ->paginate(10);
        return view('pelanggan.pemesanan.riwayat', compact('pemesanans'));
    }

    // Detail pesanan
    public function show($id)
    {
        $pemesanan = Pemesanan::with(['pakets', 'jenisPembayaran', 'details'])
            ->where('id_pelanggan', Auth::id())
            ->findOrFail($id);
        return view('pelanggan.pemesanan.show', compact('pemesanan'));
    }
}
