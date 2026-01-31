<div>
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <a href="{{ route('admin.partners.index') }}" class="text-slate-400 hover:text-slate-600">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h1 class="text-2xl font-bold tracking-tight">Detail Mitra: {{ $partnership->outlet_name }}</h1>
            </div>
            <p class="text-slate-500 text-sm ml-7">Kode Mitra: <span
                    class="font-mono font-bold">{{ $partnership->partnership_code }}</span> | Bergabung:
                {{ $partnership->joined_at ? \Carbon\Carbon::parse($partnership->joined_at)->format('d M Y') : '-' }}
            </p>
        </div>

        <div class="flex items-center gap-2 ml-7 md:ml-0">
            <span
                class="px-3 py-1 rounded-full text-sm font-bold uppercase {{ $this->getStatusColor($partnership->status) }}">
                {{ $partnership->status }}
            </span>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 border border-green-200 text-green-700 rounded-xl flex items-center gap-3">
            <i class="fas fa-check-circle"></i> {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Left Column: Outlet & Owner Info -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Outlet Information -->
            <div
                class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm p-6">
                <h3 class="font-bold text-lg mb-4">Informasi Outlet</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs text-slate-500 mb-1">Nama Outlet</p>
                        <p class="font-medium text-slate-800 dark:text-slate-200">{{ $partnership->outlet_name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 mb-1">Nama Penerima</p>
                        <p class="font-medium text-slate-800 dark:text-slate-200">{{ $partnership->recipient_name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 mb-1">Nomor Telepon</p>
                        <p class="font-medium text-slate-800 dark:text-slate-200">{{ $partnership->phone_number }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-xs text-slate-500 mb-1">Alamat Lengkap</p>
                        <p class="font-medium text-slate-800 dark:text-slate-200">{{ $partnership->address }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 mb-1">Kota</p>
                        <p class="font-medium text-slate-800 dark:text-slate-200">{{ $partnership->city }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 mb-1">Provinsi</p>
                        <p class="font-medium text-slate-800 dark:text-slate-200">{{ $partnership->province }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 mb-1">Kode Pos</p>
                        <p class="font-medium text-slate-800 dark:text-slate-200">{{ $partnership->postal_code }}</p>
                    </div>
                </div>
            </div>

            <!-- Package Info -->
            <div
                class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm p-6">
                <h3 class="font-bold text-lg mb-4">Paket Usaha Saat Ini</h3>
                <div class="flex gap-4">
                    <div class="w-20 h-20 bg-slate-100 rounded-xl overflow-hidden shrink-0">
                        @if($partnership->package->image_url)
                            <img src="{{ $partnership->package->image_url }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                <i class="fas fa-box text-2xl"></i>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800 dark:text-slate-200">{{ $partnership->package->name }}</h4>
                        <p class="text-sm text-slate-500">{{ $partnership->package->description }}</p>
                    </div>
                </div>
            </div>

            <!-- Order History (Simple List) -->
            <div
                class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm p-6">
                <h3 class="font-bold text-lg mb-4">Riwayat Pesanan</h3>
                @if($partnership->orders->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead>
                                <tr class="text-slate-500 border-b border-slate-100">
                                    <th class="py-2">ID</th>
                                    <th class="py-2">Tanggal</th>
                                    <th class="py-2">Total</th>
                                    <th class="py-2">Status</th>
                                    <th class="py-2 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($partnership->orders->take(5) as $order)
                                    <tr class="border-b border-slate-50 last:border-0 hover:bg-slate-50 transition-colors">
                                        <td class="py-3 font-mono">#{{ $order->id }}</td>
                                        <td class="py-3">{{ $order->created_at->format('d/m/Y') }}</td>
                                        <td class="py-3">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                        <td class="py-3">
                                            <span
                                                class="text-xs uppercase font-bold {{ $order->status == 'completed' ? 'text-green-600' : 'text-slate-500' }}">
                                                {{ $order->status }}
                                            </span>
                                        </td>
                                        <td class="py-3 text-right">
                                            <a href="{{ route('admin.orders.show', $order) }}"
                                                class="text-brand-500 hover:text-brand-600 text-xs font-bold">Lihat</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-slate-500 text-sm">Belum ada riwayat pesanan.</p>
                @endif
            </div>
        </div>

        <!-- Right Column: Actions & Details -->
        <div class="space-y-8">
            <!-- Update Status Actions -->
            <div
                class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm p-6">
                <h3 class="font-bold text-lg mb-4">Update Status Mitra</h3>
                <form wire:submit="updateStatus" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Status Kemitraan</label>
                        <select wire:model="status"
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none">
                            <option value="active">Active (Aktif)</option>
                            <option value="inactive">Inactive (Non-Aktif)</option>
                            <option value="pending">Pending</option>
                        </select>
                        <p class="text-xs text-slate-500 mt-2">
                            <i class="fas fa-info-circle"></i> Status 'Active' memungkinkan mitra melakukan order
                            restock.
                        </p>
                    </div>

                    <button type="submit" wire:loading.attr="disabled"
                        class="w-full py-2 bg-brand-500 hover:bg-brand-600 text-white font-bold rounded-xl transition-all shadow-lg shadow-brand-500/20 disabled:opacity-50">
                        <span wire:loading.remove>Update Status</span>
                        <span wire:loading>Updating...</span>
                    </button>
                </form>
            </div>

            <!-- Owner Info -->
            <div
                class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm p-6">
                <h3 class="font-bold text-lg mb-4">Pemilik (User)</h3>
                <div class="flex items-center gap-3 mb-4">
                    <div
                        class="w-10 h-10 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center font-bold">
                        {{ substr($partnership->user->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="font-bold text-sm">{{ $partnership->user->name }}</p>
                        <p class="text-xs text-slate-500">{{ $partnership->user->email }}</p>
                    </div>
                </div>
                <div class="text-xs text-slate-400">
                    Terdaftar sejak: {{ $partnership->user->created_at->format('d M Y') }}
                </div>
            </div>
        </div>
    </div>
</div>