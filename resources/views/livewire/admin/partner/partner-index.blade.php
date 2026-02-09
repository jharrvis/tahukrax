<div>
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">Manajemen Mitra</h1>
            <p class="text-slate-500 text-sm mt-1">Daftar mitra usaha TahuKrax.</p>
        </div>
    </div>

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
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari mitra / outlet..."
                    class="w-full pl-10 pr-4 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all">
            </div>

            <!-- Filter Status -->
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <select wire:model.live="status"
                    class="w-full sm:w-48 px-4 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all">
                    <option value="">Semua Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="pending">Pending</option>
                </select>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 dark:bg-slate-800/50">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Outlet Info</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Pemilik</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Paket / Kota</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Bergabung</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse ($partnerships as $partner)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-bold text-sm">{{ $partner->outlet_name }}</div>
                                <div class="text-xs text-slate-500 font-mono">{{ $partner->partnership_code }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-sm">{{ $partner->user->name ?? '-' }}</div>
                                <div class="text-xs text-slate-500">{{ $partner->phone_number ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium">{{ $partner->package->name ?? '-' }}</div>
                                <div class="text-xs text-slate-500">{{ $partner->city ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2.5 py-1 rounded-full text-xs font-bold uppercase {{ $this->getStatusColor($partner->status) }}">
                                    {{ $partner->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="text-sm text-slate-600">{{ $partner->joined_at ? \Carbon\Carbon::parse($partner->joined_at)->format('d M Y') : '-' }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.partners.show', $partner) }}"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-lg text-xs font-medium transition-all">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center gap-2">
                                    <i class="fas fa-users text-4xl text-slate-300"></i>
                                    <p>Belum ada mitra.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-4 border-t border-slate-100 dark:border-slate-800">
            {{ $partnerships->links() }}
        </div>
    </div>
</div>