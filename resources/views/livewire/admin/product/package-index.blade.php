<div>
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">Manajemen Paket Usaha</h1>
            <p class="text-slate-500 text-sm mt-1">Kelola daftar paket usaha yang tersedia.</p>
        </div>
        <a href="{{ route('admin.packages.create') }}"
            class="px-4 py-2 bg-brand-500 text-white rounded-xl text-sm font-bold hover:bg-brand-600 transition-all shadow-lg shadow-brand-500/20 flex items-center gap-2">
            <i class="fas fa-plus"></i> Tambah Paket
        </a>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 border border-green-200 text-green-700 rounded-xl flex items-center gap-3">
            <i class="fas fa-check-circle"></i> {{ session('message') }}
        </div>
    @endif

    <div
        class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm">
        <!-- Toolbar -->
        <div
            class="p-4 border-b border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="relative w-full sm:w-64">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="fas fa-search"></i>
                </span>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari paket..."
                    class="w-full pl-10 pr-4 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all">
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 dark:bg-slate-800/50">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Paket</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Harga</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Berat (Kg)</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse ($packages as $package)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-lg bg-slate-200 dark:bg-slate-700 overflow-hidden shrink-0">
                                        @if($package->image_url)
                                            <img src="{{ $package->image_url }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-slate-400">
                                                <i class="fas fa-box"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-semibold text-sm">{{ $package->name }}</p>
                                        <p class="text-xs text-slate-500 truncate max-w-[200px]">{{ $package->slug }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-medium">Rp
                                    {{ number_format($package->price, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm">{{ $package->weight_kg }} kg</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.packages.edit', $package) }}" class="p-2 text-slate-400 hover:text-brand-500 transition-colors">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button wire:click="delete({{ $package->id }})"
                                        wire:confirm="Yakin ingin menghapus paket ini?"
                                        class="p-2 text-slate-400 hover:text-red-500 transition-colors">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center gap-2">
                                    <i class="fas fa-inbox text-4xl text-slate-300"></i>
                                    <p>Tidak ada paket ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-4 border-t border-slate-100 dark:border-slate-800">
            {{ $packages->links() }}
        </div>
    </div>
</div>