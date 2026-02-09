<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap"
    rel="stylesheet">
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    'primary': '#C41E3A',
                    'secondary': '#FF6B35',
                    'cream': '#FFF5E6',
                    'dark': '#1a1a1a'
                },
                fontFamily: {
                    'poppins': ['Poppins', 'sans-serif']
                }
            }
        }
    }
</script>
<style>
    * {
        scroll-behavior: smooth;
    }

    body {
        font-family: 'Poppins', sans-serif;
    }

    /* Wave divider */
    .wave-top {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        overflow: hidden;
        line-height: 0;
    }

    .wave-top svg {
        position: relative;
        display: block;
        width: calc(100% + 1.3px);
        height: 80px;
    }

    .wave-bottom {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        overflow: hidden;
        line-height: 0;
        transform: rotate(180deg);
    }

    .wave-bottom svg {
        position: relative;
        display: block;
        width: calc(100% + 1.3px);
        height: 80px;
    }

    /* Animations */
    .fade-up {
        opacity: 0;
        transform: translateY(40px);
        transition: all 0.6s ease-out;
    }

    .fade-up.visible {
        opacity: 1;
        transform: translateY(0);
    }

    .fade-in {
        opacity: 0;
        transition: opacity 0.6s ease-out;
    }

    .fade-in.visible {
        opacity: 1;
    }

    /* Hover effects */
    .hover-lift {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .hover-lift:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    ::-webkit-scrollbar-thumb {
        background: #C41E3A;
        border-radius: 4px;
    }

    /* Perspective classes */
    .perspective-1000 {
        perspective: 1000px;
    }

    .rotate-3d {
        transform: rotateY(-12deg) rotateX(6deg);
        transition: transform 0.7s ease;
    }

    .group:hover .rotate-3d {
        transform: rotateY(0) rotateX(0);
    }
</style>