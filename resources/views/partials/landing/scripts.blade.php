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
</script>