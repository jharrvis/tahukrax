<!-- MODALS FASILITAS -->
@php
    $modalData = [
        ['id' => 'drift', 'name' => 'Drift', 'img' => 'paket-drift.svg', 'price' => 'Rp 1,9 Jt', 'features' => ['5 Unit RC Drift Premium', '5 Remote Control', 'Charger & Baterai Ori', '5 Baterai Cadangan (Rakitan)', '30 Traffic Cones & Obeng Mini', 'Banner Eksklusif', 'Pelatihan Operasional (Free)', 'Strategi Bisnis & Perawatan (Free)']],
        ['id' => 'offroad', 'name' => 'Off-road', 'img' => 'paket-offroad.svg', 'price' => 'Rp 2,6 Jt', 'features' => ['5 Unit RC Offroad 4WD', '5 Remote Control', 'Charger & Baterai Ori', '5 Baterai Cadangan (Rakitan)', 'Power Supply Fast Charging', 'Banner Rental', 'Pelatihan Operasional (Free)', 'Strategi Bisnis & Perawatan (Free)']],
        ['id' => 'stunt', 'name' => 'Stunt', 'img' => 'paket-stunt.svg', 'price' => 'Rp 2,7 Jt', 'features' => ['5 Unit RC Stunt 4WD', '5 Remote Control', 'Charger & Baterai Ori', 'Baterai Cadangan (Rakitan)', 'Power Supply Fast Charging', 'Banner Rental', 'Pelatihan Operasional (Free)', 'Strategi Bisnis & Perawatan (Free)']],
        ['id' => 'mixcar', 'name' => 'Mix RC Car', 'img' => 'paket-mixcar.webp', 'price' => 'Rp 2,5 Jt', 'features' => ['5 Unit RC (Drift, Offroad, Stunt)', '5 Remote Control', 'Charger & Baterai Ori', 'Ban Serep (Khusus Drift)', 'Baterai Cadangan (Rakitan)', 'Banner & Alas Drift', 'Pelatihan Operasional (Free)', 'Strategi Bisnis & Perawatan (Free)']],
        ['id' => 'excavator', 'name' => 'Excavator', 'img' => 'paket-excavator.webp', 'price' => 'Rp 3,2 Jt', 'features' => ['5 Unit RC Excavator Premium', '5 Remote Control', 'Charger & Baterai Ori', 'Baterai Cadangan (Rakitan)', 'Fast Charging Power Supply', 'Banner Eksklusif', 'Pelatihan Operasional (Free)', 'Strategi Bisnis & Perawatan (Free)']],
        ['id' => 'alatberat', 'name' => 'Alat Berat Mix', 'img' => 'paket-alatberat-mix.webp', 'price' => 'Rp 3,7 Jt', 'features' => ['5 Unit Mix (Excavator, Truck, Dozer)', '5 Remote Control', 'Baterai Original & Rakitan', 'Fast Charger (10 Baterai)', 'Banner Rental', 'Pelatihan Operasional (Free)', 'Strategi Bisnis & Perawatan (Free)']],
    ];
@endphp

@foreach($modalData as $m)
    <div id="modal-{{ $m['id'] }}" class="fixed inset-0 bg-black/80 z-[60] hidden items-center justify-center p-4">
        <div class="bg-gray-900 rounded-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto border border-gray-700">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-white">Fasilitas Paket {{ $m['name'] }}</h3>
                    <button onclick="closeModal('modal-{{ $m['id'] }}')"
                        class="text-gray-400 hover:text-white text-2xl">&times;</button>
                </div>
                <img src="{{ asset('assets/img/' . $m['img']) }}" alt="Paket {{ $m['name'] }}"
                    class="w-full h-40 object-contain mb-4">
                <p class="text-orange-500 font-bold text-2xl mb-4">{{ $m['price'] }}</p>
                <h4 class="text-white font-semibold mb-3">Yang Anda Dapatkan:</h4>
                <ul class="space-y-2 text-gray-300 text-sm mb-6">
                    @foreach($m['features'] as $f)
                        <li class="flex items-start gap-2"><i class="fas fa-check text-orange-500 mt-1"></i> {{ $f }}</li>
                    @endforeach
                </ul>
                <a href="{{ route('checkout.cart') }}"
                    onclick="if(window.RCGOCart) RCGOCart.set({ slug: '{{ $m['id'] }}', name: '{{ $m['name'] }}', price: {{ (int) preg_replace('/[^0-9]/', '', $m['price']) * 1000 }} })"
                    class="w-full btn-primary py-3 rounded-full text-white font-semibold text-center block">
                    <i class="fas fa-cart-plus mr-1"></i> Beli Sekarang
                </a>
            </div>
        </div>
    </div>
@endforeach