<?php

namespace Database\Seeders;

use App\Models\Alat;
use App\Models\Kategori;
use Illuminate\Database\Seeder;

class AlatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoriKomputer = Kategori::where('nama_kategori', 'Komputer')->first();
        $kategoriVisual = Kategori::where('nama_kategori', 'Visual')->first();
        $kategoriAudio = Kategori::where('nama_kategori', 'Audio')->first();

        if (! $kategoriKomputer || ! $kategoriVisual || ! $kategoriAudio) {
            return;
        }

        $alats = [
            [
                'nama_alat' => 'PC',
                'kategori_id' => $kategoriKomputer->id,
                'foto' => 'alat/pc.jpg',
                'stok' => 10,
                'status' => 'tersedia',
            ],
            [
                'nama_alat' => 'Proyektor',
                'kategori_id' => $kategoriVisual->id,
                'foto' => 'alat/proyektor.jpg',
                'stok' => 6,
                'status' => 'tersedia',
            ],
            [
                'nama_alat' => 'Mikrofon',
                'kategori_id' => $kategoriAudio->id,
                'foto' => 'alat/mikrofon.jpg',
                'stok' => 8,
                'status' => 'tersedia',
            ],
        ];

        foreach ($alats as $alat) {
            Alat::updateOrCreate(
                ['nama_alat' => $alat['nama_alat']],
                $alat
            );
        }
    }
}
