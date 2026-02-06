<div class="relative w-full sm:w-64" x-data="{ focused: false }" @click.away="focused = false">
    <div class="relative">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
            <i class="fas fa-search"></i>
        </span>
        <input wire:model.live.debounce.300ms="search" @focus="focused = true" type="text" placeholder="Cari data..."
            class="w-full pl-10 pr-4 py-2 bg-slate-100 dark:bg-slate-800 border-none rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all">

        <div wire:loading wire:target="search" class="absolute inset-y-0 right-0 flex items-center pr-3">
            <i class="fas fa-circle-notch fa-spin text-brand-500 text-xs"></i>
        </div>
    </div>

    @if(strlen($search) >= 2 && (count($results) > 0 || strlen($search) > 0))
        <div x-show="focused" x-transition
            class="absolute top-full mt-2 left-0 w-full md:w-80 bg-white dark:bg-slate-900 rounded-xl shadow-xl border border-slate-100 dark:border-slate-800 overflow-hidden z-50"
            style="display: none;">
            @if(count($results) > 0)
                <div class="max-h-80 overflow-y-auto custom-scrollbar">
                    @foreach($results as $result)
                        <a href="{{ $result['url'] }}"
                            class="block px-4 py-3 hover:bg-slate-50 dark:hover:bg-slate-800 border-b border-slate-50 dark:border-slate-800 last:border-0 transition-colors">
                            <div class="flex items-start gap-3">
                                <div
                                    class="w-8 h-8 rounded-lg bg-brand-50 dark:bg-slate-800 text-brand-500 flex items-center justify-center shrink-0">
                                    <i class="{{ $result['icon'] }} text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-0.5">
                                        {{ $result['type'] }}</p>
                                    <p class="text-sm font-semibold text-slate-800 dark:text-slate-200">{{ $result['title'] }}</p>
                                    @if(!empty($result['subtitle']))
                                        <p class="text-xs text-slate-500 truncate">{{ $result['subtitle'] }}</p>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="p-4 text-center text-slate-500 text-sm">
                    <i class="far fa-sad-tear text-xl mb-2 opacity-50 block"></i>
                    Tidak ada hasil ditemukan.
                </div>
            @endif
        </div>
    @endif
</div>