<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = [
            'Komputer',
            'Audio',
            'Visual',
        ];

        foreach ($kategoris as $namaKategori) {
            Kategori::updateOrCreate(
                ['nama_kategori' => $namaKategori],
                ['nama_kategori' => $namaKategori]
            );
        }
    }
}
