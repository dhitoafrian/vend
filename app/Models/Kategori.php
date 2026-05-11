<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $fillable = [
        'nama_kategori',
        'denda_per_hari',
    ];

    public function alat()
    {
        return $this->hasMany(Alat::class);
    }
}
