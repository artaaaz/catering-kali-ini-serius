<?php

namespace App\Http\Controllers\Kurir;

use App\Http\Controllers\Controller;
use App\Models\Pengiriman;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // ✅ PAKAI MODEL Pengiriman (bukan query langsung ke tabel)
        $pengirimans = Pengiriman::with(['pemesanan.pelanggan', 'kurir'])
            ->whereIn('status_kirim', ['Sedang Dikirim', 'Menunggu Kurir'])
            ->latest()
            ->paginate(10);

        return view('kurir.dashboard', compact('pengirimans'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Sedang Dikirim,Tiba Ditujukan,Menunggu Kurir'
        ]);

        $pengiriman = Pengiriman::findOrFail($id);
        $pengiriman->update(['status_kirim' => $request->status]);

        return back()->with('success', 'Status diupdate!');
    }

    public function uploadBukti(Request $request, $id)
    {
        $request->validate([
            'bukti_foto' => 'required|image|max:2048'
        ]);

        $pengiriman = Pengiriman::findOrFail($id);
        $path = $request->file('bukti_foto')->store('bukti-pengiriman', 'public');
        $pengiriman->update(['bukti_foto' => $path]);

        return back()->with('success', 'Bukti berhasil diupload!');
    }
}
