<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_paket' => 'required|string|max:50',
            'jenis' => 'required|in:Prasmanan,Box',
            'kategori' => 'required|in:Pernikahan,Selamatan,Ulang Tahun,Studi Tour,Rapat',
            'jumlah_pax' => 'required|integer|min:1',
            'harga_paket' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'foto1' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto2' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto3' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_paket.required' => 'Nama paket wajib diisi',
            'jenis.required' => 'Jenis paket wajib dipilih',
            'kategori.required' => 'Kategori wajib dipilih',
            'jumlah_pax.required' => 'Jumlah pax wajib diisi',
            'harga_paket.required' => 'Harga paket wajib diisi',
            'foto1.image' => 'Foto harus berupa gambar',
            'foto1.max' => 'Ukuran foto maksimal 2MB',
        ];
    }
}
