<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_pemesanans', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_pemesanan');
            $table->unsignedBigInteger('id_paket');

            $table->integer('qty')->default(1);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_pemesanans');
    }
};
