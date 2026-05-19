<?php
namespace App\Http\Controllers\Pelanggan;
use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Models\DetailPemesanan;
use App\Models\JenisPembayaran;
use App\Models\Paket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PemesananController extends Controller
{
    public function create() {
        $pakets = Paket::all();
        $methods = JenisPembayaran::all();
        return view('pelanggan.pemesanan.create', compact('pakets', 'methods'));
    }

    public function store(Request $request) {
        $request->validate([
            'paket_id' => 'required|exists:pakets,id',
            'jumlah_pax' => 'required|integer|min:1',
            'tgl_acara' => 'required|date|after:today',
            'alamat' => 'required|string',
            'metode_bayar' => 'required|exists:jenis_pembayarans,id',
            'bukti_bayar' => 'required|image|max:2048'
        ]);

        $paket = Paket::find($request->paket_id);
        $total = $paket->harga_paket * ($request->jumlah_pax / 1); // Simplified pricing logic

        DB::beginTransaction();
        try {
            $pemesanan = Pemesanan::create([
                'id_pelanggan' => Auth::id(),
                'id_jenis_bayar' => $request->metode_bayar,
                'tgl_pesan' => now(),
                'status_pesan' => 'Menunggu Konfirmasi',
                'total_bayar' => $total,
                'no_resi' => 'RESI-'.strtoupper(uniqid()),
                'alamat1' => $request->alamat1
            ]);

            DetailPemesanan::create([
                'id_pemesanan' => $pemesanan->id,
                'id_paket' => $request->paket_id,
                'subtotal' => $total
            ]);

            if($request->hasFile('bukti_bayar')) {
                $path = $request->file('bukti_bayar')->store('bukti-bayar', 'public');
                // Simpan path ke catatan atau field terpisah (sesuaikan schema)
            }

            DB::commit();
            return redirect()->route('pelanggan.riwayat')->with('success', 'Pesanan berhasil dibuat!');
        } catch(\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membuat pesanan: '.$e->getMessage());
        }
    }

    public function riwayat() {
        $pemesanans = Pemesanan::where('id_pelanggan', Auth::id())->latest()->paginate(10);
        return view('pelanggan.pemesanan.riwayat', compact('pemesanans'));
    }

    public function show($id) { return view('pelanggan.pemesanan.show'); }
    public function uploadBuktiBayar($id) { return back()->with('success', 'Bukti diupload!'); }
}
