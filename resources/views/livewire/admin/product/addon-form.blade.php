<div>
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">
                {{ $addonId ? 'Edit Add-on' : 'Tambah Add-on Baru' }}
            </h1>
            <p class="text-slate-500 text-sm mt-1">Lengkapi informasi item tambahan di bawah ini.</p>
        </div>
        <a href="{{ route('admin.addons.index') }}"
            class="px-4 py-2 bg-white border border-slate-200 dark:border-slate-800 text-slate-600 rounded-xl text-sm font-medium hover:bg-slate-50 transition-all flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div
        class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm p-6 md:p-8">
        <form wire:submit="save" class="space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Item -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Nama Item</label>
                    <input wire:model="name" type="text"
                        class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none transition-all"
                        placeholder="Contoh: Baterai Cadangan">
                    @error('name') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Tipe -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Tipe</label>
                    <select wire:model="type"
                        class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none transition-all">
                        <option value="unit">Unit</option>
                        <option value="part">Sparepart</option>
                        <option value="accessory">Aksesoris</option>
                        <option value="service">Jasa</option>
                    </select>
                    @error('type') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Harga -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Harga (Rp)</label>
                    <input wire:model="price" type="number"
                        class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none transition-all">
                    @error('price') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Berat -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Berat (Kg)</label>
                    <input wire:model="weight_kg" type="number" step="0.1"
                        class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none transition-all">
                    @error('weight_kg') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Gambar Add-on -->
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Gambar Add-on</label>

                <div class="flex items-start gap-4">
                    <!-- Preview -->
                    <div
                        class="w-32 h-32 bg-slate-100 dark:bg-slate-800 rounded-xl overflow-hidden border border-slate-200 dark:border-slate-700 flex items-center justify-center relative group">
                        @if ($image)
                            <img src="{{ $image->temporaryUrl() }}" class="w-full h-full object-cover">
                        @elseif ($image_url)
                            <img src="{{ asset('storage/' . $image_url) }}" class="w-full h-full object-cover">
                        @else
                            <i class="fas fa-cube text-3xl text-slate-300"></i>
                        @endif

                        <!-- Loading Indicator -->
                        <div wire:loading wire:target="image"
                            class="absolute inset-0 bg-black/50 flex items-center justify-center">
                            <i class="fas fa-spinner fa-spin text-white"></i>
                        </div>
                    </div>

                    <!-- Input -->
                    <div class="flex-1">
                        <input wire:model="image" type="file" accept="image/*" class="block w-full text-sm text-slate-500
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-xl file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-brand-50 file:text-brand-700
                                      hover:file:bg-brand-100
                                      transition-all">
                        <p class="text-xs text-slate-500 mt-2">Format: JPG, PNG. Maks: 2MB.</p>
                        @error('image') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Deskripsi</label>
                <textarea wire:model="description" rows="3"
                    class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none transition-all"></textarea>
                @error('description') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Submit Button -->
            <div class="pt-4 flex justify-end">
                <button type="submit" wire:loading.attr="disabled"
                    class="px-6 py-2.5 bg-brand-500 text-white rounded-xl font-bold hover:bg-brand-600 transition-all shadow-lg shadow-brand-500/20 flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span wire:loading.remove><i class="fas fa-save"></i> Simpan Add-on</span>
                    <span wire:loading><i class="fas fa-spinner fa-spin"></i> Menyimpan...</span>
                </button>
            </div>
        </form>
    </div>
</div>