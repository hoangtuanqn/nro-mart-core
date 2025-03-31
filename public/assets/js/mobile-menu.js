/**
 * Mobile Menu Functionality
 * Handles opening/closing of the mobile menu and overlay menu
 */

document.addEventListener('DOMContentLoaded', function() {
    // Add 'has-mobile-menu' class to body for proper spacing
    document.body.classList.add('has-mobile-menu');

    // Elements
    const menuToggle = document.querySelector('.menu-toggle');
    const mobileMenu = document.querySelector('.menu-mobile');
    const overlayMenu = document.querySelector('.mobile-overlay-menu');
    const overlayMenuClose = document.querySelector('.mobile-overlay-menu__close');
    const overlay = document.querySelector('.mobile-overlay');

    // Show overlay menu when clicking menu toggle
    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            overlayMenu.classList.add('active');
            overlay.classList.add('active');
            document.body.style.overflow = 'hidden'; // Prevent scrolling
        });
    }

    // Close overlay menu when clicking close button
    if (overlayMenuClose) {
        overlayMenuClose.addEventListener('click', function() {
            overlayMenu.classList.remove('active');
            overlay.classList.remove('active');
            document.body.style.overflow = ''; // Allow scrolling
        });
    }

    // Close overlay menu when clicking overlay
    if (overlay) {
        overlay.addEventListener('click', function() {
            overlayMenu.classList.remove('active');
            overlay.classList.remove('active');
            document.body.style.overflow = ''; // Allow scrolling
        });
    }

    // Show active mobile menu item based on current route
    const currentPath = window.location.pathname;
    const mobileLinks = document.querySelectorAll('.menu-mobile__link');

    mobileLinks.forEach(link => {
        const href = link.getAttribute('href');
        if (href) {
            if (currentPath === href || (href !== '/' && currentPath.startsWith(href))) {
                link.classList.add('active');
            }
        }
    });

    // Handle scroll behavior
    let lastScrollTop = 0;

    window.addEventListener('scroll', function() {
        // Only apply if the window width is mobile size
        if (window.innerWidth <= 768) {
            const currentScroll = window.pageYOffset || document.documentElement.scrollTop;

            // Scrolling down
            if (currentScroll > lastScrollTop && currentScroll > 150) {
                mobileMenu.style.transform = 'translateY(100%)';
            }
            // Scrolling up
            else {
                mobileMenu.style.transform = 'translateY(0)';
            }

            lastScrollTop = currentScroll <= 0 ? 0 : currentScroll;
        }
    }, { passive: true });
});
