document.addEventListener("DOMContentLoaded", function () {
    // Smooth Scroll for Internal Links
    const links = document.querySelectorAll('a[href^="#"]');
    links.forEach(link => {
        link.addEventListener("click", function (event) {
            event.preventDefault();
            const targetId = link.getAttribute("href").substring(1);
            const targetElement = document.getElementById(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: "smooth",
                    block: "start"
                });
            }
        });
    });

    // Scroll-based animation for products with vibration
    const products = document.querySelectorAll('.product[data-scroll]');
    const visibleProducts = new Set(); // Track currently visible products

    // Check if the device supports vibration and is a mobile device
    const isMobile = /Mobi|Android/i.test(navigator.userAgent);
    
    function handleScroll() {
        products.forEach(product => {
            const rect = product.getBoundingClientRect();
            const windowHeight = window.innerHeight;

            if (rect.top < windowHeight && rect.bottom > 0) {
                // Product is visible
                product.style.opacity = '1';
                product.style.transform = 'translateY(0)';

                if (!visibleProducts.has(product)) {
                    // Product appeared for the first time or reappeared
                    visibleProducts.add(product);

                    // Trigger vibration only on mobile devices
                    if (isMobile && navigator.vibrate) {
                        navigator.vibrate(20); // Short pattern
                    }
                }
            } else {
                // Product is not visible
                product.style.opacity = '0';
                product.style.transform = 'translateY(50px)';
                visibleProducts.delete(product); // Remove from visible set
            }
        });
    }

    window.addEventListener('scroll', handleScroll);
    handleScroll();

    // Product hover effects
    document.querySelectorAll('.product').forEach(product => {
        product.addEventListener('mousemove', (e) => {
            const image = product.querySelector('img');

            // Get the position of the mouse relative to the product
            const rect = product.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            // Increase rotation angles for a more noticeable effect
            const rotationX = ((y / rect.height) - 0.5) * 30; // Max rotation 30 degrees
            const rotationY = ((x / rect.width) - 0.5) * -30; // Max rotation 30 degrees

            // Apply the transformation with stronger scaling
            image.style.transform = `rotateX(${rotationX}deg) rotateY(${rotationY}deg) scale(1.1)`;

            // Adjust box-shadow based on mouse position to simulate depth
            const shadowX = ((x / rect.width) * 20 - 10) * -1; // Horizontal shadow movement
            const shadowY = ((y / rect.height) * 20 - 10) * -1; // Vertical shadow movement
            image.style.boxShadow = `${shadowX}px ${shadowY}px 30px rgba(0, 0, 0, 0.4)`; // Stronger shadow under the image
        });

        // Reset the transformation and shadow when the mouse leaves
        product.addEventListener('mouseleave', () => {
            const image = product.querySelector('img');
            image.style.transform = 'rotateX(0) rotateY(0) scale(1)';
            image.style.boxShadow = '0 10px 20px rgba(0, 0, 0, 0.2)'; // Reset default shadow
        });
    });

    // Navbar Scroll Hide/Show Logic
    let lastScrollTop = 0;
    const navbar = document.querySelector('.navbar');
    let isHoveringNavbar = false; // Track if the mouse is over the navbar

    // Function to check mouse position and show/hide navbar
    function checkMousePosition(event) {
        if (event.clientY <= 50) {  // Trigger when mouse is within 50px of top
            navbar.classList.remove('hidden');
        }
    }

    // Scroll event to hide the navbar when scrolling down
    window.addEventListener('scroll', () => {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

        if (scrollTop > lastScrollTop) {
            // Scrolling down
            if (!isHoveringNavbar) {
                navbar.classList.add('hidden');
            }
        } else {
            // Scrolling up
            navbar.classList.remove('hidden');
        }

        lastScrollTop = scrollTop <= 0 ? 0 : scrollTop; // For mobile or negative scrolling
    });

    // Mouse move event to trigger navbar appearance when near top
    window.addEventListener('mousemove', checkMousePosition);

    // Prevent navbar from hiding when hovering over it
    navbar.addEventListener('mouseenter', () => {
        isHoveringNavbar = true;
        navbar.classList.remove('hidden'); // Ensure it stays visible when hovering
    });

    navbar.addEventListener('mouseleave', () => {
        isHoveringNavbar = false;
    });
});