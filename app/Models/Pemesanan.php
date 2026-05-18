<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'tgl_pesan' => 'datetime',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }

    public function jenisPembayaran()
    {
        return $this->belongsTo(JenisPembayaran::class, 'id_jenis_bayar');
    }

    public function details()
    {
        return $this->hasMany(DetailPemesanan::class, 'id_pemesanan');
    }

    public function pengiriman()
    {
        return $this->hasOne(Pengiriman::class, 'id_pemesanan');
    }
}
