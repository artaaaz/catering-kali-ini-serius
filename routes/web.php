<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Paket;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\PaketController as AdminPaket;
use App\Http\Controllers\Admin\PemesananController as AdminPemesanan;
use App\Http\Controllers\Owner\DashboardController as OwnerDashboard;
use App\Http\Controllers\Kurir\DashboardController as KurirDashboard;
use App\Http\Controllers\Pelanggan\DashboardController as PelangganDashboard;
use App\Http\Controllers\Pelanggan\PaketController as PelangganPaket;
use App\Http\Controllers\Pelanggan\PemesananController as PelangganPemesanan;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes - FINAL CLEAN VERSION
|--------------------------------------------------------------------------
*/

// ========== PUBLIC ROUTES ==========
Route::get('/', fn() => view('welcome'))->name('home');
Route::get('/test-view', function () {
    return '<h1 style="color: green; font-family: sans-serif;">✅ HALAMAN INI MUNCUL! LARAVEL JALAN!</h1>';
});

Route::get('/pakets', function () {
    $pakets = \App\Models\Paket::paginate(6);
    return view('pakets.index', compact('pakets'));
})->name('pakets.index');

Route::get('/pakets/{paket}', [PelangganPaket::class, 'show'])->name('pelanggan.pakets.show');

// ========== AUTH ROUTES (SIMPLE & PASTI) ==========

// Register Form
Route::middleware('guest')->get('/register', function () {
    return view('auth.register');
})->name('register');

// Register Process
Route::middleware('guest')->post('/register', function (Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'level' => 'pelanggan', // ✅ Auto jadi pelanggan
    ]);

    Auth::login($user);
    return redirect()->route('pelanggan.riwayat');
});

// Login Form
Route::middleware('guest')->get('/login', function () {
    return view('auth.login');
})->name('login');

// Login Process
Route::middleware('guest')->post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();
        $user = Auth::user();

        return match ($user->level ?? 'pelanggan') {
            'admin' => redirect()->route('admin.dashboard'),
            'owner' => redirect()->route('owner.dashboard'),
            'kurir' => redirect()->route('kurir.dashboard'),
            default => redirect()->route('pelanggan.riwayat'),
        };
    }

    return back()->withErrors(['email' => 'Email atau password salah'])->withInput();
});

// Logout
Route::middleware('auth')->post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// ========== DASHBOARD REDIRECT ==========
Route::middleware('auth')->get('/dashboard', function () {
    $user = Auth::user();
    return match ($user->level ?? 'pelanggan') {
        'admin' => redirect()->route('admin.dashboard'),
        'owner' => redirect()->route('owner.dashboard'),
        'kurir' => redirect()->route('kurir.dashboard'),
        default => redirect()->route('pelanggan.riwayat'),
    };
})->name('dashboard');

// ========== ADMIN ROUTES ==========
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::resource('pakets', AdminPaket::class);
    Route::resource('pemesanans', AdminPemesanan::class);
    Route::patch('/pemesanans/{pemesanan}/status', [AdminPemesanan::class, 'updateStatus'])->name('pemesanans.updateStatus');
    Route::get('/laporan', [AdminDashboard::class, 'laporan'])->name('laporan');
});

Route::get('/admin/pelanggans', function () {
    return view('admin.pelanggans.index');
})->name('admin.pelanggans.index');

// ========== OWNER ROUTES ==========
Route::middleware('auth')->prefix('owner')->name('owner.')->group(function () {
    Route::get('/dashboard', [OwnerDashboard::class, 'index'])->name('dashboard');
    Route::get('/laporan-pdf', [OwnerDashboard::class, 'exportPdf'])->name('laporan.pdf');
});

// ========== KURIR ROUTES ==========
Route::middleware('auth')->prefix('kurir')->name('kurir.')->group(function () {
    Route::get('/dashboard', [KurirDashboard::class, 'index'])->name('dashboard');
    Route::get('/pengiriman', [KurirDashboard::class, 'pengiriman'])->name('pengiriman');
    Route::patch('/pengiriman/{id}/status', [KurirDashboard::class, 'updateStatus'])->name('pengiriman.status');
    Route::post('/pengiriman/{id}/bukti', [KurirDashboard::class, 'uploadBukti'])->name('pengiriman.bukti');
});

Route::get('/kurir/riwayat', [KurirDashboard::class, 'riwayat'])->name('kurir.riwayat');
Route::get('/kurir/profile', [KurirDashboard::class, 'profile'])->name('kurir.profile');

// ========== PELANGGAN ROUTES ==========
Route::middleware('auth')->prefix('pelanggan')->name('pelanggan.')->group(function () {
    // Form order paket (dengan ID)
    Route::get('/pesan/{id}', [\App\Http\Controllers\Pelanggan\PemesananController::class, 'create'])
        ->name('pesan.create');

    // Submit order
    Route::post('/pesan', [\App\Http\Controllers\Pelanggan\PemesananController::class, 'store'])
        ->name('pesan.store');

    // Riwayat pesanan
    Route::get('/riwayat', [\App\Http\Controllers\Pelanggan\PemesananController::class, 'riwayat'])
        ->name('riwayat');

    // Detail pesanan
    Route::get('/pemesanan/{pemesanan}', [\App\Http\Controllers\Pelanggan\PemesananController::class, 'show'])
        ->name('pemesanan.show');
});

// ========== PROFILE ROUTES (BREEZE) ==========
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
