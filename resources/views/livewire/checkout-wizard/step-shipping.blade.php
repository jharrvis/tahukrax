<div class="space-y-8">

    <!-- 1. Customer Information (Registration) -->
    @guest
        <section class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
            <div class="bg-gray-50 px-6 py-4 flex items-center justify-between border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <span
                        class="w-8 h-8 rounded-full bg-orange-500 text-white flex items-center justify-center font-bold text-sm shadow-sm">1</span>
                    <h3 class="text-lg font-bold text-gray-800 uppercase tracking-tight">Informasi Akun</h3>
                </div>
                <a href="{{ route('login') }}"
                    class="text-sm text-orange-600 hover:text-orange-700 font-medium hover:underline transition-colors">Sudah
                    punya akun? Login</a>
            </div>
            <div class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Lengkap</label>
                    <div class="relative">
                        <i class="fas fa-user absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" wire:model="name"
                            class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-800 placeholder-gray-400 focus:bg-white focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition-all outline-none"
                            placeholder="Masukkan nama sesuai KTP">
                    </div>
                    @error('name') <span class="text-red-500 text-xs font-medium">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Email Aktif</label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="email" wire:model="email"
                            class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-800 placeholder-gray-400 focus:bg-white focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition-all outline-none"
                            placeholder="email@contoh.com">
                    </div>
                    @error('email') <span class="text-red-500 text-xs font-medium">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Password Akun</label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="password" wire:model="password"
                            class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-800 placeholder-gray-400 focus:bg-white focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition-all outline-none"
                            placeholder="Min. 8 karakter">
                    </div>
                    @error('password') <span class="text-red-500 text-xs font-medium">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Nomor WhatsApp</label>
                    <div class="relative">
                        <i class="fab fa-whatsapp absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="tel" wire:model="phone_number"
                            class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-800 placeholder-gray-400 focus:bg-white focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition-all outline-none"
                            placeholder="08xxxxxxxx">
                    </div>
                    @error('phone_number') <span class="text-red-500 text-xs font-medium">{{ $message }}</span> @enderror
                </div>
            </div>
        </section>
    @endguest

    <!-- 2. Shipping Address -->
    <section class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
            <div class="flex items-center gap-3">
                <span
                    class="w-8 h-8 rounded-full bg-orange-500 text-white flex items-center justify-center font-bold text-sm shadow-sm">@auth
                    1 @else 2 @endauth</span>
                <h3 class="text-lg font-bold text-gray-800 uppercase tracking-tight">Alamat Pengiriman</h3>
            </div>
        </div>
        <div class="p-6 md:p-8 space-y-8">
            @auth
                @if(auth()->user()->address)
                    <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 flex items-start gap-4">
                        <div
                            class="w-8 h-8 rounded-full bg-blue-100 text-blue-500 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-blue-800">Alamat Tersimpan</p>
                            <p class="text-xs text-blue-600 mt-1">Alamat pengiriman otomatis diisi dari profil Anda. Silakan
                                ubah formulir di bawah jika ingin mengirim ke alamat lain.
                            </p>
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Username / Nama</label>
                        <input type="text" disabled value="{{ auth()->user()->name }}"
                            class="w-full px-4 py-3 bg-gray-100 border border-gray-200 rounded-xl text-gray-500 cursor-not-allowed font-medium">
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Nomor WhatsApp</label>
                        <div class="relative">
                            <i class="fab fa-whatsapp absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="tel" wire:model="phone_number"
                                class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-800 placeholder-gray-400 focus:bg-white focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition-all outline-none"
                                placeholder="08xxxxxxxx">
                        </div>
                        @error('phone_number') <span class="text-red-500 text-xs font-medium">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            @endauth

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Provinsi</label>
                    <div class="relative">
                        <select wire:model.live="province_id"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-800 focus:bg-white focus:border-orange-500 focus:ring-2 focus:ring-orange-200 appearance-none transition-all outline-none cursor-pointer">
                            <option value="">Pilih Provinsi...</option>
                            @foreach($provinces as $prov)
                                <option value="{{ $prov->code }}">{{ $prov->name }}</option>
                            @endforeach
                        </select>
                        <i
                            class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-xs"></i>
                    </div>
                    @error('province_id') <span class="text-red-500 text-xs font-medium">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Kota / Kabupaten</label>
                    <div class="relative">
                        <select wire:model.live="city_id" @disabled(empty($cities))
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-800 focus:bg-white focus:border-orange-500 focus:ring-2 focus:ring-orange-200 appearance-none disabled:opacity-50 disabled:cursor-not-allowed transition-all outline-none cursor-pointer">
                            <option value="">
                                {{ empty($cities) ? 'Pilih provinsi dulu' : 'Pilih Kota/Kabupaten...' }}
                            </option>
                            @foreach($cities as $city)
                                <option value="{{ $city->code }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                        <i wire:loading.remove wire:target="province_id"
                            class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-xs"></i>
                        <i wire:loading wire:target="province_id"
                            class="fas fa-spinner fa-spin absolute right-4 top-1/2 -translate-y-1/2 text-orange-500 pointer-events-none text-xs"></i>
                    </div>
                    @error('city_id') <span class="text-red-500 text-xs font-medium">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Kode Pos</label>
                    <input type="text" wire:model="postal_code"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-800 placeholder-gray-400 focus:bg-white focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition-all outline-none"
                        placeholder="12345">
                    @error('postal_code') <span class="text-red-500 text-xs font-medium">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Alamat Lengkap</label>
                <textarea wire:model="address" rows="3"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-800 placeholder-gray-400 focus:bg-white focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition-all resize-none outline-none"
                    placeholder="Jl. Contoh No. 123, RT/RW, Kelurahan, Kecamatan"></textarea>
                @error('address') <span class="text-red-500 text-xs font-medium">{{ $message }}</span> @enderror
            </div>
        </div>
    </section>
</div>