<x-layouts.dashboard>
    <x-slot:title>
        Pesanan Berhasil
    </x-slot:title>

    <div class="max-w-3xl mx-auto pt-10">
        <!-- Success Animation/Icon -->
        <div class="text-center mb-8">
            <div
                class="inline-flex items-center justify-center w-24 h-24 bg-green-100 rounded-full mb-6 animate-bounce">
                <i class="fas fa-check text-5xl text-green-600"></i>
            </div>
            <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">Pesanan Berhasil Dibuat!</h1>
            <p class="text-slate-500 dark:text-slate-400">Terima kasih telah bergabung menjadi Mitra TahuKrax.</p>
        </div>

        <!-- Order Detail Card -->
        <div
            class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-xl overflow-hidden mb-8">
            <div
                class="bg-slate-50 dark:bg-slate-800/50 px-8 py-6 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center">
                <div>
                    <h2 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Nomor Order</h2>
                    <p class="text-xl font-mono font-bold text-slate-800 dark:text-white">
                        #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
                </div>
                <div class="text-right">
                    <h2 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Tagihan</h2>
                    <p class="text-xl font-bold text-brand-600">Rp
                        {{ number_format($order->total_amount, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            <div class="p-8 space-y-6">
                <!-- Status & Payment Instruction -->
                <div
                    class="bg-yellow-50 dark:bg-yellow-900/10 border border-yellow-100 dark:border-yellow-900/20 rounded-2xl p-6 flex flex-col md:flex-row gap-6 items-start md:items-center">
                    <div
                        class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center shrink-0 text-yellow-600">
                        <i class="fas fa-wallet text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-slate-800 dark:text-yellow-100 mb-1">Menunggu Pembayaran</h3>
                        <p class="text-sm text-slate-600 dark:text-yellow-200/80 leading-relaxed">
                            Silakan selesaikan pembayaran. Invoice dan instruksi pembayaran telah kami kirimkan ke
                            WhatsApp dan Email Anda.
                        </p>
                    </div>
                    @if($order->xendit_invoice_id)
                        <a href="https://checkout.xendit.co/web/{{ $order->xendit_invoice_id }}" target="_blank"
                            class="px-6 py-2.5 bg-yellow-500 hover:bg-yellow-600 text-white font-bold rounded-xl shadow-lg shadow-yellow-500/20 transition-all text-sm whitespace-nowrap">
                            Bayar Sekarang <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    @endif
                </div>

                <!-- Item Summary -->
                <div class="space-y-4">
                    <h3 class="font-bold text-slate-800 dark:text-white border-b border-slate-100 pb-2">Rincian Pesanan
                    </h3>
                    @foreach($order->orderItems as $item)
                        <div class="flex justify-between items-center py-2 last:pb-0">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center text-slate-400">
                                    <i class="fas {{ $item->item_type == 'package' ? 'fa-box' : 'fa-puzzle-piece' }}"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-slate-700 dark:text-slate-300">
                                        @if($item->item_type == 'package' && $item->package)
                                            {{ $item->package->name }}
                                        @elseif($item->item_type == 'addon' && $item->addon)
                                            {{ $item->addon->name }}
                                        @else
                                            Item #{{ $item->id }}
                                        @endif
                                        <span class="text-slate-400 text-sm">x{{ $item->quantity }}</span>
                                    </p>
                                </div>
                            </div>
                            <span class="font-bold text-slate-600 dark:text-slate-400 text-sm">
                                Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                            </span>
                        </div>
                    @endforeach
                    <div class="flex justify-between items-center pt-2 text-sm text-slate-500">
                        <span>Ongkos Kirim</span>
                        <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Actions Footer -->
            <div class="bg-slate-50 dark:bg-slate-800/50 p-6 flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('mitra.orders.show', $order->id) }}"
                    class="px-6 py-3 bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 text-slate-700 dark:text-slate-200 font-bold rounded-xl hover:bg-slate-50 dark:hover:bg-slate-600 transition-colors text-center">
                    <i class="fas fa-eye mr-2"></i> Lihat Detail Pesanan
                </a>
                <a href="{{ route('mitra.dashboard') }}"
                    class="px-6 py-3 bg-brand-500 hover:bg-brand-600 text-white font-bold rounded-xl shadow-lg shadow-brand-500/20 transition-all text-center">
                    <i class="fas fa-home mr-2"></i> Ke Dashboard Utama
                </a>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Clear shopping cart
                localStorage.removeItem('tahukrax_cart_v1');
                // Optional: Dispatch event if using Livewire or Alpine for cart elsewhere
            });
        </script>
    @endpush
</x-layouts.dashboard>