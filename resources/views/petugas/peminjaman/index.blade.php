<x-layouts.dashboard title="Persetujuan Peminjaman">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-4 sm:p-6 border-b border-slate-100">
            <form method="GET" class="flex flex-wrap items-center gap-3">
                <select name="status" class="border border-slate-300 rounded-xl px-4 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all bg-white">
                    <option value="">Semua status</option>
                    @foreach (['pending', 'disetujui', 'tunda_pengembalian', 'ditolak', 'selesai'] as $status)
                        <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white font-medium text-sm rounded-xl px-4 py-2 transition-colors">Filter</button>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-600">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3 font-semibold">Peminjam</th>
                        <th class="px-6 py-3 font-semibold">Tgl Pinjam</th>
                        <th class="px-6 py-3 font-semibold">Rencana Kembali</th>
                        <th class="px-6 py-3 font-semibold">Status</th>
                        <th class="px-6 py-3 font-semibold">Detail</th>
                        <th class="px-6 py-3 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody id="peminjaman-table-body" class="divide-y divide-slate-100">
                    @forelse ($peminjaman as $item)
                        @php($detail = $item->detailPeminjaman->first())
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-medium text-slate-800">{{ $item->user?->name }}</td>
                            <td class="px-6 py-4">{{ $item->tanggal_pinjam?->format('Y-m-d') }}</td>
                            <td class="px-6 py-4">{{ $item->tanggal_kembali_rencana?->format('Y-m-d') }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $item->status === 'selesai' ? 'bg-emerald-100 text-emerald-700' : ($item->status === 'disetujui' ? 'bg-blue-100 text-blue-700' : ($item->status === 'ditolak' ? 'bg-rose-100 text-rose-700' : 'bg-amber-100 text-amber-700')) }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4">{{ $detail?->alat?->nama_alat }} ({{ $detail?->jumlah }})</td>
                            <td class="px-6 py-4 text-right">
                                @if ($item->status === 'pending')
                                    <div class="flex items-center justify-end gap-2">
                                        <form method="POST" action="{{ route('petugas.peminjaman.approve', $item) }}" class="inline">
                                            @csrf @method('PATCH')
                                            <button class="bg-blue-600 hover:bg-blue-700 text-white font-medium text-xs rounded-lg px-3 py-1.5 transition-colors">Setujui</button>
                                        </form>
                                        <form method="POST" action="{{ route('petugas.peminjaman.reject', $item) }}" class="inline">
                                            @csrf @method('PATCH')
                                            <button class="bg-rose-600 hover:bg-rose-700 text-white font-medium text-xs rounded-lg px-3 py-1.5 transition-colors">Tolak</button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-slate-400 text-sm">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr id="empty-peminjaman-row"><td colspan="6" class="px-6 py-8 text-center text-slate-500">Belum ada data peminjaman.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($peminjaman->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $peminjaman->links() }}
        </div>
        @endif
    </div>

    <!-- Toast Container (Fully Optimized for Mobile & Desktop) -->
    <div id="toast-container" class="fixed top-4 md:top-24 right-0 md:right-6 left-0 md:left-auto px-4 md:px-0 z-50 flex flex-col gap-4 w-full max-w-sm pointer-events-none"></div>

    <!-- Pusher Integration JavaScript -->
    <script src="https://js.pusher.com/8.0.1/pusher.min.js"></script>
    <script>
        // Set log level to console if debug is active
        Pusher.logToConsole = true;

        // Initialize Pusher Client
        const pusher = new Pusher('a8daa7028b304a7ce99c', {
            cluster: 'ap1',
            forceTLS: true
        });

        // Subscribe to Channel
        const channel = pusher.subscribe('peminjaman-channel');

        // Play premium chime sound using Web Audio API
        function playNotificationSound() {
            try {
                const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
                const now = audioCtx.currentTime;

                const playTone = (frequency, startTime, duration) => {
                    const osc = audioCtx.createOscillator();
                    const gainNode = audioCtx.createGain();

                    osc.connect(gainNode);
                    gainNode.connect(audioCtx.destination);

                    osc.type = 'sine';
                    osc.frequency.setValueAtTime(frequency, startTime);

                    // Soft premium chime volume envelope
                    gainNode.gain.setValueAtTime(0, startTime);
                    gainNode.gain.linearRampToValueAtTime(0.2, startTime + 0.04);
                    gainNode.gain.exponentialRampToValueAtTime(0.0001, startTime + duration);

                    osc.start(startTime);
                    osc.stop(startTime + duration);
                };

                // Play a sweet two-tone chime (E5 -> A5)
                playTone(659.25, now, 0.4); // E5
                playTone(880.00, now + 0.12, 0.6); // A5
            } catch (e) {
                console.warn("Speech/Audio context failed to play", e);
            }
        }

        // Show a beautiful, highly polished Toast notification
        function showToast(title, message, initials) {
            const container = document.getElementById('toast-container');
            if (!container) return;

            const toast = document.createElement('div');
            // Premium layout using Glassmorphism styling with backdrop-blur, smooth transitions and custom shadow
            toast.className = "flex items-start gap-4 bg-white/95 backdrop-blur-md border border-slate-100 rounded-3xl p-5 shadow-2xl transition-all duration-500 ease-out transform translate-x-full opacity-0 max-w-sm w-full pointer-events-auto border-l-4 border-l-blue-600";
            
            toast.innerHTML = `
                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-xs uppercase flex-shrink-0 shadow-sm">
                    ${initials}
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="text-sm font-black text-slate-800 tracking-tight">${title}</h4>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">${message}</p>
                    <div class="mt-3 flex gap-2">
                        <button onclick="closeToast(this)" class="px-3.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-xl text-[10px] uppercase tracking-widest transition-all active:scale-95">Tutup</button>
                    </div>
                </div>
            `;

            container.appendChild(toast);

            // Play notification sound
            playNotificationSound();

            // Trigger slide-in animation
            setTimeout(() => {
                toast.classList.remove('translate-x-full', 'opacity-0');
                toast.classList.add('translate-x-0', 'opacity-100');
            }, 100);

            // Auto-dismiss toast after 7 seconds
            const dismissTimeout = setTimeout(() => {
                dismissToast(toast);
            }, 7000);

            // Attach timeout ID to toast element for manual closure
            toast.dataset.timeoutId = dismissTimeout;
        }

        // Close toast manually
        function closeToast(btn) {
            const toast = btn.closest('.transition-all');
            if (toast) {
                clearTimeout(toast.dataset.timeoutId);
                dismissToast(toast);
            }
        }

        // Dismiss animation helper
        function dismissToast(toast) {
            toast.classList.remove('translate-x-0', 'opacity-100');
            toast.classList.add('translate-x-full', 'opacity-0');
            setTimeout(() => {
                toast.remove();
            }, 550);
        }

        // CSRF Token
        const csrfToken = "{{ csrf_token() }}";

        // Listen for the Event broadcasted by Laravel
        channel.bind('peminjaman.diajukan', function(data) {
            console.log('Broadcast received in Approval List:', data);

            // 1. Display elegant popup toast notification
            showToast(
                "Peminjaman Baru! 📡",
                `Peminjam <strong>${data.peminjam_name}</strong> baru saja mengajukan peminjaman alat <strong>${data.alat_name}</strong>.`,
                data.initials
            );

            // 2. Dynamically insert new row inside Persetujuan Peminjaman table
            const tableBody = document.getElementById('peminjaman-table-body');
            if (tableBody) {
                // Remove empty state if active
                const emptyRow = document.getElementById('empty-peminjaman-row');
                if (emptyRow) {
                    emptyRow.remove();
                }

                // Create the table row
                const newRow = document.createElement('tr');
                newRow.className = "hover:bg-slate-50/50 transition-all duration-500 ease-out transform -translate-y-4 opacity-0";
                
                newRow.innerHTML = `
                    <td class="px-6 py-4 font-medium text-slate-800">${data.peminjam_name}</td>
                    <td class="px-6 py-4">${data.tanggal_pinjam}</td>
                    <td class="px-6 py-4">${data.tanggal_kembali_rencana}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-amber-100 text-amber-700">
                            ${data.status}
                        </span>
                    </td>
                    <td class="px-6 py-4">${data.alat_name} (${data.jumlah})</td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <form method="POST" action="/petugas/peminjaman/${data.id}/approve" class="inline">
                                <input type="hidden" name="_token" value="${csrfToken}">
                                <input type="hidden" name="_method" value="PATCH">
                                <button class="bg-blue-600 hover:bg-blue-700 text-white font-medium text-xs rounded-lg px-3 py-1.5 transition-colors">Setujui</button>
                            </form>
                            <form method="POST" action="/petugas/peminjaman/${data.id}/reject" class="inline">
                                <input type="hidden" name="_token" value="${csrfToken}">
                                <input type="hidden" name="_method" value="PATCH">
                                <button class="bg-rose-600 hover:bg-rose-700 text-white font-medium text-xs rounded-lg px-3 py-1.5 transition-colors">Tolak</button>
                            </form>
                        </div>
                    </td>
                `;

                // Prepend to top of table body
                tableBody.insertBefore(newRow, tableBody.firstChild);

                // Wait for render, then run transition
                setTimeout(() => {
                    newRow.classList.remove('-translate-y-4', 'opacity-0');
                    newRow.classList.add('translate-y-0', 'opacity-100');
                }, 100);
            }
        });
    </script>
</x-layouts.dashboard>
