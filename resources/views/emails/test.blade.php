<x-mail::message>
    # Test Email Configuration

    Halo,

    Ini adalah email percobaan dari sistem TahuKrax.
    Jika Anda menerima email ini, berarti konfigurasi SMTP Anda sudah benar.

    **Waktu Pengiriman:** {{ now()->format('d M Y H:i:s') }}

    Terima kasih,<br>
    {{ config('app.name') }}
</x-mail::message>