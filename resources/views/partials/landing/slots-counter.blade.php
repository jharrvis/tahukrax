<section class="py-12 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 relative inline-block">
                Sekarang Waktunya Ambil Giliran Kamu
                <svg class="absolute w-full h-3 -bottom-1 left-0 text-red-500 opacity-70" viewBox="0 0 200 9"
                    fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M2.00025 6.99997C2.00025 6.99997 54.3409 1.50001 101.956 1.99998C149.571 2.49995 198.001 6.33331 198.001 6.33331"
                        stroke="currentColor" stroke-width="3" stroke-linecap="round" />
                </svg>
            </h2>

            <p class="text-gray-600 text-lg mb-8">
                Banyak yang <span class="text-red-500 font-bold underline decoration-wavy">sudah daftar</span> lebih
                dulu,
                sekarang giliran amankan slot <span
                    class="text-red-500 font-bold underline decoration-wavy">kotamu!</span>
            </p>

            <div
                class="bg-gradient-to-br from-red-600 to-orange-500 rounded-3xl p-8 md:p-10 shadow-2xl shadow-red-500/30 max-w-2xl mx-auto text-white transform hover:scale-105 transition-all duration-300 relative overflow-hidden border-4 border-white/10">
                <!-- Shine Effect -->
                <div
                    class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent skew-x-12 translate-x-[-150%] animate-shine">
                </div>

                <div class="relative z-10">
                    <h3 class="text-2xl md:text-3xl font-bold mb-4 tracking-wide drop-shadow-md">SLOT TERBATAS</h3>

                    <div class="space-y-2">
                        <div class="text-xl md:text-2xl opacity-90">
                            Batch hari ini : <span class="font-bold underline decoration-yellow-400 decoration-4">40
                                slot</span>
                        </div>

                        <div class="text-2xl md:text-4xl font-bold mt-4 animate-pulse">
                            Tersisa : <span id="slots-count"
                                class="text-yellow-300 underline decoration-white decoration-4 drop-shadow-sm">...</span> <span
                                class="text-yellow-300 underline decoration-white decoration-4 drop-shadow-sm">slot</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const STORAGE_KEY = 'tahukrax_slots_data';
        const SLOT_ELEMENT = document.getElementById('slots-count');
        const MAX_SLOTS = 40;

        // Configuration for decrement behavior
        const MIN_DECREMENT = 1;
        const MAX_DECREMENT = 3;
        // Random intervals between decrements (in milliseconds)
        // Shorter intervals for "natural" feeling during a visit? 
        // Or longer to simulate "over the day"? 
        // User says "berkurang ... dalam rentang waktu 1 hari".
        // Let's make it check every time page loads, AND set a timeout for the next decrement if user stays.
        // To strictly follow "pagi 40, siang 30, malam 5", we need a reference time.
        // But user also said "pertama kali buka random 1-40".
        // So we stick to: Start Random, then decrement over time from THAT point.

        function getTodayDateString() {
            const date = new Date();
            return date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate();
        }

        function getRandomInt(min, max) {
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }

        // Initialize or Retrieve Data
        let data = JSON.parse(localStorage.getItem(STORAGE_KEY));
        const today = getTodayDateString();

        if (!data || data.date !== today) {
            // New day or first visit: Initialize
            data = {
                date: today,
                count: getRandomInt(1, MAX_SLOTS), // Start with random 1-40 as requested
                last_updated: Date.now(),
                next_decrement_at: Date.now() + getRandomInt(1000 * 60 * 15, 1000 * 60 * 60 * 2) // Next drop in 15 mins to 2 hours
            };
            localStorage.setItem(STORAGE_KEY, JSON.stringify(data));
        }

        // Display current count
        updateDisplay(data.count);

        // Logic to simulate decrement over time if user was away
        processMissedDecrements();

        // Start live decrement loop
        scheduleNextDecrement();

        function updateDisplay(count) {
            SLOT_ELEMENT.innerText = count;

            // Visual feedback if count is low
            if (count <= 5) {
                SLOT_ELEMENT.classList.add('text-red-400');
                SLOT_ELEMENT.classList.remove('text-yellow-300');
            }
        }

        function processMissedDecrements() {
            let now = Date.now();

            // While we have passed the "next_decrement_at" time, process a decrement
            // This catches up if user closed the tab for 5 hours
            let updated = false;

            // Limit loops to prevent browser hang if data is weirdly old but date is same
            let loops = 0;
            while (now > data.next_decrement_at && data.count > 1 && loops < 50) {
                const decrease = getRandomInt(MIN_DECREMENT, MAX_DECREMENT);
                data.count = Math.max(1, data.count - decrease); // Don't go below 1 too fast

                // Schedule next
                // Random interval: 30 mins to 3 hours 
                // Adjusted to be slightly faster to ensure it drops during the day
                const interval = getRandomInt(1000 * 60 * 30, 1000 * 60 * 60 * 3);
                data.next_decrement_at += interval;
                data.last_updated = now; // update interaction time
                updated = true;
                loops++;
            }

            // If strictly catching up didn't reach "now" (because we cap loops or intervals are long),
            // just ensure next_decrement is in future.
            if (data.next_decrement_at < now) {
                data.next_decrement_at = now + getRandomInt(1000 * 60 * 15, 1000 * 60 * 60);
                updated = true;
            }

            if (updated) {
                localStorage.setItem(STORAGE_KEY, JSON.stringify(data));
                updateDisplay(data.count);
            }
        }

        function scheduleNextDecrement() {
            const now = Date.now();
            let delay = data.next_decrement_at - now;

            // Sanity check: if delay is negative (should be handled by processMissedDecrements, but just in case)
            if (delay < 0) delay = 1000;

            setTimeout(() => {
                if (data.count > 1) { // Stop at 1 or 0? "tersisa" usually implies >0. Let's stop at 1 to create urgency.
                    const decrease = getRandomInt(MIN_DECREMENT, MAX_DECREMENT);
                    data.count = Math.max(1, data.count - decrease);

                    // Set next time
                    const interval = getRandomInt(1000 * 60 * 15, 1000 * 60 * 60 * 2); // 15 mins to 2 hours
                    data.next_decrement_at = Date.now() + interval;
                    data.last_updated = Date.now();

                    localStorage.setItem(STORAGE_KEY, JSON.stringify(data));
                    updateDisplay(data.count);

                    // Recurse
                    scheduleNextDecrement();
                }
            }, delay);
        }
    });
</script>

<style>
    @keyframes shine {
        0% {
            transform: translateX(-150%) skewX(12deg);
        }

        100% {
            transform: translateX(150%) skewX(12deg);
        }
    }

    .animate-shine {
        animation: shine 3s infinite;
    }
</style>