<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'RC GO' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #000;
        }

        .btn-primary {
            background: linear-gradient(135deg, #FFA500 0%, #FF8C00 100%);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 165, 0, 0.4);
        }

        .btn-cta-primary {
            background: linear-gradient(135deg, #FFD700 0%, #FFA500 50%, #FF4500 100%);
            background-size: 200% auto;
            transition: 0.5s;
            animation: pulse-orange 2s infinite;
        }

        .btn-cta-primary:hover {
            background-position: right center;
            transform: scale(1.05);
        }

        @keyframes pulse-orange {
            0% {
                box-shadow: 0 0 0 0 rgba(255, 165, 0, 0.4);
            }

            70% {
                box-shadow: 0 0 0 20px rgba(255, 165, 0, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(255, 165, 0, 0);
            }
        }
    </style>

    @livewireStyles
</head>

<body class="bg-black text-white selection:bg-orange-500 selection:text-white">
    {{ $slot }}

    @livewireScripts
</body>

</html>