// Initialize ScrollReveal
const scrollRevealConfig = {
    distance: '50px',
    duration: 800,
    easing: 'ease-out',
    opacity: 0,
    scale: 0.95,
    reset: false
};

ScrollReveal().reveal('.hero, .product, .cta, .footer', scrollRevealConfig);