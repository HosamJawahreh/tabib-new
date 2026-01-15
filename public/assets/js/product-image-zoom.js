/**
 * Product Image Zoom JavaScript
 * Smooth, non-shaky zoom with great mobile UX
 * Features:
 * - Smooth desktop hover zoom
 * - Mobile pinch-to-zoom
 * - Tap to open fullscreen
 * - No jittery/shaking effects
 * - Hardware accelerated
 */

(function() {
    'use strict';

    // Configuration
    const config = {
        zoomScale: 2.5,
        mobileZoomScale: 3,
        transitionDuration: 300,
        enableMobileFullscreen: true,
        enableDesktopMagnifier: true
    };

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    function init() {
        console.log('🔍 Product Image Zoom: Initializing...');
        
        // Find all product images to zoom
        const imageContainers = document.querySelectorAll('.product-image-zoom-container, .product-img-holder, .single-product-image');
        
        if (imageContainers.length === 0) {
            console.log('⚠️ No product images found to zoom');
            return;
        }

        imageContainers.forEach(setupImageZoom);
        console.log(`✅ Initialized zoom for ${imageContainers.length} images`);
    }

    function setupImageZoom(container) {
        const img = container.querySelector('img');
        if (!img) return;

        // Add necessary classes
        container.classList.add('product-image-zoom-container');
        
        // Detect device type
        const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent) || 
                        ('ontouchstart' in window) || 
                        (navigator.maxTouchPoints > 0);

        if (isMobile) {
            setupMobileZoom(container, img);
        } else {
            setupDesktopZoom(container, img);
        }
    }

    // Desktop Zoom (Hover to Zoom)
    function setupDesktopZoom(container, img) {
        let isZooming = false;
        let rafId = null;

        // Smooth mouse move zoom
        container.addEventListener('mousemove', function(e) {
            if (rafId) cancelAnimationFrame(rafId);
            
            rafId = requestAnimationFrame(() => {
                const rect = container.getBoundingClientRect();
                const x = ((e.clientX - rect.left) / rect.width) * 100;
                const y = ((e.clientY - rect.top) / rect.height) * 100;
                
                img.style.transformOrigin = `${x}% ${y}%`;
            });
        });

        // Reset on mouse leave
        container.addEventListener('mouseleave', function() {
            if (rafId) cancelAnimationFrame(rafId);
            img.style.transformOrigin = 'center center';
            container.classList.remove('zoomed');
        });

        // Click to toggle zoom level
        container.addEventListener('click', function(e) {
            e.preventDefault();
            container.classList.toggle('zoomed');
        });
    }

    // Mobile Zoom (Tap for Fullscreen, Pinch to Zoom)
    function setupMobileZoom(container, img) {
        // Tap to open fullscreen zoom
        container.addEventListener('click', function(e) {
            e.preventDefault();
            openMobileZoom(img);
        });

        // Prevent context menu on long press
        container.addEventListener('contextmenu', function(e) {
            e.preventDefault();
        });
    }

    // Open fullscreen zoom modal for mobile
    function openMobileZoom(img) {
        // Create overlay
        const overlay = document.createElement('div');
        overlay.className = 'mobile-zoom-overlay active';
        
        // Create content container
        const content = document.createElement('div');
        content.className = 'mobile-zoom-content';
        
        // Clone image
        const zoomedImg = img.cloneNode(true);
        zoomedImg.style.transform = 'scale(1)';
        
        // Create close button
        const closeBtn = document.createElement('button');
        closeBtn.className = 'mobile-zoom-close';
        closeBtn.innerHTML = '×';
        closeBtn.setAttribute('aria-label', 'Close zoom');
        
        // Create instructions
        const instructions = document.createElement('div');
        instructions.className = 'zoom-instructions';
        instructions.textContent = 'Pinch to zoom • Drag to pan • Tap to close';
        
        // Assemble
        content.appendChild(zoomedImg);
        overlay.appendChild(content);
        overlay.appendChild(closeBtn);
        overlay.appendChild(instructions);
        document.body.appendChild(overlay);
        
        // Prevent body scroll
        document.body.style.overflow = 'hidden';
        
        // Setup pinch-to-zoom
        setupPinchZoom(zoomedImg, content);
        
        // Close handlers
        const closeZoom = () => {
            overlay.classList.remove('active');
            setTimeout(() => {
                document.body.removeChild(overlay);
                document.body.style.overflow = '';
            }, 300);
        };
        
        closeBtn.addEventListener('click', closeZoom);
        overlay.addEventListener('click', function(e) {
            if (e.target === overlay || e.target === content) {
                closeZoom();
            }
        });
    }

    // Pinch-to-zoom functionality
    function setupPinchZoom(img, container) {
        let scale = 1;
        let startDistance = 0;
        let startScale = 1;
        let isPinching = false;
        
        // Pan variables
        let isDragging = false;
        let startX = 0, startY = 0;
        let translateX = 0, translateY = 0;
        
        // Touch start
        container.addEventListener('touchstart', function(e) {
            if (e.touches.length === 2) {
                // Pinch start
                e.preventDefault();
                isPinching = true;
                startDistance = getDistance(e.touches[0], e.touches[1]);
                startScale = scale;
            } else if (e.touches.length === 1 && scale > 1) {
                // Pan start
                isDragging = true;
                startX = e.touches[0].clientX - translateX;
                startY = e.touches[0].clientY - translateY;
            }
        }, { passive: false });
        
        // Touch move
        container.addEventListener('touchmove', function(e) {
            if (isPinching && e.touches.length === 2) {
                e.preventDefault();
                const currentDistance = getDistance(e.touches[0], e.touches[1]);
                scale = Math.min(Math.max(1, startScale * (currentDistance / startDistance)), 4);
                updateTransform();
            } else if (isDragging && e.touches.length === 1) {
                e.preventDefault();
                translateX = e.touches[0].clientX - startX;
                translateY = e.touches[0].clientY - startY;
                updateTransform();
            }
        }, { passive: false });
        
        // Touch end
        container.addEventListener('touchend', function(e) {
            if (e.touches.length < 2) {
                isPinching = false;
            }
            if (e.touches.length === 0) {
                isDragging = false;
                
                // Reset if zoomed out
                if (scale <= 1) {
                    scale = 1;
                    translateX = 0;
                    translateY = 0;
                    updateTransform();
                }
            }
        });
        
        // Double tap to zoom
        let lastTap = 0;
        container.addEventListener('touchend', function(e) {
            const currentTime = new Date().getTime();
            const tapLength = currentTime - lastTap;
            
            if (tapLength < 300 && tapLength > 0) {
                e.preventDefault();
                if (scale === 1) {
                    scale = 2;
                } else {
                    scale = 1;
                    translateX = 0;
                    translateY = 0;
                }
                updateTransform();
            }
            lastTap = currentTime;
        });
        
        function updateTransform() {
            img.style.transform = `translate(${translateX}px, ${translateY}px) scale(${scale})`;
        }
        
        function getDistance(touch1, touch2) {
            const dx = touch1.clientX - touch2.clientX;
            const dy = touch1.clientY - touch2.clientY;
            return Math.sqrt(dx * dx + dy * dy);
        }
    }

    // Thumbnail navigation (if exists)
    function setupThumbnails() {
        const thumbnails = document.querySelectorAll('.product-thumbnail');
        const mainImage = document.querySelector('.product-image-zoom-container img');
        
        if (!mainImage || thumbnails.length === 0) return;
        
        thumbnails.forEach((thumb, index) => {
            thumb.addEventListener('click', function() {
                // Remove active class from all
                thumbnails.forEach(t => t.classList.remove('active'));
                
                // Add active to clicked
                this.classList.add('active');
                
                // Update main image
                const newSrc = this.querySelector('img').getAttribute('data-full-image') || 
                              this.querySelector('img').src;
                mainImage.src = newSrc;
                
                // Add loading state
                const container = mainImage.closest('.product-image-zoom-container');
                container.classList.add('loading');
                
                mainImage.onload = function() {
                    container.classList.remove('loading');
                };
            });
        });
        
        // Mark first thumbnail as active
        if (thumbnails[0]) {
            thumbnails[0].classList.add('active');
        }
    }

    // Setup thumbnails after a brief delay
    setTimeout(setupThumbnails, 500);

    // Export for manual initialization
    window.ProductImageZoom = {
        init: init,
        setupImageZoom: setupImageZoom
    };

    console.log('✅ Product Image Zoom: Ready!');
})();
