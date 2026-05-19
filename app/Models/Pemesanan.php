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

    // Relasi ke Pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }

    // Relasi ke Paket (melalui detail_pemesanan atau langsung)
    public function paket()
    {
        // Kalau pakai tabel pivot/detail_pemesanan:
        // return $this->belongsToMany(Paket::class, 'detail_pemesanans', 'id_pemesanan', 'id_paket');
        
        // Kalau langsung (sederhana):
        return $this->belongsTo(Paket::class, 'id_paket'); // Sesuaikan dengan struktur database kamu
    }
}

