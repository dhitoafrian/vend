<x-layouts.dashboard title="Pengembalian Alat">
    <div class="grid lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100">
                <h2 class="font-black text-slate-800">Peminjaman Aktif</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-slate-600">
                    <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-3 font-semibold">Alat</th>
                            <th class="px-6 py-3 font-semibold">Rencana Kembali</th>
                            <th class="px-6 py-3 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($myActiveLoans as $item)
                            @php($detail = $item->detailPeminjaman->first())
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 font-medium text-slate-800">{{ $detail?->alat?->nama_alat }} ({{ $detail?->jumlah }})</td>
                                <td class="px-6 py-4">{{ $item->tanggal_kembali_rencana?->format('Y-m-d') }}</td>
                                <td class="px-6 py-4 text-right">
                                    @if ($item->status === 'disetujui')
                                        <form method="POST" action="{{ route('peminjam.pengembalian.store') }}" class="inline">
                                            @csrf
                                            <input type="hidden" name="peminjaman_id" value="{{ $item->id }}">
                                            <button class="bg-blue-600 hover:bg-blue-700 text-white font-medium text-xs rounded-lg px-3 py-1.5 transition-colors">Ajukan Kembali</button>
                                        </form>
                                    @else
                                        <span class="text-xs font-medium text-amber-600 bg-amber-50 px-3 py-1.5 rounded-lg">Menunggu verifikasi</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-slate-500">Tidak ada peminjaman aktif.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100">
                <h2 class="font-black text-slate-800">Riwayat Pengembalian</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-slate-600">
                    <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-3 font-semibold">Tanggal</th>
                            <th class="px-6 py-3 font-semibold">Ketepatan</th>
                            <th class="px-6 py-3 font-semibold">Denda</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($myPengembalian as $item)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">{{ $item->tanggal_kembali?->format('Y-m-d') }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $item->status === 'terlambat' ? 'bg-rose-100 text-rose-700' : 'bg-emerald-100 text-emerald-700' }}">
                                        {{ $item->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-rose-600 font-semibold">Rp {{ number_format($item->denda, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-slate-500">Belum ada riwayat pengembalian.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($myPengembalian->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $myPengembalian->links() }}
            </div>
            @endif
        </div>
    </div>

    <!-- Toast Container (Fully Optimized for Mobile & Desktop) -->
    <div id="toast-container" class="fixed top-4 md:top-24 right-0 md:right-6 left-0 md:left-auto px-4 md:px-0 z-50 flex flex-col gap-4 w-full max-w-sm pointer-events-none"></div>

    <script src="https://js.pusher.com/8.0.1/pusher.min.js"></script>
    <script>
        // Initialize Pusher Client
        const pusher = new Pusher('a8daa7028b304a7ce99c', {
            cluster: 'ap1',
            forceTLS: true
        });

        // Subscribe to user-specific channel
        const userId = "{{ auth()->id() }}";
        const channel = pusher.subscribe(`peminjam-channel.${userId}`);

        // Native Web Audio API success bell chime (C5 -> E5)
        function playSuccessSound() {
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

                tone(523.25, 0.25); // C5
                setTimeout(() => tone(659.25, 0.35), 80); // E5
            } catch(e) {}
        }

        // Show premium Glassmorphic Toast Notification
        function showToast(title, message) {
            const container = document.getElementById('toast-container');
            if (!container) return;

            const toast = document.createElement('div');
            toast.className = "flex items-start gap-4 bg-white/95 backdrop-blur-md border border-slate-100 rounded-3xl p-5 shadow-2xl transition-all duration-500 ease-out transform translate-x-full opacity-0 max-w-sm w-full pointer-events-auto border-l-4 border-l-emerald-500";
            
            toast.innerHTML = `
                <div class="flex-1 min-w-0">
                    <h4 class="text-sm font-black text-slate-800 tracking-tight">${title}</h4>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">${message}</p>
                </div>
            `;

            container.appendChild(toast);
            playSuccessSound();

            setTimeout(() => {
                toast.classList.remove('translate-x-full', 'opacity-0');
                toast.classList.add('translate-x-0', 'opacity-100');
            }, 100);

            // Auto-dismiss and reload page to sync lists perfectly
            setTimeout(() => {
                toast.classList.remove('translate-x-0', 'opacity-100');
                toast.classList.add('translate-x-full', 'opacity-0');
                setTimeout(() => {
                    toast.remove();
                    window.location.reload();
                }, 550);
            }, 4000);
        }

        // Listen for return verified event
        channel.bind('pengembalian.diverifikasi', function(data) {
            console.log("Return verified received:", data);

            // Format currency rupiah
            const formattedDenda = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0
            }).format(data.denda).replace("IDR", "Rp");

            showToast(
                "Pengembalian Sukses! 🎉",
                `Pengembalian alat <strong>${data.alat_name}</strong> telah disetujui oleh petugas. ${data.denda > 0 ? `Denda keterlambatan sebesar <strong>${formattedDenda}</strong> telah dicatat.` : 'Tepat waktu!'}`
            );
        });
    </script>
</x-layouts.dashboard>
