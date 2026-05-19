<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\PaketController as AdminPaket;
use App\Http\Controllers\Admin\PemesananController as AdminPemesanan;
use App\Http\Controllers\Admin\PelangganController as AdminPelanggan;
use App\Http\Controllers\Owner\DashboardController as OwnerDashboard;
use App\Http\Controllers\Kurir\DashboardController as KurirDashboard;
use App\Http\Controllers\Pelanggan\DashboardController as PelangganDashboard;
use App\Http\Controllers\Pelanggan\PaketController as PelangganPaket;
use App\Http\Controllers\Pelanggan\PemesananController as PelangganPemesanan;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ─────────────────────────────────────────────────────────────
// PUBLIC ROUTES
// ─────────────────────────────────────────────────────────────
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Katalog paket publik (tanpa login)
Route::get('/pakets', [PelangganPaket::class, 'index'])->name('pelanggan.pakets.index');
Route::get('/pakets/{paket}', [PelangganPaket::class, 'show'])->name('pelanggan.pakets.show');

// ─────────────────────────────────────────────────────────────
// DEFAULT DASHBOARD (BREEZE FALLBACK)
// ─────────────────────────────────────────────────────────────
Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    $user = auth()->user();

    if ($user->level ?? null) {
        return match ($user->level) {
            'admin' => redirect()->route('admin.dashboard'),
            'owner' => redirect()->route('owner.dashboard'),
            'kurir' => redirect()->route('kurir.dashboard'),
            default => view('dashboard'),
        };
    }

    if (get_class($user) === 'App\Models\Pelanggan') {
        return redirect()->route('pelanggan.dashboard');
    }

    return view('dashboard');
})->name('dashboard');

// ─────────────────────────────────────────────────────────────
// ADMIN ROUTES
// ─────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    // CRUD Paket
    Route::resource('pakets', AdminPaket::class);

    // CRUD Pemesanan
    Route::resource('pemesanans', AdminPemesanan::class);
    Route::patch('/pemesanans/{pemesanan}/status', [AdminPemesanan::class, 'updateStatus'])->name('pemesanans.updateStatus');

    // CRUD Pelanggan
    Route::resource('pelanggans', AdminPelanggan::class);

    // Laporan
    Route::get('/laporan', [AdminDashboard::class, 'laporan'])->name('laporan');
});

// ─────────────────────────────────────────────────────────────
// OWNER ROUTES
// ─────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:owner'])->prefix('owner')->name('owner.')->group(function () {
    Route::get('/dashboard', [OwnerDashboard::class, 'index'])->name('dashboard');
    Route::get('/laporan-pdf', [OwnerDashboard::class, 'exportPdf'])->name('laporan.pdf');
    Route::get('/stats', [OwnerDashboard::class, 'stats'])->name('stats');
});

// ─────────────────────────────────────────────────────────────
// KURIR ROUTES
// ─────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:kurir'])->prefix('kurir')->name('kurir.')->group(function () {
    Route::get('/dashboard', [KurirDashboard::class, 'index'])->name('dashboard');
    Route::get('/pengiriman', [KurirDashboard::class, 'pengiriman'])->name('pengiriman');
    Route::patch('/pengiriman/{id}/update-status', [KurirDashboard::class, 'updateStatus'])->name('pengiriman.update');
    Route::post('/pengiriman/{id}/upload-bukti', [KurirDashboard::class, 'uploadBukti'])->name('pengiriman.upload');
});

// ─────────────────────────────────────────────────────────────
// PELANGGAN ROUTES
// ─────────────────────────────────────────────────────────────
Route::middleware(['auth'])->prefix('pelanggan')->name('pelanggan.')->group(function () {
    Route::get('/dashboard', [PelangganDashboard::class, 'index'])->name('dashboard');

    // Pemesanan
    Route::get('/pesan', [PelangganPemesanan::class, 'create'])->name('pesan.create');
    Route::post('/pesan', [PelangganPemesanan::class, 'store'])->name('pesan.store');
    Route::get('/riwayat', [PelangganPemesanan::class, 'riwayat'])->name('riwayat');
    Route::get('/pemesanan/{pemesanan}', [PelangganPemesanan::class, 'show'])->name('pemesanan.show');
    Route::post('/pemesanan/{pemesanan}/upload-bayar', [PelangganPemesanan::class, 'uploadBuktiBayar'])->name('pemesanan.uploadBayar');

    // Profile Pelanggan (khusus model Pelanggan)
    Route::get('/profile', [PelangganDashboard::class, 'profile'])->name('profile');
    Route::put('/profile', [PelangganDashboard::class, 'updateProfile'])->name('profile.update');
});

// ─────────────────────────────────────────────────────────────
// PROFILE ROUTES (BREEZE - UNTUK MODEL User: admin/owner/kurir)
// ─────────────────────────────────────────────────────────────
// Profile Routes (Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ─────────────────────────────────────────────────────────────
// AUTH ROUTES (BREEZE - JANGAN DIUBAH)
// ─────────────────────────────────────────────────────────────
require __DIR__.'/auth.php';