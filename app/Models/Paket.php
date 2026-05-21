<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    protected $table = 'pakets';
    
    protected $fillable = [
        'nama_paket',
        'jenis',
        'kategori',
        'jumlah_pax',
        'harga_paket',
        'deskripsi',
        'foto1',
        'foto2',
        'foto3',
    ];

    // ✅ HANYA SATU RELASI INI (hapus yang duplikat)
    public function pemesanans()
    {
        return $this->belongsToMany(Pemesanan::class, 'detail_pemesanans', 'id_paket', 'id_pemesanan')
                    ->withPivot('subtotal');
    }
}
