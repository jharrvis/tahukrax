<div
    class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden bg-[#FFFBF5]">
    <!-- Background Effects -->
    <div class="absolute inset-0 opacity-10 pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-orange-300 rounded-full blur-[100px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-orange-200 rounded-full blur-[100px]"></div>
    </div>

    <div class="max-w-md w-full space-y-8 relative z-10">
        <!-- Logo & Title -->
        <div class="text-center">
            <div class="flex justify-center mb-6">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('img/logo.svg') }}"
                        onerror="this.src='https://placehold.co/150x50/png?text=TahuKrax'" alt="Tahu Krax Logo"
                        class="h-16 md:h-20 drop-shadow-md hover:scale-105 transition-transform cursor-pointer">
                </a>
            </div>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">Selamat Datang</h2>
            <p class="text-sm text-gray-500">
                Akses Dashboard Kemitraan Anda
            </p>
        </div>

        <!-- Login Card -->
        <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-xl shadow-orange-500/5">
            <form wire:submit.prevent="login" class="space-y-6">
                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-bold text-gray-700 mb-2">
                        Email Address
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input wire:model="email" id="email" name="email" type="email" required
                            class="block w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none focus:bg-white focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 transition-all font-medium"
                            placeholder="nama@email.com">
                    </div>
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-bold text-gray-700 mb-2">
                        Password
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input wire:model="password" id="password" name="password" type="password" required
                            class="block w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none focus:bg-white focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 transition-all font-medium">
                    </div>
                </div>

                <!-- Remember & Forgot -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input wire:model="remember" id="remember-me" name="remember-me" type="checkbox"
                            class="h-4 w-4 text-orange-500 focus:ring-orange-500 border-gray-300 rounded bg-gray-50">
                        <label for="remember-me" class="ml-2 block text-sm font-medium text-gray-600">
                            Ingat saya
                        </label>
                    </div>

                    <div class="text-sm">
                        <a href="{{ route('password.request') }}"
                            class="font-bold text-orange-600 hover:text-orange-500 transition-colors">
                            Lupa Password?
                        </a>
                    </div>
                </div>

                <!-- Error Messages -->
                @if ($errors->any())
                    <div
                        class="p-4 bg-red-50 border border-red-100 rounded-xl text-red-600 text-sm font-medium flex items-center">
                        <i class="fas fa-exclamation-circle mr-2 text-xl"></i>
                        {{ $errors->first() }}
                    </div>
                @endif

                <!-- Submit Button -->
                <div>
                    <button type="submit"
                        class="w-full flex justify-center items-center gap-3 py-4 px-6 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-bold text-lg rounded-xl shadow-lg shadow-orange-500/30 hover:shadow-orange-500/40 transform hover:-translate-y-0.5 transition-all">
                        <span wire:loading.remove>MASUK SEKARANG</span>
                        <span wire:loading><i class="fas fa-spinner fa-spin"></i> Loading...</span>
                        <i class="fas fa-arrow-right" wire:loading.remove></i>
                    </button>
                </div>
            </form>

            <!-- Divider -->
            <div class="mt-8">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white text-gray-500 font-medium">Atau lanjutkan dengan</span>
                    </div>
                </div>

                <!-- Google SSO -->
                <div class="mt-6">
                    <a href="{{ route('google.login') }}"
                        class="w-full flex justify-center items-center gap-3 py-3 px-4 bg-white hover:bg-gray-50 text-gray-700 font-bold rounded-xl border border-gray-200 transition-all shadow-sm hover:shadow-md group">
                        <img src="https://www.svgrepo.com/show/475656/google-color.svg"
                            class="w-5 h-5 group-hover:scale-110 transition-transform">
                        <span>Lanjutkan dengan Google</span>
                    </a>
                </div>
            </div>

            <!-- Register Link -->
            <p class="mt-8 text-center text-sm text-gray-500">
                Belum punya akun?
                <a href="{{ route('register') }}"
                    class="font-bold text-orange-600 hover:text-orange-500 transition-colors">
                    Daftar Sekarang
                </a>
            </p>
        </div>

        <!-- Back to Home -->
        <div class="text-center">
            <a href="{{ route('home') }}"
                class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-orange-600 transition-colors">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>