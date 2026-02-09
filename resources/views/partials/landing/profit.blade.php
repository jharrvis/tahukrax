<!-- CALCULATION_SECTION -->
<section class="py-16 md:py-24 bg-primary text-white relative">
    <div class="container mx-auto px-4 pt-12">
        <h2 class="text-3xl md:text-4xl font-bold text-center mb-12">Dasar Perhitungan Operasional</h2>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center max-w-5xl mx-auto">
            <div class="space-y-6 fade-up text-lg">
                <h3 class="text-2xl font-bold mb-4">Biaya memasak per porsi tahu crispy:</h3>

                <!-- Gas -->
                <div class="mb-6">
                    <h4 class="text-xl font-bold mb-2 flex items-center gap-2">🔥 Gas</h4>
                    <ul class="space-y-1 mb-2 ml-5 list-disc text-white/90 text-base">
                        <li>Harga gas : Rp28.000</li>
                        <li>Jumlah porsi yang dihasilkan: 43 porsi</li>
                        <li>Biaya gas riil:</li>
                    </ul>
                    <div class="ml-5 font-mono bg-white/10 p-2 rounded inline-block text-sm">
                        Rp28.000 ÷ 43 ≈ Rp653/porsi
                    </div>
                </div>

                <!-- Minyak -->
                <div class="mb-8">
                    <h4 class="text-xl font-bold mb-2 flex items-center gap-2">🛢️ Minyak Goreng</h4>
                    <ul class="space-y-1 mb-2 ml-5 list-disc text-white/90 text-base">
                        <li>Harga minyak : Rp18.500</li>
                        <li>Jumlah porsi yang dihasilkan: 33 porsi</li>
                        <li>Biaya minyak riil:</li>
                    </ul>
                    <div class="ml-5 font-mono bg-white/10 p-2 rounded inline-block text-sm">
                        Rp18.500 ÷ 33 ≈ Rp555/porsi
                    </div>
                </div>

                <div class="bg-white/10 p-4 rounded-lg mb-6 inline-block w-full max-w-md">
                    <p class="font-bold flex items-center gap-2 text-white">
                        ➡️ Total biaya riil: <span class="ml-auto">± Rp1.208 / porsi</span>
                    </p>
                </div>

                <p class="text-white/90 text-sm leading-relaxed mb-6">
                    Untuk perhitungan usaha yang lebih <strong>aman</strong>, seluruh biaya operasional termasuk
                    fluktuasi pemakaian dan efisiensi siklus produksi <strong>dibulatkan menjadi</strong>:
                </p>

                <div class="bg-white/10 text-white p-6 rounded-xl border border-white/20 shadow-lg inline-block w-full">
                    <p class="text-2xl font-black flex items-center gap-3">
                        👉 <span>Rp1.300 per porsi</span>
                    </p>
                </div>
            </div>
            <div
                class="bg-white text-dark fade-up rounded-2xl shadow-xl border border-gray-100 flex flex-col h-full overflow-hidden">
                <!-- Image Top -->
                <div class="h-48 bg-gray-100 w-full relative group overflow-hidden">
                    <img src="https://placehold.co/600x400/png?text=Potensi+Keuntungan" alt="Potensi Keuntungan"
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent flex items-end p-6">
                        <h3 class="text-white text-xl font-bold">Analisa Usaha</h3>
                    </div>
                </div>

                <div class="p-6 flex-1 flex flex-col justify-center relative">
                    <!-- Potensi Keuntungan -->
                    <div class="mb-6">
                        <h3 class="text-lg font-bold mb-4 flex items-center gap-2 text-gray-800">
                            💰 Potensi Keuntungannya
                        </h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between items-center border-b border-gray-100 pb-2">
                                <span class="text-gray-600">Nilai jual produk</span>
                                <span class="font-bold text-gray-900">Rp7.000 / porsi</span>
                            </div>
                            <div class="flex justify-between items-center border-b border-gray-100 pb-2">
                                <span class="text-gray-600">Biaya energi sistem</span>
                                <span class="font-bold text-red-500">Rp1.300 / porsi</span>
                            </div>
                            <div class="flex justify-between items-center pt-1">
                                <span class="font-bold text-gray-800">Selisih nilai</span>
                                <span class="font-black text-green-600 text-lg">Rp5.700</span>
                            </div>
                        </div>
                    </div>

                    <!-- Efisiensi Sistem Produksi -->
                    <div>
                        <h3 class="text-lg font-bold mb-3 flex items-center gap-2 text-gray-800">
                            📈 Efisiensi Sistem Produksi
                        </h3>
                        <p class="text-xs text-gray-500 mb-3 leading-relaxed">
                            Efisiensi = <span class="font-semibold text-gray-700">Selisih Nilai</span> ÷
                            <span class="font-semibold text-gray-700">Modal Operasional</span>
                        </p>
                        <div
                            class="bg-gradient-to-r from-blue-50 to-indigo-50 p-4 rounded-xl text-center border border-blue-100 shadow-sm group hover:shadow-md transition-all">
                            <code
                                class="text-blue-800 font-bold text-base block group-hover:scale-105 transition-transform">
                                (Rp5.700 ÷ Rp1.300) × 100% ≈ 438%
                            </code>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
<!-- SIMULATION_SECTION -->
<section class="py-20 md:py-32 relative overflow-hidden" style="background-color: rgb(255, 245, 230);">
    <!-- Decorative Background Elements -->
    <div class="absolute top-0 left-0 w-full h-full opacity-5">
        <div class="absolute top-20 left-10 w-72 h-72 bg-primary rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-yellow-400 rounded-full blur-3xl"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <!-- Headline Block -->
        <div class="max-w-4xl mx-auto text-center mb-16">
            <p class="text-primary font-bold uppercase tracking-widest text-sm mb-4">💡 Kenapa Bisa Seuntung Itu?
            </p>
            <h2 class="text-3xl md:text-5xl font-black leading-tight mb-6 text-gray-800">
                Sistem produksi kita sangat efisien.<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-orange-500">Modal
                    Rp1.300 → Produk Rp7.000</span>
            </h2>
            <div
                class="inline-flex items-center gap-3 bg-gradient-to-r from-green-500 to-emerald-600 px-8 py-4 rounded-full shadow-2xl shadow-green-500/30">
                <span class="text-white/80 text-lg">Persentase Keuntungan:</span>
                <span class="text-4xl md:text-5xl font-black text-white animate-pulse">438%</span>
            </div>
        </div>

        <!-- Simulation Table -->
        <div class="max-w-4xl mx-auto">
            <div class="flex items-center gap-3 mb-6">
                <div
                    class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center shadow-lg">
                    <span class="text-white text-lg">📊</span>
                </div>
                <h3 class="text-xl md:text-2xl font-bold text-gray-800">Simulasi Realisasi Penjualan Harian</h3>
            </div>

            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-xl">
                <!-- Table Header -->
                <div
                    class="grid grid-cols-4 bg-gradient-to-r from-primary to-red-700 text-white font-bold text-sm md:text-base">
                    <div class="p-4 md:p-6 border-r border-white/20">Penjualan / Hari</div>
                    <div class="p-4 md:p-6 border-r border-white/20 text-center">Nilai Produksi</div>
                    <div class="p-4 md:p-6 border-r border-white/20 text-center">Biaya Energi</div>
                    <div class="p-4 md:p-6 text-center">Selisih Nilai</div>
                </div>

                <!-- Row 1: Sepi -->
                <div class="grid grid-cols-4 border-b border-gray-100 hover:bg-orange-50 transition-colors group">
                    <div class="p-4 md:p-6 border-r border-gray-100 flex items-center gap-3">
                        <span
                            class="w-3 h-3 bg-orange-400 rounded-full group-hover:scale-125 transition-transform"></span>
                        <span class="font-semibold text-gray-800">20 porsi <span
                                class="text-gray-400 text-sm">(Sepi)</span></span>
                    </div>
                    <div class="p-4 md:p-6 border-r border-gray-100 text-center font-mono text-gray-700">Rp140.000
                    </div>
                    <div class="p-4 md:p-6 border-r border-gray-100 text-center font-mono text-red-500">Rp26.000
                    </div>
                    <div class="p-4 md:p-6 text-center font-bold text-green-600 text-lg md:text-xl">Rp114.000</div>
                </div>

                <!-- Row 2: Normal -->
                <div
                    class="grid grid-cols-4 border-b border-gray-100 bg-gray-50/50 hover:bg-blue-50 transition-colors group">
                    <div class="p-4 md:p-6 border-r border-gray-100 flex items-center gap-3">
                        <span
                            class="w-3 h-3 bg-blue-400 rounded-full group-hover:scale-125 transition-transform"></span>
                        <span class="font-semibold text-gray-800">40 porsi <span
                                class="text-gray-400 text-sm">(Normal)</span></span>
                    </div>
                    <div class="p-4 md:p-6 border-r border-gray-100 text-center font-mono text-gray-700">Rp280.000
                    </div>
                    <div class="p-4 md:p-6 border-r border-gray-100 text-center font-mono text-red-500">Rp52.000
                    </div>
                    <div class="p-4 md:p-6 text-center font-bold text-green-600 text-lg md:text-xl">Rp228.000</div>
                </div>

                <!-- Row 3: Rame -->
                <div class="grid grid-cols-4 hover:bg-green-50 transition-colors group relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-green-100/50 to-transparent pointer-events-none">
                    </div>
                    <div class="p-4 md:p-6 border-r border-gray-100 flex items-center gap-3 relative">
                        <span
                            class="w-3 h-3 bg-green-500 rounded-full group-hover:scale-125 transition-transform animate-pulse"></span>
                        <span class="font-semibold text-gray-800">60 porsi <span
                                class="text-green-600 text-sm font-bold">(Rame
                                🔥)</span></span>
                    </div>
                    <div class="p-4 md:p-6 border-r border-gray-100 text-center font-mono text-gray-700 relative">
                        Rp420.000</div>
                    <div class="p-4 md:p-6 border-r border-gray-100 text-center font-mono text-red-500 relative">
                        Rp78.000</div>
                    <div class="p-4 md:p-6 text-center font-black text-green-600 text-xl md:text-2xl relative">
                        Rp342.000</div>
                </div>
            </div>
        </div>

        <!-- Footer Note -->
        <div class="max-w-3xl mx-auto mt-12">
            <div class="flex items-start gap-4 bg-white border-l-4 border-blue-500 rounded-r-xl p-6 shadow-lg">
                <div
                    class="flex-shrink-0 w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center text-xl shadow-lg">
                    ➡️
                </div>
                <p class="text-gray-700 leading-relaxed">
                    Pada kondisi lokasi yang baik, <strong class="text-primary">dengan modal yang ringan</strong>
                    memungkinkan efisiensi sistem tetap terjaga di kisaran <strong class="text-green-600 text-lg">±
                        400% per transaksi</strong>.
                </p>
            </div>
        </div>
    </div>
</section>