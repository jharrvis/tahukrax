<!-- NAV_SECTION -->
<nav class="bg-white shadow-md sticky top-0 z-50">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-20">
            <!-- Logo -->
            <a href="#" class="flex items-center gap-3">
                <img src="{{ asset('img/logo.svg') }}"
                    onerror="this.src='https://placehold.co/150x50/png?text=TahuKrax'" alt="Tahu Krax Logo"
                    class="h-12 w-auto">
            </a>

            <div class="hidden md:flex items-center gap-8">
                <a href="#hero" class="text-primary font-bold text-sm tracking-wide uppercase">Beranda</a>
                <a href="#about"
                    class="text-gray-600 hover:text-primary font-semibold text-sm tracking-wide uppercase transition-colors">Tentang</a>
                <a href="#keuntungan"
                    class="text-gray-600 hover:text-primary font-semibold text-sm tracking-wide uppercase transition-colors">Keuntungan</a>
                <a href="#packages"
                    class="text-gray-600 hover:text-primary font-semibold text-sm tracking-wide uppercase transition-colors">Paket
                    Usaha</a>
                <a href="#bonus"
                    class="text-gray-600 hover:text-primary font-semibold text-sm tracking-wide uppercase transition-colors">Bonus</a>
            </div>

            <!-- Icons -->
            <div class="flex items-center gap-4">
                <a href="#"
                    class="w-10 h-10 border border-gray-200 rounded-full flex items-center justify-center hover:border-primary hover:text-primary transition-colors text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </a>
                <!-- Mobile Menu Button -->
                <button id="mobileMenuBtn" class="md:hidden w-10 h-10 flex items-center justify-center text-primary">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>

<!-- Off-Canvas Mobile Menu -->
<div id="mobileMenuOverlay" class="fixed inset-0 bg-black/50 z-[60] hidden transition-opacity opacity-0"></div>
<div id="mobileMenuPanel"
    class="fixed top-0 right-0 h-full w-4/5 max-w-xs bg-white z-[70] transform translate-x-full transition-transform duration-300 shadow-2xl flex flex-col">
    <div class="p-4 flex items-center justify-between border-b">
        <span class="font-bold text-lg text-primary">MENU</span>
        <button id="closeMobileMenuBtn" class="p-2 text-gray-500 hover:text-red-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                </path>
            </svg>
        </button>
    </div>
    <div class="p-6 space-y-6 flex-1 overflow-y-auto">
        <div class="flex flex-col gap-6">
            <a href="#hero" class="text-dark font-bold text-lg border-b pb-2 mobile-link">Beranda</a>
            <a href="#about"
                class="text-gray-600 hover:text-primary font-bold text-lg border-b pb-2 mobile-link">Tentang</a>
            <a href="#keuntungan"
                class="text-gray-600 hover:text-primary font-bold text-lg border-b pb-2 mobile-link">Keuntungan</a>
            <a href="#packages"
                class="text-gray-600 hover:text-primary font-bold text-lg border-b pb-2 mobile-link">Paket Usaha</a>
            <a href="#bonus"
                class="text-gray-600 hover:text-primary font-bold text-lg border-b pb-2 mobile-link">Bonus</a>
        </div>

        <div class="mt-8">
            <a href="#packages"
                class="block w-full bg-primary text-white text-center py-4 rounded-xl font-bold shadow-lg">
                MULAI USAHA SEKARANG
            </a>
        </div>
    </div>
    <div class="p-6 bg-gray-50 border-t">
        <p class="text-xs text-center text-gray-400">© {{ date('Y') }} Tahu Krax Indonesia</p>
    </div>
</div>