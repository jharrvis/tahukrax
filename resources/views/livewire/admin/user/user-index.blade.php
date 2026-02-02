<div>
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">Daftar Pengguna</h1>
            <p class="text-slate-500 text-sm mt-1">Kelola data pengguna dan hak akses aplikasi.</p>
        </div>
        <a href="{{ route('admin.users.create') }}"
            class="inline-flex items-center px-4 py-2 bg-brand-500 hover:bg-brand-600 text-white text-sm font-bold rounded-xl transition-colors shadow-lg shadow-brand-500/30">
            <i class="fas fa-plus mr-2"></i> Tambah User
        </a>
    </div>

    <div
        class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
        <!-- Search & Filter -->
        <div class="p-4 border-b border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row gap-4">
            <div class="relative flex-1">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="fas fa-search"></i>
                </span>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama atau email..."
                    class="w-full pl-10 pr-4 py-2 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all">
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr
                        class="bg-slate-50 dark:bg-slate-800/50 text-slate-500 uppercase tracking-wider font-bold text-xs">
                        <th class="px-6 py-4">Nama</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Role</th>
                        <th class="px-6 py-4">Tanggal Gabung</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random"
                                        class="w-8 h-8 rounded-lg">
                                    <span class="font-medium">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-600 dark:text-slate-400">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                @if($user->role === 'admin')
                                    <span
                                        class="px-2.5 py-1 rounded-lg bg-purple-100 text-purple-600 text-xs font-bold dark:bg-purple-900/30 dark:text-purple-400">
                                        Admin
                                    </span>
                                @elseif($user->role === 'mitra')
                                    <span
                                        class="px-2.5 py-1 rounded-lg bg-blue-100 text-blue-600 text-xs font-bold dark:bg-blue-900/30 dark:text-blue-400">
                                        Mitra
                                    </span>
                                @else
                                    <span
                                        class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-600 text-xs font-bold dark:bg-slate-800 dark:text-slate-400">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-500">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end items-center gap-2">
                                    <a href="{{ route('admin.users.edit', $user) }}"
                                        class="p-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 rounded-lg text-slate-600 dark:text-slate-300 transition-colors">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button wire:click="delete({{ $user->id }})"
                                        wire:confirm="Yakin ingin menghapus user ini?"
                                        class="p-2 bg-red-50 hover:bg-red-100 dark:bg-red-900/20 dark:hover:bg-red-900/40 rounded-lg text-red-500 transition-colors disabled:opacity-50"
                                        {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                <i class="far fa-user text-4xl mb-3 opacity-20"></i>
                                <p>Belum ada data user ditemukan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
            <div class="p-4 border-t border-slate-100 dark:border-slate-800">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>