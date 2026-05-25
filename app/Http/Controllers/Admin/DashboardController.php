<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Paket;
use App\Models\Pemesanan;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik
        $totalPaket = \App\Models\Paket::count();
        $pesananBaru = \App\Models\Pemesanan::where('status_pesan', 'Menunggu Konfirmasi')->count();
        $totalPelanggan = \App\Models\User::where('level', 'pelanggan')->count();
        $pendapatan = \App\Models\Pemesanan::where('status_pesan', 'Selesai')->sum('total_bayar');

        // Pesanan terbaru
        $recentOrders = \App\Models\Pemesanan::with('pelanggan')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalPaket',
            'pesananBaru',
            'totalPelanggan',
            'pendapatan',
            'recentOrders'
        ));
    }
}
