<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Models\Paket;
use App\Models\JenisPembayaran;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PemesananController extends Controller
{
    public function create()
    {
        $pakets = Paket::all();
        $methods = JenisPembayaran::all();
        return view('pelanggan.pemesanan.create', compact('pakets', 'methods'));
    }

    public function store(Request $request)
    {
        // 1. Validasi
        $validated = $request->validate([
            'paket_id' => 'required|exists:pakets,id',
            'jumlah_pax' => 'required|integer|min:1',
            'tgl_acara' => 'required|date|after:today',
            'alamat1' => 'required|string|max:255',
            'metode_bayar' => 'required|exists:jenis_pembayarans,id',
            'bukti_bayar' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // 2. Cek user login (harus pelanggan)
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $pelanggan = Auth::user();
        $paket = Paket::findOrFail($request->paket_id);

        // 3. Hitung total
        $total = $paket->harga_paket * $request->jumlah_pax;

        DB::beginTransaction();
        try {
            // 4. Simpan ke tabel pemesanans
            $pemesanan = Pemesanan::create([
                'id_pelanggan' => $pelanggan->id,
                'id_jenis_bayar' => $request->metode_bayar,
                'tgl_pesan' => now(),
                'status_pesan' => 'Menunggu Konfirmasi',
                'total_bayar' => $total,
                'no_resi' => 'RESI-' . strtoupper(uniqid()),
                'alamat1' => $request->alamat1,
                'tgl_acara' => $request->tgl_acara,
            ]);

            // 5. Handle upload bukti bayar
            if ($request->hasFile('bukti_bayar')) {
                $path = $request->file('bukti_bayar')->store('bukti-bayar', 'public');
                $pemesanan->update(['bukti_bayar' => $path]);
            }

            DB::commit();

            return redirect()->route('pelanggan.riwayat')
                ->with('success', 'Pesanan berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function riwayat()
    {
        $pemesanans = Pemesanan::where('id_pelanggan', Auth::id())
            ->with('paket')
            ->latest()
            ->paginate(10);

        return view('pelanggan.pemesanan.riwayat', compact('pemesanans'));
    }

    public function show($id)
    {
        $pemesanan = Pemesanan::with(['paket', 'pelanggan'])
            ->where('id_pelanggan', Auth::id())
            ->findOrFail($id);

        return view('pelanggan.pemesanan.show', compact('pemesanan'));
    }
}
