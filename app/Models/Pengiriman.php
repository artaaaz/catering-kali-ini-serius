<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    protected $table = 'pengirimans';
    
    protected $fillable = [
        'id_pemesanan',
        'id_user',
        'tgl_kirim',
        'tgl_tiba',
        'status_kirim',
        'bukti_foto',
    ];

    protected $casts = [
        'tgl_kirim' => 'datetime',
        'tgl_tiba' => 'datetime',
    ];

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'id_pemesanan');
    }

    public function kurir()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}