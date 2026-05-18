<?php

namespace App\Events;

use App\Models\Peminjaman;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PeminjamanStatusDiperbarui implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Peminjaman $peminjaman;

    public function __construct(Peminjaman $peminjaman)
    {
        // Muat relasi user dan alat
        $this->peminjaman = $peminjaman->load(['user', 'detailPeminjaman.alat']);
    }

    public function broadcastOn(): array
    {
        // Menyiarkan khusus ke channel user yang meminjam alat
        return [
            new Channel('peminjam-channel.' . $this->peminjaman->user_id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'peminjaman.status.diperbarui';
    }

    public function broadcastWith(): array
    {
        $detail = $this->peminjaman->detailPeminjaman->first();
        return [
            'id' => $this->peminjaman->id,
            'alat_name' => $detail && $detail->alat ? $detail->alat->nama_alat : 'Alat',
            'jumlah' => $detail ? $detail->jumlah : 1,
            'status' => $this->peminjaman->status, // 'disetujui' atau 'ditolak'
            'tanggal_pinjam' => $this->peminjaman->tanggal_pinjam ? $this->peminjaman->tanggal_pinjam->format('Y-m-d') : '',
        ];
    }
}
