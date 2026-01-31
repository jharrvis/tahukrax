<div>
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">Pesanan Saya</h1>
            <p class="text-slate-500 text-sm mt-1">Riwayat pembelian paket dan restock.</p>
        </div>
        <div>
            <a href="{{ route('home') }}#paket"
                class="px-4 py-2 bg-brand-500 text-white rounded-xl text-sm font-bold hover:bg-brand-600 transition-all flex items-center gap-2">
                <i class="fas fa-plus"></i> Order Baru
            </a>
        </div>
    </div>

    <div
        class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm">
        <!-- Toolbar -->
        <div class="p-4 border-b border-slate-100 dark:border-slate-800 flex justify-end">
            <!-- Filter Status -->
            <select wire:model.live="filterStatus"
                class="w-full sm:w-48 px-4 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all">
                <option value="">Semua Status</option>
                <option value="pending">Pending</option>
                <option value="paid">Paid (Dibayar)</option>
                <option value="shipped">Shipped (Dikirim)</option>
                <option value="completed">Completed (Selesai)</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 dark:bg-slate-800/50">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Order ID</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Tanggal</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Total</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse ($orders as $order)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                            <td class="px-6 py-4">
                                <span class="font-mono text-sm font-bold">#{{ $order->id }}</span>
                                @if($order->tracking_number)
                                    <div class="text-[10px] text-slate-500 mt-1">Resi: {{ $order->tracking_number }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-slate-600">{{ $order->created_at->format('d M Y') }}</div>
                                <div class="text-xs text-slate-400">{{ $order->created_at->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-bold text-sm text-slate-700 dark:text-slate-300">Rp
                                    {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2.5 py-1 rounded-full text-xs font-bold uppercase {{ $this->getStatusColor($order->status) }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('mitra.orders.show', $order) }}"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-lg text-xs font-medium transition-all">
                                    Detail <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center gap-2">
                                    <i class="fas fa-shopping-bag text-4xl text-slate-300"></i>
                                    <p>Anda belum memiliki pesanan.</p>
                                    <a href="{{ route('home') }}#paket"
                                        class="text-brand-500 hover:underline text-sm font-bold mt-2">Mulai Belanja</a>
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