<!-- Top Bar - Hidden on mobile -->
<div class="bg-gradient-to-r from-gray-900 to-black border-b border-gray-800 py-2 hidden md:block">
    <div class="max-w-7xl mx-auto px-4 flex justify-between items-center text-xs text-gray-400">
        <div class="flex gap-6 items-center">
            <a href="https://wa.me/6288221201998" target="_blank"
                class="flex items-center gap-2 hover:text-orange-500 transition-colors">
                <i class="fab fa-whatsapp text-green-500"></i>
                <span>0882 2120 1998</span>
            </a>
        </div>
        <div class="flex items-center gap-4">
            <span class="text-gray-500 text-xs uppercase tracking-wider mr-2">Follow Us</span>
            <a href="#"
                class="w-7 h-7 flex items-center justify-center rounded-full bg-gray-800 hover:bg-orange-500 text-gray-400 hover:text-white transition-all"
                title="Facebook">
                <i class="fab fa-facebook-f text-xs"></i>
            </a>
            <a href="#"
                class="w-7 h-7 flex items-center justify-center rounded-full bg-gray-800 hover:bg-gradient-to-tr hover:from-purple-600 hover:to-pink-500 text-gray-400 hover:text-white transition-all"
                title="Instagram">
                <i class="fab fa-instagram text-xs"></i>
            </a>
            <a href="#"
                class="w-7 h-7 flex items-center justify-center rounded-full bg-gray-800 hover:bg-black hover:ring-1 hover:ring-white text-gray-400 hover:text-white transition-all"
                title="TikTok">
                <i class="fab fa-tiktok text-xs"></i>
            </a>
        </div>
    </div>
</div>

<!-- Navigation -->
<nav class="bg-black/95 backdrop-blur-md sticky top-0 z-50 py-3 md:py-4 border-b border-gray-800"
    x-data="{ mobileMenu: false }">
    <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="flex-shrink-0">
            <img src="{{ asset('assets/img/rcgo-logo.svg') }}" alt="RC GO Logo" class="h-10 md:h-12 lg:h-14">
        </a>

        <!-- Desktop Navigation -->
        <div class="hidden lg:flex gap-6 xl:gap-8 items-center">
            <a href="{{ route('home') }}"
                class="text-white hover:text-orange-500 font-medium transition-colors text-sm">Beranda</a>
            <a href="{{ route('home') }}#tentang"
                class="text-white hover:text-orange-500 font-medium transition-colors text-sm">Tentang</a>
            <a href="{{ route('home') }}#keuntungan"
                class="text-white hover:text-orange-500 font-medium transition-colors text-sm">Keuntungan</a>
            <a href="{{ route('home') }}#paket"
                class="text-white hover:text-orange-500 font-medium transition-colors text-sm">Paket Usaha</a>
            <a href="{{ route('home') }}#kontak"
                class="text-white hover:text-orange-500 font-medium transition-colors text-sm">Kontak</a>
        </div>

        <!-- Right Section: Auth & CTA -->
        <div class="flex items-center gap-3 md:gap-4">
            @auth
                <!-- Logged In User Dropdown -->
                <div class="hidden md:flex items-center gap-3" x-data="{ open: false }">
                    <div class="relative">
                        <button @click="open = !open"
                            class="flex items-center gap-2 px-3 py-2 rounded-full bg-gray-800/50 hover:bg-gray-800 border border-gray-700 transition-all">
                            <div
                                class="w-7 h-7 rounded-full bg-gradient-to-br from-orange-500 to-orange-600 flex items-center justify-center text-white text-xs font-bold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span
                                class="text-white text-sm font-medium max-w-[100px] truncate">{{ auth()->user()->name }}</span>
                            <i class="fas fa-chevron-down text-gray-500 text-xs transition-transform"
                                :class="{ 'rotate-180': open }"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" @click.outside="open = false" x-cloak
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-56 bg-gray-900 rounded-2xl border border-gray-800 shadow-2xl overflow-hidden z-50">

                            <div class="px-4 py-3 border-b border-gray-800">
                                <p class="text-white font-semibold text-sm truncate">{{ auth()->user()->name }}</p>
                                <p class="text-gray-500 text-xs truncate">{{ auth()->user()->email }}</p>
                            </div>

                            <div class="py-2">
                                <a href="/admin"
                                    class="flex items-center gap-3 px-4 py-2.5 text-gray-300 hover:text-white hover:bg-gray-800 transition-all">
                                    <i class="fas fa-columns text-orange-500 w-5 text-center"></i>
                                    <span class="text-sm">Dashboard Mitra</span>
                                </a>
                                <a href="/admin/orders"
                                    class="flex items-center gap-3 px-4 py-2.5 text-gray-300 hover:text-white hover:bg-gray-800 transition-all">
                                    <i class="fas fa-shopping-bag text-orange-500 w-5 text-center"></i>
                                    <span class="text-sm">Pesanan Saya</span>
                                </a>
                            </div>

                            <div class="border-t border-gray-800 py-2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full flex items-center gap-3 px-4 py-2.5 text-gray-400 hover:text-red-500 hover:bg-gray-800 transition-all">
                                        <i class="fas fa-sign-out-alt w-5 text-center"></i>
                                        <span class="text-sm">Keluar</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Guest: Login Button -->
                <a href="{{ route('login') }}"
                    class="hidden md:flex items-center gap-2 text-gray-400 hover:text-orange-500 font-medium transition-colors text-sm px-4 py-2 rounded-full hover:bg-gray-800/50">
                    <i class="fas fa-user"></i>
                    <span>Masuk</span>
                </a>
            @endauth

            <!-- CTA Button - Dynamic based on cart -->
            <div x-data="ctaButton()" x-init="init()">
                <a :href="ctaLink"
                    class="btn-primary flex items-center gap-2 px-5 md:px-6 py-2.5 md:py-3 rounded-full text-white font-bold text-sm shadow-lg shadow-orange-500/20 hover:shadow-orange-500/30 transition-all whitespace-nowrap">
                    <i class="fas" :class="iconClass"></i>
                    <span class="hidden sm:inline" x-text="buttonText">Mulai Usaha</span>
                    <span class="sm:hidden" x-text="buttonTextShort">Daftar</span>
                    <span x-show="hasCart"
                        class="bg-white text-orange-500 text-xs font-black rounded-full w-5 h-5 flex items-center justify-center"
                        style="display: none;">1</span>
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <button @click="mobileMenu = !mobileMenu" class="lg:hidden text-white p-2">
                <i class="fas" :class="mobileMenu ? 'fa-times' : 'fa-bars'"></i>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenu" x-cloak x-transition class="lg:hidden bg-gray-900 border-t border-gray-800 mt-4">
        <div class="max-w-7xl mx-auto px-4 py-4 space-y-4">
            <a href="{{ route('home') }}" class="block text-white hover:text-orange-500 font-medium py-2">Beranda</a>
            <a href="{{ route('home') }}#tentang"
                class="block text-white hover:text-orange-500 font-medium py-2">Tentang</a>
            <a href="{{ route('home') }}#keuntungan"
                class="block text-white hover:text-orange-500 font-medium py-2">Keuntungan</a>
            <a href="{{ route('home') }}#paket" class="block text-white hover:text-orange-500 font-medium py-2">Paket
                Usaha</a>
            <a href="{{ route('home') }}#kontak"
                class="block text-white hover:text-orange-500 font-medium py-2">Kontak</a>

            <div class="pt-4 border-t border-gray-800">
                @auth
                    <a href="/admin" class="flex items-center gap-2 text-orange-500 font-medium py-2">
                        <i class="fas fa-columns"></i> Dashboard Mitra
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex items-center gap-2 text-gray-400 hover:text-red-500 font-medium py-2">
                            <i class="fas fa-sign-out-alt"></i> Keluar
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                        class="flex items-center gap-2 text-gray-400 hover:text-orange-500 font-medium py-2">
                        <i class="fas fa-user"></i> Masuk
                    </a>
                @endauth
            </div>

            <!-- Mobile Social Icons -->
            <div class="pt-4 border-t border-gray-800 flex gap-3">
                <a href="#"
                    class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-800 text-gray-400 hover:bg-orange-500 hover:text-white transition-all">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#"
                    class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-800 text-gray-400 hover:bg-gradient-to-tr hover:from-purple-600 hover:to-pink-500 hover:text-white transition-all">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#"
                    class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-800 text-gray-400 hover:bg-black hover:ring-1 hover:ring-white hover:text-white transition-all">
                    <i class="fab fa-tiktok"></i>
                </a>
                <a href="https://wa.me/6288221201998" target="_blank"
                    class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-800 text-gray-400 hover:bg-green-500 hover:text-white transition-all">
                    <i class="fab fa-whatsapp"></i>
                </a>
            </div>
        </div>
    </div>
</nav>

<script>
    // Cart helper functions for global use
    window.RCGOCart = {
        get() {
            var stored = localStorage.getItem('rcgo_cart');
            if (stored) {
                try {
                    var data = JSON.parse(stored);
                    var hoursDiff = (Date.now() - data.timestamp) / (1000 * 60 * 60);
                    if (hoursDiff < 24) {
                        return data;
                    }
                    localStorage.removeItem('rcgo_cart');
                } catch (e) {
                    localStorage.removeItem('rcgo_cart');
                }
            }
            return null;
        },
        set(packageData, addons = {}) {
            localStorage.setItem('rcgo_cart', JSON.stringify({
                package: packageData,
                addons: addons,
                timestamp: Date.now()
            }));
            window.dispatchEvent(new CustomEvent('cart-updated'));
        },
        clear() {
            localStorage.removeItem('rcgo_cart');
            window.dispatchEvent(new CustomEvent('cart-updated'));
        },
        hasItems() {
            return this.get() !== null;
        }
    };

    // CTA Button Alpine component
    function ctaButton() {
        return {
            hasCart: false,
            ctaLink: '{{ route('home') }}#paket',
            buttonText: 'Mulai Usaha',
            buttonTextShort: 'Daftar',
            iconClass: 'fa-rocket',
            init() {
                this.checkCart();
                window.addEventListener('cart-updated', () => this.checkCart());
            },
            checkCart() {
                var cart = window.RCGOCart ? window.RCGOCart.get() : null;
                if (cart && cart.package) {
                    this.hasCart = true;
                    this.ctaLink = '/checkout';
                    this.buttonText = 'Keranjang';
                    this.buttonTextShort = 'Cart';
                    this.iconClass = 'fa-shopping-cart';
                } else {
                    this.hasCart = false;
                    this.ctaLink = '{{ route('home') }}#paket';
                    this.buttonText = 'Mulai Usaha';
                    this.buttonTextShort = 'Daftar';
                    this.iconClass = 'fa-rocket';
                }
            }
        }
    }
</script>