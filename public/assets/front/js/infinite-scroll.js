/**
 * Infinite Scroll for Products
 * Loads 24 products at a time when user scrolls to bottom
 */

(function($) {
    'use strict';

    let isLoading = false;
    let currentPage = 2; // Start from page 2 since page 1 is loaded initially
    let hasMorePages = true;

    /**
     * Check if user has scrolled near bottom of page
     */
    function isNearBottom() {
        const scrollTop = $(window).scrollTop();
        const windowHeight = $(window).height();
        const documentHeight = $(document).height();
        const scrollPercentage = ((scrollTop + windowHeight) / documentHeight) * 100;

        // Load more when user reaches 80% of page
        return scrollPercentage >= 80;
    }

    /**
     * Load more products via AJAX
     */
    function loadMoreProducts() {
        if (isLoading || !hasMorePages) {
            return;
        }

        isLoading = true;

        // Show loading indicator
        $('#products-loading').removeClass('d-none');

        $.ajax({
            url: '{{ route("front.products.load") }}',
            method: 'GET',
            data: {
                page: currentPage
            },
            dataType: 'json',
            success: function(response) {
                if (response.html) {
                    // Append new products to grid
                    $('#products-grid').append(response.html);

                    // Update pagination state
                    hasMorePages = response.has_more;
                    currentPage = response.next_page || currentPage;

                    // Hide loading indicator
                    $('#products-loading').addClass('d-none');

                    // Show "no more products" message if done
                    if (!hasMorePages) {
                        $('#products-end-message').removeClass('d-none');
                    }
                }

                isLoading = false;
            },
            error: function(xhr, status, error) {
                console.error('Error loading products:', error);
                $('#products-loading').addClass('d-none');
                isLoading = false;

                // Show error message
                if ($('#products-error').length) {
                    $('#products-error').removeClass('d-none');
                }
            }
        });
    }

    /**
     * Initialize infinite scroll
     */
    function initInfiniteScroll() {
        // Check if we're on a page with infinite scroll
        if ($('#products-grid').length === 0) {
            return;
        }

        // Handle scroll event
        $(window).on('scroll', function() {
            if (isNearBottom() && !isLoading && hasMorePages) {
                loadMoreProducts();
            }
        });

        // Initial check in case content doesn't fill the page
        setTimeout(function() {
            if ($(document).height() <= $(window).height() && hasMorePages) {
                loadMoreProducts();
            }
        }, 500);
    }

    /**
     * Initialize on document ready
     */
    $(document).ready(function() {
        initInfiniteScroll();
    });

})(jQuery);
