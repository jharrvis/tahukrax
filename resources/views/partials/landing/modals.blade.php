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

<!-- Validation Modals -->
<!-- 1. No Package Warning -->
<div id="modal-warning-package"
    class="fixed inset-0 bg-black/80 z-[80] hidden items-center justify-center p-4 backdrop-blur-sm">
    <div
        class="bg-gray-900 rounded-2xl max-w-sm w-full border border-orange-500/30 shadow-2xl transform scale-95 opacity-0 transition-all duration-300">
        <div class="p-6 text-center">
            <div
                class="w-16 h-16 bg-orange-500/10 rounded-full flex items-center justify-center mx-auto mb-4 border border-orange-500/20">
                <i class="fas fa-box-open text-3xl text-orange-500"></i>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">Pilih Paket Dulu!</h3>
            <p class="text-gray-400 text-sm mb-6">Anda belum memilih <b>Paket Usaha</b>. Silakan pilih paket yang sesuai
                kebutuhan bisnis Anda.</p>

            <button
                onclick="closeCustomModal('modal-warning-package'); document.getElementById('paket').scrollIntoView({behavior: 'smooth'}); closeCart();"
                class="w-full py-3 rounded-xl bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white shadow-lg shadow-orange-500/20 transition-all font-bold">
                Pilih Paket Sekarang
            </button>
        </div>
    </div>
</div>

<!-- 2. Upsell Add-on -->
<div id="modal-upsell-addon"
    class="fixed inset-0 bg-black/80 z-[80] hidden items-center justify-center p-4 backdrop-blur-sm">
    <div
        class="bg-gray-900 rounded-2xl max-w-sm w-full border border-blue-500/30 shadow-2xl transform scale-95 opacity-0 transition-all duration-300">
        <div class="p-6 text-center">
            <div
                class="w-16 h-16 bg-blue-500/10 rounded-full flex items-center justify-center mx-auto mb-4 border border-blue-500/20">
                <i class="fas fa-plug text-3xl text-blue-500"></i>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">Lupa Tambah Add-on?</h3>
            <p class="text-gray-400 text-sm mb-6">Baterai cadangan atau sparepart sangat penting untuk kelancaran
                operasional. Yakin tidak mau tambah?</p>

            <div class="flex flex-col gap-3">
                <button
                    onclick="closeCustomModal('modal-upsell-addon'); document.getElementById('addons').scrollIntoView({behavior: 'smooth'}); closeCart();"
                    class="w-full py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white shadow-lg shadow-blue-500/20 transition-all font-bold">
                    <i class="fas fa-plus-circle mr-2"></i> Lihat Add-on Dulu
                </button>
                <button onclick="window.location.href='/checkout'"
                    class="w-full py-3 rounded-xl border border-gray-700 text-gray-400 hover:text-white hover:bg-gray-800 transition-all font-medium text-sm">
                    Lanjut Checkout Saja &rarr;
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div id="confirm-modal"
    class="fixed inset-0 bg-black/80 z-[70] hidden items-center justify-center p-4 backdrop-blur-sm transition-opacity duration-300 opacity-0"
    x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

    <div class="bg-gray-900 rounded-2xl max-w-sm w-full border border-gray-700 shadow-2xl transform scale-95 transition-all duration-300"
        id="confirm-modal-content">
        <div class="p-6 text-center">
            <div class="w-16 h-16 bg-red-500/10 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-exclamation-triangle text-2xl text-red-500"></i>
            </div>
            <h3 class="text-xl font-bold text-white mb-2" id="confirm-title">Konfirmasi</h3>
            <p class="text-gray-400 text-sm mb-6" id="confirm-message">Apakah Anda yakin ingin melakukan tindakan ini?
            </p>

            <div class="flex gap-3 justify-center">
                <button onclick="closeConfirmModal(false)"
                    class="px-5 py-2.5 rounded-xl border border-gray-600 text-gray-300 hover:bg-gray-800 hover:text-white transition-colors text-sm font-medium">
                    Batal
                </button>
                <button id="confirm-yes-btn" onclick="closeConfirmModal(true)"
                    class="px-5 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white shadow-lg shadow-red-500/20 transition-all text-sm font-bold">
                    Ya, Bersihkan
                </button>
            </div>
        </div>
    </div>
</div>