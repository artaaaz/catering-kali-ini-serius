<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Paket;
use App\Models\JenisPembayaran;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Admin - Pakai updateOrCreate biar nggak error kalau udah ada
        User::updateOrCreate(
            ['email' => 'admin@catering.com'],
            [
                'name' => 'Admin Catering',
                'password' => Hash::make('password'),
                'level' => 'admin'
            ]
        );

        // Owner
        User::updateOrCreate(
            ['email' => 'owner@catering.com'],
            [
                'name' => 'Owner Catering',
                'password' => Hash::make('password'),
                'level' => 'owner'
            ]
        );

        // Kurir
        User::updateOrCreate(
            ['email' => 'kurir@catering.com'],
            [
                'name' => 'Kurir Cepat',
                'password' => Hash::make('password'),
                'level' => 'kurir'
            ]
        );

        // Paket Dummy (hapus dulu yang lama, biar nggak duplikat)
        Paket::truncate();

        Paket::create([
            'nama_paket' => 'Paket Hemat',
            'jenis' => 'Box',
            'kategori' => 'Rapat',
            'harga_paket' => 25000,
            'jumlah_pax' => 10,
            'deskripsi' => 'Paket hemat untuk acara kecil',
            'foto1' => 'pakets/dummy1.jpg'
        ]);

        Paket::create([
            'nama_paket' => 'Paket Menengah',
            'jenis' => 'Prasmanan',
            'kategori' => 'Pernikahan',
            'harga_paket' => 50000,
            'jumlah_pax' => 50,
            'deskripsi' => 'Paket untuk acara pernikahan',
            'foto1' => 'pakets/dummy2.jpg'
        ]);

        // Metode Pembayaran (truncate dulu)
        JenisPembayaran::truncate();

        JenisPembayaran::insert([
            ['metode_pembayaran' => 'BCA'],
            ['metode_pembayaran' => 'Mandiri'],
            ['metode_pembayaran' => 'BNI'],
            ['metode_pembayaran' => 'Cash']
        ]);
    }
}
