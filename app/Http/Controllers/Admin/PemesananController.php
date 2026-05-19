<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use Illuminate\Http\Request;

class PemesananController extends Controller
{
    public function index()
    {
        $pemesanans = Pemesanan::with(['pelanggan', 'paket'])->latest()->paginate(10);
        return view('admin.pemesanans.index', compact('pemesanans'));
    }

    public function show($id)
    {
        $pemesanan = Pemesanan::with(['pelanggan', 'paket'])->findOrFail($id);
        return view('admin.pemesanans.show', compact('pemesanan'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_pesan' => 'required|in:Menunggu Konfirmasi,Diproses,Selesai,Dibatalkan'
        ]);

        $pemesanan = Pemesanan::findOrFail($id);
        $pemesanan->update(['status_pesan' => $request->status_pesan]);

        return back()->with('success', 'Status berhasil diupdate!');
    }
}