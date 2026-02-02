<x-mail::message>
    # Pembayaran Berhasil

    Halo {{ $order->user->name }},

    Pembayaran Anda untuk pesanan **#{{ $order->id }}** telah kami terima
    ({{ strtoupper($order->payment_channel ?? 'Online Payment') }}).

    Status pesanan Anda sekarang sedang diproses. Kami akan memberitahu Anda ketika pesanan dikirim.

    <x-mail::button :url="route('mitra.orders.show', $order)">
        Lihat Detail Pesanan
    </x-mail::button>

    Terima kasih,<br>
    {{ config('app.name') }}
</x-mail::message>