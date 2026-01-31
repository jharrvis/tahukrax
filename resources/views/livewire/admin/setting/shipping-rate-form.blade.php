<div>
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">
                {{ $rateId ? 'Edit Tarif Pengiriman' : 'Tambah Tarif Pengiriman' }}
            </h1>
            <p class="text-slate-500 text-sm mt-1">Atur biaya pengiriman per kilogram.</p>
        </div>
        <a href="{{ route('admin.settings.shipping.index') }}"
            class="px-4 py-2 bg-white border border-slate-200 dark:border-slate-800 text-slate-600 rounded-xl text-sm font-medium hover:bg-slate-50 transition-all flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div
        class="max-w-2xl bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm p-6 md:p-8">
        <form wire:submit="save" class="space-y-6">

            <!-- Kota Tujuan -->
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Kota Tujuan</label>
                <input wire:model="destination_city" type="text"
                    class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none transition-all"
                    placeholder="Contoh: Jakarta Selatan">
                @error('destination_city') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Harga Per Kg -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Harga Per Kg
                        (Rp)</label>
                    <input wire:model="price_per_kg" type="number"
                        class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none transition-all">
                    @error('price_per_kg') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Minimal Berat -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Minimal Berat
                        (Kg)</label>
                    <input wire:model="minimum_weight" type="number" step="0.1"
                        class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none transition-all">
                    @error('minimum_weight') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-4 flex justify-end">
                <button type="submit" wire:loading.attr="disabled"
                    class="px-6 py-2.5 bg-brand-500 text-white rounded-xl font-bold hover:bg-brand-600 transition-all shadow-lg shadow-brand-500/20 flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span wire:loading.remove><i class="fas fa-save"></i> Simpan Tarif</span>
                    <span wire:loading><i class="fas fa-spinner fa-spin"></i> Menyimpan...</span>
                </button>
            </div>

        </form>
    </div>
</div>