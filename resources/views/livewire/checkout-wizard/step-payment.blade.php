<div class="space-y-8">
    <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-[0_4px_20px_-5px_rgba(0,0,0,0.1)]">
        <div class="bg-gray-50 px-6 py-4 flex items-center justify-between border-b border-gray-200">
            <div class="flex items-center gap-3">
                <span
                    class="w-8 h-8 rounded-full bg-orange-500 text-white flex items-center justify-center font-bold text-sm shadow-sm">3</span>
                <h3 class="text-lg font-bold text-gray-800 uppercase tracking-tight">Konfirmasi Akhir</h3>
            </div>
        </div>

        <div class="p-6 md:p-8 space-y-8">
            <!-- Review Customer Details -->
            <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 py-4 border-b border-gray-100">
                <div>
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Penerima</span>
                    <p class="text-gray-900 font-bold text-base">{{ $name ?: auth()->user()->name }}</p>
                    <p class="text-gray-600 text-sm mt-0.5">{{ $phone_number }}</p>
                    <p class="text-gray-500 text-sm">{{ $email ?: auth()->user()->email }}</p>
                </div>
                <button wire:click="goToStep(3)"
                    class="text-orange-600 hover:text-orange-700 text-xs font-bold uppercase tracking-wider flex items-center gap-1 transition-colors">
                    Edit <i class="fas fa-pencil-alt ml-1"></i>
                </button>
            </div>

            <!-- Review Shipping Address -->
            <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 py-4 border-b border-gray-100">
                <div>
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Alamat
                        Pengiriman</span>
                    <p class="text-gray-900 font-medium text-sm leading-relaxed max-w-lg">{{ $address }}</p>
                    <p class="text-gray-600 text-sm mt-0.5">
                        {{ \Laravolt\Indonesia\Models\City::where('code', $city_id)->value('name') }},
                        {{ \Laravolt\Indonesia\Models\Province::where('code', $province_id)->value('name') }}
                    </p>
                    <p class="text-gray-500 text-sm">Kode Pos: {{ $postal_code }}</p>
                </div>
                <button wire:click="goToStep(3)"
                    class="text-orange-600 hover:text-orange-700 text-xs font-bold uppercase tracking-wider flex items-center gap-1 transition-colors">
                    Edit <i class="fas fa-pencil-alt ml-1"></i>
                </button>
            </div>

            <!-- Items Review -->
            <div class="py-4">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Items</span>
                    <button wire:click="goToStep(2)"
                        class="text-orange-600 hover:text-orange-700 text-xs font-bold uppercase tracking-wider flex items-center gap-1 transition-colors">
                        Edit <i class="fas fa-pencil-alt ml-1"></i>
                    </button>
                </div>

                <div class="space-y-3">
                    @foreach($selectedPackages as $pkg)
                        <div class="flex justify-between items-center bg-gray-50 p-4 rounded-xl border border-gray-100">
                            <div>
                                <p class="text-gray-900 text-sm font-bold">{{ $pkg['name'] }}</p>
                                <p class="text-gray-500 text-xs mt-0.5">Qty: {{ $pkg['qty'] }}</p>
                            </div>
                            <span class="text-gray-900 font-bold text-sm">Rp
                                {{ number_format($pkg['price'] * $pkg['qty'], 0, ',', '.') }}</span>
                        </div>
                    @endforeach

                    @foreach($selectedAddons as $id => $qty)
                        @php $addon = $allAddons->firstWhere('id', $id); @endphp
                        @if($addon)
                            <div class="flex justify-between items-center bg-gray-50 p-4 rounded-xl border border-gray-100">
                                <div>
                                    <p class="text-gray-900 text-sm font-bold">{{ $addon->name }}</p>
                                    <p class="text-gray-500 text-xs mt-0.5">Qty: {{ $qty }}</p>
                                </div>
                                <span class="text-gray-900 font-bold text-sm">Rp
                                    {{ number_format($addon->price * $qty, 0, ',', '.') }}</span>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Payment Button -->
            <button wire:click="processPayment"
                class="w-full btn-cta-primary bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700 text-white py-4 rounded-xl font-black text-lg transition-all shadow-lg hover:shadow-orange-500/30 hover:-translate-y-1 active:scale-[0.98] uppercase flex items-center justify-center gap-3">
                <i class="fas fa-money-bill-wave"></i> Bayar Sekarang
            </button>
            <p class="text-center text-gray-400 text-xs max-w-sm mx-auto">
                Dengan mengklik tombol di atas, Anda menyetujui <a href="#"
                    class="text-orange-500 hover:underline">syarat & ketentuan</a> yang berlaku.
            </p>
        </div>
    </div>
</div>
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