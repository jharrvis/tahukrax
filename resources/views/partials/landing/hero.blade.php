<!-- HERO_SECTION -->
<section id="hero"
    class="relative bg-gradient-to-br from-primary via-primary to-cell-800 text-white min-h-[90vh] flex items-center overflow-hidden">

    <!-- Hero Image (85% height, no styles) -->
    <div class="hidden lg:block absolute top-1/2 right-24 -translate-y-1/2 h-[85%] w-[45%]">
        <img src="{{ asset('assets/img/tahukrax.webp') }}" alt="Tahu Krax"
            class="w-full h-full object-contain object-right">
    </div>

    <div class="container mx-auto px-4 md:px-8 py-12 md:py-20 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
            <div class="fade-up text-center lg:text-left">
                <h1 class="text-5xl sm:text-6xl md:text-7xl font-black leading-tight mb-6">
                    {!! $contents['hero_title']['value'] ?? 'Renyah, Gurih,<br><span class="text-yellow-300">Untung Melimpah!</span>' !!}
                </h1>
                <p class="text-base md:text-lg max-w-xl mb-6 text-white/90 leading-relaxed mx-auto lg:mx-0">
                    {{ $contents['hero_desc']['value'] ?? 'Bukan sekadar jualan tahu, ini adalah "Mesin Uang" yang sudah kami siapkan kuncinya. Kamu tinggal buka pintu, goreng, dan terima pesanan!' }}
                </p>
                <div
                    class="inline-block bg-yellow-400 text-primary font-bold py-3 px-6 mb-8 text-lg md:text-xl shadow-lg">
                    Modal Cuma 1 jutaan, Untung sampai 400%
                </div>
                <div class="flex flex-row justify-center lg:justify-start gap-3 sm:gap-4 flex-wrap sm:flex-nowrap">
                    <a href="#packages"
                        class="bg-white text-primary hover:bg-yellow-400 hover:text-primary transition-all font-bold py-3 px-5 sm:py-4 sm:px-8 text-sm sm:text-lg shadow-xl hover-lift inline-block text-center rounded-full flex-1 sm:flex-none">
                        AMBIL PAKET SEKARANG
                    </a>
                    <a href="#about"
                        class="border-2 border-white text-white hover:bg-white hover:text-primary transition-all font-bold py-3 px-5 sm:py-4 sm:px-8 text-sm sm:text-lg inline-block text-center rounded-full flex-1 sm:flex-none">
                        PELAJARI LEBIH LANJUT
                    </a>
                </div>
            </div>
            <!-- Empty column for spacing on large screens -->
            <div class="hidden lg:block"></div>
        </div>
    </div>
</section>