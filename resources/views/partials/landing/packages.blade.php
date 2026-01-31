<!-- SECTION 6: PAKET USAHA -->
<section id="paket" class="py-16 md:py-24 bg-black">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
            Pilih <span class="text-orange-500">Paket Usaha</span> Anda
        </h2>
        <p class="text-gray-300 text-lg max-w-3xl mx-auto mb-12">
            Tersedia berbagai jenis paket RC sesuai kebutuhan dan target pasar Anda. Semua paket dilengkapi dengan
            pelatihan dan dukungan penuh.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($packages as $p)
                <div
                    class="bg-gray-900 p-6 rounded-2xl shadow-lg text-left border {{ $p->price >= 2500000 && $p->price <= 3000000 ? 'border-2 border-orange-500 relative' : 'border-gray-800' }} hover:border-orange-500 transition-all duration-300 flex flex-col h-full group checker-bg">
                    @if($p->price >= 2500000 && $p->price <= 3000000)
                        <span
                            class="absolute -top-3 left-1/2 -translate-x-1/2 bg-orange-500 text-white text-xs font-bold px-3 py-1 rounded-full">Populer</span>
                    @endif

                    <h3 class="text-xl font-bold text-white mb-4">
                        @php
                            $extension = in_array($p->slug, ['drift', 'offroad', 'stunt']) ? 'svg' : 'webp';
                            // Special case for mixcar and alatberat-mix because their slugs might differ slightly from filenames
                            $imgName = 'paket-' . $p->slug . '.' . $extension;
                            if ($p->slug == 'alat-berat-mix')
                                $imgName = 'paket-alatberat-mix.webp';
                        @endphp
                        <img src="{{ asset('assets/img/' . $imgName) }}"
                            onerror="this.src='{{ asset("assets/img/rcgo.webp") }}'" alt="Paket {{ $p->name }}"
                            class="w-full h-48 object-contain rounded-xl mb-2">
                    </h3>
                    <p class="text-gray-400 text-sm mb-4 flex-grow">{{ $p->description }}</p>
                    <div class="mb-6">
                        <p class="text-gray-400 text-xs uppercase tracking-wider mb-1">Mulai Dari</p>
                        <p class="text-sm line-through text-gray-500">Rp {{ number_format($p->price * 1.2, 0, ',', '.') }}
                        </p>
                        <div class="text-3xl font-bold text-white">Rp {{ number_format($p->price / 1000000, 1, ',', '.') }}
                            Jt</div>
                    </div>
                    <ul class="space-y-2 text-gray-300 text-sm mb-6">
                        @if($p->features && is_array($p->features))
                            @foreach($p->features as $f)
                                <li class="flex items-center gap-2"><i class="fas fa-check text-orange-500 text-xs"></i> {{ $f }}
                                </li>
                            @endforeach
                        @endif
                    </ul>
                    <div class="flex gap-2 mt-auto">
                        <button onclick="openModal('modal-{{ $p->slug }}')"
                            class="w-12 h-10 flex items-center justify-center border border-orange-500 text-orange-500 rounded-lg hover:bg-orange-500 hover:text-white transition-all"
                            title="Lihat Detail Fasilitas">
                            <i class="fas fa-list-ul"></i>
                        </button>
                        <button
                            onclick="addToCart('{{ $p->id }}', '{{ $p->name }}', {{ $p->price }}, 'package', '{{ $p->slug }}')"
                            class="flex-1 btn-primary h-10 rounded-lg text-white font-bold text-sm hover:shadow-lg transition-all flex items-center justify-center gap-2">
                            <i class="fas fa-cart-plus"></i> + Keranjang
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <p class="text-gray-500 text-sm mt-8">
            <i class="fas fa-info-circle text-orange-500 mr-2"></i>
            Hubungi kami untuk konsultasi paket yang sesuai dengan lokasi dan target pasar Anda.
        </p>
    </div>
</section>