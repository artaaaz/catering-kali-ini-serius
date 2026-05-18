<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemesanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pelanggan')->constrained('pelanggans')->cascadeOnDelete();
            $table->foreignId('id_jenis_bayar')->nullable()->constrained('jenis_pembayarans')->nullOnDelete();
            $table->string('no_resi', 30)->nullable();
            $table->dateTime('tgl_pesan');
            $table->enum('status_pesan', ['Menunggu Konfirmasi', 'Sedang Diproses', 'Menunggu Kurir']);
            $table->bigInteger('total_bayar');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemesanans');
    }
};
