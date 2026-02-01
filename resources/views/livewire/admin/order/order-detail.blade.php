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
                        <span>Status Pembayaran</span>
                        <span
                            class="font-bold uppercase {{ $order->status == 'paid' ? 'text-green-600' : 'text-slate-500' }}">
                            {{ $order->status }}
                        </span>
                    </div>
                    @if($order->payment_channel)
                        <div class="flex justify-between items-center text-slate-600">
                            <span>Metode Pembayaran</span>
                            <div class="flex items-center gap-2">
                                @php
                                    $channel = strtoupper($order->payment_channel);
                                    $logo = null;
                                    // Simple mapping for common logos (using text or icons if specific images missing)
                                    // In a real app, you'd point to actual assets like /img/banks/bca.png
                                @endphp

                                @if(in_array($channel, ['GOPAY', 'ID_GOPAY']))
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/8/86/Gopay_logo.svg" h-4
                                        class="h-4" alt="GoPay">
                                @elseif(in_array($channel, ['OVO', 'ID_OVO']))
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/e/eb/Logo_ovo_purple.svg"
                                        class="h-4" alt="OVO">
                                @elseif(in_array($channel, ['DANA', 'ID_DANA']))
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/7/72/Logo_dana_blue.svg"
                                        class="h-4" alt="DANA">
                                @elseif(in_array($channel, ['SHOPEEPAY', 'ID_SHOPEEPAY']))
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/f/fe/Shopee.svg" class="h-4"
                                        alt="ShopeePay">
                                @elseif(in_array($channel, ['BCA', 'MANDIRI', 'BNI', 'BRI', 'PERMATA', 'CIMB']))
                                    <span class="font-bold text-slate-800">{{ $channel }}</span>
                                @elseif($channel == 'QRIS')
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/a/a2/Logo_QRIS.svg" class="h-4"
                                        alt="QRIS">
                                @else
                                    <span class="font-medium">{{ $channel }}</span>
                                @endif
                            </div>
                        </div>
                    @endif
                    <div class="my-2 border-b border-slate-100"></div>

                    <div class="flex justify-between text-slate-600">
                        <span>Total Items</span>
                        <span>Rp
                            {{ number_format($order->orderItems->sum(fn($i) => $i->price * $i->quantity), 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-slate-600 border-b border-slate-100 py-2 mb-2">
                        @php
                            $calculatedWeight = $order->orderItems->sum(function ($item) {
                                $weight = 0;
                                if ($item->item_type == 'package' && $item->package)
                                    $weight = $item->package->weight_kg;
                                elseif ($item->addon)
                                    $weight = $item->addon->weight_kg ?? 0;
                                return $weight * $item->quantity;
                            });
                        @endphp
                        <span>Ongkos Kirim ({{ $calculatedWeight }} kg)</span>
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

                    <div class="flex gap-2">
                        <button type="submit" wire:loading.attr="disabled"
                            class="flex-1 py-2 bg-brand-500 hover:bg-brand-600 text-white font-bold rounded-xl transition-all shadow-lg shadow-brand-500/20 disabled:opacity-50">
                            <span wire:loading.remove>Update Status</span>
                            <span wire:loading>Updating...</span>
                        </button>

                        @if($tracking_number)
                            <button type="button"
                                @click="$dispatch('open-tracking-modal', { url: 'https://www.indahonline.com/services/view?NO_RESI={{ $tracking_number }}' })"
                                class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-xl transition-colors"
                                title="Lacak Resi">
                                <i class="fas fa-search-location"></i>
                            </button>
                        @endif
                    </div>
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
                @php
                    $note = $order->note;
                    $address = '';
                    $cityProv = '';
                    $phone = '';

                    // Parse the note string
                    if (preg_match('/Alamat: (.*)/', $note, $match)) {
                        $address = $match[1];
                    }
                    if (preg_match('/Pengiriman ke (.*?)\./', $note, $match)) {
                        $cityProv = $match[1];
                    }
                    if (preg_match('/CP: (.*?)\./', $note, $match)) {
                        $phone = $match[1];
                    }

                    // Fallback if parsing fails (for old format)
                    if (empty($address))
                        $address = $note;

                    // Full formatted string for copy
                    $fullAddress = "Alamat: {$address}, {$cityProv}\nCP: {$order->user->name}\nHP: {$phone}";
                @endphp

                <div class="relative group">
                    <div class="space-y-3 text-sm text-slate-700 dark:text-slate-300">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase">Alamat</p>
                            <p class="leading-relaxed font-medium">{{ $address }}</p>
                            <p class="text-slate-500">{{ $cityProv }}</p>
                        </div>
                        <div class="flex gap-8">
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase">CP (Contact Person)</p>
                                <p class="font-medium">{{ $order->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase">HP / WhatsApp</p>
                                <p class="font-mono font-medium text-brand-600">{{ $phone }}</p>
                            </div>
                        </div>
                    </div>

                    <button
                        onclick="navigator.clipboard.writeText(`{{ $fullAddress }}`); Livewire.dispatch('notify', { message: 'Alamat berhasil disalin!', type: 'success' })"
                        class="absolute top-0 right-0 p-2 text-slate-400 hover:text-brand-500 transition-colors"
                        title="Copy Alamat Lengkap">
                        <i class="fas fa-copy"></i>
                    </button>
                    <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-800">
                        <button
                            onclick="navigator.clipboard.writeText(`{{ $fullAddress }}`); Livewire.dispatch('notify', { message: 'Alamat berhasil disalin!', type: 'success' })"
                            class="w-full py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-bold rounded-lg transition-colors flex items-center justify-center gap-2">
                            <i class="fas fa-copy"></i> Copy Detail Pengiriman
                        </button>
                    </div>
                </div>
                <!-- Courier info if available in future -->
            </div>
        </div>
    </div>

    <!-- Tracking Modal -->
    <div x-data="{ open: false, url: '' }" @open-tracking-modal.window="open = true; url = $event.detail.url"
        x-show="open" x-transition.opacity
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4 backdrop-blur-sm" x-cloak>

        <div @click.away="open = false"
            class="bg-white dark:bg-slate-900 w-full max-w-4xl h-[80vh] rounded-2xl shadow-2xl flex flex-col overflow-hidden">

            <div
                class="flex justify-between items-center p-4 border-b border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/50">
                <h3 class="font-bold text-lg"><i class="fas fa-search-location mr-2 text-brand-500"></i> Lacak
                    Pengiriman</h3>
                <button @click="open = false" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <div class="flex-1 bg-white relative">
                <div class="absolute inset-0 flex items-center justify-center text-slate-400">
                    <i class="fas fa-circle-notch fa-spin text-4xl"></i>
                </div>
                <iframe :src="url" class="absolute inset-0 w-full h-full z-10" border="0"></iframe>
            </div>
        </div>
    </div>
</div>