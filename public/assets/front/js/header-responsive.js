/**
 * RESPONSIVE MENU & STICKY HEADER HANDLER
 */

(function() {
    'use strict';
    
    // Wait for DOM to be ready
    document.addEventListener('DOMContentLoaded', function() {
        
        // ============================================
        // MOBILE MENU TOGGLE
        // ============================================
        
        const menuToggle = document.querySelector('.navbar-toggler');
        const menuCollapse = document.querySelector('.navbar-collapse');
        const header = document.querySelector('.ecommerce-header');
        
        if (menuToggle && menuCollapse) {
            // Toggle menu on button click
            menuToggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                menuCollapse.classList.toggle('show');
                document.body.style.overflow = menuCollapse.classList.contains('show') ? 'hidden' : '';
            });
            
            // Close menu when clicking outside
            document.addEventListener('click', function(e) {
                if (menuCollapse.classList.contains('show')) {
                    if (!menuCollapse.contains(e.target) && !menuToggle.contains(e.target)) {
                        menuCollapse.classList.remove('show');
                        document.body.style.overflow = '';
                    }
                }
            });
            
            // Close menu on ESC key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && menuCollapse.classList.contains('show')) {
                    menuCollapse.classList.remove('show');
                    document.body.style.overflow = '';
                }
            });
            
            // Add close button to mobile menu if not exists
            if (window.innerWidth < 992) {
                let closeBtn = menuCollapse.querySelector('.close-menu');
                if (!closeBtn) {
                    closeBtn = document.createElement('button');
                    closeBtn.className = 'close-menu';
                    closeBtn.innerHTML = '&times;';
                    closeBtn.setAttribute('aria-label', 'Close menu');
                    menuCollapse.insertBefore(closeBtn, menuCollapse.firstChild);
                    
                    closeBtn.addEventListener('click', function() {
                        menuCollapse.classList.remove('show');
                        document.body.style.overflow = '';
                    });
                }
            }
            
            // Close menu on window resize to desktop
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 992 && menuCollapse.classList.contains('show')) {
                    menuCollapse.classList.remove('show');
                    document.body.style.overflow = '';
                }
            });
        }
        
        // ============================================
        // DROPDOWN TOGGLE FOR MOBILE
        // ============================================
        
        const dropdownToggles = document.querySelectorAll('.navbar-nav .dropdown-toggle');
        
        dropdownToggles.forEach(function(toggle) {
            toggle.addEventListener('click', function(e) {
                if (window.innerWidth < 992) {
                    e.preventDefault();
                    const parent = this.parentElement;
                    const dropdown = parent.querySelector('.dropdown-menu');
                    
                    if (dropdown) {
                        const isVisible = dropdown.classList.contains('show');
                        
                        // Close all other dropdowns
                        document.querySelectorAll('.navbar-nav .dropdown-menu').forEach(function(menu) {
                            menu.classList.remove('show');
                        });
                        document.querySelectorAll('.navbar-nav .dropdown-toggle').forEach(function(tog) {
                            tog.classList.remove('active');
                        });
                        
                        // Toggle current dropdown
                        if (!isVisible) {
                            dropdown.classList.add('show');
                            this.classList.add('active');
                        }
                    }
                }
            });
        });
        
        // ============================================
        // STICKY HEADER SCROLL EFFECT
        // ============================================
        
        if (header) {
            let lastScroll = 0;
            
            window.addEventListener('scroll', function() {
                const currentScroll = window.pageYOffset;
                
                // Add shadow when scrolled
                if (currentScroll > 50) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
                
                lastScroll = currentScroll;
            });
        }
        
        // ============================================
        // PREVENT DROPDOWN MENU CUTOFF
        // ============================================
        
        const megaDropdowns = document.querySelectorAll('.mega-dropdown');
        
        megaDropdowns.forEach(function(dropdown) {
            dropdown.addEventListener('mouseenter', function() {
                if (window.innerWidth >= 992) {
                    const menu = this.querySelector('.mega-dropdown-menu');
                    if (menu) {
                        const rect = menu.getBoundingClientRect();
                        const viewportWidth = window.innerWidth;
                        
                        // Adjust if menu goes off-screen to the right
                        if (rect.right > viewportWidth) {
                            menu.style.left = 'auto';
                            menu.style.right = '0';
                        }
                    }
                }
            });
        });
        
        // ============================================
        // SMOOTH SCROLL FOR ANCHOR LINKS
        // ============================================
        
        document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href !== '#' && href.length > 1) {
                    const target = document.querySelector(href);
                    if (target) {
                        e.preventDefault();
                        const headerHeight = header ? header.offsetHeight : 0;
                        const targetPosition = target.offsetTop - headerHeight - 20;
                        
                        window.scrollTo({
                            top: targetPosition,
                            behavior: 'smooth'
                        });
                        
                        // Close mobile menu if open
                        if (menuCollapse && menuCollapse.classList.contains('show')) {
                            menuCollapse.classList.remove('show');
                            document.body.style.overflow = '';
                        }
                    }
                }
            });
        });
        
        console.log('✅ Responsive menu and sticky header initialized');
    });
})();
