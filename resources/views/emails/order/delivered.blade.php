<x-mail::message>
    # Pesanan Selesai

    Halo {{ $order->user->name }},

    Pesanan **#{{ $order->id }}** telah sampai di tujuan.

    Kami harap Anda puas dengan layanan dan produk kami.

    <x-mail::button :url="route('mitra.orders.show', $order)">
        Lihat Pesanan
    </x-mail::button>

    Terima kasih telah berbelanja di TahuKrax!<br>
    {{ config('app.name') }}
</x-mail::message>