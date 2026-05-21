<?php
namespace App\Http\Controllers\Owner;
use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Models\Paket;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_pesanan' => Pemesanan::count(),
            'pendapatan_bulan_ini' => Pemesanan::whereMonth('created_at', now()->month)
                ->where('status_pesan', 'Selesai')
                ->sum('total_bayar'),
            'paket_terlaris' => Paket::withCount('pemesanans')
                ->orderByDesc('pemesanans_count')
                ->first(),
        ];
        return view('owner.dashboard', compact('stats'));
    }

    public function exportPdf()
    {
        // Simple: return view PDF atau redirect ke halaman print-friendly
        return view('owner.laporan-pdf', [
            'pemesanans' => Pemesanan::with(['pelanggan', 'pakets'])->latest()->get()
        ]);
    }
}

