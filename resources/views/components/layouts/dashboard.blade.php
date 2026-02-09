<!DOCTYPE html>
<html lang="id" x-data="setup()" :class="{ 'dark': isDark }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'TahuKrax - Dashboard' }}</title>

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Alpine.js Logic (Livewire already includes Alpine, we just define the data) -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('setup', () => ({
                isDark: localStorage.getItem('theme') === 'dark' ||
                    (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
                isSidebarOpen: window.innerWidth >= 768,

                toggleDarkMode() {
                    this.isDark = !this.isDark;
                    localStorage.setItem('theme', this.isDark ? 'dark' : 'light');
                },

                toggleSidebar() {
                    this.isSidebarOpen = !this.isSidebarOpen;
                }
            }));
        });
    </script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        .smooth-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-item-active {
            background-color: #f97316;
            color: white;
            box-shadow: 0 10px 15px -3px rgba(249, 115, 22, 0.3);
        }

        .sidebar-item-inactive {
            color: #475569;
        }

        .dark .sidebar-item-inactive {
            color: #94a3b8;
        }

        .sidebar-item-inactive:hover {
            background-color: #f1f5f9;
            color: #f97316;
        }

        .dark .sidebar-item-inactive:hover {
            background-color: #1e293b;
        }

        /* Custom scrollbar for sidebar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .dark .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #334155;
        }
    </style>
    @livewireStyles
</head>

<body class="bg-slate-50 dark:bg-slate-950 font-sans text-slate-900 dark:text-slate-100 smooth-transition" x-cloak>

    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <x-dashboard.sidebar />

        <!-- Overlay Backdrop (Mobile) -->
        <div x-show="isSidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" @click="isSidebarOpen = false"
            class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-sm md:hidden" x-cloak>
        </div>

        <!-- Main Content Area -->
        <main class="flex-1 flex flex-col min-w-0 w-full smooth-transition md:ml-0"
            :class="isSidebarOpen ? 'md:ml-64' : 'md:ml-20'">

            <!-- Top Header -->
            <x-dashboard.header />

            <!-- Page Body -->
            <div class="flex-1 overflow-y-auto p-4 md:p-8 space-y-8">
                {{ $slot }}
            </div>

            <!-- Footer -->
            <footer class="p-6 text-center text-slate-500 text-xs">
                &copy; {{ date('Y') }} <span class="font-bold text-brand-500">TahuKrax Operations</span>. Build with
                Speed
                and Performance.
            </footer>
        </main>
    </div>

    @livewireScripts

    <!-- Toast Notifications -->
    <div x-data="toastHandler()" class="fixed top-4 right-4 z-50 space-y-2 pointer-events-none">
        <template x-for="toast in toasts" :key="toast.id">
            <div x-show="toast.visible" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-x-8"
                x-transition:enter-end="opacity-100 transform translate-x-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform translate-x-0"
                x-transition:leave-end="opacity-0 transform translate-x-8"
                class="pointer-events-auto flex items-center w-full max-w-xs p-4 space-x-3 text-slate-500 bg-white dark:bg-slate-800 dark:text-slate-300 rounded-xl shadow-lg border border-slate-100 dark:border-slate-700"
                role="alert">

                <!-- Icons based on type -->
                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-lg" :class="{
                        'text-green-500 bg-green-100 dark:bg-green-800 dark:text-green-200': toast.type === 'success',
                        'text-red-500 bg-red-100 dark:bg-red-800 dark:text-red-200': toast.type === 'error',
                        'text-blue-500 bg-blue-100 dark:bg-blue-800 dark:text-blue-200': toast.type === 'info',
                        'text-orange-500 bg-orange-100 dark:bg-orange-800 dark:text-orange-200': toast.type === 'warning'
                    }">
                    <i class="fas" :class="{
                        'fa-check': toast.type === 'success',
                        'fa-times': toast.type === 'error',
                        'fa-info': toast.type === 'info',
                        'fa-exclamation': toast.type === 'warning'
                    }"></i>
                </div>

                <div class="flex-1 text-sm font-semibold" x-text="toast.message"></div>

                <button @click="remove(toast.id)" type="button"
                    class="ml-auto -mx-1.5 -my-1.5 bg-white dark:bg-slate-800 text-slate-400 hover:text-slate-900 dark:hover:text-white rounded-lg focus:ring-2 focus:ring-slate-300 p-1.5 hover:bg-slate-100 dark:hover:bg-slate-700 inline-flex h-8 w-8 items-center justify-center">
                    <span class="sr-only">Close</span>
                    <i class="fas fa-times text-xs"></i>
                </button>
            </div>
        </template>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('toastHandler', () => ({
                toasts: [],
                nextId: 1,

                init() {
                    // Listen for Livewire events
                    Livewire.on('notify', (data) => {
                        // Handle both array/object event format
                        const detail = Array.isArray(data) ? data[0] : data;
                        this.add(detail.message, detail.type || 'success');
                    });

                    // Check for session flash messages (passed via Blade)
                    @if(session('message'))
                        this.add("{{ session('message') }}", 'success');
                    @endif
                    @if(session('error'))
                        this.add("{{ session('error') }}", 'error');
                    @endif
                    @if(session('success'))
                        this.add("{{ session('success') }}", 'success');
                    @endif
                },

                add(message, type = 'success') {
                    const id = this.nextId++;
                    this.toasts.push({
                        id: id,
                        message: message,
                        type: type,
                        visible: true
                    });

                    // Auto remove after 3 seconds
                    setTimeout(() => {
                        this.remove(id);
                    }, 3000);
                },

                remove(id) {
                    const toast = this.toasts.find(t => t.id === id);
                    if (toast) {
                        toast.visible = false;
                        setTimeout(() => {
                            this.toasts = this.toasts.filter(t => t.id !== id);
                        }, 300); // Wait for transition
                    }
                }
            }));
        });
    </script>
    @stack('scripts')
</body>

</html>