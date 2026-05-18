<?php

namespace App\Services;

use App\Repositories\Interfaces\PemesananRepositoryInterface;
use App\Models\DetailPemesanan;
use Illuminate\Support\Facades\DB;

class PemesananService
{
    protected $repository;

    public function __construct(PemesananRepositoryInterface $repository)
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

    public function createPemesanan(array $data)
    {
        return DB::transaction(function () use ($data) {
            // Create pemesanan
            $pemesanan = $this->repository->create([
                'id_pelanggan' => $data['id_pelanggan'],
                'id_jenis_bayar' => $data['id_jenis_bayar'] ?? null,
                'tgl_pesan' => $data['tgl_pesan'] ?? now(),
                'status_pesan' => 'Menunggu Konfirmasi',
                'total_bayar' => $data['total_bayar'],
                'no_resi' => 'RESI-' . strtoupper(uniqid()),
            ]);

            // Create detail pemesanan
            foreach ($data['details'] as $detail) {
                DetailPemesanan::create([
                    'id_pemesanan' => $pemesanan->id,
                    'id_paket' => $detail['id_paket'],
                    'subtotal' => $detail['subtotal'],
                ]);
            }

            return $pemesanan->load(['details.paket', 'pelanggan']);
        });
    }

    public function updateStatus($id, $status)
    {
        return $this->repository->update($id, ['status_pesan' => $status]);
    }
}
