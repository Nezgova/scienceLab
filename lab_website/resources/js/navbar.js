// public/js/navbar.js

document.addEventListener('DOMContentLoaded', function() {
    const indicator = document.querySelector('.nav-indicator');
    const items = document.querySelectorAll('.nav-links li');

    function handleIndicator(el) {
        const bbox = el.getBoundingClientRect();
        const navBBox = document.querySelector('.nav-links').getBoundingClientRect();

        indicator.style.width = `${bbox.width}px`;
        indicator.style.height = `${bbox.height}px`;
        indicator.style.left = `${bbox.left - navBBox.left}px`;
        indicator.style.top = `${bbox.top - navBBox.top}px`;
    }

    // Add hover effect
    items.forEach(item => {
        item.addEventListener('mouseenter', () => {
            handleIndicator(item);
        });
    });

    // Return to active element when leaving navigation
    const navLinks = document.querySelector('.nav-links');
    navLinks.addEventListener('mouseleave', () => {
        const activeItem = document.querySelector('.nav-links a.active');
        if (activeItem) {
            handleIndicator(activeItem.parentElement);
        }
    });

    // Set initial position
    window.addEventListener('load', () => {
        const activeItem = document.querySelector('.nav-links a.active');
        if (activeItem) {
            handleIndicator(activeItem.parentElement);
        }
    });

    // Update on window resize
    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            const activeItem = document.querySelector('.nav-links a.active');
            if (activeItem) {
                handleIndicator(activeItem.parentElement);
            }
        }, 250);
    });
});