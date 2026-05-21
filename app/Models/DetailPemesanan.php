<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class DetailPemesanan extends Model
{
    protected $table = 'detail_pemesanans';
    protected $fillable = ['id_pemesanan', 'id_paket', 'subtotal'];

    public function pemesanan() {
        return $this->belongsTo(Pemesanan::class, 'id_pemesanan');
    }
    public function paket() {
        return $this->belongsTo(Paket::class, 'id_paket');
    }
}

