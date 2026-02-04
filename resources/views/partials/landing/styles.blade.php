<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

    body {
        font-family: 'Poppins', sans-serif;
        background-color: #000;
    }

    [x-cloak] {
        display: none !important;
    }

    .btn-primary {
        background: linear-gradient(135deg, #FFA500 0%, #FF8C00 100%);
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255, 165, 0, 0.4);
    }

    /* Checkerboard Pattern */
    .checker-bg {
        position: relative;
    }

    .checker-bg::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 40px;
        background-image:
            linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%),
            linear-gradient(-45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%),
            linear-gradient(45deg, transparent 75%, rgba(255, 255, 255, 0.15) 75%),
            linear-gradient(-45deg, transparent 75%, rgba(255, 255, 255, 0.15) 75%);
        background-size: 20px 20px;
        background-position: 0 0, 0 10px, 10px -10px, -10px 0;
        pointer-events: none;
        opacity: 0.8;
        mask-image: linear-gradient(to top, black, transparent);
        border-radius: inherit;
    }

    /* Scroll to Top */
    #scroll-top {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #FFA500 0%, #FF8C00 100%);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 1000;
        transition: all 0.3s ease;
        opacity: 0;
        visibility: hidden;
        box-shadow: 0 4px 15px rgba(255, 165, 0, 0.3);
    }

    #scroll-top.show {
        opacity: 1;
        visibility: visible;
    }

    #scroll-top:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(255, 165, 0, 0.5);
    }

    .btn-cta-primary {
        background: linear-gradient(135deg, #FFD700 0%, #FFA500 50%, #FF4500 100%);
        background-size: 200% auto;
        transition: 0.5s;
        animation: pulse-orange 2s infinite;
    }

    .btn-cta-primary:hover {
        background-position: right center;
        transform: scale(1.02);
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

    .hero-bg {
        background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.7)),
            url('{{ asset('assets/img/hero-background.webp') }}?v=2');
        background-size: cover, cover;
        background-position: center;
        background-attachment: fixed;
    }

    .granite-texture {
        background-image: linear-gradient(rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0.75)), url('{{ asset('assets/img/background.webp') }}');
        background-size: cover, cover;
        background-attachment: fixed;
    }

    @media (max-width: 768px) {

        .hero-bg,
        .granite-texture {
            background-attachment: scroll;
        }
    }
</style>