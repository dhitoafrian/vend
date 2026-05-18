<?php

namespace App\Events;

use App\Models\Pengembalian;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PengembalianDiajukan implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Pengembalian $pengembalian;

    public function __construct(Pengembalian $pengembalian)
    {
        $this->pengembalian = $pengembalian->load(['peminjaman.user', 'peminjaman.detailPeminjaman.alat']);
    }

    public function broadcastOn(): array
    {
        // Penyiaran publik agar semua petugas tahu ada pengembalian baru
        return [
            new Channel('pengembalian-channel'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'pengembalian.diajukan';
    }

    public function broadcastWith(): array
    {
        $detail = $this->pengembalian->peminjaman->detailPeminjaman->first();
        return [
            'id' => $this->pengembalian->id,
            'peminjaman_id' => $this->pengembalian->peminjaman_id,
            'nama_peminjam' => $this->pengembalian->peminjaman->user->name,
            'tanggal_pinjam' => $this->pengembalian->peminjaman->tanggal_pinjam ? $this->pengembalian->peminjaman->tanggal_pinjam->format('Y-m-d') : '',
            'tanggal_kembali_rencana' => $this->pengembalian->peminjaman->tanggal_kembali_rencana ? $this->pengembalian->peminjaman->tanggal_kembali_rencana->format('Y-m-d') : '',
            'tanggal_kembali' => $this->pengembalian->tanggal_kembali ? $this->pengembalian->tanggal_kembali->format('Y-m-d') : '',
            'denda' => $this->pengembalian->denda,
            'status' => $this->pengembalian->status, // 'tepat' atau 'terlambat'
            'alat_name' => $detail && $detail->alat ? $detail->alat->nama_alat : 'Alat',
            'jumlah' => $detail ? $detail->jumlah : 1,
            'initials' => strtoupper(substr($this->pengembalian->peminjaman->user->name, 0, 2)),
        ];
    }
}
