<?php

namespace App\Repositories\Eloquent;

use App\Models\Paket;
use App\Repositories\Interfaces\PaketRepositoryInterface;

class PaketRepository implements PaketRepositoryInterface
{
    protected $model;

    public function __construct(Paket $model)
    {
        $this->model = $model;
    }

    public function getAllPaginated($perPage = 10)
    {
        return $this->model->latest()->paginate($perPage);
    }

    public function findById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $paket = $this->findById($id);
        $paket->update($data);
        return $paket;
    }

    public function delete($id)
    {
        $paket = $this->findById($id);
        return $paket->delete();
    }
}
