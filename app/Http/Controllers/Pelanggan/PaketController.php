<?php
namespace App\Http\Controllers\Pelanggan;
use App\Http\Controllers\Controller;
use App\Models\Paket;

class PaketController extends Controller
{
    public function index()
    {
        $pakets = \App\Models\Paket::latest()->paginate(9);
        return view('pakets.index', compact('pakets'));
    }
    public function show($id) {
        $paket = Paket::findOrFail($id);
        return view('pelanggan.pakets.show', compact('paket'));
    }
}
