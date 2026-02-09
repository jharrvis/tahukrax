<x-mail::message>
    # Selamat Datang, {{ $user->name }}!

    Terima kasih telah bergabung menjadi mitra TahuKrax. Akun Anda telah berhasil dibuat.

    Login ke dashboard untuk melihat paket kemitraan dan melakukan pemesanan.

    <x-mail::button :url="route('login')">
        Masuk ke Dashboard
    </x-mail::button>

    Terima kasih,<br>
    {{ config('app.name') }}
</x-mail::message>