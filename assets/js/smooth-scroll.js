// Smooth scrolling setup
(function() {
    let currentScroll = window.pageYOffset; // Current scroll position
    let targetScroll = currentScroll;       // Target scroll position
    const scrollSpeed = 0.1;                // Adjust for scroll speed (lower = slower)

    // Ease function (customize for different feel)
    function ease(t) {
        return t < 0.5 ? 2 * t * t : 1 - Math.pow(-2 * t + 2, 2) / 2;
    }

    // Smooth scrolling loop
    function smoothScrollLoop() {
        currentScroll += (targetScroll - currentScroll) * scrollSpeed;
        window.scrollTo(0, Math.round(currentScroll));

        // Continue animating if the scroll target isn't reached
        if (Math.abs(currentScroll - targetScroll) > 0.5) {
            requestAnimationFrame(smoothScrollLoop);
        } else {
            currentScroll = targetScroll; // Prevent overshooting
        }
    }

    // Listen to wheel and touch scroll events
    function handleScrollEvent(event) {
        targetScroll += event.deltaY || -event.wheelDelta || event.detail * 10; // Handle scroll deltas
        targetScroll = Math.max(0, Math.min(targetScroll, document.body.scrollHeight - window.innerHeight)); // Keep in bounds
        event.preventDefault(); // Prevent default scrolling
        if (!scrolling) {
            scrolling = true;
            smoothScrollLoop();
        }
    }

    let scrolling = false;
    document.addEventListener('wheel', handleScrollEvent, { passive: false });
    document.addEventListener('touchmove', handleScrollEvent, { passive: false });
})();
