<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    protected $fillable = [
        'nama_alat',
        'kategori_id',
        'foto',
        'stok',
        'status'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function peminjaman()
    {
        return $this->hasMany(DetailPeminjaman::class);
    }
}
