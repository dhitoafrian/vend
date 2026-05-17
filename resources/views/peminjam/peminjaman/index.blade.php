<x-layouts.dashboard title="Peminjaman Saya">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-4 sm:p-6 flex justify-end border-b border-slate-100">
            <a href="{{ route('peminjam.alat.index') }}"
                class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded-xl px-4 py-2 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Pinjam Alat
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-600">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3 font-semibold">Tanggal</th>
                        <th class="px-6 py-3 font-semibold">Alat</th>
                        <th class="px-6 py-3 font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($myPeminjaman as $item)
                    @php($detail = $item->detailPeminjaman->first())
                    <tr id="riwayat-row-{{ $item->id }}" class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">{{ $item->tanggal_pinjam?->format('Y-m-d') }}</td>
                        <td class="px-6 py-4 font-medium text-slate-800">{{ $detail?->alat?->nama_alat }} ({{
                            $detail?->jumlah }})</td>
                        <td class="px-6 py-4">
                            <span id="badge-status-{{ $item->id }}"
                                class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $item->status === 'selesai' ? 'bg-emerald-100 text-emerald-700' : ($item->status === 'disetujui' ? 'bg-blue-100 text-blue-700' : ($item->status === 'ditolak' ? 'bg-rose-100 text-rose-700' : 'bg-amber-100 text-amber-700')) }}">
                                {{ $item->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-8 text-center text-slate-500">Belum ada pengajuan peminjaman.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($myPeminjaman->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $myPeminjaman->links() }}
        </div>
        @endif
    </div>

    <!-- Toast Container -->
    <div id="toast-container" class="fixed top-24 right-6 z-50 flex flex-col gap-4 w-full max-w-sm pointer-events-none">
    </div>


    <script src="https://js.pusher.com/8.0.1/pusher.min.js"></script>
    <script>
        const pusher = new Pusher('a8daa7028b304a7ce99c', {
            cluster: 'ap1',
            forceTLS: true
        });

        const userId = "{{ auth()->id() }}";
        const channel = pusher.subscribe(`peminjam-channel.${userId}`);

        // Synthesizer suara audio dinamis native (Ceria vs Alarm)
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
            } catch (e) { }
        }

        channel.bind('peminjaman.status.diperbarui', function (data) {
            console.log("Riwayat table update received:", data);

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

            // 3. Update status tabel secara dinamis
            const badge = document.getElementById(`badge-status-${data.id}`);
            if (badge) {
                // Ubah tulisan status
                badge.innerText = data.status;

                // Ubah gaya warna CSS badge sesuai status baru
                badge.className = "inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider transition-all duration-500 scale-110";

                if (disetujui) {
                    badge.classList.add('bg-blue-100', 'text-blue-700');
                } else {
                    badge.classList.add('bg-rose-100', 'text-rose-700');
                }

                // Kembalikan ukuran ke normal setelah animasi berdenyut selesai
                setTimeout(() => {
                    badge.classList.remove('scale-110');
                }, 500);
            }
        });
    </script>



</x-layouts.dashboard>