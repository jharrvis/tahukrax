<header
    class="h-16 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 sticky top-0 z-40 px-4 md:px-8 flex items-center justify-between">
    <div class="flex items-center gap-4">
        <button @click="toggleSidebar()" class="md:hidden text-slate-500">
            <i class="fas fa-bars text-xl"></i>
        </button>
        <!-- Search Bar -->
        <div class="relative hidden sm:block">
            <livewire:global-search />
        </div>
    </div>

    <div class="flex items-center gap-2 md:gap-4">
        <!-- Dark Mode Toggle -->
        <button @click="toggleDarkMode()"
            class="p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-colors">
            <i class="fas" :class="isDark ? 'fa-sun' : 'fa-moon'"></i>
        </button>

        <!-- Notifications -->
        <!-- Notifications Removed as requested -->


        <div class="h-8 w-[1px] bg-slate-200 dark:bg-slate-800 mx-1"></div>

        <!-- Profile Dropdown -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" @click.away="open = false"
                class="flex items-center gap-2 p-1 pr-3 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors outline-none">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&background=f97316&color=fff"
                    class="w-8 h-8 rounded-lg shadow-sm">
                <span class="hidden md:block text-sm font-semibold">{{ Auth::user()->name ?? 'Guest' }}</span>
                <i class="fas fa-chevron-down text-[10px] text-slate-400"></i>
            </button>

            <div x-show="open" x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100" x-cloak
                class="absolute right-0 mt-2 w-48 bg-white dark:bg-slate-900 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-800 py-2 z-50">
                <div class="px-4 py-2 border-b border-slate-100 dark:border-slate-800 mb-2">
                    <p class="text-xs text-slate-400">Masuk sebagai</p>
                    <p class="text-sm font-bold truncate">{{ Auth::user()->email ?? '' }}</p>
                </div>

                @if(Auth::user()->isMitra())
                    <a href="{{ route('mitra.settings') }}"
                        class="flex items-center px-4 py-2 text-sm hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-600 dark:text-slate-300">
                        <i class="far fa-user w-5"></i> Pengaturan Akun
                    </a>
                @else
                    <a href="{{ route('admin.profile') }}"
                        class="flex items-center px-4 py-2 text-sm hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-600 dark:text-slate-300">
                        <i class="far fa-user w-5"></i> Pengaturan Profil
                    </a>
                @endif

                <!-- Log Activity - Placeholder for now -->
                {{-- <a href="#"
                    class="flex items-center px-4 py-2 text-sm hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-600 dark:text-slate-300">
                    <i class="fas fa-history w-5"></i> Log Aktivitas
                </a> --}}
                <div class="h-[1px] bg-slate-100 dark:bg-slate-800 my-2"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full text-left flex items-center px-4 py-2 text-sm text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10">
                        <i class="fas fa-sign-out-alt w-5"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>