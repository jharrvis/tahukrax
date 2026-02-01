<div>
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center gap-2 text-slate-500 text-sm mb-1">
                <a href="{{ route('mitra.orders.index') }}" class="hover:text-brand-500 transition-colors">Pesanan
                    Saya</a>
                <i class="fas fa-chevron-right text-xs"></i>
                <span>#{{ $order->id }}</span>
            </div>
            <h1 class="text-2xl font-bold tracking-tight">Detail Pesanan #{{ $order->id }}</h1>
            <p class="text-slate-500 text-sm mt-1">
                <i class="far fa-calendar-alt mr-1"></i> {{ $order->created_at->format('d M Y, H:i') }} WIB
            </p>
        </div>
        <div>
            @if($order->status == 'shipped')
                <button type="button" @click="$dispatch('open-confirmation-modal')"
                    class="px-6 py-2 bg-brand-500 text-white font-bold rounded-full hover:bg-brand-600 transition-colors shadow-lg shadow-brand-500/30 flex items-center gap-2">
                    <i class="fas fa-box-open"></i> Konfirmasi Terima
                </button>
                <button wire:click="downloadInvoice" type="button"
                    onclick="window.location.href='{{ route('invoice.download', $order->id) }}'"
                    class="px-4 py-2 bg-slate-100 text-slate-600 font-bold rounded-full hover:bg-slate-200 transition-colors flex items-center gap-2 text-sm">
                    <i class="fas fa-file-invoice"></i> Invoke
                </button>
            @else
                <span
                    class="px-4 py-2 rounded-full text-sm font-bold uppercase {{ $this->getStatusColor($order->status) }}">
                    {{ $order->status }}
                </span>
                @if(in_array($order->status, ['paid', 'processing', 'shipped', 'completed']))
                    <a href="{{ route('invoice.download', $order->id) }}" target="_blank"
                        class="px-4 py-2 bg-slate-100 text-slate-600 font-bold rounded-full hover:bg-slate-200 transition-colors flex items-center gap-2 text-sm ml-2">
                        <i class="fas fa-file-invoice"></i> Invoice
                    </a>
                @endif
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Order Items -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800">
                <h3 class="font-bold text-lg mb-4">Item Pesanan</h3>
                <div class="space-y-4">
                    @foreach ($order->orderItems as $item)
                        <div class="flex gap-4 p-3 bg-slate-50 dark:bg-slate-800/50 rounded-xl">
                            <div
                                class="w-16 h-16 bg-white rounded-lg flex items-center justify-center border border-slate-200 shrink-0">
                                @if($item->item_type == 'package')
                                    <i class="fas fa-box text-brand-500 text-2xl"></i>
                                @else
                                    <i class="fas fa-puzzle-piece text-purple-500 text-2xl"></i>
                                @endif
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-slate-800 dark:text-slate-200">
                                    @if($item->item_type == 'package' && $item->package)
                                        {{ $item->package->name }}
                                    @elseif(($item->item_type == 'addon' || $item->addon_id) && $item->addon)
                                        {{ $item->addon->name }}
                                    @else
                                        Unknown Item
                                    @endif
                                </h4>
                                <p class="text-sm text-slate-500">Qty: {{ $item->quantity }} x Rp
                                    {{ number_format($item->price, 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-slate-800 dark:text-slate-200">Rp
                                    {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 pt-6 border-t border-slate-100 dark:border-slate-700 space-y-2">
                    <div class="flex justify-between text-sm text-slate-500">
                        <span>Subtotal Item</span>
                        <span>Rp
                            {{ number_format($order->orderItems->sum(fn($item) => $item->price * $item->quantity), 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm text-slate-500">
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
                    <div
                        class="flex justify-between items-center text-lg font-bold text-slate-800 dark:text-white mt-4 pt-4 border-t border-slate-100 dark:border-slate-700">
                        <span>Total Bayar</span>
                        <span class="text-brand-500">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Shipping Info -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800">
                <h3 class="font-bold text-lg mb-4">Informasi Pengiriman</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wider font-bold mb-1">Kurir / Ekspedisi</p>
                        <p class="font-medium">Indah Cargo</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wider font-bold mb-1">Nomor Resi</p>
                        @if($order->tracking_number)
                            <div class="flex items-center gap-2">
                                <p class="font-mono font-bold text-brand-500 text-lg">{{ $order->tracking_number }}</p>
                                <button
                                    onclick="navigator.clipboard.writeText('{{ $order->tracking_number }}'); Livewire.dispatch('notify', { message: 'Resi berhasil disalin!', type: 'success' })"
                                    class="text-slate-400 hover:text-brand-500 transition-colors" title="Copy Resi">
                                    <i class="fas fa-copy"></i>
                                </button>
                                <button type="button" wire:click="checkResi"
                                    class="ml-2 px-3 py-1 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-bold rounded-lg transition-colors flex items-center gap-1"
                                    title="Lacak Paket">
                                    <i class="fas fa-search-location"></i> Lacak
                                </button>
                            </div>
                        @else
                            <p class="text-slate-500 italic">Menunggu pengiriman...</p>
                        @endif
                    </div>
                    <div class="md:col-span-2">
                        <div class="md:col-span-2">
                            <p class="text-xs text-slate-400 uppercase tracking-wider font-bold mb-3">Alamat Tujuan</p>
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
                            @endphp

                            <div class="bg-slate-50 dark:bg-slate-800/50 p-4 rounded-xl space-y-3 text-sm">
                                <div>
                                    <p class="text-xs font-bold text-slate-400 uppercase mb-1">Alamat</p>
                                    <p class="font-medium text-slate-800 dark:text-slate-200">{{ $address }}</p>
                                    <p class="text-slate-500">{{ $cityProv }}</p>
                                </div>
                                <div class="flex gap-8">
                                    <div>
                                        <p class="text-xs font-bold text-slate-400 uppercase mb-1">Penerima</p>
                                        <p class="font-medium text-slate-800 dark:text-slate-200">
                                            {{ $order->user->name }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-400 uppercase mb-1">No. HP</p>
                                        <p class="font-mono font-medium text-brand-600">{{ $phone }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-6">
            <!-- Payment Info -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800">
                <h3 class="font-bold text-lg mb-4">Pembayaran</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wider font-bold mb-1">Metode</p>
                        <div class="flex items-center gap-2">
                            @if($order->payment_channel)
                                @php
                                    $channel = strtoupper($order->payment_channel);
                                @endphp
                                @if(in_array($channel, ['GOPAY', 'ID_GOPAY']))
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/8/86/Gopay_logo.svg" h-4
                                        class="h-6" alt="GoPay">
                                @elseif(in_array($channel, ['OVO', 'ID_OVO']))
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/e/eb/Logo_ovo_purple.svg"
                                        class="h-6" alt="OVO">
                                @elseif(in_array($channel, ['DANA', 'ID_DANA']))
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/7/72/Logo_dana_blue.svg"
                                        class="h-6" alt="DANA">
                                @elseif(in_array($channel, ['SHOPEEPAY', 'ID_SHOPEEPAY']))
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/f/fe/Shopee.svg" class="h-6"
                                        alt="ShopeePay">
                                @elseif(in_array($channel, ['BCA', 'MANDIRI', 'BNI', 'BRI', 'PERMATA', 'CIMB']))
                                    <span class="font-bold text-slate-800 dark:text-white">{{ $channel }}</span>
                                @else
                                    <span class="font-medium text-slate-800 dark:text-white">{{ $channel }}</span>
                                @endif
                            @else
                                <p class="font-medium">Xendit Payment</p>
                            @endif
                        </div>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wider font-bold mb-1">Status</p>
                        <div class="flex items-center gap-2">
                            <i
                                class="fas {{ $order->status === 'paid' ? 'fa-check-circle text-green-500' : 'fa-clock text-yellow-500' }}"></i>
                            <span class="font-medium capitalize">{{ $order->status }}</span>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wider font-bold mb-1">ID Invoice</p>
                        <p class="font-mono text-xs text-slate-500 break-all">{{ $order->xendit_invoice_id ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Support -->
            <div class="bg-gradient-to-br from-brand-500 to-brand-600 rounded-2xl p-6 text-white text-center">
                <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-headset text-2xl"></i>
                </div>
                <h3 class="font-bold mb-1">Butuh Bantuan?</h3>
                <p class="text-white/80 text-sm mb-4">Jika ada masalah dengan pesanan ini, hubungi admin.</p>
                <a href="https://wa.me/6288221201998" target="_blank"
                    class="inline-block w-full py-2 bg-white text-brand-600 font-bold rounded-lg hover:bg-slate-100 transition-colors">
                    Hubungi Admin
                </a>
            </div>
        </div>
    </div>

    <!-- Tracking Modal -->
    <div x-data="{ open: false, url: '' }" @open-tracking-modal.window="open = true; url = $event.detail.url || ''"
        x-show="open" x-transition.opacity
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4 backdrop-blur-sm" x-cloak>

        <div @click.away="open = false"
            class="bg-white dark:bg-slate-900 w-full max-w-2xl rounded-2xl shadow-2xl flex flex-col overflow-hidden animate-bounce-in">

            <div
                class="flex justify-between items-center p-4 border-b border-slate-100 dark:border-slate-800 bg-brand-500 text-white">
                <h3 class="font-bold text-lg"><i class="fas fa-shipping-fast mr-2"></i> Lacak Pengiriman</h3>
                <button @click="open = false" class="text-white/80 hover:text-white transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <div class="p-6 bg-slate-50 dark:bg-slate-800/50">
                @if($isLoadingTracking)
                    <div class="flex flex-col items-center justify-center py-12">
                        <i class="fas fa-circle-notch fa-spin text-4xl text-brand-500 mb-4"></i>
                        <p class="text-slate-500 font-medium">Sedang mengambil data dari Indah Cargo...</p>
                    </div>
                @elseif($trackingData)
                    <div class="space-y-6">
                        <div
                            class="flex justify-between items-center bg-white dark:bg-slate-800 p-4 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm">
                            <div>
                                <p class="text-xs text-slate-400 uppercase font-bold">Nomor Resi</p>
                                <p class="text-xl font-mono font-bold text-brand-600">{{ $trackingData['no_resi'] ?? '-' }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-slate-400 uppercase font-bold">Layanan</p>
                                <p class="font-bold text-slate-700 dark:text-slate-200">
                                    {{ $trackingData['layanan'] ?? '-' }}
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div
                                class="bg-white dark:bg-slate-800 p-4 rounded-xl border border-slate-200 dark:border-slate-700">
                                <p class="text-xs text-slate-400 uppercase font-bold mb-2"><i
                                        class="fas fa-truck-loading text-brand-500 mr-1"></i> Asal</p>
                                <p class="font-bold text-slate-800 dark:text-slate-100">{{ $trackingData['asal'] ?? '-' }}
                                </p>
                                <p class="text-xs text-slate-500 mt-1">{{ $trackingData['pengirim'] ?? '-' }}</p>
                            </div>
                            <div
                                class="bg-white dark:bg-slate-800 p-4 rounded-xl border border-slate-200 dark:border-slate-700">
                                <p class="text-xs text-slate-400 uppercase font-bold mb-2"><i
                                        class="fas fa-map-marker-alt text-red-500 mr-1"></i> Tujuan</p>
                                <p class="font-bold text-slate-800 dark:text-slate-100">{{ $trackingData['tujuan'] ?? '-' }}
                                </p>
                                <p class="text-xs text-slate-500 mt-1">{{ $trackingData['penerima'] ?? '-' }}</p>
                            </div>
                        </div>

                        <div
                            class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-xl border border-blue-100 dark:border-blue-800 flex items-start gap-3">
                            <i class="fas fa-info-circle text-blue-500 mt-0.5"></i>
                            <div>
                                <p class="text-sm font-bold text-blue-800 dark:text-blue-200">Status Terakhir</p>
                                <p class="text-xs text-blue-600 dark:text-blue-300">Resi terdaftar pada
                                    {{ $trackingData['tanggal'] ?? '-' }}. Untuk riwayat perjalanan lengkap, silakan cek
                                    website resmi.
                                </p>
                            </div>
                        </div>

                        <div class="text-center">
                            <a href="https://www.indahonline.com/services/view?NO_RESI={{ $trackingData['no_resi'] ?? '' }}"
                                target="_blank"
                                class="inline-flex items-center gap-2 px-6 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold rounded-lg transition-colors text-sm">
                                <i class="fas fa-external-link-alt"></i> Lihat Detail di Website Indah Cargo
                            </a>
                        </div>
                    </div>
                @else
                    <div class="text-center py-8">
                        <div
                            class="bg-orange-100 text-orange-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-search text-2xl"></i>
                        </div>
                        <h4 class="font-bold text-slate-800 dark:text-slate-200 mb-2">Lacak Eksternal</h4>
                        <p class="text-slate-500 text-sm mb-6 max-w-xs mx-auto">Kami tidak dapat menampilkan data ringkas
                            saat ini. Silakan buka website ekspedisi langsung.</p>

                        <a :href="url" target="_blank"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-brand-500 hover:bg-brand-600 text-white font-bold rounded-xl transition-all shadow-lg hover:shadow-brand-500/30">
                            Buka Indah Online <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div x-data="{ open: false }" @open-confirmation-modal.window="open = true"
        @close-confirmation-modal.window="open = false" x-show="open" x-transition.opacity
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4 backdrop-blur-sm" x-cloak>

        <div @click.away="open = false"
            class="bg-white dark:bg-slate-900 w-full max-w-lg rounded-2xl shadow-2xl flex flex-col overflow-hidden animate-bounce-in max-h-[90vh] overflow-y-auto">

            <div
                class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center bg-brand-500 text-white">
                <h3 class="font-bold text-lg">Konfirmasi Penerimaan</h3>
                <button @click="open = false" type="button" class="text-white/80 hover:text-white"><i
                        class="fas fa-times text-xl"></i></button>
            </div>

            <div class="p-6">
                <form wire:submit.prevent="confirmReceiving" class="space-y-4">
                    <!-- Condition -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Kondisi Paket</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label
                                class="cursor-pointer border-2 {{ $confirmCondition == 'good' ? 'border-brand-500 bg-brand-50' : 'border-slate-200' }} rounded-xl p-3 flex flex-col items-center gap-2 hover:border-brand-300 transition-all">
                                <input type="radio" wire:model.live="confirmCondition" value="good" class="hidden">
                                <i
                                    class="fas fa-check-circle text-2xl {{ $confirmCondition == 'good' ? 'text-brand-500' : 'text-slate-300' }}"></i>
                                <span class="text-sm font-medium">Diterima Baik</span>
                            </label>
                            <label
                                class="cursor-pointer border-2 {{ $confirmCondition == 'damaged' ? 'border-red-500 bg-red-50' : 'border-slate-200' }} rounded-xl p-3 flex flex-col items-center gap-2 hover:border-red-300 transition-all">
                                <input type="radio" wire:model.live="confirmCondition" value="damaged" class="hidden">
                                <i
                                    class="fas fa-exclamation-triangle text-2xl {{ $confirmCondition == 'damaged' ? 'text-red-500' : 'text-slate-300' }}"></i>
                                <span class="text-sm font-medium">Ada Masalah</span>
                            </label>
                        </div>
                    </div>

                    <!-- Issues (Shown if damaged) -->
                    @if($confirmCondition == 'damaged')
                        <div class="bg-red-50 p-4 rounded-xl border border-red-100 space-y-3">
                            <label class="block text-sm font-bold text-red-800">Detail Masalah</label>
                            <div class="space-y-2">
                                @foreach(['packing_damaged' => 'Kemasan Rusak/Penyok', 'item_damaged' => 'Barang Rusak/Pecah', 'item_missing' => 'Barang Kurang/Hilang', 'wrong_item' => 'Barang Tidak Sesuai'] as $key => $label)
                                    <label class="flex items-center gap-2 text-sm text-slate-700 cursor-pointer">
                                        <input type="checkbox" wire:model="confirmIssueTypes" value="{{ $key }}"
                                            class="rounded text-red-500">
                                        {{ $label }}
                                    </label>
                                @endforeach
                            </div>
                            @error('confirmIssueTypes') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>
                    @endif

                    <!-- Photos -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Foto Bukti (Maks 5)</label>
                        <input type="file" wire:model="confirmImages" multiple accept="image/*"
                            class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
                        @error('confirmImages.*') <span class="text-xs text-red-500">{{ $message }}</span> @enderror

                        @if($confirmImages)
                            <div class="flex gap-2 mt-2 overflow-x-auto pb-2">
                                @foreach($confirmImages as $img)
                                    <img src="{{ $img->temporaryUrl() }}"
                                        class="w-16 h-16 object-cover rounded-lg border border-slate-200">
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Note -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Catatan Tambahan</label>
                        <textarea wire:model="confirmNote" rows="3"
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-brand-500"
                            placeholder="Ceritakan detail kondisi barang..."></textarea>
                    </div>

                    <!-- Rating -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Rating Layanan Pengiriman</label>
                        <div class="flex gap-2 justify-center">
                            @foreach(range(1, 5) as $r)
                                <button type="button" wire:click="$set('confirmRating', {{ $r }})"
                                    class="text-2xl hover:scale-110 transition-transform {{ $confirmRating >= $r ? 'text-yellow-400' : 'text-slate-300' }}">
                                    <i class="fas fa-star"></i>
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <div class="pt-4 flex gap-3">
                        <button @click="open = false" type="button"
                            class="flex-1 py-3 bg-slate-100 text-slate-600 font-bold rounded-xl hover:bg-slate-200 transition-colors">Batal</button>
                        <button type="submit" wire:loading.attr="disabled"
                            class="flex-1 py-3 bg-brand-500 text-white font-bold rounded-xl hover:bg-brand-600 shadow-lg shadow-brand-500/30 transition-all">
                            <span wire:loading.remove>Kirim Konfirmasi</span>
                            <span wire:loading>Mengirim...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>