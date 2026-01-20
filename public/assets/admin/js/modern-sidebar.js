/* ========================================
   MODERN SIDEBAR - JAVASCRIPT
   Handles toggle, scroll prevention, and interactions
   ======================================== */

(function($) {
    'use strict';

    // Initialize sidebar on document ready
    $(document).ready(function() {
        initModernSidebar();
    });

    function initModernSidebar() {
        // Collapse all accordions on mobile by default
        collapseAccordionsOnMobile();

        // Prevent body scroll when sidebar is fixed
        preventBodyScroll();

        // Handle sidebar toggle for mobile
        handleSidebarToggle();

        // Handle active states
        handleActiveStates();

        // Handle accordion animations
        handleAccordionAnimations();

        // Handle mobile overlay click
        handleMobileOverlay();
    }

    // Collapse all accordion menus on mobile devices
    function collapseAccordionsOnMobile() {
        if ($(window).width() <= 991) {
            console.log('Mobile detected - collapsing all accordions');
            $('.modern-sidebar .collapse').removeClass('show');
            $('.modern-sidebar .accordion-toggle').attr('aria-expanded', 'false');
            $('.modern-sidebar .accordion-toggle').addClass('collapsed');
        }
    }

    // Prevent body scroll when sidebar menu is scrolling
    function preventBodyScroll() {
        const sidebarWrapper = $('.sidebar-menu-wrapper');

        if (sidebarWrapper.length) {
            // Prevent body scroll when scrolling inside sidebar
            sidebarWrapper.on('wheel', function(e) {
                const scrollTop = this.scrollTop;
                const scrollHeight = this.scrollHeight;
                const height = $(this).height();
                const delta = e.originalEvent.deltaY;
                const up = delta < 0;

                const prevent = function() {
                    e.stopPropagation();
                    e.preventDefault();
                    return false;
                };

                if (!up && delta > scrollHeight - height - scrollTop) {
                    // Scrolling down
                    this.scrollTop = scrollHeight;
                    return prevent();
                } else if (up && -delta > scrollTop) {
                    // Scrolling up
                    this.scrollTop = 0;
                    return prevent();
                }
            });
        }
    }

    // Handle sidebar toggle button
    function handleSidebarToggle() {
        $('#sidebarCollapse, .menu-toggle-button a, .menu-toggle-button').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            console.log('Sidebar toggle clicked!');

            // Toggle with multiple selectors for maximum compatibility
            $('#sidebar').toggleClass('active');
            $('.modern-sidebar').toggleClass('active');
            $('.nav-sidebar').toggleClass('active');
            $('nav#sidebar.modern-sidebar').toggleClass('active');

            $('body').toggleClass('sidebar-open');

            // On mobile, collapse all accordion menus when opening sidebar
            if ($(window).width() <= 991) {
                if ($('.modern-sidebar').hasClass('active')) {
                    // Sidebar is opening - collapse all dropdowns
                    console.log('Collapsing all accordion menus on mobile');
                    $('.modern-sidebar .collapse').removeClass('show');
                    $('.modern-sidebar .accordion-toggle').attr('aria-expanded', 'false');
                    $('.modern-sidebar .accordion-toggle').addClass('collapsed');
                }
            }

            console.log('Sidebar active:', $('.modern-sidebar').hasClass('active'));
            console.log('Body sidebar-open:', $('body').hasClass('sidebar-open'));
            console.log('Sidebar left position:', $('.modern-sidebar').css('left'));
        });
    }

    // Handle active menu states
    function handleActiveStates() {
        const currentUrl = window.location.href;

        // Remove active class from all menu items
        $('.menu-link, .accordion-toggle').removeClass('active');
        $('.menu-item').removeClass('active');

        // Add active class to current page
        $('.menu-link').each(function() {
            if ($(this).attr('href') === currentUrl) {
                $(this).addClass('active');
                $(this).closest('.menu-item').addClass('active');

                // Expand parent accordion if nested
                const parentCollapse = $(this).closest('.collapse');
                if (parentCollapse.length) {
                    parentCollapse.addClass('show');
                    parentCollapse.prev('.accordion-toggle').attr('aria-expanded', 'true');
                }
            }
        });
    }

    // Handle accordion smooth animations
    function handleAccordionAnimations() {
        $('.accordion-toggle').on('click', function(e) {
            const $this = $(this);
            const target = $this.attr('href') || $this.data('target');

            if (target && target !== '#') {
                const $target = $(target);

                if ($target.length) {
                    // Close other accordions at the same level
                    const parent = $target.data('parent');
                    if (parent) {
                        $(parent).find('.collapse.show').not($target).collapse('hide');
                    }
                }
            }
        });
    }

    // Handle mobile overlay click to close sidebar
    function handleMobileOverlay() {
        $(document).on('click', function(e) {
            if ($(window).width() <= 991) {
                if ($('.modern-sidebar').hasClass('active')) {
                    if (!$(e.target).closest('.modern-sidebar, .menu-toggle-button, #sidebarCollapse').length) {
                        console.log('Closing sidebar via overlay click');
                        $('#sidebar').removeClass('active');
                        $('.modern-sidebar').removeClass('active');
                        $('.nav-sidebar').removeClass('active');
                        $('nav#sidebar.modern-sidebar').removeClass('active');
                        $('body').removeClass('sidebar-open');
                    }
                }
            }
        });
    }

    // Close sidebar on route navigation (for single page apps)
    $(document).on('click', '.menu-link', function() {
        if ($(window).width() <= 991) {
            setTimeout(function() {
                $('.modern-sidebar').removeClass('active');
                $('body').removeClass('sidebar-open');
            }, 300);
        }
    });

    // Handle window resize
    let resizeTimer;
    $(window).on('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            if ($(window).width() > 991) {
                // Desktop - close mobile sidebar
                $('.modern-sidebar').removeClass('active');
                $('body').removeClass('sidebar-open');
            } else {
                // Mobile - collapse all accordions
                collapseAccordionsOnMobile();
            }
        }, 250);
    });

    // Add smooth scroll to sidebar
    $('.sidebar-menu-wrapper').css({
        'scroll-behavior': 'smooth'
    });

    // Keyboard navigation support
    $(document).on('keydown', function(e) {
        // ESC key to close sidebar on mobile
        if (e.keyCode === 27 && $(window).width() <= 991) {
            if ($('.modern-sidebar').hasClass('active')) {
                $('.modern-sidebar').removeClass('active');
                $('body').removeClass('sidebar-open');
            }
        }
    });

})(jQuery);
