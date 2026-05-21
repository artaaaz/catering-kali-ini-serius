<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    protected $table = 'pemesanans';
    
    protected $fillable = [
        'id_pelanggan',
        'id_jenis_bayar',
        'no_resi',
        'tgl_pesan',
        'status_pesan',
        'total_bayar',
    ];

    protected $casts = [
        'tgl_pesan' => 'datetime',
    ];

    // ✅ RELASI KE PELANGGAN (1 method aja)
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }

    // ✅ RELASI KE JENIS PEMBAYARAN
    public function jenisPembayaran()
    {
        return $this->belongsTo(JenisPembayaran::class, 'id_jenis_bayar');
    }

    // ✅ RELASI KE DETAIL PEMESANAN
    public function details()
    {
        return $this->hasMany(DetailPemesanan::class, 'id_pemesanan');
    }

    // ✅ RELASI KE PAKET (MANY-TO-MANY, 1 method aja)
    public function pakets()
    {
        return $this->belongsToMany(Paket::class, 'detail_pemesanans', 'id_pemesanan', 'id_paket')
                    ->withPivot('subtotal');
    }
}