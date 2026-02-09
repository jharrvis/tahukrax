<x-layouts.checkout>
    <div class="max-w-3xl mx-auto">
        <!-- Success Animation/Icon -->
        <div class="text-center mb-8">
            <div
                class="inline-flex items-center justify-center w-24 h-24 bg-green-100 rounded-full mb-6 animate-bounce shadow-sm">
                <i class="fas fa-check text-5xl text-green-600"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Pesanan Berhasil Dibuat!</h1>
            <p class="text-gray-500">Terima kasih telah bergabung menjadi Mitra TahuKrax.</p>
        </div>

        <!-- Order Detail Card -->
        <div class="bg-white rounded-3xl border border-gray-200 shadow-xl overflow-hidden mb-8">
            <div class="bg-gray-50 px-8 py-6 border-b border-gray-200 flex justify-between items-center">
                <div>
                    <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Nomor Order</h2>
                    <p class="text-xl font-mono font-bold text-gray-800">
                        #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
                </div>
                <div class="text-right">
                    <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Total Tagihan</h2>
                    <p class="text-xl font-bold text-orange-600">Rp
                        {{ number_format($order->total_amount, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            <div class="p-8 space-y-6">
                <!-- Status & Payment Instruction -->
                <div
                    class="bg-yellow-50 border border-yellow-100 rounded-2xl p-6 flex flex-col md:flex-row gap-6 items-start md:items-center">
                    <div
                        class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center shrink-0 text-yellow-600">
                        <i class="fas fa-wallet text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-gray-900 mb-1">Menunggu Pembayaran</h3>
                        <p class="text-sm text-gray-600 leading-relaxed">
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
                    <h3 class="font-bold text-gray-800 border-b border-gray-100 pb-2">Rincian Pesanan
                    </h3>
                    @foreach($order->orderItems as $item)
                        <div class="flex justify-between items-center py-2 last:pb-0">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 bg-gray-50 rounded-lg flex items-center justify-center text-gray-400 border border-gray-100">
                                    <i class="fas {{ $item->item_type == 'package' ? 'fa-box' : 'fa-puzzle-piece' }}"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-800 text-sm">
                                        @if($item->item_type == 'package' && $item->package)
                                            {{ $item->package->name }}
                                        @elseif($item->item_type == 'addon' && $item->addon)
                                            {{ $item->addon->name }}
                                        @else
                                            Item #{{ $item->id }}
                                        @endif
                                        <span class="text-gray-400 text-xs ml-1">x{{ $item->quantity }}</span>
                                    </p>
                                </div>
                            </div>
                            <span class="font-bold text-gray-600 text-sm">
                                Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                            </span>
                        </div>
                    @endforeach
                    <div class="flex justify-between items-center pt-2 text-sm text-gray-500 border-t border-gray-50">
                        <span>Ongkos Kirim</span>
                        <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Actions Footer -->
            <div class="bg-gray-50 p-6 flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('mitra.orders.show', $order->id) }}"
                    class="px-6 py-3 bg-white border border-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-colors text-center shadow-sm">
                    <i class="fas fa-eye mr-2"></i> Lihat Detail Pesanan
                </a>
                <a href="{{ route('mitra.dashboard') }}"
                    class="px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white font-bold rounded-xl shadow-lg shadow-orange-600/20 transition-all text-center">
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
            });
        </script>
    @endpush
</x-layouts.checkout>