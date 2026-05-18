<?php

namespace App\Events;

use App\Models\Pengembalian;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PengembalianDiverifikasi implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Pengembalian $pengembalian;

    public function __construct(Pengembalian $pengembalian)
    {
        $this->pengembalian = $pengembalian->load(['peminjaman.user', 'peminjaman.detailPeminjaman.alat']);
    }

    public function broadcastOn(): array
    {
        // Penyiaran privat (user-scoped) agar peminjam yang bersangkutan tahu pengembaliannya sudah diverifikasi
        return [
            new Channel('peminjam-channel.' . $this->pengembalian->peminjaman->user_id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'pengembalian.diverifikasi';
    }

    public function broadcastWith(): array
    {
        $detail = $this->pengembalian->peminjaman->detailPeminjaman->first();
        return [
            'id' => $this->pengembalian->id,
            'peminjaman_id' => $this->pengembalian->peminjaman_id,
            'alat_name' => $detail && $detail->alat ? $detail->alat->nama_alat : 'Alat',
            'jumlah' => $detail ? $detail->jumlah : 1,
            'denda' => $this->pengembalian->denda,
            'status' => $this->pengembalian->peminjaman->status, // 'selesai'
            'tanggal_kembali' => $this->pengembalian->tanggal_kembali ? $this->pengembalian->tanggal_kembali->format('Y-m-d') : '',
        ];
    }
}
