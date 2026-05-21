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

    public function store(Request $request, PaketService $service)
    {
        $validated = $request->validate([
            'nama_paket' => 'required|string|max:255',
            'jenis' => 'required|in:Prasmanan,Box',
            'kategori' => 'required|string',
            'jumlah_pax' => 'required|integer|min:1',
            'harga_paket' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'foto1' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto2' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto3' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // ✅ Kirim $request->all() atau $validated ke service
        $paket = $service->createPaket($request->all());

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

    public function update(UpdatePaketRequest $request, $id)
    {
        try {
            $paket = $this->paketService->findById($id);
            $data = $request->validated();

            // Handle upload foto baru & hapus foto lama
            if ($request->hasFile('foto1')) {
                if ($paket->foto1) Storage::disk('public')->delete($paket->foto1);
                $data['foto1'] = $request->file('foto1')->store('pakets', 'public');
            }
            if ($request->hasFile('foto2')) {
                if ($paket->foto2) Storage::disk('public')->delete($paket->foto2);
                $data['foto2'] = $request->file('foto2')->store('pakets', 'public');
            }
            if ($request->hasFile('foto3')) {
                if ($paket->foto3) Storage::disk('public')->delete($paket->foto3);
                $data['foto3'] = $request->file('foto3')->store('pakets', 'public');
            }

            $this->paketService->updatePaket($id, $data);

            return redirect()->route('admin.pakets.index')
                ->with('success', 'Paket berhasil diupdate!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal update paket: ' . $e->getMessage());
        }
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
