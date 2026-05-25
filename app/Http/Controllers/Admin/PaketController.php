<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\PaketService;
use App\Http\Requests\StorePaketRequest;
use App\Http\Requests\UpdatePaketRequest;
use App\Models\Paket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaketController extends Controller
{
    protected $paketService;

    public function __construct(PaketService $paketService)
    {
        $this->paketService = $paketService;
    }

    public function index()
    {
        $pakets = $this->paketService->getAllPaginated(10);
        return view('admin.pakets.index', compact('pakets'));
    }

    public function create()
    {
        return view('admin.pakets.create');
    }

    public function store(Request $request)
    {
        // 1. VALIDASI (Pastikan jumlah_pax ada di sini)
        $validated = $request->validate([
            'nama_paket'  => 'required|string|max:255',
            'jenis'       => 'required|in:Prasmanan,Box,Nasi Kotak',
            'kategori'    => 'required|in:Ulang Tahun,Wedding,Rapat,Study Tour',
            'harga_paket' => 'required|numeric|min:0',
            'jumlah_pax'  => 'required|integer|min:1', // ✅ VALIDASI
            'deskripsi'   => 'nullable|string',
            'foto1'       => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'foto2'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto3'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. UPLOAD FOTO
        $foto1 = $request->file('foto1')->store('pakets', 'public');
        $foto2 = $request->hasFile('foto2') ? $request->file('foto2')->store('pakets', 'public') : null;
        $foto3 = $request->hasFile('foto3') ? $request->file('foto3')->store('pakets', 'public') : null;

        // 3. SIMPAN KE DATABASE (Pastikan jumlah_pax ada di array ini!)
        Paket::create([
            'nama_paket'  => $validated['nama_paket'],
            'jenis'       => $validated['jenis'],
            'kategori'    => $validated['kategori'],
            'harga_paket' => $validated['harga_paket'],
            'jumlah_pax'  => $validated['jumlah_pax'], // ✅ INI YANG SERING HILANG! PASTIKAN ADA!
            'deskripsi'   => $validated['deskripsi'] ?? null,
            'foto1'       => $foto1,
            'foto2'       => $foto2,
            'foto3'       => $foto3,
        ]);

        return redirect()->route('admin.pakets.index')->with('success', 'Paket berhasil ditambahkan!');
    }


    public function show($id)
    {
        $paket = $this->paketService->findById($id);
        return view('admin.pakets.show', compact('paket'));
    }

    public function edit($id)
    {
        $paket = $this->paketService->findById($id);
        return view('admin.pakets.edit', compact('paket'));
    }

    public function update(Request $request, Paket $paket)
    {
        $validated = $request->validate([
            'nama_paket'  => 'required|string|max:255',
            'jenis'       => 'required|in:Prasmanan,Box,Nasi Kotak',
            'kategori'    => 'required|in:Ulang Tahun,Wedding,Rapat,Study Tour',
            'harga_paket' => 'required|numeric|min:0',
            'jumlah_pax'  => 'required|integer|min:1',
            'deskripsi'   => 'nullable|string',
            'foto1'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto2'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto3'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle update foto (hapus lama jika ada yang baru)
        if ($request->hasFile('foto1')) {
            Storage::disk('public')->delete($paket->foto1);
            $validated['foto1'] = $request->file('foto1')->store('pakets', 'public');
        }
        if ($request->hasFile('foto2')) {
            if ($paket->foto2) Storage::disk('public')->delete($paket->foto2);
            $validated['foto2'] = $request->file('foto2')->store('pakets', 'public');
        }
        if ($request->hasFile('foto3')) {
            if ($paket->foto3) Storage::disk('public')->delete($paket->foto3);
            $validated['foto3'] = $request->file('foto3')->store('pakets', 'public');
        }

        $paket->update($validated);

        return redirect()->route('admin.pakets.index')->with('success', 'Paket berhasil diupdate!');
    }

    public function destroy($id)
    {
        try {
            $this->paketService->deletePaket($id);
            return redirect()->route('admin.pakets.index')
                ->with('success', 'Paket berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal hapus paket: ' . $e->getMessage());
        }
    }
}
