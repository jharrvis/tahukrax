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
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">Lupa Password?</h2>
            <p class="text-sm text-gray-500">
                Masukkan email Anda untuk reset password
            </p>
        </div>

        <!-- Card -->
        <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-xl shadow-orange-500/5">
            @if ($status)
                <div
                    class="mb-4 bg-green-50 text-green-600 p-4 rounded-xl text-sm font-medium border border-green-100 flex items-center">
                    <i class="fas fa-check-circle mr-2 text-lg"></i>
                    {{ $status }}
                </div>
            @endif

            <form wire:submit.prevent="sendResetLink" class="space-y-6">
                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-bold text-gray-700 mb-2">
                        Email Address
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input wire:model="email" id="email" name="email" type="email" required autofocus
                            class="block w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none focus:bg-white focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 transition-all font-medium"
                            placeholder="nama@email.com">
                    </div>
                    @error('email')
                        <span class="text-red-500 text-xs font-medium mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit"
                        class="w-full flex justify-center items-center gap-3 py-4 px-6 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-bold text-lg rounded-xl shadow-lg shadow-orange-500/30 hover:shadow-orange-500/40 transform hover:-translate-y-0.5 transition-all">
                        <span wire:loading.remove>KIRIM LINK RESET</span>
                        <span wire:loading><i class="fas fa-spinner fa-spin"></i> Loading...</span>
                        <i class="fas fa-paper-plane" wire:loading.remove></i>
                    </button>
                </div>
            </form>

            <!-- Back to Login -->
            <p class="mt-8 text-center text-sm text-gray-500">
                Ingat password Anda?
                <a href="{{ route('login') }}"
                    class="font-bold text-orange-600 hover:text-orange-500 transition-colors">
                    Masuk Sekarang
                </a>
            </p>
        </div>
    </div>
</div>