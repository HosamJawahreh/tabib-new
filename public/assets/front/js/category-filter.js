/**
 * Category Navigation and Product Filtering
 * Professional AJAX-based filtering without page refresh
 */

(function() {
    'use strict';

    // Wait for DOM and jQuery to be ready
    if (typeof jQuery === 'undefined') {
        console.error('❌ jQuery is required for category filtering!');
        return;
    }

    jQuery(document).ready(function($) {
        console.log('🎯 Category Filter System Initialized');

        // ==========================================
        // State Management
        // ==========================================
        const FilterState = {
            currentCategory: 'all',
            currentSubcategory: null,
            currentChildcategory: null,
            isLoading: false,
            cache: new Map()
        };

        // ==========================================
        // DOM Elements
        // ==========================================
        const $productsGrid = $('#products-grid');
        const $productsLoading = $('#products-loading');
        const $productsError = $('#products-error');
        const $productsEndMessage = $('#products-end-message');

        // ==========================================
        // Category Click Handler (Main Categories)
        // ==========================================
        $('.main-category-item').on('click', function(e) {
            e.stopPropagation();

            const $this = $(this);
            const categoryId = $this.data('category-id');
            const hasSubs = $this.data('has-subs') === 1;

            console.log('📁 Main category clicked:', { categoryId, hasSubs });

            // Remove active from all main categories
            $('.main-category-item').removeClass('active');
            $this.addClass('active');

            // Remove active from all subcategories and child categories
            $('.subcategory-item, .childcategory-item').removeClass('active');

            // Hide all subcategory and child category rows
            $('.subcategories-row, .childcategories-row').slideUp(200);

            // Show subcategories if this category has them
            if (hasSubs) {
                $('.subcategories-container').slideDown(200);
                $(`.subcategories-row[data-parent-category="${categoryId}"]`).slideDown(300);
            } else {
                $('.subcategories-container').slideUp(200);
            }

            // Filter by category
            filterByCategory(categoryId);
        });

        // ==========================================
        // Subcategory Click Handler
        // ==========================================
        $(document).on('click', '.subcategory-item', function(e) {
            e.stopPropagation();

            const $this = $(this);
            const subcategoryId = $this.data('subcategory-id');
            const parentCategory = $this.data('parent-category');
            const hasChilds = $this.data('has-childs') === 1;

            console.log('📂 Subcategory clicked:', { subcategoryId, parentCategory, hasChilds });

            // Remove active from all subcategories
            $('.subcategory-item').removeClass('active');
            $this.addClass('active');

            // Remove active from all child categories
            $('.childcategory-item').removeClass('active');

            // Remove active from main categories
            $('.main-category-item').removeClass('active');

            // Show/hide child categories if this subcategory has them
            if (hasChilds) {
                // Hide all child category rows
                $('.childcategories-row').slideUp(200);

                // Show the child categories container and this subcategory's children
                $('.childcategories-container').slideDown(200);
                $(`.childcategories-row[data-parent-subcategory="${subcategoryId}"]`).slideDown(300);
            } else {
                // Hide all child category rows and container
                $('.childcategories-row').slideUp(200);
                $('.childcategories-container').slideUp(200);
            }

            // Filter by subcategory
            filterBySubcategory(parentCategory, subcategoryId);
        });

        // ==========================================
        // Child Category Click Handler
        // ==========================================
        $(document).on('click', '.childcategory-item', function(e) {
            e.stopPropagation();

            const $this = $(this);
            const childcategoryId = $this.data('childcategory-id');
            const parentSubcategory = $this.data('parent-subcategory');
            const parentCategory = $this.data('parent-category');

            console.log('📄 Child category clicked:', { childcategoryId, parentSubcategory, parentCategory });

            // Remove active from all child categories
            $('.childcategory-item').removeClass('active');
            $this.addClass('active');

            // Remove active from main categories
            $('.main-category-item').removeClass('active');

            // Filter by child category
            filterByChildcategory(parentCategory, parentSubcategory, childcategoryId);
        });

        // ==========================================
        // Filter Functions
        // ==========================================

        function filterByCategory(categoryId) {
            console.log('🔍 Filtering by category:', categoryId);

            // Update state
            FilterState.currentCategory = categoryId;
            FilterState.currentSubcategory = null;
            FilterState.currentChildcategory = null;

            // Update UI
            updateActiveStates(categoryId);

            // Load products
            loadProducts({
                category_id: categoryId === 'all' ? null : categoryId
            });
        }

        function filterBySubcategory(categoryId, subcategoryId) {
            console.log('🔍 Filtering by subcategory:', subcategoryId, 'in category:', categoryId);

            // Update state
            FilterState.currentCategory = categoryId;
            FilterState.currentSubcategory = subcategoryId;
            FilterState.currentChildcategory = null;

            // Update UI
            updateActiveStates(categoryId, subcategoryId);

            // Load products
            loadProducts({
                category_id: categoryId,
                subcategory_id: subcategoryId === 'all' ? null : subcategoryId
            });
        }

        function filterByChildcategory(categoryId, subcategoryId, childcategoryId) {
            console.log('🔍 Filtering by child category:', childcategoryId);

            // Update state
            FilterState.currentCategory = categoryId;
            FilterState.currentSubcategory = subcategoryId;
            FilterState.currentChildcategory = childcategoryId;

            // Update UI
            updateActiveStates(categoryId, subcategoryId, childcategoryId);

            // Load products
            loadProducts({
                category_id: categoryId,
                subcategory_id: subcategoryId,
                childcategory_id: childcategoryId === 'all' ? null : childcategoryId
            });
        }

        function resetFilters() {
            console.log('🔄 Resetting filters');

            // Reset filter state
            FilterState.currentCategory = null;
            FilterState.currentSubcategory = null;
            FilterState.currentChildcategory = null;

            // Remove all active classes
            $('.main-category-item, .subcategory-item, .childcategory-item').removeClass('active');

            // Hide all subcategory and child category containers and rows
            $('.subcategories-container, .childcategories-container').slideUp(200);
            $('.subcategories-row, .childcategories-row').slideUp(200);

            // Load all products
            loadProducts({});
        }

        // ==========================================
        // AJAX Product Loading
        // ==========================================

        function loadProducts(filters) {
            if (FilterState.isLoading) {
                console.log('⏸️ Already loading, skipping...');
                return;
            }

            // Check cache
            const cacheKey = JSON.stringify(filters);
            if (FilterState.cache.has(cacheKey)) {
                console.log('💾 Loading from cache');
                const cachedData = FilterState.cache.get(cacheKey);
                displayProducts(cachedData);
                return;
            }

            FilterState.isLoading = true;

            // Show loading
            $productsGrid.addClass('loading-products');
            $productsLoading.removeClass('d-none').show();
            $productsError.addClass('d-none').hide();
            $productsEndMessage.addClass('d-none').hide();

            console.log('📡 Loading products with filters:', filters);

            $.ajax({
                url: window.filterProductsUrl || '/products/filter',
                method: 'GET',
                data: filters,
                dataType: 'json',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    console.log('✅ Products loaded successfully:', {
                        count: response.products_count,
                        total: response.total_count,
                        hasMore: response.has_more
                    });

                    // Cache the result
                    FilterState.cache.set(cacheKey, response);

                    // Display products
                    displayProducts(response);

                    // Show message if no products found
                    if (response.products_count === 0) {
                        console.log('ℹ️ No products found for this filter');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('❌ Error loading products:', {
                        status: xhr.status,
                        statusText: xhr.statusText,
                        error: error,
                        response: xhr.responseText
                    });

                    $productsError.removeClass('d-none').show();

                    // Show error message
                    toastr.error('Failed to load products. Please try again.', 'Error');
                },
                complete: function() {
                    FilterState.isLoading = false;
                    $productsLoading.addClass('d-none').hide();
                    $productsGrid.removeClass('loading-products');
                }
            });
        }

        function displayProducts(response) {
            // Smooth fade out
            $productsGrid.fadeTo(200, 0, function() {
                // Replace content
                $productsGrid.html(response.html);

                // Update count display
                updateProductCount(response.products_count, response.total_count);

                // Reset pagination state for infinite scroll
                if (window.resetPaginationState) {
                    window.resetPaginationState(response.has_more);
                }

                // Smooth fade in
                $productsGrid.fadeTo(300, 1);

                // Removed scroll animation - stay at current position

                // Initialize lazy loading if available
                if (typeof lazy === 'function') {
                    lazy();
                }
            });
        }

        function updateProductCount(showing, total) {
            const $countText = $('.products-section .text-muted').first();
            if ($countText.length) {
                const showingText = window.translations?.showing || 'Showing';
                const ofText = window.translations?.of || 'of';
                const productsText = window.translations?.products || 'products';

                $countText.text(`${showingText} ${showing} ${ofText} ${total} ${productsText}`);
            }
        }

        // ==========================================
        // UI Helper Functions
        // ==========================================

        function updateActiveStates(categoryId, subcategoryId = null, childcategoryId = null) {
            // Reset all active states
            $('.main-category-item').removeClass('active');
            $('.subcategory-item').removeClass('active');
            $('.childcategory-item').removeClass('active');

            // Set category active
            $(`.main-category-item[data-category-id="${categoryId}"]`).addClass('active');

            // Set subcategory active
            if (subcategoryId) {
                $(`.subcategory-item[data-subcategory-id="${subcategoryId}"]`).addClass('active');
            }

            // Set child category active
            if (childcategoryId) {
                $(`.childcategory-item[data-childcategory-id="${childcategoryId}"]`).addClass('active');
            }
        }

        // ==========================================
        // Expose public API
        // ==========================================
        window.CategoryFilter = {
            filterByCategory: filterByCategory,
            resetFilters: resetFilters,
            getState: () => FilterState
        };

        console.log('✅ Category Filter System Ready!');
    });
})();
