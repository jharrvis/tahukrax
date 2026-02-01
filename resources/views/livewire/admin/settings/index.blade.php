<div>
    <div class="mb-6">
        <h1 class="text-2xl font-bold tracking-tight">Pengaturan Website</h1>
        <p class="text-slate-500 text-sm">Kelola informasi website, invoice, dan kontak.</p>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 border border-green-200 text-green-700 rounded-xl flex items-center gap-3">
            <i class="fas fa-check-circle"></i> {{ session('message') }}
        </div>
    @endif

    <div
        class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm">

        <!-- Tabs -->
        <div class="flex border-b border-slate-200 dark:border-slate-800 overflow-x-auto">
            <button wire:click="$set('activeTab', 'general')"
                class="px-6 py-4 font-bold text-sm transition-colors whitespace-nowrap {{ $activeTab === 'general' ? 'text-brand-500 border-b-2 border-brand-500 bg-brand-50' : 'text-slate-500 hover:text-slate-700' }}">
                <i class="fas fa-globe mr-2"></i> Umum & Identitas
            </button>
            <button wire:click="$set('activeTab', 'company')"
                class="px-6 py-4 font-bold text-sm transition-colors whitespace-nowrap {{ $activeTab === 'company' ? 'text-brand-500 border-b-2 border-brand-500 bg-brand-50' : 'text-slate-500 hover:text-slate-700' }}">
                <i class="fas fa-building mr-2"></i> Perusahaan & Invoice
            </button>
            <button wire:click="$set('activeTab', 'finance')"
                class="px-6 py-4 font-bold text-sm transition-colors whitespace-nowrap {{ $activeTab === 'finance' ? 'text-brand-500 border-b-2 border-brand-500 bg-brand-50' : 'text-slate-500 hover:text-slate-700' }}">
                <i class="fas fa-wallet mr-2"></i> Keuangan & Ekspedisi
            </button>
            <button wire:click="$set('activeTab', 'social')"
                class="px-6 py-4 font-bold text-sm transition-colors whitespace-nowrap {{ $activeTab === 'social' ? 'text-brand-500 border-b-2 border-brand-500 bg-brand-50' : 'text-slate-500 hover:text-slate-700' }}">
                <i class="fas fa-share-alt mr-2"></i> Sosial Media
            </button>
        </div>

        <div class="p-6">

            <!-- General Tab -->
            @if($activeTab === 'general')
                <form wire:submit.prevent="update('general')" class="space-y-6 max-w-3xl animate-fade-in">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nama Website</label>
                        <input type="text" wire:model="site_name"
                            class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:ring-brand-500 focus:border-brand-500">
                        @error('site_name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Deskripsi Website</label>
                        <textarea wire:model="site_description" rows="3"
                            class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:ring-brand-500 focus:border-brand-500"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Logo Website</label>
                        <div class="flex items-center gap-4">
                            @if ($new_site_logo)
                                <img src="{{ $new_site_logo->temporaryUrl() }}"
                                    class="h-16 w-auto rounded-lg border border-slate-200">
                            @elseif ($site_logo)
                                <img src="{{ Storage::url($site_logo) }}"
                                    class="h-16 w-auto rounded-lg border border-slate-200">
                            @endif
                            <input type="file" wire:model="new_site_logo"
                                class="text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
                        </div>
                    </div>
                    <div class="pt-4 border-t border-slate-100">
                        <button type="submit"
                            class="px-6 py-2 bg-brand-500 text-white font-bold rounded-xl hover:bg-brand-600 transition-colors shadow-lg shadow-brand-500/30">
                            <span wire:loading.remove target="update('general')">Simpan Perubahan</span>
                            <span wire:loading target="update('general')"><i class="fas fa-spinner fa-spin"></i>
                                Menyimpan...</span>
                        </button>
                    </div>
                </form>
            @endif

            <!-- Company Tab -->
            @if($activeTab === 'company')
                <form wire:submit.prevent="update('company')" class="space-y-6 max-w-3xl animate-fade-in">
                    <div class="p-4 bg-blue-50 border border-blue-100 rounded-xl mb-6">
                        <p class="text-sm text-blue-800"><i class="fas fa-info-circle mr-1"></i> Informasi ini akan
                            ditampilkan pada <strong>Header & Footer Invoice</strong>.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nama Perusahaan / Toko</label>
                        <input type="text" wire:model="company_name"
                            class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:ring-brand-500 focus:border-brand-500">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Alamat Lengkap</label>
                        <textarea wire:model="company_address" rows="3"
                            class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:ring-brand-500 focus:border-brand-500"
                            placeholder="Jl. Contoh No. 123..."></textarea>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Email Kontak</label>
                            <input type="email" wire:model="company_email"
                                class="w-full px-4 py-2 border border-slate-200 rounded-xl">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">No. Telepon / WA</label>
                            <input type="text" wire:model="company_phone"
                                class="w-full px-4 py-2 border border-slate-200 rounded-xl">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Tanda Tangan / Stempel Digital</label>
                        <div class="flex items-center gap-4">
                            @if ($new_company_signature)
                                <img src="{{ $new_company_signature->temporaryUrl() }}"
                                    class="h-16 w-auto rounded-lg border border-slate-200">
                            @elseif ($company_signature)
                                <img src="{{ Storage::url($company_signature) }}"
                                    class="h-16 w-auto rounded-lg border border-slate-200">
                            @endif
                            <input type="file" wire:model="new_company_signature"
                                class="text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
                        </div>
                        <p class="text-xs text-slate-400 mt-1">Akan muncul di bagian bawah invoice.</p>
                    </div>
                    <div class="pt-4 border-t border-slate-100">
                        <button type="submit"
                            class="px-6 py-2 bg-brand-500 text-white font-bold rounded-xl hover:bg-brand-600 transition-colors shadow-lg shadow-brand-500/30">
                            <span wire:loading.remove target="update('company')">Simpan Perubahan</span>
                            <span wire:loading target="update('company')"><i class="fas fa-spinner fa-spin"></i>
                                Menyimpan...</span>
                        </button>
                    </div>
                </form>
            @endif

            <!-- Finance Tab -->
            @if($activeTab === 'finance')
                <form wire:submit.prevent="update('finance')" class="space-y-6 max-w-3xl animate-fade-in">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Rekening Bank Default</label>
                        <textarea wire:model="bank_account_default" rows="2"
                            class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:ring-brand-500 focus:border-brand-500"
                            placeholder="BCA 1234567890 a.n PT RC GO Indonesia"></textarea>
                        <p class="text-xs text-slate-400 mt-1">Ditampilkan jika pembayaran manual dipilih.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Kota Asal Pengiriman</label>
                        <input type="text" wire:model="origin_city"
                            class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:ring-brand-500 focus:border-brand-500">
                    </div>
                    <div class="pt-4 border-t border-slate-100">
                        <button type="submit"
                            class="px-6 py-2 bg-brand-500 text-white font-bold rounded-xl hover:bg-brand-600 transition-colors shadow-lg shadow-brand-500/30">
                            <span wire:loading.remove target="update('finance')">Simpan Perubahan</span>
                            <span wire:loading target="update('finance')"><i class="fas fa-spinner fa-spin"></i>
                                Menyimpan...</span>
                        </button>
                    </div>
                </form>
            @endif

            <!-- Social Tab -->
            @if($activeTab === 'social')
                <form wire:submit.prevent="update('social')" class="space-y-6 max-w-3xl animate-fade-in">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Facebook URL</label>
                        <input type="url" wire:model="social_facebook"
                            class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:ring-brand-500 focus:border-brand-500"
                            placeholder="https://facebook.com/...">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Instagram URL</label>
                        <input type="url" wire:model="social_instagram"
                            class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:ring-brand-500 focus:border-brand-500"
                            placeholder="https://instagram.com/...">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">TikTok URL</label>
                        <input type="url" wire:model="social_tiktok"
                            class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:ring-brand-500 focus:border-brand-500"
                            placeholder="https://tiktok.com/@...">
                    </div>
                    <div class="pt-4 border-t border-slate-100">
                        <button type="submit"
                            class="px-6 py-2 bg-brand-500 text-white font-bold rounded-xl hover:bg-brand-600 transition-colors shadow-lg shadow-brand-500/30">
                            <span wire:loading.remove target="update('social')">Simpan Perubahan</span>
                            <span wire:loading target="update('social')"><i class="fas fa-spinner fa-spin"></i>
                                Menyimpan...</span>
                        </button>
                    </div>
                </form>
            @endif

        </div>
    </div>
</div>