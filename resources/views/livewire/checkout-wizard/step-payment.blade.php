<div class="space-y-8">
    <div class="bg-gray-900/50 border border-gray-800 rounded-3xl overflow-hidden shadow-sm">
        <div class="bg-gray-800/50 px-8 py-6 flex items-center justify-between border-b border-gray-700">
            <div class="flex items-center gap-4">
                <span
                    class="w-8 h-8 rounded-full bg-orange-500 text-black flex items-center justify-center font-black text-sm">3</span>
                <h3 class="text-lg font-bold text-white uppercase">Konfirmasi Akhir</h3>
            </div>
        </div>

        <div class="p-8 space-y-8">
            <!-- Review Customer Details -->
            <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 py-4 border-b border-gray-800">
                <div>
                    <span class="text-xs font-bold text-gray-500 uppercase block mb-1">Penerima</span>
                    <p class="text-white font-medium">{{ $name ?: auth()->user()->name }}</p>
                    <p class="text-gray-400 text-sm">{{ $phone_number }}</p>
                    <p class="text-gray-400 text-sm">{{ $email ?: auth()->user()->email }}</p>
                </div>
                <button wire:click="goToStep(3)"
                    class="text-orange-500 text-xs hover:text-orange-400 font-bold uppercase tracking-wider">
                    Edit <i class="fas fa-pencil-alt ml-1"></i>
                </button>
            </div>

            <!-- Review Shipping Address -->
            <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 py-4 border-b border-gray-800">
                <div>
                    <span class="text-xs font-bold text-gray-500 uppercase block mb-1">Alamat Pengiriman</span>
                    <p class="text-white font-medium">{{ $address }}</p>
                    <p class="text-gray-400 text-sm">
                        {{ \Laravolt\Indonesia\Models\City::where('code', $city_id)->value('name') }},
                        {{ \Laravolt\Indonesia\Models\Province::where('code', $province_id)->value('name') }}
                    </p>
                    <p class="text-gray-400 text-sm">Kode Pos: {{ $postal_code }}</p>
                </div>
                <button wire:click="goToStep(3)"
                    class="text-orange-500 text-xs hover:text-orange-400 font-bold uppercase tracking-wider">
                    Edit <i class="fas fa-pencil-alt ml-1"></i>
                </button>
            </div>

            <!-- Items Review -->
            <div class="py-4">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-bold text-gray-500 uppercase block">Items</span>
                    <button wire:click="goToStep(2)"
                        class="text-orange-500 text-xs hover:text-orange-400 font-bold uppercase tracking-wider">
                        Edit <i class="fas fa-pencil-alt ml-1"></i>
                    </button>
                </div>

                <div class="space-y-3">
                    @foreach($selectedPackages as $pkg)
                        <div class="flex justify-between items-center bg-black/30 p-3 rounded-lg border border-gray-800">
                            <div>
                                <p class="text-white text-sm font-medium">{{ $pkg['name'] }}</p>
                                <p class="text-gray-500 text-xs">Qty: {{ $pkg['qty'] }}</p>
                            </div>
                            <span class="text-white font-bold text-sm">Rp
                                {{ number_format($pkg['price'] * $pkg['qty'], 0, ',', '.') }}</span>
                        </div>
                    @endforeach

                    @foreach($selectedAddons as $id => $qty)
                        @php $addon = $allAddons->firstWhere('id', $id); @endphp
                        @if($addon)
                            <div class="flex justify-between items-center bg-black/30 p-3 rounded-lg border border-gray-800">
                                <div>
                                    <p class="text-white text-sm font-medium">{{ $addon->name }}</p>
                                    <p class="text-gray-500 text-xs">Qty: {{ $qty }}</p>
                                </div>
                                <span class="text-white font-bold text-sm">Rp
                                    {{ number_format($addon->price * $qty, 0, ',', '.') }}</span>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Payment Button -->
            <button wire:click="processPayment"
                class="w-full btn-cta-primary bg-orange-500 hover:bg-orange-600 text-black py-4 rounded-2xl font-black text-lg transition-all shadow-xl hover:shadow-orange-500/20 active:scale-[0.98] uppercase flex items-center justify-center gap-3">
                <i class="fas fa-money-bill-wave"></i> Bayar Sekarang
            </button>
            <p class="text-center text-gray-500 text-xs">
                Dengan mengklik tombol di atas, Anda menyetujui syarat & ketentuan yang berlaku.
            </p>
        </div>
    </div>
</div>