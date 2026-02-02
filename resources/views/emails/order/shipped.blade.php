<x-mail::message>
    # Pesanan Dikirim

    Halo {{ $order->user->name }},

    Pesanan **#{{ $order->id }}** sedang dalam pengiriman.

    **Nomor Resi:** {{ $order->tracking_number ?? '-' }}
    **Kurir:** Indah Logistik (Default)

    Anda dapat melacak status pengiriman melalui dashboard atau website kurir terkait.

    <x-mail::button :url="route('mitra.orders.show', $order)">
        Lacak Pesanan
    </x-mail::button>

    Terima kasih,<br>
    {{ config('app.name') }}
</x-mail::message>