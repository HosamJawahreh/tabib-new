/**
 * ============================================
 * RESPONSIVE CART SIDEBAR JAVASCRIPT
 * ============================================
 * Handles cart sidebar open/close and scroll behavior
 */

(function($) {
    'use strict';

    // Cart Sidebar Manager
    const CartSidebar = {
        
        // Initialize
        init: function() {
            this.cacheElements();
            this.bindEvents();
            this.preventBodyScroll();
        },

        // Cache DOM elements
        cacheElements: function() {
            this.$cartSidebar = $('.cart-sidebar, .cart-drawer, .shopping-cart, .side-cart, .cart-panel');
            this.$cartBackdrop = $('.cart-overlay-backdrop, .cart-backdrop');
            this.$cartClose = $('.cart-close, .close-cart, .cart-header .close');
            this.$cartOpen = $('.cart-icon, .open-cart, .view-cart, [data-toggle="cart"]');
            this.$body = $('body');
        },

        // Bind events
        bindEvents: function() {
            const self = this;

            // Open cart
            this.$cartOpen.on('click', function(e) {
                e.preventDefault();
                self.openCart();
            });

            // Close cart
            this.$cartClose.on('click', function(e) {
                e.preventDefault();
                self.closeCart();
            });

            // Close on backdrop click
            this.$cartBackdrop.on('click', function() {
                self.closeCart();
            });

            // Close on ESC key
            $(document).on('keydown', function(e) {
                if (e.key === 'Escape' && self.$cartSidebar.hasClass('active')) {
                    self.closeCart();
                }
            });

            // Update cart on add to cart
            $(document).on('cart:updated', function() {
                self.refreshCart();
            });

            // Quantity change handlers
            this.$cartSidebar.on('click', '.qty-btn-minus, .quantity-decrease', function(e) {
                e.preventDefault();
                self.decreaseQuantity($(this));
            });

            this.$cartSidebar.on('click', '.qty-btn-plus, .quantity-increase', function(e) {
                e.preventDefault();
                self.increaseQuantity($(this));
            });

            // Remove item
            this.$cartSidebar.on('click', '.cart-item-remove, .remove-from-cart, .delete-item', function(e) {
                e.preventDefault();
                self.removeItem($(this));
            });

            // Smooth scroll in cart items
            this.enableSmoothScroll();
        },

        // Open cart sidebar
        openCart: function() {
            this.$cartSidebar.addClass('active show open');
            this.$cartBackdrop.addClass('active show');
            this.$body.addClass('cart-open').css('overflow', 'hidden');

            // Trigger event
            $(document).trigger('cart:opened');

            // Focus on cart for accessibility
            this.$cartSidebar.attr('tabindex', '-1').focus();
        },

        // Close cart sidebar
        closeCart: function() {
            this.$cartSidebar.removeClass('active show open');
            this.$cartBackdrop.removeClass('active show');
            this.$body.removeClass('cart-open').css('overflow', '');

            // Trigger event
            $(document).trigger('cart:closed');
        },

        // Prevent body scroll when cart is open
        preventBodyScroll: function() {
            const self = this;
            let scrollPosition = 0;

            $(document).on('cart:opened', function() {
                scrollPosition = window.pageYOffset;
                self.$body.css({
                    'overflow': 'hidden',
                    'position': 'fixed',
                    'top': `-${scrollPosition}px`,
                    'width': '100%'
                });
            });

            $(document).on('cart:closed', function() {
                self.$body.css({
                    'overflow': '',
                    'position': '',
                    'top': '',
                    'width': ''
                });
                window.scrollTo(0, scrollPosition);
            });
        },

        // Enable smooth scrolling
        enableSmoothScroll: function() {
            const $cartItems = this.$cartSidebar.find('.cart-items, .cart-body');
            
            // Add momentum scrolling for iOS
            $cartItems.css('-webkit-overflow-scrolling', 'touch');

            // Smooth scroll behavior
            $cartItems.on('wheel', function(e) {
                const delta = e.originalEvent.deltaY;
                const scrollTop = $(this).scrollTop();
                const scrollHeight = this.scrollHeight;
                const height = $(this).height();
                const isAtTop = scrollTop === 0;
                const isAtBottom = scrollTop + height >= scrollHeight;

                // Prevent overscroll
                if ((isAtTop && delta < 0) || (isAtBottom && delta > 0)) {
                    e.preventDefault();
                }
            });
        },

        // Decrease quantity
        decreaseQuantity: function($btn) {
            const $input = $btn.siblings('.qty-input, .quantity-input');
            const currentQty = parseInt($input.val()) || 1;
            
            if (currentQty > 1) {
                const newQty = currentQty - 1;
                $input.val(newQty);
                this.updateCartItem($btn.closest('.cart-item'), newQty);
            }
        },

        // Increase quantity
        increaseQuantity: function($btn) {
            const $input = $btn.siblings('.qty-input, .quantity-input');
            const currentQty = parseInt($input.val()) || 1;
            const maxQty = parseInt($input.attr('max')) || 999;
            
            if (currentQty < maxQty) {
                const newQty = currentQty + 1;
                $input.val(newQty);
                this.updateCartItem($btn.closest('.cart-item'), newQty);
            }
        },

        // Update cart item
        updateCartItem: function($item, quantity) {
            const productId = $item.data('product-id') || $item.data('id');
            
            // Show loading
            $item.addClass('updating');

            // AJAX update cart
            $.ajax({
                url: '/cart/update',
                method: 'POST',
                data: {
                    product_id: productId,
                    quantity: quantity,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Update cart totals
                    if (response.success) {
                        $('.cart-total-amount').text(response.total);
                        $('.cart-count').text(response.count);
                        
                        // Update item subtotal
                        $item.find('.cart-item-subtotal').text(response.item_total);
                    }
                },
                error: function() {
                    alert('Error updating cart. Please try again.');
                },
                complete: function() {
                    $item.removeClass('updating');
                }
            });
        },

        // Remove item from cart
        removeItem: function($btn) {
            const $item = $btn.closest('.cart-item, .cart-product');
            const productId = $item.data('product-id') || $item.data('id');

            // Confirm removal
            if (!confirm('Remove this item from cart?')) {
                return;
            }

            // Show loading
            $item.addClass('removing');

            // AJAX remove from cart
            $.ajax({
                url: '/cart/remove',
                method: 'POST',
                data: {
                    product_id: productId,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        // Animate removal
                        $item.slideUp(300, function() {
                            $(this).remove();
                            
                            // Update cart totals
                            $('.cart-total-amount').text(response.total);
                            $('.cart-count').text(response.count);

                            // Show empty cart if no items
                            if (response.count === 0) {
                                $('.cart-items').html(`
                                    <div class="cart-empty">
                                        <i class="fas fa-shopping-cart" style="font-size: 80px; color: #ddd;"></i>
                                        <p>Your cart is empty</p>
                                        <a href="/" class="btn btn-primary">Continue Shopping</a>
                                    </div>
                                `);
                            }
                        });
                    }
                },
                error: function() {
                    alert('Error removing item. Please try again.');
                    $item.removeClass('removing');
                }
            });
        },

        // Refresh cart data
        refreshCart: function() {
            $.ajax({
                url: '/cart/data',
                method: 'GET',
                success: function(response) {
                    if (response.html) {
                        $('.cart-items, .cart-body').html(response.html);
                        $('.cart-total-amount').text(response.total);
                        $('.cart-count').text(response.count);
                    }
                }
            });
        }
    };

    // Initialize on document ready
    $(document).ready(function() {
        CartSidebar.init();
    });

    // Re-initialize on AJAX cart updates
    $(document).on('cart:item-added', function() {
        CartSidebar.openCart();
    });

})(jQuery);

/**
 * ============================================
 * VANILLA JS VERSION (No jQuery)
 * ============================================
 */
class CartSidebarManager {
    constructor() {
        this.cartSidebar = document.querySelector('.cart-sidebar, .cart-drawer, .shopping-cart');
        this.cartBackdrop = document.querySelector('.cart-overlay-backdrop, .cart-backdrop');
        this.cartCloseBtn = document.querySelectorAll('.cart-close, .close-cart');
        this.cartOpenBtn = document.querySelectorAll('.cart-icon, .open-cart, [data-toggle="cart"]');
        
        if (this.cartSidebar) {
            this.init();
        }
    }

    init() {
        this.bindEvents();
        this.enableSmoothScroll();
    }

    bindEvents() {
        // Open cart
        this.cartOpenBtn.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                this.openCart();
            });
        });

        // Close cart
        this.cartCloseBtn.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                this.closeCart();
            });
        });

        // Close on backdrop click
        if (this.cartBackdrop) {
            this.cartBackdrop.addEventListener('click', () => {
                this.closeCart();
            });
        }

        // Close on ESC key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.cartSidebar.classList.contains('active')) {
                this.closeCart();
            }
        });
    }

    openCart() {
        this.cartSidebar.classList.add('active', 'show', 'open');
        if (this.cartBackdrop) {
            this.cartBackdrop.classList.add('active', 'show');
        }
        document.body.style.overflow = 'hidden';
        
        // Focus for accessibility
        this.cartSidebar.focus();
    }

    closeCart() {
        this.cartSidebar.classList.remove('active', 'show', 'open');
        if (this.cartBackdrop) {
            this.cartBackdrop.classList.remove('active', 'show');
        }
        document.body.style.overflow = '';
    }

    enableSmoothScroll() {
        const cartItems = this.cartSidebar.querySelector('.cart-items, .cart-body');
        if (cartItems) {
            cartItems.style.webkitOverflowScrolling = 'touch';
        }
    }
}

// Initialize vanilla JS version if jQuery is not available
if (typeof jQuery === 'undefined') {
    document.addEventListener('DOMContentLoaded', () => {
        new CartSidebarManager();
    });
}
