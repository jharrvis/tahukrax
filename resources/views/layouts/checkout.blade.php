<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | RC GO</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])


    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    @include('partials.landing.styles')

    @livewireStyles
</head>

<body class="bg-black text-white selection:bg-orange-500 selection:text-white">

    @include('partials.landing.nav')

    <main class="granite-texture min-h-screen py-16 md:py-24">
        {{ $slot }}
    </main>

    @include('partials.landing.footer')

    @livewireScripts
</body>

</html>