<!-- SECTION 6: TESTIMONI -->
<section class="py-16 md:py-24 bg-gray-950 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
            Apa Kata <span class="text-orange-500">Mitra Kami?</span>
        </h2>
        <p class="text-gray-300 text-lg max-w-3xl mx-auto mb-12">
            Dengarkan pengalaman nyata dari para mitra RC GO yang telah sukses mengembangkan bisnis rental RC
            mereka.
        </p>

        <!-- SWIPER TESTIMONIALS -->
        <div class="swiper swiper-testimonials pb-12">
            <div class="swiper-wrapper">
                @php
                    $testis = [
                        ['name' => 'Andi', 'role' => 'Usaha RC di CFD', 'text' => 'Awalnya cuma coba satu unit drift. Ternyata ramai, anak-anak repeat terus. Sekarang sudah nambah unit dan pakai sistem timer.'],
                        ['name' => 'Rina', 'role' => 'Usaha RC Rumahan', 'text' => 'Saya pemula banget, tapi sistemnya gampang. ADD-ON bisa nyusul belakangan, jadi nggak berat di awal.'],
                        ['name' => 'Budi', 'role' => 'Event & Booth RC', 'text' => 'Asisten AI-nya bantu banget buat bikin caption dan promo. Jadi walau nggak jago marketing, tetap bisa posting.'],
                        ['name' => 'Dewi', 'role' => 'Event Sekolah & Komunitas', 'text' => 'Main di event sekolah, ternyata cepat muter. Anak-anak nggak cuma sekali main, tapi balik lagi. RC Go cukup bantu buat usaha harian.'],
                        ['name' => 'Yuni', 'role' => 'Usaha Keluarga', 'text' => 'Awalnya ragu karena belum pernah usaha mainan. Tapi ternyata sistemnya simpel dan gampang dijalanin.'],
                    ];
                @endphp

                @foreach($testis as $t)
                    <div class="swiper-slide h-auto">
                        <div
                            class="bg-gray-900 p-8 rounded-2xl shadow-lg text-left border border-gray-800 h-full flex flex-col">
                            <div class="flex items-center mb-6">
                                <div
                                    class="w-14 h-14 bg-orange-500/20 rounded-full flex items-center justify-center mr-4 shrink-0 border border-orange-500/30">
                                    <i class="fas fa-user text-orange-500 text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-white font-bold text-lg">{{ $t['name'] }}</p>
                                    <p class="text-gray-400 text-sm">{{ $t['role'] }}</p>
                                </div>
                            </div>
                            <p class="text-gray-300 leading-relaxed italic relative flex-grow">
                                <span class="text-orange-500 text-4xl absolute -top-4 -left-2 opacity-20">"</span>
                                {{ $t['text'] }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- Pagination -->
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>

<style>
    .swiper-pagination-bullet {
        background: #fff;
        opacity: 0.5;
    }

    .swiper-pagination-bullet-active {
        background: #FFA500 !important;
        opacity: 1;
    }
</style>