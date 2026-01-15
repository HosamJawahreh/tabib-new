/**
 * ============================================
 * OPTIMIZED SEARCH AUTOCOMPLETE
 * ============================================
 * 
 * Fast, debounced search with autocomplete dropdown
 * Performance optimized with caching and debouncing
 */

(function() {
    'use strict';

    // Configuration
    const CONFIG = {
        minChars: 2,           // Minimum characters before search
        debounceDelay: 300,    // Delay before search (ms)
        maxResults: 10,        // Maximum results to show
        cacheTimeout: 300000,  // Cache timeout (5 minutes)
        searchUrl: '/quick-search' // Search endpoint
    };

    // Cache for search results
    const searchCache = new Map();
    let debounceTimer = null;
    let currentRequest = null;

    /**
     * Initialize search functionality
     */
    function initSearch() {
        const searchInput = document.getElementById('prod_name');
        const searchForm = document.getElementById('searchForm');
        const autocompleteContainer = document.getElementById('myInputautocomplete-list');

        if (!searchInput || !searchForm) {
            console.warn('Search elements not found');
            return;
        }

        // =====================================================
        // Event Listeners
        // =====================================================

        // Input event with debouncing
        searchInput.addEventListener('input', function(e) {
            const query = e.target.value.trim();
            
            // Clear previous timer
            clearTimeout(debounceTimer);

            // Hide autocomplete if query too short
            if (query.length < CONFIG.minChars) {
                hideAutocomplete();
                return;
            }

            // Show loading state
            searchForm.classList.add('searching');

            // Debounce the search
            debounceTimer = setTimeout(() => {
                performSearch(query);
            }, CONFIG.debounceDelay);
        });

        // Focus event
        searchInput.addEventListener('focus', function(e) {
            const query = e.target.value.trim();
            if (query.length >= CONFIG.minChars) {
                performSearch(query);
            }
        });

        // Click outside to close
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.product-search-one')) {
                hideAutocomplete();
            }
        });

        // Keyboard navigation
        searchInput.addEventListener('keydown', function(e) {
            handleKeyboard(e);
        });

        console.log('✅ Optimized search initialized');
    }

    /**
     * Perform search with caching
     */
    function performSearch(query) {
        // Check cache first
        if (searchCache.has(query)) {
            const cached = searchCache.get(query);
            if (Date.now() - cached.timestamp < CONFIG.cacheTimeout) {
                console.log('📦 Using cached results for:', query);
                displayResults(cached.results);
                return;
            }
        }

        // Cancel previous request
        if (currentRequest) {
            currentRequest.abort();
        }

        // Create new request
        currentRequest = new AbortController();

        // Fetch results
        fetch(CONFIG.searchUrl + '?search=' + encodeURIComponent(query), {
            signal: currentRequest.signal
        })
        .then(response => response.json())
        .then(data => {
            // Cache results
            searchCache.set(query, {
                results: data,
                timestamp: Date.now()
            });

            // Display results
            displayResults(data);

            // Remove loading state
            const searchForm = document.getElementById('searchForm');
            searchForm.classList.remove('searching');

            console.log('🔍 Search completed:', query, '(' + data.length + ' results)');
        })
        .catch(error => {
            if (error.name !== 'AbortError') {
                console.error('Search error:', error);
            }
            
            const searchForm = document.getElementById('searchForm');
            searchForm.classList.remove('searching');
        })
        .finally(() => {
            currentRequest = null;
        });
    }

    /**
     * Display autocomplete results
     */
    function displayResults(results) {
        const container = document.getElementById('myInputautocomplete-list');
        
        if (!container) return;

        // Clear previous results
        container.innerHTML = '';

        // No results
        if (!results || results.length === 0) {
            const noResults = document.createElement('div');
            noResults.className = 'autocomplete-no-results';
            noResults.style.cssText = 'padding: 15px; text-align: center; color: #666; font-size: 14px;';
            noResults.textContent = 'No products found';
            container.appendChild(noResults);
            container.style.display = 'block';
            return;
        }

        // Create result items
        results.forEach((item, index) => {
            const div = document.createElement('div');
            div.className = 'autocomplete-item';
            div.style.cssText = `
                padding: 10px 15px;
                cursor: pointer;
                display: flex;
                align-items: center;
                gap: 12px;
                border-bottom: 1px solid #f0f0f0;
                transition: background 0.2s ease;
            `;

            // Product image
            const img = document.createElement('img');
            img.src = item.image;
            img.alt = item.name;
            img.style.cssText = 'width: 40px; height: 40px; object-fit: cover; border-radius: 4px;';
            
            // Product info
            const info = document.createElement('div');
            info.style.cssText = 'flex: 1;';
            
            const name = document.createElement('div');
            name.textContent = item.name;
            name.style.cssText = 'font-size: 14px; font-weight: 500; color: #333; margin-bottom: 2px;';
            
            const price = document.createElement('div');
            price.textContent = item.price;
            price.style.cssText = 'font-size: 13px; color: #7caa53; font-weight: 600;';
            
            info.appendChild(name);
            info.appendChild(price);
            
            div.appendChild(img);
            div.appendChild(info);

            // Click handler
            div.addEventListener('click', function() {
                window.location.href = item.url;
            });

            // Hover effect
            div.addEventListener('mouseenter', function() {
                this.style.background = '#f8f9fa';
            });
            div.addEventListener('mouseleave', function() {
                this.style.background = '';
            });

            container.appendChild(div);
        });

        container.style.display = 'block';
    }

    /**
     * Hide autocomplete
     */
    function hideAutocomplete() {
        const container = document.getElementById('myInputautocomplete-list');
        if (container) {
            container.style.display = 'none';
        }
    }

    /**
     * Handle keyboard navigation
     */
    function handleKeyboard(e) {
        const container = document.getElementById('myInputautocomplete-list');
        if (!container || container.style.display === 'none') return;

        const items = container.querySelectorAll('.autocomplete-item');
        if (items.length === 0) return;

        let currentIndex = -1;
        
        // Find currently focused item
        items.forEach((item, index) => {
            if (item.classList.contains('active')) {
                currentIndex = index;
            }
        });

        // Arrow down
        if (e.keyCode === 40) {
            e.preventDefault();
            currentIndex = (currentIndex + 1) % items.length;
        }
        // Arrow up
        else if (e.keyCode === 38) {
            e.preventDefault();
            currentIndex = currentIndex <= 0 ? items.length - 1 : currentIndex - 1;
        }
        // Enter
        else if (e.keyCode === 13 && currentIndex >= 0) {
            e.preventDefault();
            items[currentIndex].click();
            return;
        }
        // Escape
        else if (e.keyCode === 27) {
            hideAutocomplete();
            return;
        }
        else {
            return;
        }

        // Update active item
        items.forEach(item => item.classList.remove('active'));
        items[currentIndex].classList.add('active');
        items[currentIndex].style.background = '#f8f9fa';
    }

    /**
     * Clear old cache entries
     */
    function clearOldCache() {
        const now = Date.now();
        for (const [key, value] of searchCache.entries()) {
            if (now - value.timestamp > CONFIG.cacheTimeout) {
                searchCache.delete(key);
            }
        }
    }

    // Clear cache periodically
    setInterval(clearOldCache, 60000); // Every minute

    // Initialize on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSearch);
    } else {
        initSearch();
    }

})();

console.log('✅ Optimized search autocomplete loaded');
