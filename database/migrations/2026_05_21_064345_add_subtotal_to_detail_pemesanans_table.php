<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('detail_pemesanans', function (Blueprint $table) {
            // Cek dulu biar nggak error duplicate
            if (!Schema::hasColumn('detail_pemesanans', 'subtotal')) {
                $table->bigInteger('subtotal')->default(0)->after('id_paket');
            }
        });
    }

    public function down()
    {
        Schema::table('detail_pemesanans', function (Blueprint $table) {
            $table->dropColumn('subtotal');
        });
    }
};