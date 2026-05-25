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
        'tgl_acara',
        'alamat_pengiriman',
        'jumlah_pax',
        'status_pesan',
        'total_bayar',
        'bukti_bayar',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(User::class, 'id_pelanggan');
    }

    public function jenisPembayaran()
    {
        return $this->belongsTo(JenisPembayaran::class, 'id_jenis_bayar');
    }

    public function pakets()
    {
        return $this->belongsToMany(Paket::class, 'detail_pemesanans', 'id_pemesanan', 'id_paket');
    }
}
