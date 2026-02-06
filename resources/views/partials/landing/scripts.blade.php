<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    // Smooth Scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href === '#') return;
            e.preventDefault();
            const target = document.querySelector(href);
            if (target) target.scrollIntoView({ behavior: 'smooth' });
        });
    });

    // Modals
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (!modal) return;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (!modal) return;
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = 'auto';
    }

    // Close modal when clicking outside
    document.querySelectorAll('[id^="modal-"]').forEach(modal => {
        modal.addEventListener('click', function (e) {
            if (e.target === this) {
                closeModal(this.id);
            }
        });
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('[id^="modal-"]').forEach(modal => {
                if (!modal.classList.contains('hidden')) {
                    closeModal(modal.id);
                }
            });
        }
    });

    // Calculator Logic
    const unitsInput = document.getElementById('calc-units');
    const priceInput = document.getElementById('calc-price');
    const hppInput = document.getElementById('calc-hpp');
    const trxInput = document.getElementById('calc-trx');
    const resultDisplay = document.getElementById('calc-result');

    function calculateProfit() {
        if (!unitsInput || !priceInput || !hppInput || !trxInput || !resultDisplay) return;

        const units = parseInt(unitsInput.value) || 0;
        const price = parseInt(priceInput.value) || 0;
        const hpp = parseInt(hppInput.value) || 0;
        const trx = parseInt(trxInput.value) || 0;

        const labaBersihPerSesi = price - hpp;
        const totalLabaBersihPerBulan = labaBersihPerSesi * trx * units * 30;

        resultDisplay.innerText = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0
        }).format(totalLabaBersihPerBulan);
    }

    if (unitsInput) {
        [unitsInput, priceInput, hppInput, trxInput].forEach(input => {
            input.addEventListener('input', calculateProfit);
        });
        calculateProfit();
    }

    // Scroll to Top
    document.addEventListener('DOMContentLoaded', function () {
        const scrollTopBtn = document.getElementById('scroll-top');
        if (scrollTopBtn) {
            window.addEventListener('scroll', () => {
                if (window.pageYOffset > 300) {
                    scrollTopBtn.classList.add('show');
                } else {
                    scrollTopBtn.classList.remove('show');
                }
            });

            scrollTopBtn.addEventListener('click', () => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }
    });
    // Confirm Modal Logic
    let confirmCallback = null;
    const confirmModal = document.getElementById('confirm-modal');

    function openConfirmModal(title, message, callback) {
        if (!confirmModal) return;

        document.getElementById('confirm-title').innerText = title || 'Konfirmasi';
        document.getElementById('confirm-message').innerText = message || 'Apakah Anda yakin?';
        confirmCallback = callback;

        confirmModal.classList.remove('hidden');
        confirmModal.classList.add('flex');

        // Animation trigger
        setTimeout(() => {
            confirmModal.classList.remove('opacity-0');
        }, 10);
    }

    function closeConfirmModal(confirmed) {
        if (!confirmModal) return;

        if (confirmed && confirmCallback) {
            confirmCallback();
        }

        confirmModal.classList.add('opacity-0');

        setTimeout(() => {
            confirmModal.classList.add('hidden');
            confirmModal.classList.remove('flex');
            confirmCallback = null;
        }, 300);
    }

    // Live Notification Pop-ups
    const notificationNames = [
        'Rina', 'Arief', 'Budi', 'Siti', 'Dewi', 'Ahmad', 'Fitri', 'Joko', 'Ani', 'Rudi',
        'Maya', 'Hendra', 'Lina', 'Agus', 'Putri', 'Dian', 'Eko', 'Ratna', 'Bambang', 'Sri',
        'Yanto', 'Wati', 'Andi', 'Nur', 'Tono'
    ];

    const notificationCities = [
        'Jakarta', 'Surabaya', 'Bandung', 'Medan', 'Semarang', 'Bekasi', 'Tangerang', 'Depok',
        'Palembang', 'Makassar', 'Batam', 'Bogor', 'Malang', 'Yogyakarta', 'Denpasar',
        'Balikpapan', 'Pontianak', 'Banjarmasin', 'Samarinda', 'Manado', 'Solo', 'Cirebon',
        'Pekanbaru', 'Jambi', 'Padang'
    ];

    const notificationPackages = [
        'Paket Drift', 'Paket Offroad', 'Paket Stunt', 'Paket Alat Berat Mix', 'Paket Racing'
    ];

    function createNotification() {
        const name = notificationNames[Math.floor(Math.random() * notificationNames.length)];
        const city = notificationCities[Math.floor(Math.random() * notificationCities.length)];
        const packageName = notificationPackages[Math.floor(Math.random() * notificationPackages.length)];

        const notification = document.createElement('div');
        notification.className = 'live-notification';
        notification.innerHTML = `
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center shrink-0">
                    <i class="fas fa-check text-white text-sm"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-semibold text-white">
                        <span class="text-orange-400">${name}</span> – ${city}
                    </p>
                    <p class="text-xs text-gray-300">baru saja mengambil ${packageName}</p>
                </div>
            </div>
        `;

        const container = document.getElementById('live-notifications-container');
        if (container) {
            container.appendChild(notification);

            // Trigger animation
            setTimeout(() => {
                notification.classList.add('show');
            }, 100);

            // Remove after 5 seconds
            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, 5000);
        }
    }

    // Start showing notifications after page load
    document.addEventListener('DOMContentLoaded', function () {
        // Show first notification after 3 seconds
        setTimeout(() => {
            createNotification();

            // Then show random notifications every 8-15 seconds
            setInterval(() => {
                createNotification();
            }, Math.random() * 7000 + 8000); // Random between 8-15 seconds
        }, 3000);
    });
</script>