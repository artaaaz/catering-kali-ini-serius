<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\PaketService;
use App\Http\Requests\StorePaketRequest;
use App\Http\Requests\UpdatePaketRequest;
use Illuminate\Http\Request;

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

    public function store(StorePaketRequest $request)
    {
        $this->paketService->createPaket($request->validated());

        return redirect()->route('admin.pakets.index')
            ->with('success', 'Paket berhasil ditambahkan!');
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
        $this->paketService->updatePaket($id, $request->validated());

        return redirect()->route('admin.pakets.index')
            ->with('success', 'Paket berhasil diupdate!');
    }

    public function destroy($id)
    {
        $this->paketService->deletePaket($id);

        return redirect()->route('admin.pakets.index')
            ->with('success', 'Paket berhasil dihapus!');
    }
}
