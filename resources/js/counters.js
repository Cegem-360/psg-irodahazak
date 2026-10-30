// Home page counters (components/pages/sections/home/bizalomerosito.blade.php).
// The HTML already holds the final values; once the block scrolls into view they
// count up from 0. Runs on every "livewire:navigated" (also fired on the first
// page load), so it works after wire:navigate page changes too.

function animateCounter(el) {
    const to = parseInt(el.getAttribute("data-to"));
    const suffix = el.getAttribute("data-suffix") || "";
    const duration = 1500;
    const stepTime = Math.max(Math.floor(duration / to), 30);
    const increment = to / (duration / stepTime);
    let current = 0;

    el.textContent = current + suffix;

    function updateCounter() {
        current += increment;

        if (current < to) {
            el.textContent = Math.floor(current) + suffix;
            setTimeout(updateCounter, stepTime);
        } else {
            el.textContent = to + suffix;
        }
    }

    updateCounter();
}

document.addEventListener("livewire:navigated", () => {
    const counters = document.querySelectorAll(".counter");
    const block = counters[0]?.closest(".grid");

    if (!block || block.dataset.countersInitialized) {
        return;
    }

    block.dataset.countersInitialized = "true";

    const observer = new IntersectionObserver(
        (entries) => {
            if (entries.some((entry) => entry.isIntersecting)) {
                counters.forEach(animateCounter);
                observer.disconnect();
            }
        },
        { threshold: 0.8 },
    );

    observer.observe(block);
});
