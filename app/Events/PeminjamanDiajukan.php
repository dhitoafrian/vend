<?php

namespace App\Events;

use App\Models\Peminjaman;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PeminjamanDiajukan implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $peminjaman;

    /**
     * Create a new event instance.
     */
    public function __construct(Peminjaman $peminjaman)
    {
        $this->peminjaman = $peminjaman->load(['user', 'detailPeminjaman.alat']);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('peminjaman-channel'),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'peminjaman.diajukan';
    }

    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        $detail = $this->peminjaman->detailPeminjaman->first();
        return [
            'id' => $this->peminjaman->id,
            'peminjam_name' => $this->peminjaman->user->name,
            'status' => $this->peminjaman->status,
            'created_at_formatted' => $this->peminjaman->created_at->diffForHumans(),
            'initials' => strtoupper(substr($this->peminjaman->user->name, 0, 2)),
            'tanggal_pinjam' => $this->peminjaman->tanggal_pinjam ? $this->peminjaman->tanggal_pinjam->format('Y-m-d') : '',
            'tanggal_kembali_rencana' => $this->peminjaman->tanggal_kembali_rencana ? $this->peminjaman->tanggal_kembali_rencana->format('Y-m-d') : '',
            'alat_name' => $detail && $detail->alat ? $detail->alat->nama_alat : '',
            'jumlah' => $detail ? $detail->jumlah : 0,
        ];
    }
}
