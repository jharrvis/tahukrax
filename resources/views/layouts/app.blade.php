<!DOCTYPE html>
<html lang="id" class="h-full bg-stone-50 dark:bg-[#0f0c0a]">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Checkout | RCGO' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Black+Ops+One&family=Russo+One&family=Space+Grotesk:wght@400;700&display=swap');

        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Space Grotesk', sans-serif;
            background-color: #0f0c0a;
            background-image: url("https://www.transparenttextures.com/patterns/dark-matter.png");
        }

        .font-stencil {
            font-family: 'Black Ops One', system-ui;
        }

        .font-rugged {
            font-family: 'Russo One', sans-serif;
        }

        .fi-btn {
            clip-path: polygon(10% 0, 100% 0, 90% 100%, 0 100%);
            text-transform: uppercase;
            font-weight: 800;
        }

        /* Standalone Form Fixes */
        .fi-section {
            margin-bottom: 2rem;
            background: #1a1614 !important;
            border-radius: 0.75rem;
            border: 2px solid #3d2b1f !important;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        .fi-section-header {
            padding: 1.5rem;
            background: #2d241e !important;
            border-bottom: 2px solid #3d2b1f !important;
        }

        .fi-section-header-title {
            color: #ff6b00 !important;
            font-family: 'Russo One', sans-serif !important;
            text-transform: uppercase;
        }

        .fi-section-content {
            padding: 1.5rem;
            color: #e7e5e4 !important;
        }

        .fi-fo-field-group {
            margin-bottom: 1.5rem;
        }

        .fi-fo-field-group-label,
        label {
            font-weight: 800 !important;
            margin-bottom: 0.5rem !important;
            display: block !important;
            font-size: 0.75rem !important;
            color: #ff6b00 !important;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        input[type="text"],
        input[type="number"],
        input[type="tel"],
        select,
        textarea {
            width: 100% !important;
            padding: 0.75rem 1rem !important;
            border-radius: 0.25rem !important;
            border: 2px solid #3d2b1f !important;
            background-color: #0f0c0a !important;
            color: white !important;
            font-weight: 600 !important;
            transition: all 0.2s ease;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: #ff6b00 !important;
            outline: none !important;
            box-shadow: 0 0 0 2px rgba(255, 107, 0, 0.2) !important;
        }

        input:disabled {
            background-color: #2d241e !important;
            opacity: 0.7;
        }

        button {
            cursor: pointer;
        }

        /* Generic Button for Filament/Livewire items */
        .fi-fo-repeater-add-item-button {
            background-color: #ff6b00 !important;
            color: black !important;
            font-weight: 900 !important;
            padding: 0.75rem 1.5rem !important;
            border-radius: 0 !important;
            text-transform: uppercase !important;
            font-size: 0.875rem !important;
            clip-path: polygon(5% 0, 100% 0, 95% 100%, 0 100%);
            transition: all 0.2s ease;
        }

        .fi-fo-repeater-add-item-button:hover {
            transform: scale(1.05);
            background-color: white !important;
        }

        .fi-fo-repeater-item {
            background: #2d241e !important;
            border: 1px solid #3d2b1f !important;
            padding: 1rem !important;
            border-radius: 0.5rem !important;
            margin-bottom: 1rem !important;
        }

        .rugged-card {
            background: #ffffff;
            border: 2px solid #e7e5e4;
            position: relative;
            overflow: hidden;
            clip-path: polygon(0% 0%, 95% 0%, 100% 5%, 100% 100%, 5% 100%, 0% 95%);
            transition: all 0.3s ease;
        }

        .dark .rugged-card {
            background: linear-gradient(145deg, #1a1614, #2d241e);
            border-color: #3d2b1f;
        }
    </style>

    {{-- Manual link to published Filament CSS as fallback --}}
    <link href="/css/filament/filament/app.css" rel="stylesheet">
    @filamentStyles
</head>

<body class="h-full text-stone-900 dark:text-stone-200 antialiased">
    <div class="min-h-full">
        <nav class="bg-white dark:bg-[#151210] border-b-2 border-stone-200 dark:border-stone-800">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 justify-between items-center">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('img/rcgo-logo.svg') }}" alt="RCGO Logo" class="h-6 md:h-8">
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="text-sm font-bold uppercase italic text-stone-500">Checkout Secure</span>
                        <i class="fas fa-lock text-stone-400"></i>
                    </div>
                </div>
            </div>
        </nav>

        <main class="py-10">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </main>
    </div>

    @livewire('notifications')
    @filamentScripts
    @stack('scripts')
</body>

</html>