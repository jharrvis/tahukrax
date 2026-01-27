<div class="max-w-7xl mx-auto px-4" x-data="{ 
        showFacilitiesModal: false, 
        showAddonModal: false, 
        selectedAddon: null,
        noPackage: {{ $package ? 'false' : 'true' }},
        loading: {{ $package ? 'false' : 'true' }},
        initCheckout() {
            @if(!$package)
                let cart = window.RCGOCart ? window.RCGOCart.get() : null;
                if (cart && cart.package && cart.package.slug) {
                    // Load package
                    $wire.loadPackageBySlug(cart.package.slug).then(() => {
                        this.loading = false;
                        this.noPackage = false;
                        // Load addons if any
                        if (cart.addons && Object.keys(cart.addons).length > 0) {
                            $wire.loadAddonsFromCart(cart.addons);
                        }
                    });
                } else {
                    this.loading = false;
                    this.noPackage = true;
                }
            @else
                // Save package to cart
                let cart = window.RCGOCart ? window.RCGOCart.get() : null;
                let existingAddons = (cart && cart.addons) ? cart.addons : {};
                if (window.RCGOCart) {
                    window.RCGOCart.set(
                        { slug: '{{ $package->slug }}', name: '{{ $package->name }}', price: {{ $package->price }} },
                        existingAddons
                    );
                }
                // Load existing addons
                if (Object.keys(existingAddons).length > 0) {
                    $wire.loadAddonsFromCart(existingAddons);
                }
            @endif
        }
    }" 
    x-init="initCheckout()"
    @addons-changed.window="
        if (window.RCGOCart) {
            let cart = window.RCGOCart.get();
            if (cart && cart.package) {
                window.RCGOCart.set(cart.package, $event.detail.addons);
            }
        }
    ">

    <!-- Loading State -->
    <div x-show="loading" x-cloak class="text-center py-20">
        <div class="w-16 h-16 border-4 border-orange-500 border-t-transparent rounded-full animate-spin mx-auto mb-4">
        </div>
        <p class="text-gray-400">Memuat keranjang belanja...</p>
    </div>

    <!-- Empty Cart State -->
    <div x-show="noPackage && !loading" x-cloak class="text-center py-20">
        <div class="w-24 h-24 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-shopping-cart text-gray-600 text-4xl"></i>
        </div>
        <h2 class="text-2xl font-bold text-white mb-4">Keranjang Belanja Kosong</h2>
        <p class="text-gray-400 mb-8 max-w-md mx-auto">
            Anda belum memilih paket usaha. Silakan pilih paket yang sesuai dengan kebutuhan Anda.
        </p>
        <a href="{{ route('home') }}#paket"
            class="btn-primary px-8 py-3 rounded-full text-white font-bold inline-flex items-center gap-2">
            <i class="fas fa-box"></i> Lihat Paket Usaha
        </a>
    </div>

    <!-- Main Content (only show when package is loaded) -->
    @if($package)
        <div x-show="!noPackage && !loading">
            <!-- Breadcrumb -->
            <div class="mb-8">
                <a href="{{ route('home') }}" class="text-gray-400 hover:text-orange-500 transition text-sm">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Beranda
                </a>
            </div>

            <!-- Page Title -->
            <div class="text-center mb-12">
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-4">
                    Checkout <span class="text-orange-500">Paket Usaha</span>
                </h1>
                <p class="text-gray-300 text-lg max-w-2xl mx-auto">
                    Lengkapi data Anda untuk memulai kemitraan dengan RC GO.
                </p>
            </div>

            <!-- Checkout Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Left Column: Package, Add-ons, Form -->
                <div class="lg:col-span-2 space-y-8">

                    <!-- 1. Package Detail Card -->
                    <div class="bg-gray-900 rounded-3xl border border-gray-800 p-8 checker-bg">
                        <div class="flex flex-col md:flex-row gap-8 items-center">
                            <div
                                class="w-full md:w-48 h-48 bg-black rounded-2xl border border-gray-800 p-4 flex items-center justify-center">
                                @if($package->image_url)
                                    <img src="{{ asset('storage/' . $package->image_url) }}"
                                        class="w-full h-full object-contain" alt="{{ $package->name }}">
                                @else
                                    <img src="{{ asset('assets/img/rcgo-logo.svg') }}" class="w-24 opacity-20" alt="Logo">
                                @endif
                            </div>
                            <div class="flex-grow text-center md:text-left">
                                <span
                                    class="inline-block px-3 py-1 bg-orange-500 text-black text-[10px] font-black uppercase rounded-full mb-2">Paket
                                    Pilihan Anda</span>
                                <h2 class="text-3xl md:text-4xl font-black text-white uppercase">{{ $package->name }}</h2>
                                <p class="text-gray-400 mt-2 text-sm md:text-base">
                                    {{ $package->description ?? 'Paket usaha lengkap untuk memulai bisnis rental RC Anda.' }}
                                </p>
                                <div class="mt-4 text-2xl font-black text-orange-500">
                                    Rp {{ number_format($package->price, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>

                        <!-- Package Action Buttons -->
                        <div class="flex flex-wrap gap-3 mt-6 pt-6 border-t border-gray-800">
                            <button @click="showFacilitiesModal = true"
                                class="flex-1 md:flex-none border border-orange-500 text-orange-500 px-6 py-2.5 rounded-full font-semibold text-sm hover:bg-orange-500/10 transition-all">
                                <i class="fas fa-list-ul mr-2"></i> Lihat Fasilitas
                            </button>
                            <a href="{{ route('home') }}#paket"
                                class="flex-1 md:flex-none border border-gray-600 text-gray-400 px-6 py-2.5 rounded-full font-semibold text-sm hover:border-gray-500 hover:text-gray-300 transition-all text-center">
                                <i class="fas fa-exchange-alt mr-2"></i> Ganti Paket
                            </a>
                        </div>
                    </div>

                    <!-- 2. Add-ons Selection -->
                    <div class="bg-gray-900/80 backdrop-blur-md rounded-3xl border border-gray-800 p-8">
                        <div class="flex items-center justify-between mb-8">
                            <div>
                                <h3 class="text-2xl font-black text-white uppercase flex items-center gap-3">
                                    <i class="fas fa-plus-circle text-orange-500"></i> Tambah Perlengkapan (ADD-ON)
                                </h3>
                                <p class="text-gray-400 text-sm mt-1">Perkuat armada Anda dengan unit tambahan atau spare
                                    part.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($allAddons as $addon)
                                @php $isSelected = isset($selectedAddons[$addon->id]); @endphp
                                <div
                                    class="group relative bg-black/40 rounded-2xl border {{ $isSelected ? 'border-orange-500' : 'border-gray-800' }} p-4 transition-all hover:border-orange-500/50">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-16 h-16 bg-gray-900 rounded-lg flex items-center justify-center border border-gray-800">
                                            @if($addon->image_url)
                                                <img src="{{ asset('storage/' . $addon->image_url) }}"
                                                    class="w-12 h-12 object-contain" alt="{{ $addon->name }}">
                                            @else
                                                <i class="fas fa-tools text-gray-700"></i>
                                            @endif
                                        </div>
                                        <div class="flex-grow">
                                            <div class="flex items-center gap-2">
                                                <h4 class="text-white font-bold text-sm leading-tight">{{ $addon->name }}</h4>
                                                @if($addon->description)
                                                    <button
                                                        @click="selectedAddon = {{ json_encode(['name' => $addon->name, 'description' => $addon->description, 'price' => $addon->price]) }}; showAddonModal = true"
                                                        class="text-gray-500 hover:text-orange-500 transition" title="Lihat Detail">
                                                        <i class="fas fa-info-circle text-xs"></i>
                                                    </button>
                                                @endif
                                            </div>
                                            <p class="text-orange-500 font-bold text-xs mt-1">Rp
                                                {{ number_format($addon->price, 0, ',', '.') }}
                                            </p>
                                        </div>

                                        @if($isSelected)
                                            <div
                                                class="flex items-center gap-2 bg-gray-900 rounded-full p-1 border border-gray-800">
                                                <button type="button" wire:click="decrementAddon({{ $addon->id }})"
                                                    class="w-6 h-6 flex items-center justify-center text-white hover:text-orange-500"><i
                                                        class="fas fa-minus text-xs"></i></button>
                                                <span
                                                    class="text-white font-black text-xs min-w-4 text-center">{{ $selectedAddons[$addon->id] }}</span>
                                                <button type="button" wire:click="incrementAddon({{ $addon->id }})"
                                                    class="w-6 h-6 flex items-center justify-center text-white hover:text-orange-500"><i
                                                        class="fas fa-plus text-xs"></i></button>
                                            </div>
                                        @else
                                            <button type="button" wire:click="toggleAddon({{ $addon->id }})"
                                                class="w-10 h-10 bg-orange-500 text-black rounded-full flex items-center justify-center hover:scale-110 transition active:scale-95 shadow-lg shadow-orange-500/20">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- 3. Registration Form (Guest Only) -->
                    @guest
                        <div class="bg-gray-900/80 backdrop-blur-md rounded-3xl border border-gray-800 overflow-hidden">
                            <div class="bg-gradient-to-r from-orange-500/20 to-transparent px-8 py-6 border-b border-gray-800">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-orange-500 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user-plus text-black text-lg"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-black text-white uppercase">Daftar Sebagai Mitra</h3>
                                        <p class="text-gray-400 text-sm">Buat akun untuk mengakses dashboard dan tracking
                                            pesanan.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="p-8">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Name -->
                                    <div>
                                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">
                                            <i class="fas fa-user mr-2 text-orange-500"></i> Nama Lengkap
                                        </label>
                                        <input type="text" wire:model="name" placeholder="Nama sesuai KTP"
                                            class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-xl text-white placeholder-gray-600 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition">
                                        @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Email -->
                                    <div>
                                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">
                                            <i class="fas fa-envelope mr-2 text-orange-500"></i> Email Aktif
                                        </label>
                                        <input type="email" wire:model="email" placeholder="email@contoh.com"
                                            class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-xl text-white placeholder-gray-600 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition">
                                        @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Phone -->
                                    <div>
                                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">
                                            <i class="fab fa-whatsapp mr-2 text-orange-500"></i> Nomor WhatsApp
                                        </label>
                                        <input type="tel" wire:model="phone_number" placeholder="08xxxxxxxxxx"
                                            class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-xl text-white placeholder-gray-600 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition">
                                        <p class="text-gray-500 text-xs mt-1">Untuk notifikasi pesanan & dukungan.</p>
                                        @error('phone_number') <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Password -->
                                    <div>
                                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">
                                            <i class="fas fa-lock mr-2 text-orange-500"></i> Password Dashboard
                                        </label>
                                        <input type="password" wire:model="password" placeholder="Min. 8 karakter"
                                            class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-xl text-white placeholder-gray-600 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition">
                                        <p class="text-gray-500 text-xs mt-1">Untuk login ke dashboard mitra.</p>
                                        @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endguest

                    <!-- 4. Shipping Address -->
                    <div class="bg-gray-900/80 backdrop-blur-md rounded-3xl border border-gray-800 overflow-hidden">
                        <div class="bg-gradient-to-r from-orange-500/20 to-transparent px-8 py-6 border-b border-gray-800">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-orange-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-truck text-black text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-black text-white uppercase">Alamat Pengiriman</h3>
                                    <p class="text-gray-400 text-sm">Paket akan dikirim ke alamat ini.</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Province -->
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">
                                        <i class="fas fa-map mr-2 text-orange-500"></i> Provinsi
                                    </label>
                                    <select wire:model.live="province_id"
                                        class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-xl text-white focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition">
                                        <option value="">Pilih Provinsi...</option>
                                        @foreach($provinces as $prov)
                                            <option value="{{ $prov->code }}">{{ $prov->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('province_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- City -->
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">
                                        <i class="fas fa-building mr-2 text-orange-500"></i> Kota / Kabupaten
                                    </label>
                                    <select wire:model.live="city_id"
                                        class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-xl text-white focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition"
                                        {{ empty($cities) ? 'disabled' : '' }}>
                                        <option value="">
                                            {{ empty($cities) ? 'Pilih provinsi dulu...' : 'Pilih Kota/Kabupaten...' }}
                                        </option>
                                        @foreach($cities as $city)
                                            <option value="{{ $city->code }}">{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('city_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Postal Code -->
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">
                                        <i class="fas fa-mail-bulk mr-2 text-orange-500"></i> Kode Pos
                                    </label>
                                    <input type="text" wire:model="postal_code" placeholder="Contoh: 12345"
                                        class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-xl text-white placeholder-gray-600 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition">
                                    @error('postal_code') <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Phone (if logged in) -->
                                @auth
                                    <div>
                                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">
                                            <i class="fab fa-whatsapp mr-2 text-orange-500"></i> Nomor WhatsApp
                                        </label>
                                        <input type="tel" wire:model="phone_number" placeholder="08xxxxxxxxxx"
                                            class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-xl text-white placeholder-gray-600 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition">
                                        @error('phone_number') <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endauth

                                <!-- Address -->
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">
                                        <i class="fas fa-home mr-2 text-orange-500"></i> Alamat Lengkap
                                    </label>
                                    <textarea wire:model="address" rows="3"
                                        placeholder="Jl. Contoh No. 123, RT/RW, Kelurahan, Kecamatan"
                                        class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-xl text-white placeholder-gray-600 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition resize-none"></textarea>
                                    <p class="text-gray-500 text-xs mt-1">Sertakan patokan lokasi jika memungkinkan.</p>
                                    @error('address') <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Mobile Order Button -->
                            <div class="lg:hidden mt-8">
                                <button wire:click="submit"
                                    class="w-full btn-cta-primary text-black py-4 px-8 rounded-full font-black text-xl shadow-xl hover:shadow-orange-500/40">
                                    <i class="fas fa-play mr-2"></i> ORDER SEKARANG
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Summary Sticky -->
                <div class="lg:col-span-1">
                    <div class="sticky top-24 space-y-6">
                        <div class="bg-gray-900 rounded-3xl border-2 border-orange-500/30 overflow-hidden shadow-2xl">
                            <div class="bg-black px-6 py-4 border-b border-gray-800 flex items-center gap-3">
                                <i class="fas fa-shopping-cart text-orange-500"></i>
                                <h3 class="text-lg font-black text-white uppercase">Ringkasan Pesanan</h3>
                            </div>

                            <div class="p-6 space-y-6">
                                <!-- Items List -->
                                <div class="space-y-4">
                                    <div class="flex justify-between items-start">
                                        <div class="text-sm text-gray-400 italic">1x Paket {{ $package->name }}</div>
                                        <div class="text-white font-bold">Rp
                                            {{ number_format($package->price, 0, ',', '.') }}
                                        </div>
                                    </div>

                                    @foreach($selectedAddons as $id => $qty)
                                        @php $addon = $allAddons->firstWhere('id', $id); @endphp
                                        @if($addon)
                                            <div class="flex justify-between items-start">
                                                <div class="text-sm text-gray-400 italic">{{ $qty }}x {{ $addon->name }}</div>
                                                <div class="text-white font-bold">Rp
                                                    {{ number_format($addon->price * $qty, 0, ',', '.') }}
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach

                                    @if($this->total['shipping'] > 0)
                                        <div class="flex justify-between items-start">
                                            <div class="text-sm text-gray-400 italic">Ongkos Kirim</div>
                                            <div class="text-white font-bold">Rp
                                                {{ number_format($this->total['shipping'], 0, ',', '.') }}
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- Total -->
                                <div class="pt-6 border-t-2 border-dashed border-gray-800">
                                    <div class="flex justify-between items-end mb-1">
                                        <span class="text-gray-400 text-sm font-bold uppercase">Total Pembayaran</span>
                                        <span class="text-xs text-green-400 font-bold uppercase">Aman (SSL)</span>
                                    </div>
                                    <div class="text-4xl font-black text-orange-500 tracking-tighter">
                                        Rp {{ number_format($this->total['grand_total'], 0, ',', '.') }}
                                    </div>
                                    <p class="text-[10px] text-gray-500 italic mt-2">* Bayar via Xendit Secure Payment</p>
                                </div>

                                <!-- Submit Button Desktop -->
                                <button wire:click="submit"
                                    class="w-full btn-cta-primary text-black py-4 px-8 rounded-full font-black text-xl shadow-xl hover:shadow-orange-500/40 relative overflow-hidden group">
                                    <span class="relative z-10">KONFIRMASI & BAYAR</span>
                                    <div
                                        class="absolute inset-0 bg-white/20 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-500">
                                    </div>
                                </button>
                            </div>
                        </div>

                        <!-- Trust Badges -->
                        <div
                            class="bg-gray-900/50 p-6 rounded-2xl border border-gray-800 flex flex-wrap justify-center gap-4 opacity-70">
                            <i class="fab fa-cc-visa text-2xl"></i>
                            <i class="fab fa-cc-mastercard text-2xl"></i>
                            <div class="flex items-center gap-1 text-[10px] uppercase font-bold text-gray-400">
                                <i class="fas fa-shield-alt text-orange-500"></i> Xendit Protected
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Package Facilities Modal -->
            <div x-show="showFacilitiesModal" x-cloak
                class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                @click.self="showFacilitiesModal = false">
                <div class="bg-gray-900 rounded-3xl border border-gray-700 max-w-lg w-full max-h-[80vh] overflow-y-auto"
                    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100">
                    <div
                        class="sticky top-0 bg-gray-900 px-6 py-4 border-b border-gray-800 flex items-center justify-between">
                        <h3 class="text-xl font-black text-white uppercase">
                            <i class="fas fa-list-ul text-orange-500 mr-2"></i> Fasilitas Paket {{ $package->name }}
                        </h3>
                        <button @click="showFacilitiesModal = false" class="text-gray-500 hover:text-white transition">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-400 mb-6">
                            {{ $package->description ?? 'Paket usaha lengkap untuk memulai bisnis rental RC Anda.' }}
                        </p>

                        <h4 class="text-sm font-bold text-orange-500 uppercase mb-4">Yang Anda Dapatkan:</h4>
                        <ul class="space-y-3">
                            @php
                                $facilities = [
                                    'drift' => ['5 Unit RC Drift Premium', 'Charger & Baterai Ori', '30 Traffic Cones', 'Banner Eksklusif', 'Garansi 1 Bulan'],
                                    'offroad' => ['5 Unit RC Off-road 4WD', 'Charger & Baterai Ori', 'Power Supply Fast Charging', 'Banner Rental', 'Garansi 1 Bulan'],
                                    'stunt' => ['5 Unit RC Stunt 4WD', 'Charger & Baterai Ori', 'Baterai Cadangan Rakitan', 'Banner Rental', 'Garansi 1 Bulan'],
                                    'mixcar' => ['5 Unit RC (Drift, Offroad, Stunt)', 'Charger & Baterai Ori', 'Ban Serep & Baterai Cadangan', 'Banner & Alas Drift', 'Garansi 1 Bulan'],
                                    'excavator' => ['5 Unit RC Excavator Premium', 'Remote & Baterai Ori', 'Fast Charging Power Supply', 'Banner Eksklusif', 'Garansi 1 Bulan'],
                                    'alatberat' => ['5 Unit Mix (Excavator, Truck, Dozer)', 'Baterai Ori & Rakitan', 'Fast Charger (10 Baterai)', 'Banner Rental', 'Garansi 1 Bulan'],
                                ];
                                $currentFacilities = $facilities[$package->slug] ?? ['5 Unit RC', 'Charger & Baterai', 'Perlengkapan Rental', 'Banner', 'Garansi 1 Bulan'];
                            @endphp
                            @foreach($currentFacilities as $facility)
                                <li class="flex items-center gap-3 text-gray-300">
                                    <i class="fas fa-check text-orange-500"></i>
                                    {{ $facility }}
                                </li>
                            @endforeach
                        </ul>

                        <div class="mt-8 pt-6 border-t border-gray-800 flex gap-3">
                            <button @click="showFacilitiesModal = false"
                                class="flex-1 btn-cta-primary text-black py-3 px-6 rounded-full font-bold text-sm">
                                Lanjut Checkout
                            </button>
                            <a href="{{ route('home') }}#paket"
                                class="flex-1 border border-gray-600 text-gray-400 py-3 px-6 rounded-full font-bold text-sm text-center hover:border-orange-500 hover:text-orange-500 transition">
                                Ganti Paket
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Addon Detail Modal -->
            <div x-show="showAddonModal" x-cloak
                class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                @click.self="showAddonModal = false">
                <div class="bg-gray-900 rounded-3xl border border-gray-700 max-w-md w-full"
                    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100">
                    <div class="px-6 py-4 border-b border-gray-800 flex items-center justify-between">
                        <h3 class="text-lg font-black text-white uppercase" x-text="selectedAddon?.name"></h3>
                        <button @click="showAddonModal = false" class="text-gray-500 hover:text-white transition">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-400 text-sm leading-relaxed" x-text="selectedAddon?.description"></p>
                        <div class="mt-4 pt-4 border-t border-gray-800 flex items-center justify-between">
                            <span class="text-gray-500 text-sm">Harga Satuan:</span>
                            <span class="text-orange-500 font-black text-xl"
                                x-text="'Rp ' + (selectedAddon?.price || 0).toLocaleString('id-ID')"></span>
                        </div>
                    </div>
                </div>
            </div>

        </div> <!-- End Main Content wrapper x-show="!noPackage && !loading" -->
    @endif</div>
