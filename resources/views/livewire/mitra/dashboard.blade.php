<div>
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold tracking-tight">Mitra Dashboard</h1>
            <p class="text-slate-500 mt-1">Halo Mitra, selamat datang di panel kontrol Anda.</p>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mt-8">
        <div
            class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-slate-500 text-sm font-medium mb-1">Paket Aktif</p>
                <p class="text-3xl font-bold text-slate-800 dark:text-white">{{ $stats['packages'] }}</p>
            </div>
            <div
                class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center text-orange-600 border border-orange-200">
                <i class="fas fa-box text-xl"></i>
            </div>
        </div>

        <div
            class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-slate-500 text-sm font-medium mb-1">Total Pesanan</p>
                <p class="text-3xl font-bold text-slate-800 dark:text-white">{{ $stats['orders'] }}</p>
            </div>
            <div
                class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 border border-blue-200">
                <i class="fas fa-shopping-bag text-xl"></i>
            </div>
        </div>

        <div
            class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-slate-500 text-sm font-medium mb-1">Total Pengeluaran</p>
                <p class="text-2xl font-bold text-slate-800 dark:text-white">Rp
                    {{ number_format($stats['spending'], 0, ',', '.') }}</p>
            </div>
            <div
                class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-600 border border-emerald-200">
                <i class="fas fa-wallet text-xl"></i>
            </div>
        </div>
    </div>
</div>