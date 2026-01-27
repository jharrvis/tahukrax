<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    <!-- Background Effects -->
    <div class="absolute inset-0 opacity-20 pointer-events-none">
        <div class="absolute top-20 right-10 w-80 h-80 bg-orange-500 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 left-10 w-72 h-72 bg-orange-600 rounded-full blur-3xl"></div>
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
            <h2 class="text-2xl md:text-3xl font-bold text-white mb-2">Bergabung Bersama Kami</h2>
            <p class="text-sm text-gray-400">
                Daftar Kemitraan RCGO Sekarang
            </p>
        </div>

        <!-- Register Card -->
        <div class="bg-gray-900/50 backdrop-blur-lg p-8 rounded-2xl border border-gray-800 shadow-2xl">
            <form wire:submit.prevent="register" class="space-y-5">
                <!-- Full Name Field -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-300 mb-2">
                        Nama Lengkap
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500">
                            <i class="fas fa-user"></i>
                        </span>
                        <input wire:model="name" id="name" name="name" type="text" required
                            class="block w-full pl-12 pr-4 py-3 bg-gray-800/50 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all"
                            placeholder="John Doe">
                    </div>
                    @error('name')
                        <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

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
                            placeholder="john@example.com">
                    </div>
                    @error('email')
                        <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password Fields -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
                        @error('password')
                            <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-300 mb-2">
                            Konfirmasi
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500">
                                <i class="fas fa-check-double"></i>
                            </span>
                            <input wire:model="password_confirmation" id="password_confirmation"
                                name="password_confirmation" type="password" required
                                class="block w-full pl-12 pr-4 py-3 bg-gray-800/50 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all">
                        </div>
                    </div>
                </div>

                <!-- Terms Checkbox -->
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="terms" name="terms" type="checkbox" required
                            class="h-4 w-4 text-orange-500 focus:ring-orange-500 border-gray-600 rounded bg-gray-800">
                    </div>
                    <div class="ml-3">
                        <label for="terms" class="text-sm text-gray-400">
                            Saya menyetujui
                            <a href="#"
                                class="font-semibold text-orange-500 hover:text-orange-400 transition-colors">Syarat &
                                Ketentuan</a>
                            kemitraan RCGO
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit"
                        class="btn-cta-primary w-full flex justify-center items-center gap-3 py-4 px-6 text-white font-bold text-lg rounded-lg shadow-lg hover:shadow-orange-500/50 transition-all">
                        <i class="fas fa-user-plus"></i>
                        DAFTAR SEKARANG
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
                        Daftar dengan Google
                    </a>
                </div>
            </div>

            <!-- Login Link -->
            <p class="mt-8 text-center text-sm text-gray-400">
                Sudah punya akun?
                <a href="{{ route('login') }}"
                    class="font-semibold text-orange-500 hover:text-orange-400 transition-colors">
                    Masuk Sekarang
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