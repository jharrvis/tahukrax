<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="{ 
        showFacilitiesModal: false, 
        selectedAddon: null,
        noPackage: {{ $package ? 'false' : 'true' }},
        loading: {{ $package ? 'false' : 'true' }},

        initCheckout() {
            @if(!$package)
                // Try to get from global RCGOCart or directly from localStorage
                let stored = localStorage.getItem('rcgo_cart_v4');
                let cart = null;

                if (window.RCGOCart) {
                    cart = window.RCGOCart.get();
                } else if (stored) {
                    try {
                        let parsed = JSON.parse(stored);
                        // Normalize structure if needed
                        cart = {
                            package: (parsed.mainPackages && parsed.mainPackages.length > 0) ? parsed.mainPackages[0] : null,
                            addons: parsed.addons ? parsed.addons.reduce((acc, curr) => { acc[curr.id] = curr.qty; return acc; }, {}) : {}
                        };
                    } catch(e) { console.error('Checkout init parse error', e); }
                }

                if (cart && cart.package && (cart.package.slug || cart.package.id)) {
                    // Use slug if available, otherwise we might need to fetch by ID (but controller expects slug)
                    // The cart logic saves 'slug' for packages.
                    let slug = cart.package.slug; 

                    if (slug) {
                        $wire.loadPackageBySlug(slug).then(() => {
                            this.loading = false;
                            this.noPackage = false;

                            // Load Package Qty
                            let qty = cart.package.qty || 1;
                            if (qty > 1) {
                                $wire.setQuantity(qty);
                            }

                            // Load addons
                            if (cart.addons && Object.keys(cart.addons).length > 0) {
                                // Ensure addons formatted as ID => Qty
                                $wire.loadAddonsFromCart(cart.addons);
                            }
                        });
                    } else {
                         this.loading = false;
                         this.noPackage = true;
                    }
                } else {
                    this.loading = false;
                    this.noPackage = true;
                }
            @else
                // Save package to cart (sync from backend to frontend cart if needed, or just let it exist)
                // For consistenty we might want to update the cart if it's empty, but usually we just load addons
                let cart = window.RCGOCart ? window.RCGOCart.get() : null;
                let existingAddons = (cart && cart.addons) ? cart.addons : {};

                // If we want to ensure the current package overwrites the cart, we can do:
                if (window.RCGOCart) {
                     window.RCGOCart.set(
                        { id: {{ $package->id }}, slug: '{{ $package->slug }}', name: '{{ $package->name }}', price: {{ $package->price }} },
                        existingAddons
                    );
                }

                if (Object.keys(existingAddons).length > 0) {
                    $wire.loadAddonsFromCart(existingAddons);
                }
                this.loading = false;
                this.noPackage = false;
            @endif
        }
    }" x-init="initCheckout()" @addons-changed.window="
        if (window.RCGOCart) {
            let cart = window.RCGOCart.get();
            if (cart && cart.package) {
                window.RCGOCart.set(cart.package, $event.detail.addons);
            }
        }
    ">

    <!-- Loading Overlay for Submit -->
    <div wire:loading wire:target="submit"
        class="fixed inset-0 bg-black/60 z-[100] flex items-center justify-center backdrop-blur-sm">
        <div class="text-center">
            <div
                class="w-16 h-16 border-4 border-orange-500 border-t-transparent rounded-full animate-spin mx-auto mb-4">
            </div>
            <p class="text-white font-bold text-lg">Sedang Memproses Pesanan...</p>
            <p class="text-gray-400 text-sm">Mohon tunggu sebentar, kami sedang menyiapkan invoice Anda.</p>
        </div>
    </div>

    @if($package)
        <div x-show="!noPackage && !loading" x-cloak>
            <!-- Page Header -->
            <div class="mb-10">
                <a href="{{ route('home') }}"
                    class="group inline-flex items-center text-gray-400 hover:text-orange-500 transition-colors mb-6">
                    <i class="fas fa-chevron-left mr-2 transform group-hover:-translate-x-1 transition-transform"></i>
                    Kembali Belanja
                </a>
                <h1 class="text-4xl font-black text-white tracking-tight uppercase">Konfirmasi <span
                        class="text-orange-500">Kemitraan</span></h1>
                <p class="text-gray-400 mt-2">Lengkapi data pengiriman dan pembayaran untuk memulai bisnis Anda hari ini.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-10 items-start">
                <!-- Left: Checkout Forms -->
                <div class="md:col-span-8 space-y-8">

                    <!-- 1. Customer Information (Registration) -->
                    @guest
                        <section class="bg-gray-900/50 border border-gray-800 rounded-3xl overflow-hidden shadow-sm">
                            <div class="bg-gray-800/50 px-8 py-6 flex items-center justify-between border-b border-gray-700">
                                <div class="flex items-center gap-4">
                                    <span
                                        class="w-10 h-10 rounded-full bg-orange-500 text-black flex items-center justify-center font-black">1</span>
                                    <h3 class="text-xl font-bold text-white uppercase">Informasi Akun</h3>
                                </div>
                                <a href="{{ route('login') }}" class="text-sm text-orange-500 hover:underline">Sudah punya akun?
                                    Login</a>
                            </div>
                            <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-xs font-bold text-gray-500 uppercase">Nama Lengkap</label>
                                    <div class="relative">
                                        <i class="fas fa-user absolute left-4 top-1/2 -translate-y-1/2 text-gray-600"></i>
                                        <input type="text" wire:model="name"
                                            class="w-full pl-11 pr-4 py-3.5 bg-black border border-gray-700 rounded-xl text-white focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all"
                                            placeholder="Masukkan nama sesuai KTP">
                                    </div>
                                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div class="space-y-2">
                                    <label class="text-xs font-bold text-gray-500 uppercase">Email Aktif</label>
                                    <div class="relative">
                                        <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-600"></i>
                                        <input type="email" wire:model="email"
                                            class="w-full pl-11 pr-4 py-3.5 bg-black border border-gray-700 rounded-xl text-white focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all"
                                            placeholder="email@contoh.com">
                                    </div>
                                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div class="space-y-2">
                                    <label class="text-xs font-bold text-gray-500 uppercase">Password Akun</label>
                                    <div class="relative">
                                        <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-600"></i>
                                        <input type="password" wire:model="password"
                                            class="w-full pl-11 pr-4 py-3.5 bg-black border border-gray-700 rounded-xl text-white focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all"
                                            placeholder="Min. 8 karakter">
                                    </div>
                                    @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div class="space-y-2">
                                    <label class="text-xs font-bold text-gray-500 uppercase">Nomor WhatsApp</label>
                                    <div class="relative">
                                        <i class="fab fa-whatsapp absolute left-4 top-1/2 -translate-y-1/2 text-gray-600"></i>
                                        <input type="tel" wire:model="phone_number"
                                            class="w-full pl-11 pr-4 py-3.5 bg-black border border-gray-700 rounded-xl text-white focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all"
                                            placeholder="08xxxxxxxx">
                                    </div>
                                    @error('phone_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </section>
                    @endguest

                    <!-- 2. Shipping Address -->
                    <section class="bg-gray-900/50 border border-gray-800 rounded-3xl overflow-hidden shadow-sm">
                        <div class="bg-gray-800/50 px-8 py-6 border-b border-gray-700">
                            <div class="flex items-center gap-4">
                                <span
                                    class="w-10 h-10 rounded-full bg-orange-500 text-black flex items-center justify-center font-black">@auth
                                    1 @else 2 @endauth</span>
                                <h3 class="text-xl font-bold text-white uppercase">Alamat Pengiriman</h3>
                            </div>
                        </div>
                        <div class="p-8 space-y-8">
                            @auth
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <label class="text-xs font-bold text-gray-500 uppercase">Username / Nama</label>
                                        <input type="text" disabled value="{{ auth()->user()->name }}"
                                            class="w-full px-4 py-3.5 bg-gray-800 border border-gray-700 rounded-xl text-gray-400">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-xs font-bold text-gray-500 uppercase">Nomor WhatsApp</label>
                                        <div class="relative">
                                            <i
                                                class="fab fa-whatsapp absolute left-4 top-1/2 -translate-y-1/2 text-gray-600"></i>
                                            <input type="tel" wire:model="phone_number"
                                                class="w-full pl-11 pr-4 py-3.5 bg-black border border-gray-700 rounded-xl text-white focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all"
                                                placeholder="08xxxxxxxx">
                                        </div>
                                        @error('phone_number') <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endauth

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-xs font-bold text-gray-500 uppercase">Provinsi</label>
                                    <div class="relative">
                                        <select wire:model.live="province_id"
                                            class="w-full px-4 py-3.5 bg-black border border-gray-700 rounded-xl text-white focus:border-orange-500 focus:ring-1 focus:ring-orange-500 appearance-none transition-all">
                                            <option value="">Pilih Provinsi...</option>
                                            @foreach($provinces as $prov)
                                                <option value="{{ $prov->code }}">{{ $prov->name }}</option>
                                            @endforeach
                                        </select>
                                        <i
                                            class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-600 pointer-events-none"></i>
                                    </div>
                                    @error('province_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div class="space-y-2">
                                    <label class="text-xs font-bold text-gray-500 uppercase">Kota / Kabupaten</label>
                                    <div class="relative">
                                        <select wire:model.live="city_id" @disabled(empty($cities))
                                            class="w-full px-4 py-3.5 bg-black border border-gray-700 rounded-xl text-white focus:border-orange-500 focus:ring-1 focus:ring-orange-500 appearance-none disabled:opacity-50 transition-all">
                                            <option value="">
                                                {{ empty($cities) ? 'Pilih provinsi dulu' : 'Pilih Kota/Kabupaten...' }}
                                            </option>
                                            @foreach($cities as $city)
                                                <option value="{{ $city->code }}">{{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                        <i wire:loading.remove wire:target="province_id"
                                            class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-600 pointer-events-none"></i>
                                        <i wire:loading wire:target="province_id"
                                            class="fas fa-spinner fa-spin absolute right-4 top-1/2 -translate-y-1/2 text-orange-500 pointer-events-none"></i>
                                    </div>
                                    @error('city_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div class="space-y-2">
                                    <label class="text-xs font-bold text-gray-500 uppercase">Kode Pos</label>
                                    <input type="text" wire:model="postal_code"
                                        class="w-full px-4 py-3.5 bg-black border border-gray-700 rounded-xl text-white focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all"
                                        placeholder="12345">
                                    @error('postal_code') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-500 uppercase">Alamat Lengkap</label>
                                <textarea wire:model="address" rows="3"
                                    class="w-full px-4 py-3.5 bg-black border border-gray-700 rounded-xl text-white focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all resize-none"
                                    placeholder="Jl. Contoh No. 123, RT/RW, Kelurahan, Kecamatan"></textarea>
                                @error('address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </section>

                    <!-- 3. Add-on Extras (Upsell) -->
                    <section class="bg-gray-900/50 border border-gray-800 rounded-3xl overflow-hidden shadow-sm">
                        <div class="bg-gray-800/50 px-8 py-6 border-b border-gray-700">
                            <div class="flex items-center gap-4">
                                <span
                                    class="w-10 h-10 rounded-full bg-orange-500 text-black flex items-center justify-center font-black">@auth
                                    2 @else 3 @endauth</span>
                                <h3 class="text-xl font-bold text-white uppercase line-clamp-1">Tambahkan Perlengkapan</h3>
                            </div>
                        </div>
                        <div class="p-4 md:p-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($allAddons as $addon)
                                    @php $isSelected = isset($selectedAddons[$addon->id]); @endphp
                                    <div
                                        class="bg-black/60 rounded-2xl border {{ $isSelected ? 'border-orange-500 bg-orange-500/5' : 'border-gray-800' }} p-4 transition-all hover:border-gray-600 flex items-center gap-4">
                                        <div
                                            class="w-16 h-16 bg-gray-900 rounded-xl flex items-center justify-center border border-gray-800 flex-shrink-0">
                                            <img src="{{ asset('assets/img/addon-' . \Illuminate\Support\Str::slug($addon->name) . '.webp') }}"
                                                onerror="this.src='{{ asset('assets/img/rcgo.webp') }}'"
                                                class="w-12 h-12 object-contain" alt="{{ $addon->name }}">
                                        </div>
                                        <div class="flex-grow min-w-0">
                                            <h4 class="text-white font-bold text-sm truncate uppercase">{{ $addon->name }}</h4>
                                            <p class="text-orange-500 font-bold text-sm">Rp
                                                {{ number_format($addon->price, 0, ',', '.') }}
                                            </p>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            @if($isSelected)
                                                <div class="flex items-center bg-gray-800 rounded-lg p-1 border border-gray-700">
                                                    <button wire:click="decrementAddon({{ $addon->id }})"
                                                        class="w-7 h-7 flex items-center justify-center text-gray-400 hover:text-white transition-colors">-</button>
                                                    <span class="text-white font-bold px-2">{{ $selectedAddons[$addon->id] }}</span>
                                                    <button wire:click="incrementAddon({{ $addon->id }})"
                                                        class="w-7 h-7 flex items-center justify-center text-gray-400 hover:text-white transition-colors">+</button>
                                                </div>
                                            @else
                                                <button wire:click="toggleAddon({{ $addon->id }})"
                                                    class="w-10 h-10 rounded-full bg-gray-800 text-white flex items-center justify-center hover:bg-orange-500 hover:text-black transition-all shadow-lg active:scale-95">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </section>
                </div>

                <!-- Right: Order Summary Sidebar -->
                <div class="md:col-span-4">
                    <div class="sticky top-24 space-y-6">

                        <!-- Summary Card -->
                        <div class="bg-gray-900 rounded-3xl border-2 border-orange-500/20 overflow-hidden shadow-2xl">
                            <div class="p-8">
                                <h3
                                    class="text-xl font-black text-white uppercase tracking-wider mb-6 pb-4 border-b border-gray-800">
                                    Ringkasan Pesanan</h3>

                                <!-- Detailed Breakdown -->
                                <div class="space-y-4 mb-8">
                                    <!-- Package -->
                                    <div class="flex justify-between gap-4">
                                        <div class="text-gray-400 flex items-center gap-2 min-w-0">
                                            <i class="fas fa-box text-orange-500 text-xs"></i>
                                            <span class="truncate">
                                                Paket Usaha: {{ $package->name }}
                                                @if($packageQty > 1) <span
                                                    class="text-orange-500 font-bold ml-1">({{ $packageQty }}x)</span>
                                                @endif
                                            </span>
                                        </div>
                                        <span class="text-white font-bold whitespace-nowrap text-sm">Rp
                                            {{ number_format($package->price * $packageQty, 0, ',', '.') }}</span>
                                    </div>

                                    <!-- Addons -->
                                    @foreach($selectedAddons as $id => $qty)
                                        @php $addon = $allAddons->firstWhere('id', $id); @endphp
                                        @if($addon)
                                            <div class="flex justify-between gap-4">
                                                <div class="text-gray-400 text-sm flex items-center gap-2 min-w-0">
                                                    <i class="fas fa-plus text-gray-600 text-[10px]"></i>
                                                    <span class="truncate">{{ $qty }}x {{ $addon->name }}</span>
                                                </div>
                                                <span class="text-white font-bold whitespace-nowrap text-sm">Rp
                                                    {{ number_format($addon->price * $qty, 0, ',', '.') }}</span>
                                            </div>
                                        @endif
                                    @endforeach

                                    <!-- Shipping -->
                                    <div class="flex justify-between pt-4 border-t border-gray-800">
                                        <div class="text-gray-400 text-sm flex items-center gap-2">
                                            <i class="fas fa-truck text-gray-600 text-[10px]"></i>
                                            <span>Ongkos Kirim</span>
                                        </div>
                                        @if($this->total['shipping'] > 0)
                                            <span class="text-white font-bold text-sm">Rp
                                                {{ number_format($this->total['shipping'], 0, ',', '.') }}</span>
                                        @else
                                            <span class="text-gray-600 italic text-xs">Pilih Kota Dahulu</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Final Total -->
                                <div class="bg-black/40 rounded-2xl p-6 border border-gray-800 mb-8">
                                    <p class="text-gray-500 text-[10px] font-bold uppercase tracking-widest mb-1">Total
                                        Pembayaran</p>
                                    <div class="text-3xl font-black text-orange-500 tracking-tighter"
                                        wire:loading.class="opacity-50"
                                        wire:target="city_id, toggleAddon, incrementAddon, decrementAddon">
                                        Rp {{ number_format($this->total['grand_total'], 0, ',', '.') }}
                                    </div>
                                    <div wire:loading wire:target="city_id, toggleAddon, incrementAddon, decrementAddon"
                                        class="text-[10px] text-orange-400">Menghitung ulang...</div>
                                </div>

                                <!-- Buttons -->
                                <div class="space-y-4">
                                    <button wire:click="submit"
                                        class="w-full btn-cta-primary bg-orange-500 hover:bg-orange-600 text-black py-4 rounded-2xl font-black text-lg transition-all shadow-xl hover:shadow-orange-500/20 active:scale-[0.98] uppercase">
                                        Konfirmasi & Bayar
                                    </button>
                                    <div class="flex items-center justify-center gap-2 text-gray-500 text-xs">
                                        <i class="fas fa-shield-alt text-green-500"></i>
                                        Pembayaran Aman via Xendit Secure
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Trust Cards -->
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gray-900/40 border border-gray-800 p-4 rounded-2xl text-center">
                                <i class="fas fa-headset text-orange-500 mb-2"></i>
                                <h4 class="text-[10px] font-bold text-white uppercase tracking-wider">Support 24/7</h4>
                            </div>
                            <div class="bg-gray-900/40 border border-gray-800 p-4 rounded-2xl text-center">
                                <i class="fas fa-undo text-orange-500 mb-2"></i>
                                <h4 class="text-[10px] font-bold text-white uppercase tracking-wider">Money Back</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Error/Fallback Empty -->
    <div x-show="noPackage && !loading" x-cloak class="text-center py-32">
        <div
            class="w-24 h-24 bg-gray-900 rounded-full flex items-center justify-center mx-auto mb-8 border border-gray-800">
            <i class="fas fa-shopping-basket text-gray-700 text-4xl"></i>
        </div>
        <h2 class="text-3xl font-black text-white uppercase mb-4 tracking-tight">Keranjang Anda Kosong</h2>
        <p class="text-gray-400 mb-10 max-w-md mx-auto">Silakan pilih paket usaha impian Anda terlebih dahulu untuk
            melanjutkan kemitraan.</p>
        <a href="{{ route('home') }}#paket"
            class="btn-primary inline-flex items-center gap-3 px-10 py-4 rounded-full text-white font-bold bg-orange-500 hover:bg-orange-600 transition-all shadow-lg shadow-orange-500/20">
            <i class="fas fa-search"></i> Temukan Paket Usaha
        </a>
    </div>

</div>