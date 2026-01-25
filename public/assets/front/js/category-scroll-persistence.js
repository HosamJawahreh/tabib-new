/**
 * Category Selection & Scroll Position Persistence
 * Professional client-side state management for category filtering and scroll restoration
 */

(function() {
    'use strict';

    // Wait for DOM and jQuery to be ready
    if (typeof jQuery === 'undefined') {
        console.error('❌ jQuery is required for scroll persistence!');
        return;
    }

    jQuery(document).ready(function($) {
        console.log('🔄 Category & Scroll Persistence System Initialized');

        // ==========================================
        // Storage Keys
        // ==========================================
        const STORAGE_KEYS = {
            CATEGORY: 'homepage_selected_category',
            SUBCATEGORY: 'homepage_selected_subcategory',
            CHILDCATEGORY: 'homepage_selected_childcategory',
            SCROLL_POSITION: 'homepage_scroll_position',
            PRODUCT_ID: 'homepage_last_product_id',
            TIMESTAMP: 'homepage_state_timestamp'
        };

        const STATE_EXPIRY = 30 * 60 * 1000; // 30 minutes

        // ==========================================
        // Storage Helper Functions
        // ==========================================
        const Storage = {
            set: function(key, value) {
                try {
                    sessionStorage.setItem(key, JSON.stringify(value));
                    console.log(`💾 Saved ${key}:`, value);
                } catch (e) {
                    console.error('Storage error:', e);
                }
            },

            get: function(key) {
                try {
                    const value = sessionStorage.getItem(key);
                    return value ? JSON.parse(value) : null;
                } catch (e) {
                    console.error('Storage error:', e);
                    return null;
                }
            },

            remove: function(key) {
                try {
                    sessionStorage.removeItem(key);
                } catch (e) {
                    console.error('Storage error:', e);
                }
            },

            clear: function() {
                Object.values(STORAGE_KEYS).forEach(key => {
                    this.remove(key);
                });
                console.log('🗑️ Cleared all homepage state');
            },

            isExpired: function() {
                const timestamp = this.get(STORAGE_KEYS.TIMESTAMP);
                if (!timestamp) return true;
                return (Date.now() - timestamp) > STATE_EXPIRY;
            }
        };

        // ==========================================
        // Save State When User Interacts
        // ==========================================
        function saveCurrentState() {
            // Save timestamp
            Storage.set(STORAGE_KEYS.TIMESTAMP, Date.now());

            // Save scroll position
            const scrollPos = $(window).scrollTop();
            Storage.set(STORAGE_KEYS.SCROLL_POSITION, scrollPos);

            // Save active category
            const $activeCategory = $('.main-category-item.active');
            if ($activeCategory.length) {
                const categoryId = $activeCategory.data('category-id');
                Storage.set(STORAGE_KEYS.CATEGORY, categoryId);
                console.log('📁 Saved category:', categoryId);
            }

            // Save active subcategory
            const $activeSubcategory = $('.subcategory-item.active');
            if ($activeSubcategory.length) {
                const subcategoryId = $activeSubcategory.data('subcategory-id');
                Storage.set(STORAGE_KEYS.SUBCATEGORY, subcategoryId);
                console.log('📂 Saved subcategory:', subcategoryId);
            }

            // Save active child category
            const $activeChild = $('.childcategory-item.active');
            if ($activeChild.length) {
                const childId = $activeChild.data('childcategory-id');
                Storage.set(STORAGE_KEYS.CHILDCATEGORY, childId);
                console.log('📄 Saved child category:', childId);
            }
        }

        // ==========================================
        // Restore State on Page Load
        // ==========================================
        function restoreState() {
            // Check if state is expired
            if (Storage.isExpired()) {
                console.log('⏰ State expired, clearing...');
                Storage.clear();
                return;
            }

            const categoryId = Storage.get(STORAGE_KEYS.CATEGORY);
            const subcategoryId = Storage.get(STORAGE_KEYS.SUBCATEGORY);
            const childcategoryId = Storage.get(STORAGE_KEYS.CHILDCATEGORY);
            const scrollPosition = Storage.get(STORAGE_KEYS.SCROLL_POSITION);
            const lastProductId = Storage.get(STORAGE_KEYS.PRODUCT_ID);

            console.log('🔄 Restoring state:', {
                categoryId,
                subcategoryId,
                childcategoryId,
                scrollPosition,
                lastProductId
            });

            // Restore category selection
            if (categoryId && categoryId !== 'all') {
                setTimeout(() => {
                    const $category = $(`.main-category-item[data-category-id="${categoryId}"]`);
                    if ($category.length) {
                        console.log('✅ Restoring category:', categoryId);
                        $category.trigger('click');

                        // Restore subcategory if exists
                        if (subcategoryId) {
                            setTimeout(() => {
                                const $subcategory = $(`.subcategory-item[data-subcategory-id="${subcategoryId}"]`);
                                if ($subcategory.length) {
                                    console.log('✅ Restoring subcategory:', subcategoryId);
                                    $subcategory.trigger('click');
                                }

                                // Restore child category if exists
                                if (childcategoryId) {
                                    setTimeout(() => {
                                        const $child = $(`.childcategory-item[data-childcategory-id="${childcategoryId}"]`);
                                        if ($child.length) {
                                            console.log('✅ Restoring child category:', childcategoryId);
                                            $child.trigger('click');
                                        }
                                    }, 300);
                                }
                            }, 300);
                        }
                    }
                }, 500);
            }

            // Restore scroll position
            if (scrollPosition !== null) {
                // If we have a last product ID, scroll to that product
                if (lastProductId) {
                    setTimeout(() => {
                        const $product = $(`.product-item[data-product-id="${lastProductId}"]`);
                        if ($product.length) {
                            console.log('📍 Scrolling to product:', lastProductId);
                            $('html, body').animate({
                                scrollTop: $product.offset().top - 100
                            }, 600, 'swing');
                            
                            // Highlight the product briefly
                            $product.find('.product-card').css({
                                'box-shadow': '0 0 20px rgba(40, 167, 69, 0.5)',
                                'transform': 'scale(1.02)'
                            });
                            
                            setTimeout(() => {
                                $product.find('.product-card').css({
                                    'box-shadow': '',
                                    'transform': ''
                                });
                            }, 1500);

                            // Clear product ID after scrolling
                            Storage.remove(STORAGE_KEYS.PRODUCT_ID);
                        } else {
                            // Product not found, use saved scroll position
                            console.log('📜 Restoring scroll position:', scrollPosition);
                            setTimeout(() => {
                                $('html, body').animate({
                                    scrollTop: scrollPosition
                                }, 600, 'swing');
                            }, 800);
                        }
                    }, 1200); // Wait for categories to load products
                } else {
                    // Just restore scroll position
                    console.log('📜 Restoring scroll position:', scrollPosition);
                    setTimeout(() => {
                        $('html, body').animate({
                            scrollTop: scrollPosition
                        }, 600, 'swing');
                    }, 800);
                }
            }
        }

        // ==========================================
        // Track Product Clicks
        // ==========================================
        function setupProductTracking() {
            $(document).on('click', '.product-item a, .product-card a', function(e) {
                const $productItem = $(this).closest('.product-item');
                if ($productItem.length) {
                    const productId = $productItem.data('product-id');
                    if (productId) {
                        console.log('🎯 Product clicked:', productId);
                        Storage.set(STORAGE_KEYS.PRODUCT_ID, productId);
                        saveCurrentState();
                    }
                }
            });
        }

        // ==========================================
        // Track Category Changes
        // ==========================================
        function setupCategoryTracking() {
            // Track main category clicks
            $(document).on('click', '.main-category-item', function() {
                setTimeout(saveCurrentState, 100);
            });

            // Track subcategory clicks
            $(document).on('click', '.subcategory-item', function() {
                setTimeout(saveCurrentState, 100);
            });

            // Track child category clicks
            $(document).on('click', '.childcategory-item', function() {
                setTimeout(saveCurrentState, 100);
            });

            // Track "All Products" button
            $(document).on('click', '[data-category-id="all"]', function() {
                Storage.clear();
                console.log('🗑️ Cleared filters');
            });
        }

        // ==========================================
        // Track Scroll Position (Throttled)
        // ==========================================
        function setupScrollTracking() {
            let scrollTimeout;
            $(window).on('scroll', function() {
                clearTimeout(scrollTimeout);
                scrollTimeout = setTimeout(() => {
                    const scrollPos = $(window).scrollTop();
                    Storage.set(STORAGE_KEYS.SCROLL_POSITION, scrollPos);
                }, 300); // Save every 300ms during scroll
            });
        }

        // ==========================================
        // Handle Page Refresh
        // ==========================================
        function setupRefreshHandler() {
            // Save state before page unload (refresh)
            $(window).on('beforeunload', function() {
                saveCurrentState();
            });
        }

        // ==========================================
        // Clear State on Manual Navigation
        // ==========================================
        function setupNavigationClear() {
            // Clear state when navigating away from homepage
            $('a').not('.product-item a, .product-card a').on('click', function() {
                const href = $(this).attr('href');
                // Don't clear if it's a product link
                if (href && !href.includes('/item/') && !href.includes('/product/')) {
                    Storage.clear();
                }
            });
        }

        // ==========================================
        // Initialize
        // ==========================================
        function init() {
            console.log('🚀 Initializing Category & Scroll Persistence...');

            // Setup tracking
            setupProductTracking();
            setupCategoryTracking();
            setupScrollTracking();
            setupRefreshHandler();
            setupNavigationClear();

            // Restore state on page load
            restoreState();

            console.log('✅ Category & Scroll Persistence Ready!');
        }

        // Start the system
        init();

        // ==========================================
        // Public API
        // ==========================================
        window.CategoryScrollPersistence = {
            save: saveCurrentState,
            restore: restoreState,
            clear: () => Storage.clear(),
            getState: () => ({
                category: Storage.get(STORAGE_KEYS.CATEGORY),
                subcategory: Storage.get(STORAGE_KEYS.SUBCATEGORY),
                childcategory: Storage.get(STORAGE_KEYS.CHILDCATEGORY),
                scroll: Storage.get(STORAGE_KEYS.SCROLL_POSITION),
                product: Storage.get(STORAGE_KEYS.PRODUCT_ID)
            })
        };
    });
})();
