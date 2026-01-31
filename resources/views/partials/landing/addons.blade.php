<!-- SECTION: ADD-ONS & AKSESORIS -->
<section id="addons" class="py-16 md:py-24 bg-gray-950">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
            Tingkatkan <span class="text-orange-500">Potensi Usaha</span> Anda
        </h2>
        <p class="text-gray-300 text-lg max-w-3xl mx-auto mb-12">
            Tambahkan aksesoris dan fasilitas pendukung untuk memaksimalkan pengalaman pelanggan dan keuntungan
            bisnis Anda.
        </p>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-6">
            @foreach($addons as $addon)
                <div
                    class="bg-gray-900 p-4 rounded-xl shadow-lg text-left border border-gray-800 hover:border-orange-500 transition-all duration-300 flex flex-col h-full group">

                    <div class="relative mb-3">
                        <img src="{{ asset('assets/img/addon-' . \Illuminate\Support\Str::slug($addon->name) . '.webp') }}"
                            onerror="this.src='{{ asset("assets/img/rcgo.webp") }}'" alt="{{ $addon->name }}"
                            class="w-full h-32 md:h-40 object-contain rounded-lg bg-gray-950/50 p-2">
                        <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <span class="bg-orange-500 text-white text-[10px] font-bold px-2 py-1 rounded-full shadow-lg">
                                {{ $addon->type == 'track' ? 'Track' : 'Unit' }}
                            </span>
                        </div>
                    </div>

                    <h3 class="text-sm md:text-base font-bold text-white mb-1 line-clamp-1" title="{{ $addon->name }}">
                        {{ $addon->name }}
                    </h3>

                    <p class="text-gray-500 text-xs mb-3 flex-grow line-clamp-2 leading-relaxed">
                        {{ $addon->description }}
                    </p>

                    <div class="mt-auto">
                        <div class="mb-3">
                            <p class="text-gray-600 text-[10px] uppercase tracking-wider font-semibold">Harga</p>
                            <div class="text-base md:text-lg font-bold text-orange-400">Rp
                                {{ number_format($addon->price, 0, ',', '.') }}
                            </div>
                        </div>

                        <button onclick="addToCart('{{ $addon->id }}', '{{ $addon->name }}', {{ $addon->price }}, 'addon')"
                            class="w-full btn-primary py-2 rounded-lg text-white font-semibold text-xs md:text-sm hover:shadow-lg transition-all flex items-center justify-center gap-2 group-hover:scale-[1.02]">
                            <i class="fas fa-cart-plus"></i> <span class="hidden sm:inline">Tambah</span><span
                                class="sm:hidden">Beli</span>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <p class="text-gray-500 text-sm mt-8">
            <i class="fas fa-info-circle text-orange-500 mr-2"></i>
            Semua add-on bersifat opsional dan dapat ditambahkan kapan saja sesuai kebutuhan.
        </p>
    </div>
</section>