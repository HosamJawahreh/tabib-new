/**
 * Professional Facebook Pixel E-commerce Tracking
 * Tracks all standard e-commerce events with proper currency (JOD - Jordanian Dinar)
 * Created: 2026-01-25
 * 
 * Standard Events Tracked:
 * - ViewContent (Product Page View)
 * - AddToCart (Add to Cart)
 * - InitiateCheckout (Start Checkout)
 * - Purchase (Order Completed)
 * - Search (Product Search)
 * - AddToWishlist (Wishlist)
 */

(function($) {
    'use strict';

    // Check if Facebook Pixel is loaded
    if (typeof fbq === 'undefined') {
        console.warn('Facebook Pixel not loaded');
        return;
    }

    // Currency constant - Jordanian Dinar
    const CURRENCY = 'JOD';

    /**
     * Facebook Pixel E-commerce Tracker
     */
    window.FacebookPixelTracker = {
        
        /**
         * Track Product View (ViewContent)
         * @param {Object} product - Product details
         */
        trackViewContent: function(product) {
            try {
                fbq('track', 'ViewContent', {
                    content_name: product.name,
                    content_ids: [product.id.toString()],
                    content_type: 'product',
                    value: parseFloat(product.price),
                    currency: CURRENCY
                });
                console.log('✓ Facebook Pixel: ViewContent tracked', product);
            } catch (error) {
                console.error('Facebook Pixel ViewContent error:', error);
            }
        },

        /**
         * Track Add to Cart (AddToCart)
         * @param {Object} product - Product details
         * @param {Number} quantity - Quantity added
         */
        trackAddToCart: function(product, quantity = 1) {
            try {
                const value = parseFloat(product.price) * quantity;
                
                fbq('track', 'AddToCart', {
                    content_name: product.name,
                    content_ids: [product.id.toString()],
                    content_type: 'product',
                    value: value,
                    currency: CURRENCY,
                    num_items: quantity
                });
                
                console.log('✓ Facebook Pixel: AddToCart tracked', {
                    product: product.name,
                    value: value,
                    currency: CURRENCY,
                    quantity: quantity
                });
            } catch (error) {
                console.error('Facebook Pixel AddToCart error:', error);
            }
        },

        /**
         * Track Initiate Checkout (InitiateCheckout)
         * @param {Array} products - Array of products in cart
         * @param {Number} totalValue - Total cart value
         */
        trackInitiateCheckout: function(products, totalValue) {
            try {
                const contentIds = products.map(p => p.id.toString());
                const contents = products.map(p => ({
                    id: p.id.toString(),
                    quantity: p.quantity || 1,
                    item_price: parseFloat(p.price)
                }));
                
                fbq('track', 'InitiateCheckout', {
                    content_ids: contentIds,
                    contents: contents,
                    content_type: 'product',
                    value: parseFloat(totalValue),
                    currency: CURRENCY,
                    num_items: products.length
                });
                
                console.log('✓ Facebook Pixel: InitiateCheckout tracked', {
                    products: products.length,
                    value: totalValue,
                    currency: CURRENCY
                });
            } catch (error) {
                console.error('Facebook Pixel InitiateCheckout error:', error);
            }
        },

        /**
         * Track Purchase (Purchase)
         * @param {Object} orderData - Order details
         */
        trackPurchase: function(orderData) {
            try {
                const contentIds = orderData.products.map(p => p.id.toString());
                const contents = orderData.products.map(p => ({
                    id: p.id.toString(),
                    quantity: p.quantity || 1,
                    item_price: parseFloat(p.price)
                }));
                
                fbq('track', 'Purchase', {
                    content_ids: contentIds,
                    contents: contents,
                    content_type: 'product',
                    value: parseFloat(orderData.total),
                    currency: CURRENCY,
                    num_items: orderData.products.length,
                    transaction_id: orderData.order_number || orderData.order_id
                });
                
                console.log('✓ Facebook Pixel: Purchase tracked', {
                    order_number: orderData.order_number,
                    value: orderData.total,
                    currency: CURRENCY,
                    products: orderData.products.length
                });
            } catch (error) {
                console.error('Facebook Pixel Purchase error:', error);
            }
        },

        /**
         * Track Search (Search)
         * @param {String} searchQuery - Search term
         */
        trackSearch: function(searchQuery) {
            try {
                fbq('track', 'Search', {
                    search_string: searchQuery,
                    content_type: 'product'
                });
                
                console.log('✓ Facebook Pixel: Search tracked', searchQuery);
            } catch (error) {
                console.error('Facebook Pixel Search error:', error);
            }
        },

        /**
         * Track Add to Wishlist (AddToWishlist)
         * @param {Object} product - Product details
         */
        trackAddToWishlist: function(product) {
            try {
                fbq('track', 'AddToWishlist', {
                    content_name: product.name,
                    content_ids: [product.id.toString()],
                    content_type: 'product',
                    value: parseFloat(product.price),
                    currency: CURRENCY
                });
                
                console.log('✓ Facebook Pixel: AddToWishlist tracked', product);
            } catch (error) {
                console.error('Facebook Pixel AddToWishlist error:', error);
            }
        },

        /**
         * Track View Category (ViewCategory - Custom Event)
         * @param {String} categoryName
         */
        trackViewCategory: function(categoryName) {
            try {
                fbq('trackCustom', 'ViewCategory', {
                    content_name: categoryName,
                    content_type: 'product_group'
                });
                
                console.log('✓ Facebook Pixel: ViewCategory tracked', categoryName);
            } catch (error) {
                console.error('Facebook Pixel ViewCategory error:', error);
            }
        }
    };

    /**
     * Auto-track Add to Cart when cart button is clicked
     * NOTE: This is just for tracking, doesn't interfere with cart functionality
     */
    $(document).on('click', '.add-to-cart, .cart-icon-clean, [data-add-to-cart]', function(e) {
        // Don't prevent default - let the cart handler do its job
        const $button = $(this);
        const productId = $button.data('product-id') || $button.data('id');
        const productName = $button.data('product-name') || $button.data('name');
        const productPrice = $button.data('product-price') || $button.data('price');
        const quantity = $button.data('quantity') || 1;

        // Only track if we have the required data
        // The actual cart addition is handled by product-card-custom.js
        if (productId && productName && productPrice) {
            // Use setTimeout to ensure this doesn't block the cart addition
            setTimeout(function() {
                FacebookPixelTracker.trackAddToCart({
                    id: productId,
                    name: productName,
                    price: productPrice
                }, quantity);
            }, 100);
        }
    });

    /**
     * Auto-track Search
     */
    $(document).on('submit', 'form[action*="search"], .search-form', function(e) {
        const searchQuery = $(this).find('input[name="q"], input[name="search"], input[type="search"]').val();
        
        if (searchQuery && searchQuery.trim() !== '') {
            FacebookPixelTracker.trackSearch(searchQuery.trim());
        }
    });

    /**
     * Track when search input is used (with debounce)
     */
    let searchTimeout;
    $(document).on('keyup', 'input[name="q"], input[name="search"], input[type="search"]', function() {
        const searchQuery = $(this).val();
        
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            if (searchQuery && searchQuery.trim().length >= 3) {
                FacebookPixelTracker.trackSearch(searchQuery.trim());
            }
        }, 1000); // Track after 1 second of no typing
    });

    /**
     * Auto-track Wishlist
     */
    $(document).on('click', '.add-to-wishlist, [data-add-to-wishlist]', function(e) {
        const $button = $(this);
        const productId = $button.data('product-id') || $button.data('id');
        const productName = $button.data('product-name') || $button.data('name');
        const productPrice = $button.data('product-price') || $button.data('price');

        if (productId && productName && productPrice) {
            FacebookPixelTracker.trackAddToWishlist({
                id: productId,
                name: productName,
                price: productPrice
            });
        }
    });

    // Log that the tracker is ready
    console.log('✓ Facebook Pixel E-commerce Tracker Ready (Currency: JOD)');

})(jQuery);
