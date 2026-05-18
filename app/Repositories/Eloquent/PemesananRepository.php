<?php

namespace App\Repositories\Eloquent;

use App\Models\Pemesanan;
use App\Repositories\Interfaces\PemesananRepositoryInterface;

class PemesananRepository implements PemesananRepositoryInterface
{
    protected $model;

    public function __construct(Pemesanan $model)
    {
        $this->model = $model;
    }

    public function getAllPaginated($perPage = 10)
    {
        return $this->model->with(['pelanggan', 'details.paket', 'pengiriman'])
            ->latest()
            ->paginate($perPage);
    }

    public function findById($id)
    {
        return $this->model->with(['pelanggan', 'details.paket', 'jenisPembayaran', 'pengiriman'])
            ->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $pemesanan = $this->findById($id);
        $pemesanan->update($data);
        return $pemesanan;
    }
}
