<div>
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">Manajemen Pesanan</h1>
            <p class="text-slate-500 text-sm mt-1">Pantau dan kelola pesanan masuk.</p>
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
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari pesanan..."
                    class="w-full pl-10 pr-4 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all">
            </div>

            <!-- Filter Status -->
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <select wire:model.live="status"
                    class="w-full sm:w-48 px-4 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all">
                    <option value="">Semua Status</option>
                    <option value="pending">Pending</option>
                    <option value="paid">Lunas / Paid</option>
                    <option value="shipped">Dikirim</option>
                    <option value="completed">Selesai</option>
                    <option value="cancelled">Dibatalkan</option>
                </select>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 dark:bg-slate-800/50">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">ID / Invoice</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Customer</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Paket / Total</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Tanggal</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse ($orders as $order)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-mono text-sm font-semibold">#{{ $order->id }}</div>
                                <div class="text-xs text-slate-500">{{ $order->xendit_invoice_id ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-sm">{{ $order->user->name ?? 'Guest' }}</div>
                                <div class="text-xs text-slate-500">{{ $order->user->email ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium">{{ $order->package->name ?? '-' }}</div>
                                <div class="text-xs text-slate-500">Rp
                                    {{ number_format($order->total_amount, 0, ',', '.') }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2.5 py-1 rounded-full text-xs font-bold uppercase {{ $this->getStatusColor($order->status) }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-slate-600">{{ $order->created_at->format('d M Y H:i') }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.orders.show', $order) }}"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-lg text-xs font-medium transition-all">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center gap-2">
                                    <i class="fas fa-box-open text-4xl text-slate-300"></i>
                                    <p>Belum ada pesanan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-4 border-t border-slate-100 dark:border-slate-800">
            {{ $orders->links() }}
        </div>
    </div>
</div>