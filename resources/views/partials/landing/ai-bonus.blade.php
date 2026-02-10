<!-- Bonus Section -->
<section id="bonus" class="py-16 md:py-24 bg-black text-white relative overflow-hidden">
    <!-- Decorative background glow -->
    <div
        class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-red-900/40 rounded-full blur-[100px]">
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Left Side: Content -->
            <div class="fade-up order-2 lg:order-1">
                <div class="flex items-center gap-3 mb-6">
                    <span class="text-3xl">🤖</span>
                    <h2 class="text-xl md:text-2xl font-bold uppercase tracking-wide">
                        BONUS EKSKLUSIF: ASISTEN AI TAHU KRAX
                    </h2>
                </div>

                <div
                    class="mb-8 p-6 rounded-3xl bg-white/5 border border-white/10 backdrop-blur-sm relative overflow-hidden">
                    <div
                        class="absolute top-0 right-0 bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-bl-xl uppercase">
                        Hanya Bulan Ini
                    </div>
                    <p class="text-gray-400 text-lg mb-1">Senilai <span
                            class="line-through text-red-500 font-bold decoration-2 text-xl">Rp 15.900.000</span>
                    </p>
                    <h3 class="text-5xl md:text-7xl font-black text-white leading-none mb-2 tracking-tight">
                        GRATIS
                    </h3>
                    <p class="text-2xl md:text-3xl font-bold text-white/90">UNTUK MITRA</p>
                </div>

                <div class="space-y-6">
                    <p class="text-lg text-gray-300 leading-relaxed">
                        Kamu <span class="text-white font-bold border-b-2 border-primary">tidak hanya dapat produk &
                            resep</span>.
                        Kamu juga dapat <span class="bg-primary/20 text-white px-1 font-bold">asisten digital</span>
                        yang membantu jualan
                        dan operasional, terutama kalau kamu:
                    </p>
                    <ul class="space-y-4">
                        <li class="flex items-center gap-4 bg-gray-900/50 p-3 rounded-xl border border-gray-800">
                            <span
                                class="w-8 h-8 rounded-full bg-red-500/20 text-red-500 flex items-center justify-center font-bold">❌</span>
                            <span class="text-gray-200 font-medium">Belum jago marketing</span>
                        </li>
                        <li class="flex items-center gap-4 bg-gray-900/50 p-3 rounded-xl border border-gray-800">
                            <span
                                class="w-8 h-8 rounded-full bg-red-500/20 text-red-500 flex items-center justify-center font-bold">❌</span>
                            <span class="text-gray-200 font-medium">Nggak punya tim</span>
                        </li>
                        <li class="flex items-center gap-4 bg-gray-900/50 p-3 rounded-xl border border-gray-800">
                            <span
                                class="w-8 h-8 rounded-full bg-red-500/20 text-red-500 flex items-center justify-center font-bold">❌</span>
                            <span class="text-gray-200 font-medium">Jualan sendirian</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Right Side: Image -->
            <div class="fade-up text-center lg:text-right order-1 lg:order-2">
                <div class="relative perspective-1000 group">
                    <!-- Glow behind laptop -->
                    <div
                        class="absolute inset-0 bg-primary/30 blur-3xl rounded-full transform scale-75 group-hover:scale-90 transition-transform duration-700">
                    </div>

                    <!-- Laptop Image -->
                    <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=800&auto=format&fit=crop&q=80"
                        alt="Dashboard AI Tahu Krax"
                        class="relative z-10 w-full max-w-xl mx-auto rounded-xl shadow-2xl border-4 border-gray-800 rotate-3d">

                    <!-- Floating Badge -->
                    <div
                        class="absolute -bottom-6 -left-6 z-20 bg-white text-dark p-4 rounded-xl shadow-xl transform rotate-3 animate-bounce-slow hidden md:block">
                        <p class="font-bold text-sm">🔥 8 Asisten AI</p>
                        <p class="text-xs text-gray-500">Siap bantu 24/7</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- AI Assistants Grid (Updated) -->
        <div class="mt-16 grid grid-cols-2 md:grid-cols-3 gap-4 md:gap-6">
            @foreach(['dion.webp', 'freya.webp', 'liora.webp', 'manda.webp', 'naya.webp', 'odelia.webp', 'vezia.webp'] as $img)
                <div class="group">
                    <img src="{{ asset('img/ai-bot/' . $img) }}" alt="AI Assistant"
                        class="w-full h-auto rounded-2xl shadow-lg hover:scale-105 transition-transform duration-300">
                </div>
            @endforeach
        </div>
    </div>
    </div>
    <style>
        .perspective-1000 {
            perspective: 1000px;
        }

        .rotate-3d {
            transform: rotateY(-12deg) rotateX(6deg);
            transition: transform 0.7s ease;
        }

        .group:hover .rotate-3d {
            transform: rotateY(0) rotateX(0);
        }
    </style>
</section>