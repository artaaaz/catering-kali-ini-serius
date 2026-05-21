<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    protected $table = 'pemesanans';

    protected $fillable = [
        'id_pelanggan',
        'id_jenis_bayar',
        'tgl_pesan',
        'status_pesan',
        'total_bayar',
        'no_resi',
        'alamat1',
        'tgl_acara',
    ];

    // Relasi pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }

    // Relasi paket (many to many)
    public function pakets()
    {
        return $this->belongsToMany(
            Paket::class,
            'detail_pemesanans',
            'id_pemesanan',
            'id_paket'
        );
    }
}
