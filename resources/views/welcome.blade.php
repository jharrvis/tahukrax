<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $contents['site_title']['value'] ?? 'Tahu Krax - Peluang Usaha Tahu Crispy' }}</title>
    @include('partials.landing.styles')
</head>

<body class="bg-white text-dark overflow-x-hidden font-poppins">

    @include('partials.landing.nav')
    @include('partials.landing.hero')
    @include('partials.landing.about')
    @include('partials.landing.sistem')
    @include('partials.landing.keunggulan')
    @include('partials.landing.perbandingan')
    @include('partials.landing.profit')
    @include('partials.landing.packages')
    @include('partials.landing.ai-bonus')
    @include('partials.landing.testimoni')
    @include('partials.landing.faq')
    @include('partials.landing.cta')
    @include('partials.landing.footer')

    @include('partials.landing.scripts')

</body>

</html>