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
    $(document).on('click', '.cart-icon-clean.add-cart', function(e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
        
        var $button = $(this);
        var dataHref = $button.data('href');
        
        // Prevent double-clicks and duplicate execution
        if ($button.hasClass('loading') || $button.prop('disabled') || cartAddInProgress) {
            return false;
        }
        
        // Set flag to prevent duplicate execution
        cartAddInProgress = true;
        
        // Add loading state
        setLoadingState($button);
        
        $.get(dataHref, function(data) {
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
                $("#total-cost").html(data[1]);
                $(".cart-popup").load(mainurl + "/carts/view");
                
                // Success animation
                setSuccessState($button);
                toastr.success(lang.cart_success);
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
