<x-layouts.dashboard title="Dashboard Petugas">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <!-- Card Pending -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 border-l-4 border-l-amber-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Menunggu</p>
                    <p id="total-pending-counter" class="text-3xl font-black text-slate-800 transition-all duration-300">{{ $totalPending }}</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Card Dipinjam -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 border-l-4 border-l-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Dipinjam</p>
                    <p class="text-3xl font-black text-slate-800">{{ $totalDipinjam }}</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Card Selesai -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 border-l-4 border-l-emerald-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Selesai</p>
                    <p class="text-3xl font-black text-slate-800">{{ $totalSelesai }}</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Pending Peminjaman -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-6">
                <h2 class="font-black text-slate-800 tracking-tight">Antrean Pengajuan</h2>
                <a href="{{ route('petugas.peminjaman.index') }}" class="text-xs font-bold text-blue-600 hover:underline">Lihat Semua</a>
            </div>
            <div id="antrean-peminjaman-container" class="space-y-4">
                @forelse ($pendingPeminjaman as $item)
                    <div class="flex items-center justify-between p-4 rounded-2xl bg-slate-50 border border-slate-100 group hover:bg-white hover:shadow-md transition-all">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-xs uppercase">
                                {{ substr($item->user->name, 0, 2) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800">{{ $item->user->name }}</p>
                                <p class="text-[10px] text-slate-500 uppercase font-medium tracking-tighter">{{ $item->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-[10px] font-bold uppercase tracking-widest">Pending</span>
                    </div>
                @empty
                    <div id="empty-peminjaman-state" class="text-center py-8">
                        <p class="text-sm text-slate-400">Tidak ada pengajuan baru</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Pending Pengembalian -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-6">
                <h2 class="font-black text-slate-800 tracking-tight">Verifikasi Kembali</h2>
                <a href="{{ route('petugas.pengembalian.index') }}" class="text-xs font-bold text-blue-600 hover:underline">Lihat Semua</a>
            </div>
            <div class="space-y-4">
                @forelse ($pendingPengembalian as $item)
                    <div class="flex items-center justify-between p-4 rounded-2xl bg-slate-50 border border-slate-100 group hover:bg-white hover:shadow-md transition-all">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold text-xs uppercase">
                                {{ substr($item->user->name, 0, 2) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800">{{ $item->user->name }}</p>
                                <p class="text-[10px] text-slate-500 uppercase font-medium tracking-tighter">Menunggu Verifikasi</p>
                            </div>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-400 group-hover:text-blue-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <p class="text-sm text-slate-400">Semua pengembalian sudah diverifikasi</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Toast Container -->
    <div id="toast-container" class="fixed top-24 right-6 z-50 flex flex-col gap-4 w-full max-w-sm pointer-events-none"></div>

    <!-- Pusher Integration JavaScript -->
    <script src="https://js.pusher.com/8.0.1/pusher.min.js"></script>
    <script>
        // Set log level to console if debug is active (optional)
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
                        <a href="{{ route('petugas.peminjaman.index') }}" class="px-3.5 py-1.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-[10px] uppercase tracking-widest transition-all active:scale-95 shadow-md shadow-blue-200">Verifikasi</a>
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

        // Listen for the Event broadcasted by Laravel
        channel.bind('peminjaman.diajukan', function(data) {
            console.log('Broadcast received:', data);

            // 1. Display elegant popup toast notification
            showToast(
                "Peminjaman Baru! 📡",
                `Peminjam <strong>${data.peminjam_name}</strong> baru saja mengajukan peminjaman alat baru.`,
                data.initials
            );

            // 2. Animate and update counter "Menunggu"
            const counter = document.getElementById('total-pending-counter');
            if (counter) {
                let currentCount = parseInt(counter.innerText) || 0;
                counter.innerText = currentCount + 1;

                // Add bounce animation
                counter.classList.add('scale-125', 'text-amber-600');
                setTimeout(() => {
                    counter.classList.remove('scale-125', 'text-amber-600');
                }, 500);
            }

            // 3. Dynamically insert new row inside Antrean Pengajuan list
            const antreanContainer = document.getElementById('antrean-peminjaman-container');
            if (antreanContainer) {
                // Remove empty state if active
                const emptyState = document.getElementById('empty-peminjaman-state');
                if (emptyState) {
                    emptyState.remove();
                }

                // Create the card element
                const newCard = document.createElement('div');
                newCard.className = "flex items-center justify-between p-4 rounded-2xl bg-slate-50 border border-slate-100 group hover:bg-white hover:shadow-md transition-all duration-500 ease-out transform -translate-y-4 opacity-0";
                
                newCard.innerHTML = `
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-xs uppercase shadow-sm">
                            ${data.initials}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-800">${data.peminjam_name}</p>
                            <p class="text-[10px] text-slate-500 uppercase font-medium tracking-tighter">Baru Saja</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-[10px] font-bold uppercase tracking-widest shadow-sm">Pending</span>
                `;

                // Prepend to top of container list
                antreanContainer.insertBefore(newCard, antreanContainer.firstChild);

                // Wait for render, then run transition
                setTimeout(() => {
                    newCard.classList.remove('-translate-y-4', 'opacity-0');
                    newCard.classList.add('translate-y-0', 'opacity-100');
                }, 100);
            }
        });
    </script>
</x-layouts.dashboard>
