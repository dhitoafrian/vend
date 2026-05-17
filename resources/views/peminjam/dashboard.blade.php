<x-layouts.dashboard title="Dashboard Saya">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8 mb-8">
        <div class="max-w-2xl">
            <h2 class="text-2xl md:text-3xl font-black text-slate-800 mb-3 tracking-tight">
                Halo, <span class="text-blue-600">{{ auth()->user()->name }}</span>!
            </h2>
            <p class="text-slate-500 text-base mb-6 leading-relaxed">
                Selamat datang kembali di VEND. Kelola peminjaman dan pengembalian alat dengan mudah.
            </p>

            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('peminjam.alat.index') }}"
                   class="inline-flex items-center justify-center gap-2 px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all active:scale-95 text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    Lihat & Pinjam Alat
                </a>
                <a href="{{ route('peminjam.peminjaman.index') }}"
                   class="inline-flex items-center justify-center gap-2 px-5 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl transition-all active:scale-95 text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Riwayat Peminjaman
                </a>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <div class="flex items-center justify-between mb-5">
            <h3 class="font-black text-slate-800">Alat Menunggu Persetujuan</h3>
            @if ($pendingPeminjaman->count() > 0)
                <span class="text-xs font-bold text-amber-600 bg-amber-50 px-3 py-1 rounded-full">{{ $pendingPeminjaman->count() }} menunggu</span>
            @endif
        </div>

        <div id="pending-list-container" class="space-y-3">
            @forelse ($pendingPeminjaman as $item)
                <div id="peminjaman-card-{{ $item->id }}" class="flex items-center justify-between p-4 rounded-xl bg-slate-50 border border-slate-100">
                    <div class="flex-1 min-w-0 mr-3">
                        <p class="text-sm font-bold text-slate-800 truncate">
                            {{ $item->detailPeminjaman->first()?->alat?->nama_alat ?? 'Alat tidak tersedia' }}
                        </p>
                        <p class="text-xs text-slate-500 mt-0.5">
                            {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}
                        </p>
                    </div>
                    <span class="shrink-0 px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-[10px] font-bold uppercase tracking-wider">Pending</span>
                </div>
            @empty
                <div class="text-center py-10">
                    <svg class="w-10 h-10 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-sm text-slate-400">Tidak ada alat yang menunggu persetujuan</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Toast Container (Fully Optimized for Mobile & Desktop) -->
    <div id="toast-container" class="fixed top-4 md:top-24 right-0 md:right-6 left-0 md:left-auto px-4 md:px-0 z-50 flex flex-col gap-4 w-full max-w-sm pointer-events-none"></div>

    <!-- Pusher JS -->
    <script src="https://js.pusher.com/8.0.1/pusher.min.js"></script>
    <script>
        const pusher = new Pusher('a8daa7028b304a7ce99c', {
        cluster: 'ap1',
        forceTLS: true
    });

    // Subscribe ke channel spesifik user yang sedang login
    const userId = "{{ auth()->id() }}";
    const channel = pusher.subscribe(`peminjam-channel.${userId}`);

    // Synthesizer suara audio dinamis native
    function playSoundEffect(isSuccess) {
        try {
            const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
            const now = audioCtx.currentTime;

            const tone = (freq, duration, type = 'sine', vol = 0.15) => {
                const osc = audioCtx.createOscillator();
                const gain = audioCtx.createGain();
                osc.connect(gain);
                gain.connect(audioCtx.destination);
                osc.type = type;
                osc.frequency.setValueAtTime(freq, now);
                gain.gain.setValueAtTime(0, now);
                gain.gain.linearRampToValueAtTime(vol, now + 0.02);
                gain.gain.exponentialRampToValueAtTime(0.0001, now + duration);
                osc.start(now);
                osc.stop(now + duration);
            };

            if (isSuccess) {
                // Suara Ceria Ding-Ding (Disetujui)
                tone(523.25, 0.25); // C5
                setTimeout(() => tone(659.25, 0.35), 80); // E5
            } else {
                // Suara Alarm Buzzer (Ditolak)
                tone(180, 0.4, 'sawtooth', 0.2);
            }
        } catch(e) {}
    }

    // Listener status peminjaman diperbarui
    channel.bind('peminjaman.status.diperbarui', function(data) {
        console.log("Status update received:", data);

        const disetujui = data.status === 'disetujui';
        
        // 1. Bunyikan efek suara spesifik
        playSoundEffect(disetujui);

        // 2. Munculkan Toast pop-up premium
        const toast = document.createElement('div');
        toast.className = `flex items-start gap-4 bg-white/95 backdrop-blur-md border border-slate-100 rounded-3xl p-5 shadow-2xl transition-all duration-500 ease-out transform translate-x-full opacity-0 border-l-4 ${disetujui ? 'border-l-emerald-500' : 'border-l-rose-500'}`;
        toast.innerHTML = `
            <div class="flex-1">
                <h4 class="text-sm font-black text-slate-800 tracking-tight">${disetujui ? 'Pengajuan Disetujui! 🎉' : 'Pengajuan Ditolak ❌'}</h4>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">Peminjaman alat <strong>${data.alat_name}</strong> (${data.jumlah} unit) telah ${data.status} oleh petugas.</p>
            </div>
        `;
        document.getElementById('toast-container').appendChild(toast);
        setTimeout(() => toast.classList.remove('translate-x-full', 'opacity-0'), 100);
        setTimeout(() => {
            toast.classList.add('translate-x-full', 'opacity-0');
            setTimeout(() => toast.remove(), 600);
        }, 6000);

        // 3. Update DOM Dashboard (Hapus kartu yang sudah disetujui/ditolak karena bukan pending lagi)
        const targetCard = document.getElementById(`peminjaman-card-${data.id}`);
        if (targetCard) {
            targetCard.classList.add('scale-95', 'opacity-0', 'transition-all', 'duration-500');
            setTimeout(() => {
                targetCard.remove();
                // Jika daftar pending habis, tampilkan state kosong
                const container = document.getElementById('pending-list-container');
                if (container && container.children.length === 0) {
                    container.innerHTML = `
                        <div class="text-center py-10">
                            <svg class="w-10 h-10 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p class="text-sm text-slate-400">Tidak ada alat yang menunggu persetujuan</p>
                        </div>
                    `;
                }
            }, 500);
        }
    });
</script>

</x-layouts.dashboard>
