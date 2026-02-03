<div class="space-y-6">
    
    <!-- Packages Section -->
    <section class="space-y-3">
        <h2 class="text-base md:text-lg font-bold text-white flex items-center gap-2">
            <i class="fas fa-box text-orange-500"></i> Paket Usaha
        </h2>
        
        <div class="space-y-3">
            @if(empty($selectedPackages))
                 <div class="bg-gray-900 border border-dashed border-gray-700 rounded-xl p-6 text-center">
                    <i class="fas fa-box-open text-3xl text-gray-700 mb-2"></i>
                    <p class="text-gray-400 text-sm">Belum ada paket dipilih.</p>
                 </div>
            @else
                @foreach($selectedPackages as $index => $pkg)
                    @php
                        $packageModel = $allPackages->firstWhere('id', $pkg['id']);
                        $imageUrl = null;
                        if ($packageModel && $packageModel->image_url) {
                            $imageUrl = $packageModel->image_url;
                            if (!\Illuminate\Support\Str::startsWith($imageUrl, ['/storage', 'http', 'https'])) {
                                $imageUrl = \Illuminate\Support\Facades\Storage::url($imageUrl);
                            }
                        }
                    @endphp
                    <div class="bg-gray-900 rounded-xl p-3 md:p-4 border border-gray-800 flex items-center gap-3 md:gap-4">
                        <!-- Package Image -->
                        <div class="w-16 h-16 md:w-20 md:h-20 bg-gray-800 rounded-lg flex items-center justify-center flex-shrink-0 overflow-hidden">
                            @if($imageUrl)
                                <img src="{{ asset($imageUrl) }}" alt="{{ $pkg['name'] }}" class="w-full h-full object-contain p-1">
                            @else
                                @php
                                    $extension = in_array($pkg['slug'], ['drift', 'offroad', 'stunt']) ? 'svg' : 'webp';
                                    $imgName = 'paket-' . $pkg['slug'] . '.' . $extension;
                                    if ($pkg['slug'] == 'alat-berat-mix') $imgName = 'paket-alatberat-mix.webp';
                                @endphp
                                <img src="{{ asset('assets/img/' . $imgName) }}" 
                                    onerror="this.onerror=null; this.src='{{ asset('assets/img/rcgo.webp') }}'"
                                    alt="{{ $pkg['name'] }}" class="w-full h-full object-contain p-1">
                            @endif
                        </div>
                        
                        <div class="flex-1 min-w-0">
                            <h3 class="text-sm md:text-base font-bold text-white truncate">{{ $pkg['name'] }}</h3>
                            <p class="text-orange-500 font-bold text-sm md:text-lg">Rp {{ number_format($pkg['price'], 0, ',', '.') }}</p>
                        </div>

                        <!-- Qty Control -->
                        <div class="flex items-center gap-1 bg-black rounded-lg p-0.5 border border-gray-700">
                            <button wire:click="decrementPackage({{ $index }})" class="w-7 h-7 md:w-8 md:h-8 rounded flex items-center justify-center text-gray-400 hover:text-white hover:bg-gray-800 transition-colors">
                                <i class="fas fa-minus text-[10px]"></i>
                            </button>
                            <span class="font-bold text-white w-5 text-center text-sm">{{ $pkg['qty'] }}</span>
                            <button wire:click="incrementPackage({{ $index }})" class="w-7 h-7 md:w-8 md:h-8 rounded flex items-center justify-center text-gray-400 hover:text-white hover:bg-gray-800 transition-colors">
                                <i class="fas fa-plus text-[10px]"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            @endif
             @error('packages') <span class="text-red-500 text-xs block">{{ $message }}</span> @enderror
        </div>

        <!-- Add More Packages -->
        <div x-data="{ open: false }">
            <button @click="open = !open" 
                class="w-full py-2.5 rounded-lg border border-dashed border-gray-700 text-center text-gray-400 hover:border-orange-500 hover:text-orange-500 transition-all font-medium text-sm">
                <span x-text="open ? 'Tutup' : '+ Tambah Paket Lain'"></span>
            </button>
            
            <div x-show="open" x-collapse class="mt-3 grid grid-cols-2 md:grid-cols-3 gap-2">
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
                    <div class="bg-gray-900 p-2 md:p-3 rounded-lg border border-gray-800 cursor-pointer hover:border-orange-500 transition-colors"
                         wire:click="addPackage({{ $pkg->id }})"
                         @click="open = false">
                        <div class="w-full h-12 md:h-14 bg-gray-800 rounded-md mb-2 overflow-hidden flex items-center justify-center">
                            @if($imgUrl)
                                <img src="{{ asset($imgUrl) }}" alt="{{ $pkg->name }}" class="h-full object-contain">
                            @else
                                <i class="fas fa-box text-gray-600"></i>
                            @endif
                        </div>
                        <h4 class="text-white font-bold text-xs md:text-sm truncate">{{ $pkg->name }}</h4>
                        <p class="text-orange-500 text-xs font-bold">Rp {{ number_format($pkg->price / 1000000, 1) }} Jt</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Addons Section -->
    <section class="space-y-3">
        <h2 class="text-base md:text-lg font-bold text-white flex items-center gap-2">
            <i class="fas fa-puzzle-piece text-orange-500"></i> Tambahan 
            <span class="text-xs font-normal text-gray-500">(Optional)</span>
        </h2>
        
        <!-- Add-ons Grid - Visible on ALL devices -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
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
                <div class="bg-gray-900 rounded-xl p-3 border transition-all {{ $isSelected ? 'border-orange-500 bg-orange-500/5' : 'border-gray-800 hover:border-gray-700' }}">
                    <!-- Addon Image -->
                    <div class="w-full h-16 md:h-20 bg-gray-800 rounded-lg mb-2 overflow-hidden flex items-center justify-center">
                        @if($addonImageUrl)
                            <img src="{{ asset($addonImageUrl) }}" alt="{{ $addon->name }}" class="h-full object-contain p-1">
                        @else
                            <i class="fas fa-puzzle-piece text-2xl text-gray-600"></i>
                        @endif
                    </div>
                    
                    <div class="mb-2">
                        <h4 class="text-white font-bold text-xs md:text-sm truncate">{{ $addon->name }}</h4>
                        <p class="text-orange-400 text-xs md:text-sm font-bold">Rp {{ number_format($addon->price, 0, ',', '.') }}</p>
                    </div>
                    
                    @if($isSelected)
                        <div class="flex items-center justify-between">
                            <span class="text-[9px] text-green-500 font-bold uppercase">Added</span>
                            <div class="flex items-center gap-1 bg-black rounded-lg p-0.5 border border-gray-700">
                                <button wire:click="decrementAddon({{ $addon->id }})" class="w-6 h-6 rounded flex items-center justify-center text-gray-400 hover:text-white hover:bg-gray-800">
                                    <i class="fas fa-minus text-[10px]"></i>
                                </button>
                                <span class="text-white text-xs font-bold w-4 text-center">{{ $qty }}</span>
                                <button wire:click="incrementAddon({{ $addon->id }})" class="w-6 h-6 rounded flex items-center justify-center text-gray-400 hover:text-white hover:bg-gray-800">
                                    <i class="fas fa-plus text-[10px]"></i>
                                </button>
                            </div>
                        </div>
                    @else
                        <button wire:click="toggleAddon({{ $addon->id }})" class="w-full py-1.5 bg-gray-800 hover:bg-gray-700 text-gray-300 text-xs font-bold rounded-lg transition-colors">
                            + Tambah
                        </button>
                    @endif
                </div>
            @endforeach
        </div>
    </section>

</div>
