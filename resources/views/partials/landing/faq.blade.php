<!-- SECTION 7: FAQ -->
<section class="py-16 md:py-24 bg-black">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
            Pertanyaan yang Sering <span class="text-orange-500">Diajukan</span>
        </h2>
        <p class="text-gray-300 text-lg max-w-3xl mx-auto mb-12">
            Temukan jawaban atas pertanyaan umum seputar bisnis rental RC GO dan bagaimana kami dapat membantu Anda.
        </p>

        <div class="max-w-3xl mx-auto space-y-4 text-left">
            @php
                $faqs = [
                    ['q' => 'Apakah paket usaha RC Go bisa langsung dijalankan?', 'a' => 'Ya. Paket usaha dasar <strong class="text-white">sudah siap dimainkan</strong> tanpa ADD-ON tambahan.'],
                    ['q' => 'Apakah saya harus langsung beli semua ADD-ON?', 'a' => 'Tidak. ADD-ON <strong class="text-white">bersifat opsional</strong> dan bisa ditambahkan kapan saja sesuai kebutuhan dan budget.'],
                    ['q' => 'Apakah usaha ini cocok untuk pemula?', 'a' => 'Sangat cocok. RC Go dirancang agar <strong class="text-white">mudah dijalankan tanpa pengalaman khusus</strong>.'],
                    ['q' => 'Bagaimana jika saya ingin upgrade atau menambah unit?', 'a' => 'Anda bisa melakukan upgrade atau penambahan unit <strong class="text-white">kapan saja</strong>, cukup hubungi tim RC Go.'],
                    ['q' => 'Apakah RC Go bisa untuk event atau pindah-pindah lokasi?', 'a' => 'Bisa. RC Go <strong class="text-white">fleksibel digunakan</strong> untuk event, CFD, mall, maupun usaha menetap.'],
                ];
            @endphp

            @foreach($faqs as $f)
                <div class="bg-gray-900 p-6 rounded-xl border border-gray-800">
                    <details class="group">
                        <summary
                            class="flex justify-between items-center font-bold text-white text-lg cursor-pointer list-none">
                            {{ $f['q'] }}
                            <span class="transition group-open:rotate-180">
                                <i class="fas fa-chevron-down text-orange-500"></i>
                            </span>
                        </summary>
                        <p class="text-gray-300 mt-4 leading-relaxed">
                            {!! $f['a'] !!}
                        </p>
                    </details>
                </div>
            @endforeach
        </div>
    </div>
</section>