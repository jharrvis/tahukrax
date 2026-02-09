<div>
    <!-- Page Title -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold tracking-tight">Dashboard Overview</h1>
            <p class="text-slate-500 mt-1">Selamat datang kembali, mari pantau perkembangan bisnis hari ini.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <button
                class="px-4 py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm font-medium hover:bg-slate-50 transition-colors shadow-sm">
                <i class="fas fa-download mr-2"></i> Ekspor Laporan
            </button>
            <button
                class="px-4 py-2 bg-brand-500 text-white rounded-xl text-sm font-bold hover:bg-brand-600 transition-all shadow-lg shadow-brand-500/20">
                <i class="fas fa-plus mr-2"></i> Paket Baru
            </button>
        </div>
    </div>

    <!-- Welcome Cards -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">
        <!-- Welcome Card -->
        <div
            class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 flex items-center justify-between group hover:shadow-xl hover:shadow-slate-200/50 dark:hover:shadow-none transition-all">
            <div class="flex items-center gap-6">
                <div
                    class="w-20 h-20 rounded-2xl bg-slate-900 dark:bg-brand-500 flex items-center justify-center text-white text-3xl font-bold shadow-lg shadow-slate-900/20">
                    {{ substr(Auth::user()->name ?? 'A', 0, 2) }}
                </div>
                <div>
                    <h3 class="text-xl font-bold">Welcome Back!</h3>
                    <p class="text-slate-500">{{ Auth::user()->name ?? 'Admin' }}</p>
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 mt-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1.5"></span>
                        Sistem Normal
                    </span>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="px-5 py-2.5 border border-slate-200 dark:border-slate-700 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 flex items-center gap-2 transition-colors">
                    <i class="fas fa-sign-out-alt text-slate-400"></i>
                    <span class="font-medium text-sm">Sign out</span>
                </button>
            </form>
        </div>

        <!-- Framework Card -->
        <div
            class="bg-gradient-to-br from-brand-500 to-orange-600 p-6 rounded-3xl text-white shadow-xl shadow-brand-500/20 relative overflow-hidden group">
            <div class="relative z-10 flex flex-col h-full justify-between">
                <div>
                    <h2 class="text-3xl font-black italic tracking-tighter mb-1">TahuKrax Core</h2>
                    <p class="text-brand-100 text-sm">v5.1.0 Stable Build</p>
                </div>
                <div class="flex items-center gap-4 mt-6">
                    <a href="#"
                        class="flex items-center gap-2 text-sm bg-white/20 hover:bg-white/30 px-4 py-2 rounded-lg backdrop-blur-sm transition-colors">
                        <i class="fas fa-book"></i> Dokumentasi
                    </a>
                    <a href="#"
                        class="flex items-center gap-2 text-sm bg-white/20 hover:bg-white/30 px-4 py-2 rounded-lg backdrop-blur-sm transition-colors">
                        <i class="fab fa-github"></i> GitHub
                    </a>
                </div>
            </div>
            <div
                class="absolute -right-4 -bottom-4 opacity-20 scale-150 group-hover:rotate-12 transition-transform duration-700">
                <i class="fas fa-cog text-9xl"></i>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mt-6">
        <div class="bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-200 dark:border-slate-800">
            <div class="flex items-center justify-between mb-4">
                <div class="p-2 bg-blue-50 dark:bg-blue-500/10 rounded-lg">
                    <i class="fas fa-handshake text-blue-600"></i>
                </div>
            </div>
            <p class="text-slate-500 text-sm">Total Mitra</p>
            <p class="text-2xl font-bold">{{ number_format($stats['total_mitra']) }}</p>
        </div>
        <div class="bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-200 dark:border-slate-800">
            <div class="flex items-center justify-between mb-4">
                <div class="p-2 bg-orange-50 dark:bg-orange-500/10 rounded-lg">
                    <i class="fas fa-box text-orange-600"></i>
                </div>
            </div>
            <p class="text-slate-500 text-sm">Paket Terjual</p>
            <p class="text-2xl font-bold">{{ number_format($stats['paket_terjual']) }}</p>
        </div>
        <div class="bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-200 dark:border-slate-800">
            <div class="flex items-center justify-between mb-4">
                <div class="p-2 bg-purple-50 dark:bg-purple-500/10 rounded-lg">
                    <i class="fas fa-wallet text-purple-600"></i>
                </div>
            </div>
            <p class="text-slate-500 text-sm">Pendapatan</p>
            <p class="text-2xl font-bold">Rp {{ number_format($stats['pendapatan'] / 1000000, 1) }} Juta</p>
        </div>
        <div
            class="bg-white dark:bg-slate-900 p-5 rounded-2xl border {{ $stats['laporan_masalah'] > 0 ? 'border-red-500 shadow-lg shadow-red-500/10' : 'border-slate-200 dark:border-slate-800' }}">
            <div class="flex items-center justify-between mb-4">
                <div
                    class="p-2 {{ $stats['laporan_masalah'] > 0 ? 'bg-red-500 text-white' : 'bg-red-50 dark:bg-red-500/10 text-red-600' }} rounded-lg">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                @if($stats['laporan_masalah'] > 0)
                    <span
                        class="text-[10px] font-bold bg-red-100 text-red-700 px-2 py-0.5 rounded-full animate-pulse">ACTION
                        REQUIRED</span>
                @endif
            </div>
            <p class="text-slate-500 text-sm font-medium">Laporan Masalah</p>
            <p class="text-2xl font-bold">{{ $stats['laporan_masalah'] }} Laporan</p>
        </div>
    </div>

    <!-- Table Area -->
    <div
        class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm mt-6">
        <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
            <h3 class="font-bold text-lg text-slate-800 dark:text-slate-100">Daftar Mitra Terbaru</h3>
            <button class="text-brand-500 text-sm font-semibold hover:underline">Lihat Semua</button>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 dark:bg-slate-800/50">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Mitra</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Paket</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Lokasi</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase text-right">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($recentPartnerships as $partnership)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center font-bold text-xs uppercase">
                                        {{ substr($partnership->user->name ?? 'M', 0, 2) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-sm">{{ $partnership->user->name ?? 'Unknown' }}</p>
                                        <p class="text-xs text-slate-500 italic">ID: {{ $partnership->partnership_code }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-medium">{{ $partnership->package->name ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm">{{ $partnership->city ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2.5 py-1 rounded-lg text-[10px] font-black uppercase bg-green-100 text-green-700">{{ $partnership->status ?? 'Active' }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button class="p-2 text-slate-400 hover:text-brand-500 transition-colors">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-slate-500 text-sm">Belum ada data mitra.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>