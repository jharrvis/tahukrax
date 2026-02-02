<x-mail::message>
    # Pesanan Diterima

    Halo {{ $order->user->name }},

    Terima kasih telah melakukan pemesanan di RCGO Indonesia.
    Nomor Invoice: **#{{ $order->id }}**

    ## Detail Pesanan

    <x-mail::table>
        | Item | Qty | Harga |
        |:-----|:---:|:------|
        @foreach($order->orderItems as $item)
            | {{ $item->package ? $item->package->name : ($item->addon ? $item->addon->name : 'Item') }} |
            {{ $item->quantity }} | Rp {{ number_format($item->price, 0, ',', '.') }} |
        @endforeach
        | **Total** | | **Rp {{ number_format($order->total_amount, 0, ',', '.') }}** |
    </x-mail::table>

    Silakan selesaikan pembayaran Anda melalui link berikut:

    <x-mail::button :url="$invoiceUrl">
        Bayar Sekarang
    </x-mail::button>

    Jika tombol tidak berfungsi, salin link berikut:
    {{ $invoiceUrl }}

    Terima kasih,<br>
    {{ config('app.name') }}
</x-mail::message>