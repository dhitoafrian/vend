<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'peminjaman_id',
        'tanggal_kembali',
        'denda',
        'status'
    ];

    protected $casts = [
        'tanggal_kembali' => 'date',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }
}
