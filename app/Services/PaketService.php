<?php

namespace App\Services;

use App\Repositories\Interfaces\PaketRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class PaketService
{
    protected $repository;

    public function __construct(PaketRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAllPaginated($perPage = 10)
    {
        return $this->repository->getAllPaginated($perPage);
    }

    public function findById($id)
    {
        return $this->repository->findById($id);
    }

    public function createPaket(array $data)
    {
        // Handle file uploads dengan safety check
        if (isset($data['foto1']) && $data['foto1'] instanceof \Illuminate\Http\UploadedFile) {
            $data['foto1'] = $data['foto1']->store('pakets', 'public');
        } elseif (isset($data['foto1']) && is_string($data['foto1'])) {
            // Kalau string, hapus aja (mungkin file lama atau kosong)
            unset($data['foto1']);
        }

        if (isset($data['foto2']) && $data['foto2'] instanceof \Illuminate\Http\UploadedFile) {
            $data['foto2'] = $data['foto2']->store('pakets', 'public');
        } elseif (isset($data['foto2']) && is_string($data['foto2'])) {
            unset($data['foto2']);
        }

        if (isset($data['foto3']) && $data['foto3'] instanceof \Illuminate\Http\UploadedFile) {
            $data['foto3'] = $data['foto3']->store('pakets', 'public');
        } elseif (isset($data['foto3']) && is_string($data['foto3'])) {
            unset($data['foto3']);
        }

        return $this->repository->create($data);
    }

    public function updatePaket($id, array $data)
    {
        $paket = $this->repository->findById($id);

        // Handle file uploads jika ada
        if (isset($data['foto1']) && $data['foto1'] instanceof \Illuminate\Http\UploadedFile) {
            // Delete old file
            if ($paket->foto1) {
                Storage::disk('public')->delete($paket->foto1);
            }
            $data['foto1'] = $data['foto1']->store('pakets', 'public');
        }

        return $this->repository->update($id, $data);
    }

    public function deletePaket($id)
    {
        $paket = $this->repository->findById($id);

        // Delete images
        if ($paket->foto1) Storage::disk('public')->delete($paket->foto1);
        if ($paket->foto2) Storage::disk('public')->delete($paket->foto2);
        if ($paket->foto3) Storage::disk('public')->delete($paket->foto3);

        return $this->repository->delete($id);
    }
}
