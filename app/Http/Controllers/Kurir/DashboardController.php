<?php

namespace App\Http\Controllers\Kurir;

use App\Http\Controllers\Controller;
use App\Models\Pengiriman;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // ✅ TAMBAHKAN INI!

class DashboardController extends Controller
{
    // Dashboard Kurir (Lihat tugas pengiriman)
    public function index()
    {
        // Statistik - GANTI id_kurir jadi id_user
        $totalPengiriman = \App\Models\Pengiriman::where('id_user', Auth::id())->count();

        $sedangDikirim = \App\Models\Pengiriman::where('id_user', Auth::id())
            ->where('status_kirim', 'Sedang Dikirim')
            ->count();

        $selesai = \App\Models\Pengiriman::where('id_user', Auth::id())
            ->where('status_kirim', 'Tiba Ditujuan')
            ->count();

        // Pengiriman terbaru
        $recentPengiriman = \App\Models\Pengiriman::where('id_user', Auth::id())
            ->with(['pemesanan.pelanggan'])
            ->latest()
            ->limit(5)
            ->get();

        return view('kurir.dashboard', compact(
            'totalPengiriman',
            'sedangDikirim',
            'selesai',
            'recentPengiriman'
        ));
    }

    // Halaman List Pesanan untuk Kurir
    public function pengiriman()
    {
        // Ambil pesanan yang statusnya butuh kurir
        $pemesanans = Pemesanan::whereIn('status_pesan', ['Menunggu Kurir', 'Sedang Dikirim'])
            ->with(['pelanggan', 'pakets'])
            ->latest()
            ->get();

        return view('kurir.pengiriman', compact('pemesanans'));
    }

    // Update Status Pengiriman
    public function updateStatus(Request $request, $id)
    {
        $pemesanan = Pemesanan::findOrFail($id);

        // Update status di tabel pemesanans
        $pemesanan->update(['status_pesan' => $request->status_kirim]);

        // Jika status jadi "Sedang Dikirim", catat/update di tabel pengirimans
        if ($request->status_kirim == 'Sedang Dikirim') {
            \App\Models\Pengiriman::updateOrCreate(
                [
                    'id_pemesanan' => $id,  // ✅ PAKAI INI!
                ],
                [
                    'id_user' => Auth::id(),
                    'tgl_kirim' => now(),
                    'status_kirim' => 'Sedang Dikirim'
                ]
            );
        }

        return back()->with('success', 'Status berhasil diupdate!');
    }

    // Upload Bukti Foto Pengiriman
    public function uploadBukti(Request $request, $id)
    {
        $request->validate([
            'bukti_foto' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // ✅ Cari berdasarkan id_pemesanan
        $pengiriman = \App\Models\Pengiriman::where('id_pemesanan', $id)->first();

        // Kalau belum ada record, buat baru
        if (!$pengiriman) {
            $pengiriman = new \App\Models\Pengiriman();
            $pengiriman->id_pemesanan = $id;  // ✅ PAKAI INI!
            $pengiriman->id_user = Auth::id();
            $pengiriman->tgl_kirim = now();
        }

        // Upload file
        $path = $request->file('bukti_foto')->store('bukti-pengiriman', 'public');

        // Update data
        $pengiriman->bukti_foto = $path;
        $pengiriman->status_kirim = 'Tiba Ditujuan';  // Atau 'Tiba Di Tujuan' (sesuaikan)
        $pengiriman->save();

        // Update juga status di tabel pemesanans jadi "Selesai"
        Pemesanan::findOrFail($id)->update(['status_pesan' => 'Selesai']);

        return back()->with('success', 'Bukti berhasil diupload! Pesanan selesai.');
    }

    public function riwayat()
    {
        $pengirimans = \App\Models\Pengiriman::where('id_user', Auth::id())
            ->with(['pemesanan.pelanggan'])
            ->latest()
            ->paginate(10);

        return view('kurir.riwayat', compact('pengirimans'));
    }

}
