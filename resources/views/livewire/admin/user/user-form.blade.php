<div>
    <div class="mb-8">
        <h1 class="text-2xl font-bold tracking-tight">{{ $user ? 'Edit Pengguna' : 'Tambah Pengguna Baru' }}</h1>
        <p class="text-slate-500 text-sm mt-1">Silakan isi form di bawah ini.</p>
    </div>

    <div class="max-w-3xl">
        <form wire:submit="save"
            class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800 shadow-sm space-y-6">

            <!-- Nama -->
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Nama Lengkap</label>
                <input type="text" wire:model="name"
                    class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none transition-all">
                @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Email</label>
                <input type="email" wire:model="email"
                    class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none transition-all">
                @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Role -->
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Role / Hak
                    Akses</label>
                <div class="grid grid-cols-2 gap-4">
                    <label class="cursor-pointer relative">
                        <input type="radio" wire:model.live="role" value="mitra" class="peer sr-only">
                        <div
                            class="p-4 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 peer-checked:border-brand-500 peer-checked:bg-white dark:peer-checked:bg-slate-900 peer-checked:ring-2 peer-checked:ring-brand-500 transition-all text-center">
                            <span class="block font-bold">Mitra</span>
                            <span class="text-xs text-slate-500">Akses terbatas dashboard mitra</span>
                        </div>
                    </label>
                    <label class="cursor-pointer relative">
                        <input type="radio" wire:model.live="role" value="admin" class="peer sr-only">
                        <div
                            class="p-4 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 peer-checked:border-brand-500 peer-checked:bg-white dark:peer-checked:bg-slate-900 peer-checked:ring-2 peer-checked:ring-brand-500 transition-all text-center">
                            <span class="block font-bold">Admin</span>
                            <span class="text-xs text-slate-500">Akses penuh sistem admin</span>
                        </div>
                    </label>
                </div>
                @error('role') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Password -->
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                    Password {{ $user ? '(Opsional)' : '' }}
                </label>
                <input type="password" wire:model="password"
                    placeholder="{{ $user ? 'Biarkan kosong jika tidak ingin mengubah password' : 'Masukkan password minimal 8 karakter' }}"
                    class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none transition-all">
                @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="pt-4 flex justify-between items-center">
                <a href="{{ route('admin.users.index') }}"
                    class="text-slate-500 hover:text-slate-700 font-medium text-sm">Kembali</a>
                <button type="submit" wire:loading.attr="disabled"
                    class="px-6 py-2.5 bg-brand-500 hover:bg-brand-600 disabled:opacity-50 text-white font-bold rounded-xl shadow-lg shadow-brand-500/30 transition-all flex items-center">
                    <span wire:loading.remove><i class="fas fa-save mr-2"></i> Simpan Data</span>
                    <span wire:loading><i class="fas fa-spinner fa-spin mr-2"></i> Menyimpan...</span>
                </button>
            </div>
        </form>
    </div>
</div>