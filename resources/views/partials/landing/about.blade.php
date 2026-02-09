<!-- ABOUT_SECTION -->
<section id="about"
    class="py-16 md:py-24 bg-gradient-to-br from-white via-cream to-orange-50 relative overflow-hidden">
    <!-- Decorative Elements -->
    <!-- Top Left Dotted Pattern -->
    <div class="absolute top-10 left-10 w-24 h-24 opacity-30">
        <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="10" cy="10" r="3" fill="#FF6B35" />
            <circle cx="30" cy="10" r="3" fill="#FF6B35" />
            <circle cx="50" cy="10" r="3" fill="#FF6B35" />
            <circle cx="70" cy="10" r="3" fill="#FF6B35" />
            <circle cx="10" cy="30" r="3" fill="#FF6B35" />
            <circle cx="30" cy="30" r="3" fill="#FF6B35" />
            <circle cx="50" cy="30" r="3" fill="#FF6B35" />
            <circle cx="70" cy="30" r="3" fill="#FF6B35" />
            <circle cx="10" cy="50" r="3" fill="#FF6B35" />
            <circle cx="30" cy="50" r="3" fill="#FF6B35" />
            <circle cx="50" cy="50" r="3" fill="#FF6B35" />
            <circle cx="70" cy="50" r="3" fill="#FF6B35" />
        </svg>
    </div>

    <!-- Large Circular Arc Behind Image -->
    <div class="absolute top-1/2 left-0 -translate-y-1/2 w-96 h-96 opacity-20">
        <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="100" cy="100" r="80" stroke="#FF6B35" stroke-width="4" fill="none"
                stroke-dasharray="10 5" />
            <circle cx="100" cy="100" r="60" fill="#FF6B35" opacity="0.1" />
        </svg>
    </div>

    <!-- Small Dots Decoration -->
    <div class="absolute top-20 right-20 flex gap-2">
        <div class="w-3 h-3 bg-secondary rounded-full"></div>
        <div class="w-3 h-3 bg-primary rounded-full"></div>
        <div class="w-3 h-3 bg-secondary rounded-full"></div>
    </div>

    <!-- Bottom Right Accent -->
    <div class="absolute bottom-10 right-10 w-32 h-32 opacity-20">
        <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M50 10 Q90 50 50 90 Q10 50 50 10" fill="#C41E3A" />
        </svg>
    </div>

    <div class="container mx-auto px-4 md:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="fade-up relative">
                <img src="{{ asset('assets/img/tentang-tahukrax.webp') }}" alt="Tentang Tahu Krax" class="w-full relative z-10">
            </div>
            <div class="fade-up text-center lg:text-left">
                <h2 class="text-primary text-3xl md:text-4xl font-bold mb-6">
                    Sebenarnya, apa sih TAHU KRAX itu?
                </h2>
                <div class="space-y-6 text-gray-700 leading-relaxed">

                    <p>
                        TAHU KRAX adalah jawaban buat kamu yang ingin punya usaha kuliner yang renyah, gurih, dan
                        gak pernah sepi peminat. Banyak orang pengen usaha, tapi berhenti di satu titik: takut rugi,
                        takut salah langkah, dan capek lihat peluang tapi nggak berani mulai
                    </p>

                    <p>
                        Singkatnya, TAHU KRAX dibuat supaya orang awam pun bisa langsung jadi pengusaha. Kamu nggak
                        perlu melewati masa sulit <em>trial-error</em> dari nol yang buang-buang waktu dan biaya.
                        Kami sudah siapkan semuanya: resep yang konsisten, tekstur renyah yang stabil, hingga alur
                        produksi yang sangat simpel.
                    </p>

                    <p class="font-bold text-dark text-lg">Tugasmu cuma satu: Mulai sekarang.</p>
                </div>

                <div class="mt-10">
                    <a href="#packages"
                        class="inline-block bg-secondary text-white font-bold py-4 px-10 hover:bg-primary transition-all hover-lift rounded-full text-lg shadow-lg">
                        AMBIL PAKET USAHA SEKARANG
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>