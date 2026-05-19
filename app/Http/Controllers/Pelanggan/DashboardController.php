<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index() { return view('pelanggan.dashboard'); }
    public function profile() { return view('pelanggan.profile'); }
    public function updateProfile() { return back()->with('success', 'Profile updated'); }
}

