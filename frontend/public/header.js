/**
 * Header Interactive Functionality
 * Handles mobile menu toggle, language dropdown, and scroll effects
 */

document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const header = document.getElementById('main-header');
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIcon = document.getElementById('menu-icon');
    const closeIcon = document.getElementById('close-icon');
    const langButton = document.getElementById('lang-button');
    const langDropdown = document.getElementById('lang-dropdown');
    const langArrow = document.getElementById('lang-arrow');
    
    let mobileMenuOpen = false;
    let langDropdownOpen = false;

    // Mobile Menu Toggle
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
            mobileMenuOpen = !mobileMenuOpen;
            
            if (mobileMenuOpen) {
                // Open menu
                mobileMenu.classList.remove('-translate-y-full', 'opacity-0', 'invisible');
                mobileMenu.classList.add('translate-y-0', 'opacity-100', 'visible');
                menuIcon.classList.add('hidden');
                closeIcon.classList.remove('hidden');
                document.body.style.overflow = 'hidden'; // Prevent scrolling
            } else {
                // Close menu
                mobileMenu.classList.add('-translate-y-full', 'opacity-0', 'invisible');
                mobileMenu.classList.remove('translate-y-0', 'opacity-100', 'visible');
                menuIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');
                document.body.style.overflow = ''; // Restore scrolling
            }
        });

        // Close mobile menu when clicking on a link
        const mobileLinks = mobileMenu.querySelectorAll('a');
        mobileLinks.forEach(link => {
            link.addEventListener('click', function() {
                mobileMenuOpen = false;
                mobileMenu.classList.add('-translate-y-full', 'opacity-0', 'invisible');
                mobileMenu.classList.remove('translate-y-0', 'opacity-100', 'visible');
                menuIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');
                document.body.style.overflow = '';
            });
        });
    }

    // Language Dropdown Toggle
    if (langButton && langDropdown) {
        langButton.addEventListener('click', function(e) {
            e.stopPropagation();
            langDropdownOpen = !langDropdownOpen;
            
            if (langDropdownOpen) {
                langDropdown.classList.remove('opacity-0', 'invisible', 'scale-95');
                langDropdown.classList.add('opacity-100', 'visible', 'scale-100');
                langArrow.style.transform = 'rotate(180deg)';
            } else {
                langDropdown.classList.add('opacity-0', 'invisible', 'scale-95');
                langDropdown.classList.remove('opacity-100', 'visible', 'scale-100');
                langArrow.style.transform = 'rotate(0deg)';
            }
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!langButton.contains(e.target) && !langDropdown.contains(e.target)) {
                langDropdownOpen = false;
                langDropdown.classList.add('opacity-0', 'invisible', 'scale-95');
                langDropdown.classList.remove('opacity-100', 'visible', 'scale-100');
                langArrow.style.transform = 'rotate(0deg)';
            }
        });
    }

    // Header Scroll Effect - Add shadow and adjust blur on scroll
    let lastScroll = 0;
    
    window.addEventListener('scroll', function() {
        const currentScroll = window.pageYOffset;
        
        if (currentScroll > 50) {
            header.classList.add('scrolled');
            // Add stronger shadow on scroll
            header.querySelector('.glass-header').classList.add('shadow-xl');
        } else {
            header.classList.remove('scrolled');
            header.querySelector('.glass-header').classList.remove('shadow-xl');
        }
        
        lastScroll = currentScroll;
    });

    // Close mobile menu on window resize (when switching to desktop view)
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 768 && mobileMenuOpen) {
            mobileMenuOpen = false;
            mobileMenu.classList.add('-translate-y-full', 'opacity-0', 'invisible');
            mobileMenu.classList.remove('translate-y-0', 'opacity-100', 'visible');
            menuIcon.classList.remove('hidden');
            closeIcon.classList.add('hidden');
            document.body.style.overflow = '';
        }
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href !== '#' && document.querySelector(href)) {
                e.preventDefault();
                const target = document.querySelector(href);
                const headerHeight = header.offsetHeight;
                const targetPosition = target.offsetTop - headerHeight;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
});