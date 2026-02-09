<div class="space-y-6" x-data="{ 
    modalOpen: false, 
    modalImage: '', 
    modalTitle: '',
    openModal(img, title) {
        this.modalImage = img;
        this.modalTitle = title;
        this.modalOpen = true;
    }
}">
    
    <!-- Image Modal -->
    <div x-show="modalOpen" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[200] flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm"
        @click.self="modalOpen = false" @keydown.escape.window="modalOpen = false" x-cloak>
        <div class="relative max-w-3xl w-full bg-white rounded-2xl overflow-hidden shadow-2xl border border-gray-200">
            <button @click="modalOpen = false" class="absolute top-3 right-3 w-10 h-10 bg-white/50 hover:bg-white rounded-full flex items-center justify-center text-gray-800 z-10 shadow-md transition-colors">
                <i class="fas fa-times"></i>
            </button>
            <img :src="modalImage" :alt="modalTitle" class="w-full h-auto max-h-[70vh] object-contain bg-gray-50">
            <div class="p-4 text-center bg-white border-t border-gray-100">
                <h3 class="text-gray-900 font-bold text-lg" x-text="modalTitle"></h3>
            </div>
        </div>
    </div>

    <!-- Packages Section -->
    <section class="space-y-3">
        <h2 class="text-base md:text-lg font-bold text-gray-800 flex items-center gap-2">
            <i class="fas fa-box text-orange-600"></i> Paket Usaha
        </h2>
        
        <div class="space-y-3">
            @if(empty($selectedPackages))
                 <div class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-xl p-8 text-center hover:border-orange-300 transition-colors group">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-3 shadow-sm group-hover:scale-110 transition-transform">
                        <i class="fas fa-box-open text-3xl text-orange-200 group-hover:text-orange-500 transition-colors"></i>
                    </div>
                    <p class="text-gray-500 text-sm font-medium">Belum ada paket dipilih.</p>
                    <p class="text-gray-400 text-xs mt-1">Silakan pilih paket dari daftar di bawah.</p>
                 </div>
            @else
                @foreach($selectedPackages as $index => $pkg)
                    @php
                        $packageModel = $allPackages->firstWhere('id', $pkg['id']);
                        $imageUrl = null;
                        $imageSrc = asset('img/tahukrax.webp'); // default
                        
                        if ($packageModel && $packageModel->image_url) {
                            $imageUrl = $packageModel->image_url;
                            if (!\Illuminate\Support\Str::startsWith($imageUrl, ['/storage', 'http', 'https'])) {
                                $imageUrl = \Illuminate\Support\Facades\Storage::url($imageUrl);
                            }
                            $imageSrc = asset($imageUrl);
                        } else {
                            $extension = in_array($pkg['slug'], ['drift', 'offroad', 'stunt']) ? 'svg' : 'webp';
                            $imgName = 'paket-' . $pkg['slug'] . '.' . $extension;
                            if ($pkg['slug'] == 'alat-berat-mix') $imgName = 'paket-alatberat-mix.webp';
                            $imageSrc = asset('assets/img/' . $imgName);
                        }
                    @endphp
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden md:flex hover:shadow-md transition-all">
                        <!-- Package Image - Left side on desktop, clickable -->
                        <div class="w-full md:w-32 lg:w-40 h-32 md:h-auto bg-gray-50 cursor-pointer relative group flex-shrink-0 border-b md:border-b-0 md:border-r border-gray-100"
                             @click="openModal('{{ $imageSrc }}', '{{ $pkg['name'] }}')">
                            <img src="{{ $imageSrc }}" 
                                onerror="this.onerror=null; this.src='{{ asset('img/tahukrax.webp') }}'"
                                alt="{{ $pkg['name'] }}" 
                                class="w-full h-full object-contain p-4 group-hover:scale-110 transition-transform duration-300">
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/5 transition-colors flex items-center justify-center">
                                <i class="fas fa-search-plus text-gray-800 opacity-0 group-hover:opacity-100 transition-opacity bg-white/80 p-2 rounded-full shadow-sm"></i>
                            </div>
                        </div>
                        
                        <!-- Package Info & Controls - Right side -->
                        <div class="p-4 flex-1 flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base md:text-lg font-bold text-gray-800 truncate mb-1">{{ $pkg['name'] }}</h3>
                                <p class="text-gray-500 text-xs md:text-sm hidden md:block">Paket lengkap siap usaha Tahu Krax</p>
                                <p class="text-orange-600 font-extrabold text-lg mt-2">Rp {{ number_format($pkg['price'], 0, ',', '.') }}</p>
                            </div>

                            <!-- Qty Control -->
                            <div class="flex items-center gap-1 bg-gray-50 rounded-lg p-1 border border-gray-200 shadow-sm">
                                <button wire:click="decrementPackage({{ $index }})" class="w-9 h-9 rounded-md flex items-center justify-center text-gray-500 hover:text-red-500 hover:bg-white hover:shadow-sm transition-all">
                                    <i class="fas fa-minus text-xs"></i>
                                </button>
                                <span class="font-bold text-gray-800 w-8 text-center text-sm">{{ $pkg['qty'] }}</span>
                                <button wire:click="incrementPackage({{ $index }})" class="w-9 h-9 rounded-md flex items-center justify-center text-gray-500 hover:text-green-500 hover:bg-white hover:shadow-sm transition-all">
                                    <i class="fas fa-plus text-xs"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
             @error('packages') <span class="text-red-500 text-xs block">{{ $message }}</span> @enderror
        </div>

        <!-- Add More Packages -->
        <div x-data="{ open: false }">
            <button @click="open = !open" 
                class="w-full py-3 rounded-xl border border-dashed border-gray-300 text-center text-gray-500 hover:border-orange-500 hover:text-orange-600 hover:bg-orange-50 transition-all font-medium text-sm flex items-center justify-center gap-2">
                <i class="fas" :class="open ? 'fa-chevron-up' : 'fa-plus'"></i>
                <span x-text="open ? 'Tutup Pilihan Paket' : 'Tambah Paket Lain'"></span>
            </button>
            
            <div x-show="open" x-collapse class="mt-4 grid grid-cols-2 gap-3">
                @foreach($allPackages as $pkg)
                    @php
                        $imgUrl = null;
                        if ($pkg->image_url) {
                            $imgUrl = $pkg->image_url;
                            if (!\Illuminate\Support\Str::startsWith($imgUrl, ['/storage', 'http', 'https'])) {
                                $imgUrl = \Illuminate\Support\Facades\Storage::url($imgUrl);
                            }
                        }
                    @endphp
                    <div class="bg-white rounded-xl border border-gray-200 hover:border-orange-500 hover:shadow-md transition-all flex flex-col items-center gap-2 p-3 cursor-pointer group text-center h-full"
                         wire:click="addPackage({{ $pkg->id }})"
                         @click="open = false">
                        <!-- Image Top -->
                        <div class="w-full h-20 bg-gray-50 rounded-lg overflow-hidden flex-shrink-0 flex items-center justify-center border border-gray-100 group-hover:border-orange-200">
                            @if($imgUrl)
                                <img src="{{ asset($imgUrl) }}" alt="{{ $pkg->name }}" class="h-full object-contain p-1 group-hover:scale-110 transition-transform">
                            @else
                                <i class="fas fa-box text-gray-300 text-2xl"></i>
                            @endif
                        </div>
                        <!-- Name & Price Bottom -->
                        <div class="w-full min-w-0">
                            <h4 class="text-gray-800 font-bold text-xs truncate group-hover:text-orange-600 transition-colors">{{ $pkg->name }}</h4>
                            <p class="text-orange-500 text-[10px] font-bold">Rp {{ number_format($pkg->price / 1000000, 1) }} Jt</p>
                        </div>
                        <!-- Add Button Overlay or Bottom -->
                        <div class="w-full py-1 bg-gray-50 text-gray-400 group-hover:bg-orange-500 group-hover:text-white rounded text-[10px] font-bold transition-colors">
                            + Tambah
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Addons Section -->
    <section class="space-y-3 pt-4 border-t border-gray-100">
        <h2 class="text-base md:text-lg font-bold text-gray-800 flex items-center gap-2">
            <i class="fas fa-puzzle-piece text-orange-500"></i> Add-on
            <span class="text-xs font-normal text-gray-500 bg-gray-100 px-2 py-0.5 rounded-full">Opsional</span>
        </h2>
        
        <!-- Add-ons Grid - Visible on ALL devices -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($allAddons as $addon)
                @php 
                    $isSelected = isset($selectedAddons[$addon->id]);
                    $qty = $isSelected ? $selectedAddons[$addon->id] : 0;
                    
                    // Get addon image
                    $addonImageUrl = null;
                    if ($addon->image_url) {
                        $addonImageUrl = $addon->image_url;
                        if (!\Illuminate\Support\Str::startsWith($addonImageUrl, ['/storage', 'http', 'https'])) {
                            $addonImageUrl = \Illuminate\Support\Facades\Storage::url($addonImageUrl);
                        }
                    }
                @endphp
                <div class="bg-white rounded-xl p-3 border transition-all shadow-sm hover:shadow-md {{ $isSelected ? 'border-orange-500 bg-orange-50' : 'border-gray-200 hover:border-orange-300' }}">
                    <!-- Addon Image -->
                    <div class="w-full h-24 bg-white rounded-lg mb-3 overflow-hidden flex items-center justify-center border border-gray-100">
                        @if($addonImageUrl)
                            <img src="{{ asset($addonImageUrl) }}" alt="{{ $addon->name }}" class="h-full object-contain p-2">
                        @else
                            <i class="fas fa-puzzle-piece text-3xl text-gray-200"></i>
                        @endif
                    </div>
                    
                    <div class="mb-3 text-center">
                        <h4 class="text-gray-800 font-bold text-xs md:text-sm truncate mb-1" title="{{ $addon->name }}">{{ $addon->name }}</h4>
                        <p class="text-orange-600 text-xs md:text-sm font-bold">Rp {{ number_format($addon->price, 0, ',', '.') }}</p>
                    </div>
                    
                    @if($isSelected)
                        <div class="flex items-center gap-1 bg-white rounded-lg p-0.5 border border-gray-200 shadow-sm">
                            <button wire:click="decrementAddon({{ $addon->id }})" class="w-8 h-8 rounded flex items-center justify-center text-gray-400 hover:text-red-500 hover:bg-gray-50 transition-colors">
                                <i class="fas fa-minus text-[10px]"></i>
                            </button>
                            <span class="font-bold text-gray-800 flex-1 text-center text-sm">{{ $qty }}</span>
                            <button wire:click="incrementAddon({{ $addon->id }})" class="w-8 h-8 rounded flex items-center justify-center text-gray-400 hover:text-green-500 hover:bg-gray-50 transition-colors">
                                <i class="fas fa-plus text-[10px]"></i>
                            </button>
                        </div>
                    @else
                        <button wire:click="toggleAddon({{ $addon->id }})" class="w-full py-2 bg-gray-50 hover:bg-orange-500 hover:text-white text-gray-600 text-xs font-bold rounded-lg transition-all shadow-sm">
                            + Tambah
                        </button>
                    @endif
                </div>
            @endforeach
        </div>
    </section>

</div>
