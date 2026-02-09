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
                <a href="{{ request()->routeIs('home') ? '#hero' : url('/#hero') }}"
                    class="text-primary font-bold text-sm tracking-wide uppercase">Beranda</a>
                <a href="{{ request()->routeIs('home') ? '#about' : url('/#about') }}"
                    class="text-gray-600 hover:text-primary font-semibold text-sm tracking-wide uppercase transition-colors">Tentang</a>
                <a href="{{ request()->routeIs('home') ? '#keuntungan' : url('/#keuntungan') }}"
                    class="text-gray-600 hover:text-primary font-semibold text-sm tracking-wide uppercase transition-colors">Keuntungan</a>
                <a href="{{ request()->routeIs('home') ? '#packages' : url('/#packages') }}"
                    class="text-gray-600 hover:text-primary font-semibold text-sm tracking-wide uppercase transition-colors">Paket
                    Usaha</a>
                <a href="{{ request()->routeIs('home') ? '#bonus' : url('/#bonus') }}"
                    class="text-gray-600 hover:text-primary font-semibold text-sm tracking-wide uppercase transition-colors">Bonus</a>
            </div>

            <div class="hidden md:flex items-center gap-4">
                @auth
                    <div class="relative group">
                        <button
                            class="flex items-center gap-2 text-gray-600 hover:text-primary transition-colors focus:outline-none">
                            <span class="text-sm font-bold hidden lg:block text-right leading-tight">
                                <span class="block text-xs font-normal text-gray-400">Halo,</span>
                                {{ \Illuminate\Support\Str::limit(auth()->user()->name, 15) }}
                            </span>
                            <div class="w-10 h-10 rounded-full bg-gray-100 border border-gray-200 overflow-hidden">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=FFF2E5&color=FF6B35"
                                    alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                            </div>
                        </button>
                        <!-- Dropdown -->
                        <div
                            class="absolute right-0 top-full mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all transform group-hover:translate-y-0 translate-y-2 z-50">
                            <div class="p-2">
                                <div class="px-3 py-2 border-b border-gray-100 mb-2 md:hidden">
                                    <p class="text-sm font-bold text-gray-800">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                                </div>
                                <a href="/admin"
                                    class="block px-3 py-2 rounded-lg text-sm text-gray-700 hover:bg-orange-50 hover:text-primary transition-colors">
                                    <i class="fas fa-columns mr-2"></i> Dashboard
                                </a>
                                {{-- <a href="#"
                                    class="block px-3 py-2 rounded-lg text-sm text-gray-700 hover:bg-orange-50 hover:text-primary transition-colors">
                                    <i class="fas fa-user-circle mr-2"></i> Profil Saya
                                </a> --}}
                                <form method="POST" action="{{ route('logout') }}"
                                    class="mt-1 border-t border-gray-100 pt-1">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left px-3 py-2 rounded-lg text-sm text-red-600 hover:bg-red-50 transition-colors">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                        class="text-sm font-bold text-gray-600 hover:text-primary transition-colors">MASUK</a>
                    <a href="{{ route('register') }}"
                        class="px-5 py-2.5 rounded-full bg-primary text-white font-bold text-sm shadow-lg hover:bg-secondary hover:shadow-orange-500/30 transition-all hover:-translate-y-0.5">
                        DAFTAR
                    </a>
                @endauth
            </div>
            <!-- Mobile Menu Button -->
            <button id="mobileMenuBtn" class="md:hidden w-10 h-10 flex items-center justify-center text-primary">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
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
        <!-- Auth Section for Mobile -->
        <div class="border-b border-gray-100 pb-6">
            @auth
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full bg-gray-100 border border-gray-200 overflow-hidden">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=FFF2E5&color=FF6B35"
                            alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-800">
                            {{ \Illuminate\Support\Str::limit(auth()->user()->name, 15) }}
                        </p>
                        <p class="text-xs text-gray-500 truncate max-w-[150px]">{{ auth()->user()->email }}</p>
                    </div>
                </div>
                <div class="space-y-2">
                    <a href="/admin"
                        class="block w-full text-left px-4 py-3 rounded-xl bg-orange-50 text-primary font-bold text-sm">
                        <i class="fas fa-columns mr-2"></i> Dashboard
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-4 py-3 rounded-xl bg-red-50 text-red-600 font-bold text-sm">
                            <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                        </button>
                    </form>
                </div>
            @else
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('login') }}"
                        class="flex items-center justify-center px-4 py-3 rounded-xl border border-gray-200 text-gray-700 font-bold text-sm hover:bg-gray-50">
                        MASUK
                    </a>
                    <a href="{{ route('register') }}"
                        class="flex items-center justify-center px-4 py-3 rounded-xl bg-primary text-white font-bold text-sm hover:bg-secondary">
                        DAFTAR
                    </a>
                </div>
            @endauth
        </div>
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