<script>
    // Notification Pop-up Simulator
    const notifData = [
        { name: 'Rina', city: 'Bekasi', package: 'Paket Hemat' },
        { name: 'Arief', city: 'Malang', package: 'Paket Signature' },
        { name: 'Doni', city: 'Jakarta', package: 'Paket Booth' },
        { name: 'Siska', city: 'Surabaya', package: 'Paket Tanpa Booth' },
        { name: 'Budi', city: 'Medan', package: 'Paket Ultimate' },
        { name: 'Maya', city: 'Bandung', package: 'Paket Hemat' }
    ];

    let slotLeft = 15;
    const popup = document.getElementById('popup-notif');
    const popupText = document.getElementById('popup-text');

    function showNotification() {
        if (!popup || !popupText) return;

        const data = notifData[Math.floor(Math.random() * notifData.length)];
        const isSlotReduction = Math.random() > 0.7;

        if (isSlotReduction && slotLeft > 1) {
            slotLeft--;
            popupText.innerHTML = `✅ Slot live berkurang. Tersisa <span class="text-red-600 font-bold">${slotLeft} slot</span> hari ini`;
        } else {
            popupText.innerHTML = `✅ <strong>${data.name} – ${data.city}</strong> baru saja mengambil <strong>${data.package}</strong>`;
        }

        popup.classList.remove('translate-y-20', 'opacity-0');
        popup.classList.add('translate-y-0', 'opacity-100');

        setTimeout(() => {
            popup.classList.add('translate-y-20', 'opacity-0');
            popup.classList.remove('translate-y-0', 'opacity-100');
        }, 4000);
    }

    // Show first notification after 3 seconds, then every 8-15 seconds
    setTimeout(() => {
        showNotification();
        setInterval(showNotification, Math.floor(Math.random() * 7000) + 8000);
    }, 3000);

    // Scroll Animation
    function handleScroll() {
        const elements = document.querySelectorAll('.fade-up, .fade-in');
        elements.forEach(el => {
            const rect = el.getBoundingClientRect();
            if (rect.top < window.innerHeight - 100) {
                el.classList.add('visible');
            }
        });
    }

    window.addEventListener('scroll', handleScroll);
    window.addEventListener('load', handleScroll);

    // Off-Canvas Mobile Menu Logic
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const closeMobileMenuBtn = document.getElementById('closeMobileMenuBtn');
    const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');
    const mobileMenuPanel = document.getElementById('mobileMenuPanel');
    const mobileLinks = document.querySelectorAll('.mobile-link');

    function openMobileMenu() {
        if (!mobileMenuOverlay || !mobileMenuPanel) return;
        mobileMenuOverlay.classList.remove('hidden');
        // heavy timeout to allow display:block to apply before opacity transition
        setTimeout(() => {
            mobileMenuOverlay.classList.remove('opacity-0');
            mobileMenuPanel.classList.remove('translate-x-full');
        }, 10);
    }

    function closeMobileMenu() {
        if (!mobileMenuOverlay || !mobileMenuPanel) return;
        mobileMenuOverlay.classList.add('opacity-0');
        mobileMenuPanel.classList.add('translate-x-full');
        setTimeout(() => {
            mobileMenuOverlay.classList.add('hidden');
        }, 300);
    }

    if (mobileMenuBtn) mobileMenuBtn.addEventListener('click', openMobileMenu);
    if (closeMobileMenuBtn) closeMobileMenuBtn.addEventListener('click', closeMobileMenu);
    if (mobileMenuOverlay) mobileMenuOverlay.addEventListener('click', closeMobileMenu);

    if (mobileLinks) {
        mobileLinks.forEach(link => {
            link.addEventListener('click', closeMobileMenu);
        });
    }

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            const target = document.querySelector(targetId);
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // Testimonial Carousel Logic
    (function () {
        const track = document.getElementById('testimonialTrack');
        const dots = document.querySelectorAll('.testimonial-dot');
        const totalSlides = 4;
        let currentSlide = 0;
        let autoSlideInterval;

        if (!track) return;

        function goToSlide(index) {
            if (index < 0) index = totalSlides - 1;
            if (index >= totalSlides) index = 0;
            currentSlide = index;
            track.style.transform = `translateX(-${currentSlide * 100}%)`;
            updateDots();
        }

        function updateDots() {
            dots.forEach((dot, i) => {
                if (i === currentSlide) {
                    dot.classList.remove('bg-gray-300');
                    dot.classList.add('bg-primary');
                } else {
                    dot.classList.remove('bg-primary');
                    dot.classList.add('bg-gray-300');
                }
            });
        }

        function nextSlide() {
            goToSlide(currentSlide + 1);
        }

        function prevSlide() {
            goToSlide(currentSlide - 1);
        }

        function startAutoSlide() {
            autoSlideInterval = setInterval(nextSlide, 5000);
        }

        function stopAutoSlide() {
            clearInterval(autoSlideInterval);
        }

        // Dots click event
        dots.forEach(dot => {
            dot.addEventListener('click', () => {
                const index = parseInt(dot.dataset.index);
                goToSlide(index);
                stopAutoSlide();
                startAutoSlide();
            });
        });

        // Touch/Swipe Support
        let touchStartX = 0;
        let touchEndX = 0;
        const slider = document.getElementById('testimonialSlider');

        if (slider) {
            slider.addEventListener('touchstart', e => {
                touchStartX = e.changedTouches[0].screenX;
            });

            slider.addEventListener('touchend', e => {
                touchEndX = e.changedTouches[0].screenX;
                handleSwipe();
            });
        }

        function handleSwipe() {
            const diff = touchStartX - touchEndX;
            if (Math.abs(diff) > 50) {
                if (diff > 0) {
                    nextSlide();
                } else {
                    prevSlide();
                }
                stopAutoSlide();
                startAutoSlide();
            }
        }

        // Start auto-slide
        startAutoSlide();
    })();

    // Scroll to Top Logic
    const scrollTopBtn = document.getElementById('scrollTopBtn');

    if (scrollTopBtn) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                scrollTopBtn.classList.remove('opacity-0', 'invisible', 'translate-y-10');
            } else {
                scrollTopBtn.classList.add('opacity-0', 'invisible', 'translate-y-10');
            }
        });

        scrollTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
</script>