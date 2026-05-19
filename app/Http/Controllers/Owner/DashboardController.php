<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik Real-time
        $totalPendapatan = DB::table('pemesanans')
            ->where('status_pesan', 'Lunas')
            ->sum('total_bayar');
        
        $totalPesanan = DB::table('pemesanans')->count();
        $totalPaket = DB::table('pakets')->count();
        $pesananProses = DB::table('pemesanans')
            ->whereIn('status_pesan', ['Menunggu Konfirmasi', 'Sedang Diproses'])
            ->count();

        // Data Chart: Pendapatan Bulanan (6 bulan terakhir)
        $monthlyRevenue = DB::table('pemesanans')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(total_bayar) as total'))
            ->where('status_pesan', 'Lunas')
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        // Lengkapi array 1-12 biar chart rapi
        $chartData = array_fill(1, 12, 0);
        foreach($monthlyRevenue as $m => $t) { $chartData[$m] = $t; }

        return view('owner.dashboard', compact('totalPendapatan', 'totalPesanan', 'totalPaket', 'pesananProses', 'chartData'));
    }

    public function exportPdf()
    {
        $pemesanans = DB::table('pemesanans')
            ->join('pelanggans', 'pemesanans.id_pelanggan', '=', 'pelanggans.id')
            ->select('pemesanans.*', 'pelanggans.nama_pelanggan')
            ->latest()
            ->get();

        $pdf = Pdf::loadView('owner.pdf.laporan', compact('pemesanans'));
        return $pdf->download('laporan-pemesanan-' . now()->format('d-m-Y') . '.pdf');
    }

    public function stats()
    {
        return redirect()->route('owner.dashboard');
    }
}

