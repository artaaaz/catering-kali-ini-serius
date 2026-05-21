<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    // ⚠️ PENTING: Sesuaikan dengan nama tabel di database kamu
    protected $table = 'pengirimans';  // ← Pakai 'pengirimans' (plural)

    protected $fillable = [
        'id_pemesanan',
        'id_kurir',
        'status_kirim',
        'bukti_foto',
        'resi_number',  
        'tgl_kirim',
        'tgl_sampai',
    ];

    protected $casts = [
        'tgl_kirim' => 'datetime',
        'tgl_sampai' => 'datetime',
    ];

    // Relasi ke Pemesanan
    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'id_pemesanan');
    }

    // Relasi ke Kurir (User)
    public function kurir()
    {
        return $this->belongsTo(User::class, 'id_kurir');
    }
}
