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
            @php
                $pakets = [
                    [
                        'id' => 'drift',
                        'name' => 'Drift',
                        'img' => 'paket-drift.svg',
                        'desc' => 'Mobil RC drift dengan handling presisi. Cocok untuk area indoor dengan permukaan halus.',
                        'old_price' => 'Rp 3.800.000',
                        'price' => 'Rp 1,9 Jt',
                        'features' => ['5 Unit RC Drift Premium', 'Charger & Baterai Ori', '30 Traffic Cones', 'Banner Eksklusif']
                    ],
                    [
                        'id' => 'offroad',
                        'name' => 'Off-road',
                        'img' => 'paket-offroad.svg',
                        'desc' => 'Mobil RC off-road tangguh untuk segala medan. Ideal untuk area outdoor seperti taman dan lapangan.',
                        'old_price' => 'Rp 5.200.000',
                        'price' => 'Rp 2,6 Jt',
                        'features' => ['5 Unit RC Off-road 4WD', 'Charger & Baterai Ori', 'Power Supply Fast Charging', 'Banner Rental']
                    ],
                    [
                        'id' => 'stunt',
                        'name' => 'Stunt',
                        'img' => 'paket-stunt.svg',
                        'desc' => 'Mobil RC akrobatik dengan gerakan 360°. Paling diminati anak-anak untuk atraksi seru.',
                        'old_price' => 'Rp 5.400.000',
                        'price' => 'Rp 2,7 Jt',
                        'features' => ['5 Unit RC Stunt 4WD', 'Charger & Baterai Ori', 'Baterai Cadangan Rakitan', 'Banner Rental']
                    ],
                    [
                        'id' => 'mixcar',
                        'name' => 'Mix RC Car',
                        'img' => 'paket-mixcar.webp',
                        'desc' => 'Kombinasi berbagai jenis mobil RC (Drift, Off-road, Stunt). Lebih variatif untuk menarik pelanggan.',
                        'old_price' => 'Rp 5.000.000',
                        'price' => 'Rp 2,5 Jt',
                        'popular' => true,
                        'features' => ['5 Unit RC (Drift, Offroad, Stunt)', 'Charger & Baterai Ori', 'Ban Serep & Baterai Cadangan', 'Banner & Alas Drift']
                    ],
                    [
                        'id' => 'excavator',
                        'name' => 'Excavator',
                        'img' => 'paket-excavator.webp',
                        'desc' => 'RC Excavator dengan fungsi beko realistis. Unik dan edukatif, cocok untuk anak-anak.',
                        'old_price' => 'Rp 6.400.000',
                        'price' => 'Rp 3,2 Jt',
                        'features' => ['5 Unit RC Excavator Premium', 'Remote & Baterai Ori', 'Fast Charging Power Supply', 'Banner Eksklusif']
                    ],
                    [
                        'id' => 'alatberat',
                        'name' => 'Alat Berat Mix',
                        'img' => 'paket-alatberat-mix.webp',
                        'desc' => 'Kombinasi RC alat berat (Excavator, Bulldozer, Dump Truck). Tema konstruksi yang menarik.',
                        'old_price' => 'Rp 7.400.000',
                        'price' => 'Rp 3,7 Jt',
                        'features' => ['5 Unit Mix (Excavator, Truck, Dozer)', 'Baterai Ori & Rakitan', 'Fast Charger (10 Baterai)', 'Banner Rental']
                    ],
                ];
            @endphp

            @foreach($pakets as $p)
                <div
                    class="bg-gray-900 p-6 rounded-2xl shadow-lg text-left border {{ isset($p['popular']) ? 'border-2 border-orange-500 relative' : 'border-gray-800' }} hover:border-orange-500 transition-all duration-300 flex flex-col h-full group checker-bg">
                    @if(isset($p['popular']))
                        <span
                            class="absolute -top-3 left-1/2 -translate-x-1/2 bg-orange-500 text-white text-xs font-bold px-3 py-1 rounded-full">Populer</span>
                    @endif

                    <h3 class="text-xl font-bold text-white mb-4">
                        <img src="{{ asset('assets/img/' . $p['img']) }}" alt="Paket {{ $p['name'] }}"
                            class="w-full h-48 object-contain rounded-xl mb-2">
                    </h3>
                    <p class="text-gray-400 text-sm mb-4 flex-grow">{{ $p['desc'] }}</p>
                    <div class="mb-6">
                        <p class="text-gray-400 text-xs uppercase tracking-wider mb-1">Mulai Dari</p>
                        <p class="text-sm line-through text-gray-500">{{ $p['old_price'] }}</p>
                        <div class="text-3xl font-bold text-white">{{ $p['price'] }}</div>
                    </div>
                    <ul class="space-y-2 text-gray-300 text-sm mb-6">
                        @foreach($p['features'] as $f)
                            <li class="flex items-center gap-2"><i class="fas fa-check text-orange-500 text-xs"></i> {{ $f }}
                            </li>
                        @endforeach
                    </ul>
                    <div class="flex gap-3 mt-auto">
                        <button onclick="openModal('modal-{{ $p['id'] }}')"
                            class="flex-1 border border-orange-500 text-orange-500 px-4 py-2.5 rounded-full font-semibold text-sm hover:bg-orange-500/10 transition-all">
                            <i class="fas fa-list-ul mr-1"></i> Fasilitas
                        </button>
                        <a href="{{ route('checkout.cart') }}"
                            onclick="if(window.RCGOCart) RCGOCart.set({ slug: '{{ $p['id'] }}', name: '{{ $p['name'] }}', price: {{ (int) preg_replace('/[^0-9]/', '', $p['price']) * 1000 }} })"
                            class="flex-1 btn-primary px-4 py-2.5 rounded-full text-white font-semibold text-sm text-center hover:shadow-lg transition-all">
                            <i class="fas fa-cart-plus mr-1"></i> Beli Sekarang
                        </a>
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