(function () {
    let currentScroll = window.pageYOffset; // Current scroll position
    let targetScroll = currentScroll;       // Target scroll position
    const scrollSpeed = 0.1;                // Adjust for smoothness (lower = smoother, slower)

    // Smooth scrolling loop
    function smoothScrollLoop() {
        currentScroll += (targetScroll - currentScroll) * scrollSpeed;

        // Scroll to the calculated position
        window.scrollTo(0, Math.round(currentScroll));

        // Continue animating if the scroll target isn't reached
        if (Math.abs(currentScroll - targetScroll) > 0.5) {
            requestAnimationFrame(smoothScrollLoop);
        }
    }

    // Handle scroll input
    function handleScrollEvent(event) {
        targetScroll += event.deltaY || -event.wheelDelta || event.detail * 10;

        // Clamp targetScroll to the page boundaries
        targetScroll = Math.max(
            0,
            Math.min(targetScroll, document.body.scrollHeight - window.innerHeight)
        );

        // Trigger the scroll loop if not already running
        if (Math.abs(currentScroll - targetScroll) > 0.5) {
            smoothScrollLoop();
        }

        // Prevent default scrolling behavior
        event.preventDefault();
    }

    // Attach event listeners for wheel and touch scrolling
    document.addEventListener("wheel", handleScrollEvent, { passive: false });
    document.addEventListener("touchmove", handleScrollEvent, { passive: false });
})();
