/**
 * Enhanced Product Card Cart Functionality
 * Adds loading states and success animations to cart buttons
 * Prevents duplicate alerts by stopping event propagation
 */

(function($) {
    'use strict';

    // Initialize tooltips for cart buttons
    function initTooltips() {
        $('[data-bs-toggle="tooltip"]').tooltip();
    }

    // Add loading state to cart button
    function setLoadingState($button) {
        $button.addClass('loading').prop('disabled', true);
    }

    // Remove loading state and add success animation
    function setSuccessState($button) {
        $button.removeClass('loading').addClass('added');
        setTimeout(function() {
            $button.removeClass('added').prop('disabled', false);
        }, 1000);
    }

    // Remove loading state on error
    function removeLoadingState($button) {
        $button.removeClass('loading').prop('disabled', false);
    }

    // Flag to prevent duplicate execution
    var cartAddInProgress = false;

    // Override the default add-cart click handler to add animations
    // Use a very specific selector and stop all event propagation
    $(document).off('click', '.cart-icon-clean.add-cart');
    $(document).off('click', '.add-cart');
    
    $(document).on('click', '.cart-icon-clean.add-cart, .add-cart', function(e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
        
        var $button = $(this);
        var dataHref = $button.data('href');
        
        console.log('Cart button clicked:', {
            hasDataHref: !!dataHref,
            productId: $button.data('product-id'),
            productName: $button.data('product-name'),
            productPrice: $button.data('product-price')
        });
        
        // Prevent double-clicks and duplicate execution
        if ($button.hasClass('loading') || $button.prop('disabled') || cartAddInProgress) {
            console.log('Cart add blocked - already in progress');
            return false;
        }
        
        // Set flag to prevent duplicate execution
        cartAddInProgress = true;
        
        // Add loading state
        setLoadingState($button);
        
        // Get product data for Facebook Pixel
        var productId = $button.data('product-id');
        var productName = $button.data('product-name');
        var productPrice = $button.data('product-price');
        
        console.log('Making AJAX request to:', dataHref);
        console.log('Making AJAX request to:', dataHref);
        
        $.get(dataHref, function(data) {
            console.log('Cart response:', data);
            
            if (data == "digital") {
                toastr.error(lang.cart_already);
                removeLoadingState($button);
            } else if (data[0] == 0) {
                toastr.error(lang.cart_out);
                removeLoadingState($button);
            } else {
                // Update cart counts
                $("#cart-count").html(data[0]);
                $("#cart-count1").html(data[0]);
                // Show badge when items added
                if (data[0] > 0) {
                    $("#cart-count").show();
                    $("#cart-count1").show();
                } else {
                    $("#cart-count").hide();
                    $("#cart-count1").hide();
                }
                $("#total-cost").html(data[1]);
                $(".cart-popup").load(mainurl + "/carts/view");
                
                // Success animation
                setSuccessState($button);
                toastr.success(lang.cart_success);
                
                // Track Facebook Pixel AddToCart (if available)
                if (productId && productName && productPrice) {
                    console.log('Attempting Facebook Pixel tracking...', {
                        id: productId,
                        name: productName,
                        price: productPrice,
                        hasTrackerObject: typeof FacebookPixelTracker !== 'undefined',
                        hasFbq: typeof fbq !== 'undefined'
                    });
                    
                    try {
                        if (typeof FacebookPixelTracker !== 'undefined' && FacebookPixelTracker.trackAddToCart) {
                            console.log('Using FacebookPixelTracker.trackAddToCart');
                            FacebookPixelTracker.trackAddToCart({
                                id: productId,
                                name: productName,
                                price: productPrice
                            }, 1);
                        } else if (typeof fbq !== 'undefined') {
                            // Fallback to direct fbq call if FacebookPixelTracker is not available
                            console.log('Using direct fbq call');
                            fbq('track', 'AddToCart', {
                                content_ids: [productId],
                                content_name: productName,
                                content_type: 'product',
                                value: productPrice,
                                currency: 'JOD'
                            });
                        } else {
                            console.warn('No Facebook Pixel tracking method available');
                        }
                    } catch (err) {
                        console.error('Facebook Pixel tracking error:', err);
                    }
                } else {
                    console.warn('Missing product data for Facebook Pixel:', {
                        productId: productId,
                        productName: productName,
                        productPrice: productPrice
                    });
                }
            }
            
            // Reset flag after a short delay
            setTimeout(function() {
                cartAddInProgress = false;
            }, 500);
        }).fail(function() {
            toastr.error('Failed to add item to cart. Please try again.');
            removeLoadingState($button);
            
            // Reset flag
            setTimeout(function() {
                cartAddInProgress = false;
            }, 500);
        });
        
        return false;
    });

    // Handle quick add to cart
    $(document).on('click', '.add-to-cart-quick', function(e) {
        e.preventDefault();
        
        var $button = $(this);
        var dataHref = $button.data('href');
        
        setLoadingState($button);
        
        $.get(dataHref, function(data) {
            if (data == 0) {
                toastr.error(lang.cart_out);
                removeLoadingState($button);
            } else {
                setSuccessState($button);
                window.location = mainurl + "/checkout";
            }
        }).fail(function() {
            toastr.error('Failed to add item to cart. Please try again.');
            removeLoadingState($button);
        });
        
        return false;
    });

    // Prevent out of stock button clicks
    $(document).on('click', '.cart-out-of-stock', function(e) {
        e.preventDefault();
        toastr.warning('This product is currently out of stock.');
        return false;
    });

    // Initialize on document ready
    $(document).ready(function() {
        initTooltips();
        
        // Reinitialize tooltips after AJAX pagination
        $(document).on('productsLoaded', function() {
            initTooltips();
        });
    });

    // Reinitialize tooltips after products are loaded via AJAX
    var observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.addedNodes.length > 0) {
                initTooltips();
            }
        });
    });

    // Observe the products grid for changes
    var productsGrid = document.getElementById('products-grid');
    if (productsGrid) {
        observer.observe(productsGrid, {
            childList: true,
            subtree: true
        });
    }

})(jQuery);
