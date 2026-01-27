<div class="space-y-3 pt-4">
    <div class="flex justify-between items-center text-stone-600 dark:text-stone-400">
        <span class="text-sm">Produk Utama (Paket)</span>
        <span class="font-bold whitespace-nowrap">Rp {{ number_format($packagePrice, 0, ',', '.') }}</span>
    </div>

    @if($addonTotal > 0)
        <div class="flex justify-between items-center text-stone-600 dark:text-stone-400">
            <span class="text-sm">Tambahan (Add-ons)</span>
            <span class="font-bold whitespace-nowrap">+ Rp {{ number_format($addonTotal, 0, ',', '.') }}</span>
        </div>
    @endif

    <div class="flex justify-between items-center text-stone-600 dark:text-stone-400">
        <span class="text-sm">Ongkos Kirim Estimasi</span>
        <span class="font-bold whitespace-nowrap">+ Rp {{ number_format($shippingCost, 0, ',', '.') }}</span>
    </div>

    <div class="mt-4 pt-4 border-t-2 border-stone-200 dark:border-stone-800 flex justify-between items-center">
        <span class="font-rugged text-lg uppercase">Total Bayar</span>
        <span class="font-rugged text-2xl text-warning whitespace-nowrap">Rp
            {{ number_format($total, 0, ',', '.') }}</span>
    </div>

    @if($shippingCost == 0)
        <p class="text-[10px] text-red-500 font-bold italic text-right">* Pilih Kota Tujuan untuk menghitung ongkos kirim
        </p>
    @endif
</div>