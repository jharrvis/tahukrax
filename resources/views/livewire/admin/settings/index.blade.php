<div>
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">Pengaturan Website</h1>
            <p class="text-slate-500 text-sm mt-1">Kelola informasi website, invoice, dan kontak.</p>
        </div>
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
            <button wire:click="$set('activeTab', 'system')"
                class="px-6 py-4 font-bold text-sm transition-colors whitespace-nowrap {{ $activeTab === 'system' ? 'text-brand-500 border-b-2 border-brand-500 bg-brand-50' : 'text-slate-500 hover:text-slate-700' }}">
                <i class="fas fa-server mr-2"></i> System & Email
            </button>
        </div>

        <div class="p-6">

            <!-- General Tab -->
            @if($activeTab === 'general')
                <form wire:submit.prevent="update('general')" class="space-y-6 max-w-3xl animate-fade-in">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nama Website</label>
                        <input type="text" wire:model="site_name"
                            class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:ring-brand-500 focus:border-brand-500 active:ring-brand-500">
                        @error('site_name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Deskripsi Website</label>
                        <textarea wire:model="site_description" rows="3"
                            class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:ring-brand-500 focus:border-brand-500 active:ring-brand-500"></textarea>
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
                    <div class="pt-4 border-t border-slate-100 dark:border-slate-800">
                        <button type="submit"
                            class="px-6 py-2 bg-brand-500 text-white font-bold rounded-xl hover:bg-brand-600 transition-colors shadow-lg shadow-brand-500/30 flex items-center gap-2">
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
                                class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:ring-brand-500">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">No. Telepon / WA</label>
                            <input type="text" wire:model="company_phone"
                                class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:ring-brand-500">
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
                    <div class="pt-4 border-t border-slate-100 dark:border-slate-800">
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
                    <div class="pt-4 border-t border-slate-100 dark:border-slate-800">
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
                    <div class="pt-4 border-t border-slate-100 dark:border-slate-800">
                        <button type="submit"
                            class="px-6 py-2 bg-brand-500 text-white font-bold rounded-xl hover:bg-brand-600 transition-colors shadow-lg shadow-brand-500/30">
                            <span wire:loading.remove target="update('social')">Simpan Perubahan</span>
                            <span wire:loading target="update('social')"><i class="fas fa-spinner fa-spin"></i>
                                Menyimpan...</span>
                        </button>
                    </div>
                </form>
            @endif

            <!-- System Tab -->
            @if($activeTab === 'system')
                <div class="space-y-8 animate-fade-in">

                    <!-- SMTP Config -->
                    <form wire:submit.prevent="update('system')" class="space-y-6 max-w-3xl">
                        <div class="p-4 bg-yellow-50 border border-yellow-100 rounded-xl mb-6">
                            <p class="text-sm text-yellow-800"><i class="fas fa-exclamation-triangle mr-1"></i>
                                <strong>Perhatian:</strong> Pengaturan ini akan mengubah file <code>.env</code> server
                                secara langsung. Pastikan Anda tahu apa yang Anda lakukan.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Mail Host</label>
                                <input type="text" wire:model="mail_host"
                                    class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:ring-brand-500"
                                    placeholder="smtp.google.com">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Mail Port</label>
                                <input type="text" wire:model="mail_port"
                                    class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:ring-brand-500"
                                    placeholder="465 / 587">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Username / Email</label>
                                <input type="text" wire:model="mail_username"
                                    class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:ring-brand-500">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Password / App Password</label>
                                <input type="password" wire:model="mail_password"
                                    class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:ring-brand-500">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Encryption</label>
                                <select wire:model="mail_encryption"
                                    class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:ring-brand-500">
                                    <option value="ssl">SSL (Port 465)</option>
                                    <option value="tls">TLS (Port 587)</option>
                                    <option value="">None</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">From Address</label>
                                <input type="email" wire:model="mail_from_address"
                                    class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:ring-brand-500">
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-100 dark:border-slate-800">
                            <button type="submit"
                                class="px-6 py-2 bg-brand-500 text-white font-bold rounded-xl hover:bg-brand-600 transition-colors shadow-lg shadow-brand-500/30">
                                <span wire:loading.remove target="update('system')">Simpan Konfigurasi SMTP</span>
                                <span wire:loading target="update('system')"><i class="fas fa-spinner fa-spin"></i>
                                    Menyimpan...</span>
                            </button>
                        </div>
                    </form>

                    <hr class="border-slate-200 dark:border-slate-800">

                    <!-- Test Email -->
                    <div class="max-w-3xl">
                        <h3 class="text-lg font-bold text-slate-800 mb-4">Test Kirim Email</h3>
                        <div class="flex gap-4">
                            <div class="flex-1">
                                <input type="email" wire:model="test_email_recipient"
                                    class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:ring-brand-500"
                                    placeholder="Masukkan email penerima tes...">
                                @error('test_email_recipient') <span class="text-xs text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <button wire:click="sendTestEmail"
                                class="px-6 py-2 bg-slate-800 text-white font-bold rounded-xl hover:bg-slate-900 transition-colors shadow-lg">
                                <span wire:loading.remove target="sendTestEmail">Kirim Test</span>
                                <span wire:loading target="sendTestEmail"><i class="fas fa-spinner fa-spin"></i>
                                    Mengirim...</span>
                            </button>
                        </div>
                    </div>

                </div>
            @endif

        </div>
    </div>
</div>