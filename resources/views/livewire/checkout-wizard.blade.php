<div class="min-h-screen pb-24 md:pb-10" x-data="{ 
        initCheckout() {
             @if(count($selectedPackages) === 0 && $step === 2)
                let stored = localStorage.getItem('tahukrax_cart_v1');
                let cart = null;
                if (window.TahuKraxCart) {
                    cart = window.TahuKraxCart.get();
                } else if (stored) {
                    try {
                        let parsed = JSON.parse(stored);
                        cart = {
                            mainPackages: parsed.mainPackages || [],
                            addons: parsed.addons ? parsed.addons.reduce((acc, curr) => { acc[curr.id] = curr.qty; return acc; }, {}) : {}
                        };
                    } catch(e) { console.error('Checkout init parse error', e); }
                }

                if (cart && cart.mainPackages && cart.mainPackages.length > 0) {
                     $wire.setPackages(cart.mainPackages).then(() => {
                        if (cart.addons && Object.keys(cart.addons).length > 0) {
                             $wire.loadAddonsFromCart(cart.addons);
                        }
                    });
                }
             @endif
        }
    }" x-init="initCheckout()">

    <!-- Loading Overlay -->
    <div wire:loading wire:target="processPayment, nextStep, previousStep"
        class="fixed inset-0 bg-white/80 z-[100] flex items-center justify-center backdrop-blur-sm">
        <div class="text-center">
            <div
                class="w-16 h-16 border-4 border-orange-500 border-t-transparent rounded-full animate-spin mx-auto mb-4">
            </div>
            <p class="text-gray-800 font-bold text-lg">Memproses...</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-10">
        <!-- Header & Progress Bar -->
        <div class="mb-6 md:mb-10">
            <a href="{{ route('home') }}"
                class="group inline-flex items-center text-gray-500 hover:text-orange-600 transition-colors mb-4 md:mb-6 text-sm font-medium">
                <i class="fas fa-chevron-left mr-2 transform group-hover:-translate-x-1 transition-transform"></i>
                Kembali ke Beranda
            </a>

            <!-- Wizard Progress - Compact on Mobile -->
            <div class="flex items-center justify-between relative max-w-md md:max-w-2xl mx-auto">
                <div
                    class="absolute left-0 top-1/2 -translate-y-1/2 w-full h-0.5 md:h-1 bg-gray-200 -z-10 rounded-full">
                </div>
                <div class="absolute left-0 top-1/2 -translate-y-1/2 h-0.5 md:h-1 bg-orange-500 -z-10 rounded-full transition-all duration-500"
                    style="width: {{ ($step - 1) / 3 * 100 }}%"></div>

                <!-- Step 1: Paket -->
                <div class="flex flex-col items-center gap-1 md:gap-2 cursor-pointer" wire:click="goToStep(2)">
                    <div
                        class="w-8 h-8 md:w-10 md:h-10 rounded-full flex items-center justify-center font-bold text-xs md:text-sm transition-all z-10 
                        {{ $step >= 2 ? 'bg-orange-500 text-white shadow-[0_0_15px_rgba(249,115,22,0.4)]' : 'bg-white text-gray-400 border-2 border-gray-200' }}">
                        @if($step > 2) <i class="fas fa-check text-xs"></i> @else 1 @endif
                    </div>
                    <span
                        class="text-[10px] md:text-xs font-bold uppercase tracking-wider {{ $step >= 2 ? 'text-orange-600' : 'text-gray-400' }}">Paket</span>
                </div>

                <!-- Step 2: Data -->
                <div class="flex flex-col items-center gap-1 md:gap-2 cursor-pointer" @if($step > 2)
                wire:click="goToStep(3)" @endif>
                    <div
                        class="w-8 h-8 md:w-10 md:h-10 rounded-full flex items-center justify-center font-bold text-xs md:text-sm transition-all z-10 
                        {{ $step >= 3 ? 'bg-orange-500 text-white shadow-[0_0_15px_rgba(249,115,22,0.4)]' : 'bg-white text-gray-400 border-2 border-gray-200' }}">
                        @if($step > 3) <i class="fas fa-check text-xs"></i> @else 2 @endif
                    </div>
                    <span
                        class="text-[10px] md:text-xs font-bold uppercase tracking-wider {{ $step >= 3 ? 'text-orange-600' : 'text-gray-400' }}">Data</span>
                </div>

                <!-- Step 3: Bayar -->
                <div class="flex flex-col items-center gap-1 md:gap-2">
                    <div
                        class="w-8 h-8 md:w-10 md:h-10 rounded-full flex items-center justify-center font-bold text-xs md:text-sm transition-all z-10 
                        {{ $step >= 4 ? 'bg-orange-500 text-white shadow-[0_0_15px_rgba(249,115,22,0.4)]' : 'bg-white text-gray-400 border-2 border-gray-200' }}">
                        3
                    </div>
                    <span
                        class="text-[10px] md:text-xs font-bold uppercase tracking-wider {{ $step >= 4 ? 'text-orange-600' : 'text-gray-400' }}">Bayar</span>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 md:gap-8 lg:gap-10 items-start">

            <!-- Left Column: Step Content -->
            <div class="md:col-span-7 lg:col-span-7 xl:col-span-8 space-y-6">
                @if($step === 2)
                    @include('livewire.checkout-wizard.step-packages')
                @elseif($step === 3)
                    @include('livewire.checkout-wizard.step-shipping')
                @elseif($step === 4)
                    @include('livewire.checkout-wizard.step-payment')
                @endif
            </div>

            <!-- Right Column: Order Summary (Sticky - stops when left column ends) -->
            <div class="hidden md:block md:col-span-5 lg:col-span-5 xl:col-span-4 self-start sticky top-24">
                <!-- Summary Card -->
                <div
                    class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-[0_10px_40px_-10px_rgba(0,0,0,0.08)]">

                    <!-- Header - Fixed -->
                    <div class="p-5 border-b border-gray-100 flex-shrink-0 bg-gray-50/50">
                        <div class="flex items-center justify-between">
                            <h3
                                class="text-base font-black text-gray-800 uppercase tracking-wider flex items-center gap-2">
                                <i class="fas fa-receipt text-orange-500"></i> Ringkasan
                            </h3>
                            @if($step === 2 && (!empty($selectedPackages) || !empty($selectedAddons)))
                                <button wire:click="resetCart"
                                    class="px-3 py-1 bg-red-50 border border-red-100 rounded-lg text-red-500 hover:bg-red-100 transition-all text-xs font-bold">
                                    <i class="fas fa-trash-alt mr-1"></i> Reset
                                </button>
                            @endif
                        </div>
                    </div>

                    <!-- Items List - Scrollable Middle -->
                    <div class="flex-1 overflow-y-auto custom-scrollbar p-5 space-y-4 min-h-0 max-h-[50vh]">
                        @if($step === 2)
                            {{-- Step 2: Interactive items with controls --}}
                            @if(empty($selectedPackages) && empty($selectedAddons))
                                <div class="text-center py-10">
                                    <div
                                        class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                        <i class="fas fa-shopping-cart text-2xl text-gray-400"></i>
                                    </div>
                                    <p class="text-gray-500 text-sm font-medium">Keranjang masih kosong</p>
                                    <p class="text-gray-400 text-xs mt-1">Pilih paket usaha di sebelah kiri</p>
                                </div>
                            @else
                                {{-- Packages --}}
                                @foreach($selectedPackages as $index => $pkg)
                                    <div
                                        class="bg-white rounded-xl p-3 border border-gray-200 shadow-sm hover:border-orange-300 transition-all group">
                                        <div class="flex items-start justify-between gap-2 mb-3">
                                            <div class="min-w-0 flex-1">
                                                <h4 class="text-gray-800 font-bold text-sm truncate">{{ $pkg['name'] }}</h4>
                                                <p class="text-orange-600 text-xs font-bold">@ Rp
                                                    {{ number_format($pkg['price'], 0, ',', '.') }}
                                                </p>
                                            </div>
                                            <button wire:click="removePackage({{ $index }})"
                                                class="text-gray-400 hover:text-red-500 p-1 transition-colors">
                                                <i class="fas fa-times text-xs"></i>
                                            </button>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-1 bg-gray-50 rounded-lg border border-gray-200 p-0.5">
                                                <button wire:click="decrementPackage({{ $index }})"
                                                    class="w-7 h-7 rounded-md flex items-center justify-center text-gray-500 hover:bg-white hover:text-red-500 hover:shadow-sm transition-all">
                                                    <i class="fas fa-minus text-[10px]"></i>
                                                </button>
                                                <span
                                                    class="text-gray-800 text-xs font-bold w-6 text-center">{{ $pkg['qty'] }}</span>
                                                <button wire:click="incrementPackage({{ $index }})"
                                                    class="w-7 h-7 rounded-md flex items-center justify-center text-gray-500 hover:bg-white hover:text-green-500 hover:shadow-sm transition-all">
                                                    <i class="fas fa-plus text-[10px]"></i>
                                                </button>
                                            </div>
                                            <span class="text-gray-800 font-bold text-sm">Rp
                                                {{ number_format($pkg['price'] * $pkg['qty'], 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                @endforeach

                                {{-- Add-ons --}}
                                @foreach($selectedAddons as $id => $qty)
                                    @php $addon = $allAddons->firstWhere('id', $id); @endphp
                                    @if($addon)
                                        <div class="bg-gray-50 rounded-xl p-3 border border-gray-200">
                                            <div class="flex items-start justify-between gap-2 mb-2">
                                                <div class="min-w-0 flex-1">
                                                    <div class="flex items-center gap-1.5">
                                                        <i class="fas fa-puzzle-piece text-gray-400 text-[10px]"></i>
                                                        <h4 class="text-gray-700 text-sm truncate font-medium">{{ $addon->name }}</h4>
                                                    </div>
                                                    <p class="text-gray-500 text-xs pl-4">@ Rp
                                                        {{ number_format($addon->price, 0, ',', '.') }}
                                                    </p>
                                                </div>
                                                <button wire:click="removeAddon({{ $id }})"
                                                    class="text-gray-400 hover:text-red-500 p-1">
                                                    <i class="fas fa-times text-xs"></i>
                                                </button>
                                            </div>
                                            <div class="flex items-center justify-between pl-4">
                                                <div class="flex items-center gap-1 bg-white rounded-lg border border-gray-200 p-0.5">
                                                    <button wire:click="decrementAddon({{ $id }})"
                                                        class="w-6 h-6 rounded flex items-center justify-center text-gray-400 hover:text-red-500">
                                                        <i class="fas fa-minus text-[10px]"></i>
                                                    </button>
                                                    <span class="text-gray-700 text-xs font-bold w-5 text-center">{{ $qty }}</span>
                                                    <button wire:click="incrementAddon({{ $id }})"
                                                        class="w-6 h-6 rounded flex items-center justify-center text-gray-400 hover:text-green-500">
                                                        <i class="fas fa-plus text-[10px]"></i>
                                                    </button>
                                                </div>
                                                <span class="text-gray-700 font-bold text-sm">Rp
                                                    {{ number_format($addon->price * $qty, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        @else
                            {{-- Step 3 & 4: Compact read-only list --}}
                            <div class="space-y-3">
                                @forelse($selectedPackages as $pkg)
                                    <div
                                        class="flex justify-between gap-3 text-sm pb-3 border-b border-gray-50 last:border-0 last:pb-0">
                                        <span class="text-gray-600 truncate flex-1"><i
                                                class="fas fa-box text-orange-500 text-xs mr-2"></i>{{ $pkg['name'] }}
                                            @if($pkg['qty'] > 1)<span
                                            class="text-orange-600 font-bold ml-1">x{{ $pkg['qty'] }}</span>@endif</span>
                                        <span class="text-gray-800 font-bold whitespace-nowrap">Rp
                                            {{ number_format($pkg['price'] * $pkg['qty'], 0, ',', '.') }}</span>
                                    </div>
                                @empty
                                    <p class="text-gray-400 text-sm italic">Belum ada paket</p>
                                @endforelse
                                @foreach($selectedAddons as $id => $qty)
                                    @php $addon = $allAddons->firstWhere('id', $id); @endphp
                                    @if($addon)
                                        <div class="flex justify-between gap-3 text-sm pb-2 border-b border-gray-50 last:border-0">
                                            <span class="text-gray-500 truncate flex-1"><i
                                                    class="fas fa-puzzle-piece text-gray-400 text-xs mr-2"></i>{{ $qty }}x
                                                {{ $addon->name }}</span>
                                            <span class="text-gray-700 font-bold whitespace-nowrap">Rp
                                                {{ number_format($addon->price * $qty, 0, ',', '.') }}</span>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Footer - Fixed at bottom -->
                    <div class="flex-shrink-0 border-t border-gray-100 bg-gray-50">
                        <!-- Shipping & Weight -->
                        <div class="px-5 py-4 space-y-2 text-sm border-b border-gray-100">
                            <div class="flex justify-between">
                                <span class="text-gray-500"><i class="fas fa-truck mr-2 text-gray-400"></i>Ongkir</span>
                                <span class="text-gray-800 font-bold">
                                    @if($this->total['shipping'] > 0)
                                        Rp {{ number_format($this->total['shipping'], 0, ',', '.') }}
                                    @else
                                        <span class="text-gray-400 text-xs italic">Hitung di langkah selanjutnya</span>
                                    @endif
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500"><i
                                        class="fas fa-weight-hanging mr-2 text-gray-400"></i>Berat Total</span>
                                <span class="text-gray-800 font-bold">{{ $this->total['total_weight'] }} Kg</span>
                            </div>
                        </div>

                        <!-- Grand Total -->
                        <div class="px-5 py-4 bg-white">
                            <div class="flex justify-between items-end">
                                <p class="text-xs text-gray-500 font-bold uppercase tracking-widest mb-1">Total
                                    Pembayaran</p>
                                <div class="text-2xl font-black text-orange-600" wire:loading.class="opacity-50">
                                    Rp {{ number_format($this->total['grand_total'], 0, ',', '.') }}
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="p-5 space-y-3 bg-white border-t border-gray-100">
                            @if($step < 4)
                                <button wire:click="nextStep"
                                    class="w-full py-3.5 rounded-xl bg-gradient-to-r from-orange-500 to-red-600 text-white font-bold hover:from-orange-600 hover:to-red-700 transition-all shadow-lg hover:shadow-orange-500/30 hover:-translate-y-0.5 flex items-center justify-center gap-2 text-sm uppercase tracking-wide">
                                    @if($step === 2)
                                        Lanjut ke Data Mitra <i class="fas fa-arrow-right"></i>
                                    @elseif($step === 3)
                                        Lanjut ke Pembayaran <i class="fas fa-arrow-right"></i>
                                    @endif
                                </button>
                            @endif
                            @if($step > 2)
                                <button wire:click="previousStep"
                                    class="w-full py-3 rounded-xl border-2 border-gray-200 text-gray-500 hover:border-gray-800 hover:text-gray-800 font-bold transition-all flex items-center justify-center gap-2 text-sm">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MOBILE: Fixed Bottom Bar with Expandable Summary -->
    <div class="lg:hidden fixed bottom-0 left-0 right-0 z-50 safe-area-bottom" x-data="{ showSummary: false }">

        <!-- Expandable Summary Panel -->
        <div x-show="showSummary" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-full" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-full"
            class="bg-gray-900 border-t border-gray-700 max-h-64 overflow-y-auto">
            <div class="p-4 space-y-2">
                <h4 class="text-sm font-bold text-white flex items-center gap-2 mb-3">
                    <i class="fas fa-receipt text-orange-500"></i> Ringkasan Pesanan
                </h4>

                @foreach($selectedPackages as $pkg)
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-400 truncate flex-1 mr-2">
                            <i class="fas fa-box text-orange-500 text-xs mr-1"></i>
                            {{ $pkg['name'] }} @if($pkg['qty'] > 1)<span
                            class="text-orange-500">({{ $pkg['qty'] }}x)</span>@endif
                        </span>
                        <span class="text-white font-bold">Rp
                            {{ number_format($pkg['price'] * $pkg['qty'], 0, ',', '.') }}</span>
                    </div>
                @endforeach

                @foreach($selectedAddons as $id => $qty)
                    @php $addon = $allAddons->firstWhere('id', $id); @endphp
                    @if($addon)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-400 truncate flex-1 mr-2">
                                <i class="fas fa-puzzle-piece text-gray-600 text-xs mr-1"></i>
                                {{ $qty }}x {{ $addon->name }}
                            </span>
                            <span class="text-white font-bold">Rp {{ number_format($addon->price * $qty, 0, ',', '.') }}</span>
                        </div>
                    @endif
                @endforeach

                <div class="pt-2 mt-2 border-t border-gray-800 flex justify-between text-sm">
                    <span class="text-gray-500"><i class="fas fa-truck mr-1"></i> Ongkir</span>
                    <span class="text-white font-bold">
                        @if($this->total['shipping'] > 0)
                            Rp {{ number_format($this->total['shipping'], 0, ',', '.') }}
                        @else
                            <span class="text-gray-600 text-xs">-</span>
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <!-- Main Bottom Bar -->
        <div class="bg-gray-900 border-t border-gray-800 shadow-2xl">
            <div class="px-4 py-3">
                <!-- Summary Row -->
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <p class="text-[10px] text-gray-500 uppercase tracking-wider">Total Pembayaran</p>
                        <p class="text-xl font-black text-orange-500" wire:loading.class="opacity-50">
                            Rp {{ number_format($this->total['grand_total'], 0, ',', '.') }}
                        </p>
                    </div>

                    <!-- Toggle Summary Button -->
                    <button @click="showSummary = !showSummary" class="relative">
                        <div class="bg-gray-800 rounded-lg px-3 py-2 flex items-center gap-2">
                            <i class="fas fa-shopping-bag text-orange-500"></i>
                            <span
                                class="text-white text-sm font-bold">{{ count($selectedPackages) + count($selectedAddons) }}</span>
                            <i class="fas text-gray-500 text-xs transition-transform"
                                :class="showSummary ? 'fa-chevron-down' : 'fa-chevron-up'"></i>
                        </div>
                    </button>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3">
                    @if($step > 2)
                        <button wire:click="previousStep"
                            class="px-4 py-3 rounded-xl border border-gray-700 text-gray-400 hover:bg-gray-800 font-bold transition-all">
                            <i class="fas fa-arrow-left"></i>
                        </button>
                    @endif

                    @if($step < 4)
                        <button wire:click="nextStep"
                            class="flex-1 py-3 rounded-xl bg-gradient-to-r from-orange-500 to-red-600 text-white font-bold hover:from-orange-600 hover:to-red-700 transition-all shadow-lg flex items-center justify-center gap-2">
                            @if($step === 2)
                                Lanjut ke Data <i class="fas fa-arrow-right"></i>
                            @elseif($step === 3)
                                Bayar <i class="fas fa-money-bill-wave"></i>
                            @endif
                        </button>
                    @elseif($step === 4)
                        <button wire:click="processPayment"
                            class="flex-1 py-3 rounded-xl bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold hover:from-green-600 hover:to-emerald-700 transition-all shadow-lg flex items-center justify-center gap-2">
                            <i class="fas fa-lock"></i> Bayar Sekarang
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .safe-area-bottom {
            padding-bottom: env(safe-area-inset-bottom, 0);
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #374151;
            border-radius: 2px;
        }
    </style>
</div>