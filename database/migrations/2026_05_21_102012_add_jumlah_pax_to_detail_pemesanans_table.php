<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('detail_pemesanans', function (Blueprint $table) {
            if (!Schema::hasColumn('detail_pemesanans', 'jumlah_pax')) {
                $table->integer('jumlah_pax')->default(1)->after('subtotal');
            }
        });
    }

    public function down()
    {
        Schema::table('detail_pemesanans', function (Blueprint $table) {
            $table->dropColumn('jumlah_pax');
        });
    }
};
