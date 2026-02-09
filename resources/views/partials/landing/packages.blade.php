<!-- SECTION 6: PAKET USAHA -->
<section id="packages" class="py-16 md:py-24 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl md:text-4xl font-bold text-center mb-4 text-primary">PAKET USAHA TAHU KRAX</h2>
        <p class="text-center text-gray-600 mb-12 max-w-2xl mx-auto">Pilih paket yang paling sesuai dengan target
            bisnismu</p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
            @foreach($packages as $p)
                <div class="bg-cream overflow-hidden hover-lift fade-up relative flex flex-col h-full rounded-2xl group">
                    <!-- Best Seller Badge Logic -->
                    @if($p->price >= 2500000 && $p->price <= 3500000)
                        <div
                            class="absolute top-4 right-4 bg-yellow-400 text-dark px-3 py-1 text-xs font-bold z-10 rounded shadow-md">
                            BEST SELLER
                        </div>
                    @endif

                    <!-- Image Section -->
                    <div
                        class="h-48 bg-gradient-to-br from-primary to-red-700 flex items-center justify-center overflow-hidden">
                        @if($p->image_url)
                            @php
                                $imageUrl = $p->image_url;
                                if (!Str::startsWith($imageUrl, ['/storage', 'http', 'https'])) {
                                    $imageUrl = Storage::url($imageUrl);
                                }
                            @endphp
                            <img src="{{ asset($imageUrl) }}" alt="Paket {{ $p->name }}"
                                class="w-full h-full object-cover opacity-90 group-hover:scale-110 transition-transform duration-500">
                        @else
                            <!-- Fallback Image Logic -->
                            @php
                                $extension = in_array($p->slug, ['drift', 'offroad', 'stunt']) ? 'svg' : 'webp';
                                // Simple fallback mapping if specific assets don't exist, generic tahukrax image
                                $imgName = 'tahukrax.webp'; 
                            @endphp
                            <img src="{{ asset('img/' . $imgName) }}"
                                onerror="this.src='https://placehold.co/600x400/png?text=Paket+{{ $p->name }}'"
                                alt="Paket {{ $p->name }}"
                                class="w-full h-full object-cover opacity-80 group-hover:scale-110 transition-transform duration-500">
                        @endif
                    </div>

                    <!-- Body Section -->
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-xl font-bold mb-2 text-gray-800">{{ $p->name }}</h3>
                        <p class="text-gray-500 text-sm mb-4 flex-grow">
                            {{ $p->description ?? 'Paket usaha lengkap siap jualan.' }}
                        </p>

                        <!-- Optional Features List (Limited to 3) -->
                        @if($p->features && is_array($p->features))
                            <ul class="mb-4 space-y-1 text-xs text-gray-600">
                                @foreach(array_slice($p->features, 0, 3) as $f)
                                    <li class="flex items-start gap-2">
                                        <span class="text-green-500 mt-0.5">✔</span>
                                        <span>{{ Str::limit($f, 40) }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        <!-- Price Section -->
                        <div class="flex items-center gap-2 mb-6 mt-auto">
                            <span class="text-gray-400 line-through text-sm">Rp
                                {{ number_format($p->price * 1.5, 0, ',', '.') }}</span>
                            <span class="text-2xl font-black text-primary">Rp
                                {{ number_format($p->price / 1000000, 1, ',', '.') }} jt</span>
                        </div>

                        <!-- Action Button -->
                        <a href="{{ route('checkout.wizard', $p->slug) }}"
                            class="block w-full bg-primary text-white py-3 font-bold hover:bg-secondary transition-colors text-center rounded-xl shadow-lg hover:shadow-xl">
                            Pilih Paket
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Link to detailed comparison or more packages if needed -->
        <div class="text-center mt-12">
            <p class="text-gray-500 text-sm">
                *Harga belum termasuk ongkos kirim ke lokasi Anda.
            </p>
        </div>
    </div>
</section>