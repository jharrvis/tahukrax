<div>
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <a href="{{ route('admin.orders.index') }}" class="text-slate-400 hover:text-slate-600">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h1 class="text-2xl font-bold tracking-tight">Detail Pesanan #{{ $order->id }}</h1>
            </div>
            <p class="text-slate-500 text-sm ml-7">Invoice: {{ $order->xendit_invoice_id ?? '-' }} | Tanggal:
                {{ $order->created_at->format('d M Y H:i') }}
            </p>
        </div>

        <div class="flex items-center gap-2 ml-7 md:ml-0">
            <span
                class="px-3 py-1 rounded-full text-sm font-bold uppercase {{ $this->getStatusColor($order->status) }}">
                {{ $order->status }}
            </span>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 border border-green-200 text-green-700 rounded-xl flex items-center gap-3">
            <i class="fas fa-check-circle"></i> {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Left Column: Order Items -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Order Items -->
            <div
                class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm p-6">
                <h3 class="font-bold text-lg mb-4">Item Pesanan</h3>
                <div class="space-y-4">
                    @foreach($order->orderItems as $item)
                        <div
                            class="flex justify-between items-center border-b border-slate-50 dark:border-slate-800 last:border-0 pb-4 last:pb-0">
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-16 bg-slate-100 rounded-lg flex items-center justify-center shrink-0">
                                    @if($item->item_type == 'package')
                                        <i class="fas fa-box text-brand-500 text-2xl"></i>
                                    @else
                                        <i class="fas fa-puzzle-piece text-purple-500 text-xl"></i>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-800 dark:text-slate-200">
                                        @if($item->item_type == 'package' && $item->package)
                                            {{ $item->package->name }}
                                        @elseif(($item->item_type == 'addon' || $item->addon_id) && $item->addon)
                                            {{ $item->addon->name }}
                                        @else
                                            Unknown Item
                                        @endif
                                    </h4>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="px-2 py-0.5 rounded text-xs font-bold bg-slate-100 text-slate-600">
                                            {{ $item->quantity }}x
                                        </span>
                                        <span class="text-sm text-slate-500">
                                            @ Rp {{ number_format($item->price, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="font-mono text-sm font-bold text-slate-700 dark:text-slate-300">
                                Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Payment Summary -->
            <div
                class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm p-6">
                <h3 class="font-bold text-lg mb-4">Rincian Pembayaran</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between text-slate-600">
                        <span>Total Items</span>
                        <span>Rp
                            {{ number_format($order->orderItems->sum(fn($i) => $i->price * $i->quantity), 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-slate-600 border-b border-slate-100 py-2 mb-2">
                        <span>Ongkos Kirim</span>
                        <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between font-bold text-lg text-brand-600">
                        <span>Total Bayar</span>
                        <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Actions & Details -->
        <div class="space-y-8">
            <!-- Update Status Actions -->
            <div
                class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm p-6">
                <h3 class="font-bold text-lg mb-4">Update Status</h3>
                <form wire:submit="updateStatus" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Status Pesanan</label>
                        <select wire:model="status"
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none">
                            <option value="pending">Pending</option>
                            <option value="paid">Lunas / Paid</option>
                            <option value="shipped">Dikirim</option>
                            <option value="completed">Selesai</option>
                            <option value="cancelled">Dibatalkan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nomor Resi / Tracking</label>
                        <input wire:model="tracking_number" type="text" placeholder="Masukkan nomor resi..."
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none">
                    </div>

                    <button type="submit" wire:loading.attr="disabled"
                        class="w-full py-2 bg-brand-500 hover:bg-brand-600 text-white font-bold rounded-xl transition-all shadow-lg shadow-brand-500/20 disabled:opacity-50">
                        <span wire:loading.remove>Update Status</span>
                        <span wire:loading>Updating...</span>
                    </button>
                </form>
            </div>

            <!-- Customer Info -->
            <div
                class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm p-6">
                <h3 class="font-bold text-lg mb-4">Informasi Customer</h3>
                <div class="flex items-center gap-3 mb-4">
                    <div
                        class="w-10 h-10 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center font-bold">
                        {{ substr($order->user->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="font-bold text-sm">{{ $order->user->name }}</p>
                        <p class="text-xs text-slate-500">{{ $order->user->email }}</p>
                        <p class="text-xs text-slate-500">{{ $order->user->phone_number ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Shipping Info -->
            <div
                class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm p-6">
                <h3 class="font-bold text-lg mb-4">Alamat Pengiriman</h3>
                <p class="text-sm text-slate-600 leading-relaxed">
                    {{ $order->note ?? 'Alamat tidak tersedia' }}
                </p>
                <!-- Courier info if available in future -->
            </div>
        </div>
    </div>
</div>