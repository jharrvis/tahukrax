<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    <!-- Background Effects -->
    <div class="absolute inset-0 opacity-20 pointer-events-none">
        <div class="absolute top-10 left-10 w-64 h-64 bg-orange-500 rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-orange-600 rounded-full blur-3xl"></div>
    </div>

    <div class="max-w-md w-full space-y-8 relative z-10">
        <!-- Logo & Title -->
        <div class="text-center">
            <div class="flex justify-center mb-6">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('img/rcgo-logo.svg') }}" alt="RCGO Logo"
                        class="h-16 md:h-20 drop-shadow-[0_0_15px_rgba(255,165,0,0.5)] hover:scale-105 transition-transform cursor-pointer">
                </a>
            </div>
            <h2 class="text-2xl md:text-3xl font-bold text-white mb-2">Selamat Datang Kembali</h2>
            <p class="text-sm text-gray-400">
                Akses Dashboard Kemitraan Anda
            </p>
        </div>

        <!-- Login Card -->
        <div class="bg-gray-900/50 backdrop-blur-lg p-8 rounded-2xl border border-gray-800 shadow-2xl">
            <form wire:submit.prevent="login" class="space-y-6">
                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-300 mb-2">
                        Email Address
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input wire:model="email" id="email" name="email" type="email" required
                            class="block w-full pl-12 pr-4 py-3 bg-gray-800/50 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all"
                            placeholder="admin@rcgo.test">
                    </div>
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-300 mb-2">
                        Password
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input wire:model="password" id="password" name="password" type="password" required
                            class="block w-full pl-12 pr-4 py-3 bg-gray-800/50 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all">
                    </div>
                </div>

                <!-- Remember & Forgot -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input wire:model="remember" id="remember-me" name="remember-me" type="checkbox"
                            class="h-4 w-4 text-orange-500 focus:ring-orange-500 border-gray-600 rounded bg-gray-800">
                        <label for="remember-me" class="ml-2 block text-sm text-gray-400">
                            Remember me
                        </label>
                    </div>

                    <div class="text-sm">
                        <a href="#" class="font-semibold text-orange-500 hover:text-orange-400 transition-colors">
                            Lupa Password?
                        </a>
                    </div>
                </div>

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="p-4 bg-red-500/10 border border-red-500/30 rounded-lg text-red-400 text-sm">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        {{ $errors->first() }}
                    </div>
                @endif

                <!-- Submit Button -->
                <div>
                    <button type="submit"
                        class="btn-cta-primary w-full flex justify-center items-center gap-3 py-4 px-6 text-white font-bold text-lg rounded-lg shadow-lg hover:shadow-orange-500/50 transition-all">
                        <i class="fas fa-sign-in-alt"></i>
                        MASUK SEKARANG
                    </button>
                </div>
            </form>

            <!-- Divider -->
            <div class="mt-8">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-700"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-gray-900/50 text-gray-400">Atau lanjutkan dengan</span>
                    </div>
                </div>

                <!-- Google SSO -->
                <div class="mt-6">
                    <a href="{{ route('google.login') }}"
                        class="w-full flex justify-center items-center gap-3 py-3 px-4 bg-white hover:bg-gray-100 text-gray-900 font-semibold rounded-lg border border-gray-300 transition-all shadow-md hover:shadow-lg">
                        <i class="fab fa-google text-orange-500 text-lg"></i>
                        Lanjutkan dengan Google
                    </a>
                </div>
            </div>

            <!-- Register Link -->
            <p class="mt-8 text-center text-sm text-gray-400">
                Belum punya akun?
                <a href="{{ route('register') }}"
                    class="font-semibold text-orange-500 hover:text-orange-400 transition-colors">
                    Daftar Sekarang
                </a>
            </p>
        </div>

        <!-- Back to Home -->
        <div class="text-center">
            <a href="{{ route('home') }}"
                class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-orange-500 transition-colors">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>