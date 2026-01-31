<div>
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">Manajemen Ongkos Kirim</h1>
            <p class="text-slate-500 text-sm mt-1">Atur tarif pengiriman per kota.</p>
        </div>
        <div class="flex items-center gap-2">
            <button wire:click="toggleImport"
                class="px-4 py-2 bg-white border border-slate-200 dark:border-slate-800 text-slate-600 rounded-xl text-sm font-medium hover:bg-slate-50 transition-all flex items-center gap-2">
                <i class="fas fa-file-import"></i> Import CSV
            </button>
            <a href="{{ route('admin.settings.shipping.create') }}"
                class="px-4 py-2 bg-brand-500 text-white rounded-xl text-sm font-bold hover:bg-brand-600 transition-all shadow-lg shadow-brand-500/20 flex items-center gap-2">
                <i class="fas fa-plus"></i> Tambah Tarif
            </a>
        </div>
    </div>

    <!-- Import Section -->
    <div x-show="$wire.isImporting" x-transition
        class="mb-8 bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm p-6">
        <h3 class="font-bold text-lg mb-4">Import Data Ongkir (CSV)</h3>
        <p class="text-sm text-slate-500 mb-4">Pastikan format CSV sesuai dengan standar Indah Cargo (Delimiter:
            <code>;</code>).</p>

        <form wire:submit="import" class="flex flex-col md:flex-row items-start md:items-end gap-4">
            <div class="w-full md:w-auto flex-1">
                <input wire:model="csvFile" type="file" accept=".csv" class="block w-full text-sm text-slate-500
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-xl file:border-0
                    file:text-sm file:font-semibold
                    file:bg-brand-50 file:text-brand-700
                    hover:file:bg-brand-100
                    transition-all">
                @error('csvFile') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <button type="submit" wire:loading.attr="disabled"
                class="px-6 py-2 bg-brand-500 text-white rounded-xl font-bold hover:bg-brand-600 transition-all shadow-lg shadow-brand-500/20 flex items-center gap-2 disabled:opacity-50">
                <span wire:loading.remove>Upload & Process</span>
                <span wire:loading><i class="fas fa-spinner fa-spin"></i> Processing...</span>
            </button>
        </form>
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
            <!-- Search -->
            <div class="relative w-full sm:w-64">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="fas fa-search"></i>
                </span>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari kota..."
                    class="w-full pl-10 pr-4 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all">
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 dark:bg-slate-800/50">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Kota Tujuan</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Harga / Kg</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Min. Berat</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse ($rates as $rate)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-bold text-sm">{{ $rate->destination_city }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-mono text-sm text-slate-700 dark:text-slate-300">Rp
                                    {{ number_format($rate->price_per_kg, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-slate-600">{{ $rate->minimum_weight }} Kg</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.settings.shipping.edit', $rate->id) }}"
                                        class="px-3 py-1.5 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-lg text-xs font-medium transition-all">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <button wire:click="delete({{ $rate->id }})"
                                        wire:confirm="Yakin ingin menghapus tarif ini?"
                                        class="px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg text-xs font-medium transition-all">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center gap-2">
                                    <i class="fas fa-truck text-4xl text-slate-300"></i>
                                    <p>Belum ada data tarif pengiriman.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-4 border-t border-slate-100 dark:border-slate-800">
            {{ $rates->links() }}
        </div>
    </div>
</div>