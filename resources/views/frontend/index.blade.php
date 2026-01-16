@extends('layouts.front')

@section('css')
<style>
    /* Ensure no extra spacing */
    #page_wrapper {
        padding-top: 0 !important;
        margin-top: 0 !important;
    }

    /* Body spacing for sticky header */
    body {
        margin: 0 !important;
        padding: 0 !important;
        padding-top: 50px !important;
        overflow-x: hidden;
        position: relative;
    }

    /* Mobile body padding for sticky header */
    @media (max-width: 991px) {
        body {
            padding-top: 48px !important;
        }
    }

    header, .ecommerce-header {
        margin-bottom: 0 !important;
        background: #ffffff !important;
        position: sticky !important;
        top: 0 !important;
        z-index: 9999 !important;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1) !important;
    }

    .main-nav {
        padding: 8px 0 !important;
        margin: 0 !important;
    }

    section {
        margin-top: 0 !important;
    }

    .home-slider-section {
        margin-top: 0 !important;
        margin-bottom: 15px !important;
        padding-top: 0 !important;
        padding-bottom: 0 !important;
        position: relative !important;
        z-index: 1 !important;
        background: #f5f5f5 !important;
    }

    .category-navigation-section {
        margin-top: 0 !important;
        margin-bottom: 0 !important;
        padding: 10px 0 !important;
    }

    .products-section {
        margin-top: 0 !important;
        padding: 20px 0 !important;
    }

    /* Ensure smooth scrolling without conflicts */
    html {
        scroll-behavior: smooth;
        overflow-x: hidden;
    }

    /* Product Grid Styles */
    .product-card {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        transition: all 0.3s ease;
        overflow: hidden;
        background: #fff;
    }

    .product-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        transform: translateY(-2px);
    }

    .product-thumb {
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .product-image {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain;
    }

    /* Cart icon always visible */
    .add-to-cart-btn {
        opacity: 1 !important;
        transition: all 0.3s ease;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .product-card:hover .add-to-cart-btn {
        opacity: 1 !important;
        transform: scale(1.1);
    }

    .price-current {
        font-size: 1.1rem;
        color: #28a745;
    }

    .product-title {
        font-size: 0.9rem;
        line-height: 1.4;
    }

    /* Cart Icon - Force Visibility */
    .cart-action-buttons {
        display: flex !important;
        opacity: 1 !important;
        visibility: visible !important;
    }

    .cart-icon-clean {
        display: inline-flex !important;
        opacity: 1 !important;
        visibility: visible !important;
        background: transparent !important;
        width: 40px !important;
        height: 40px !important;
        border-radius: 50% !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15) !important;
    }

    .cart-icon-clean:hover {
        background: #000 !important;
        transform: scale(1.1);
    }

    .cart-icon-clean:hover i {
        color: #fff !important;
    }

    /* Loading Spinner */
    .spinner-border-custom {
        width: 3rem;
        height: 3rem;
    }

    /* Products Section */
    .products-section {
        padding: 40px 0;
        background: #f5f5f5;
    }

    .section-title {
        font-size: 2rem;
        font-weight: 600;
        margin-bottom: 30px;
        text-align: center;
    }

    /* Slider Styles - Responsive with Rounded Corners */
    .home-slider-section {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        margin-bottom: 20px !important;
        width: 100% !important;
        padding: 0 !important;
        margin-left: 0 !important;
        margin-right: 0 !important;
        margin-top: 0 !important;
    }

    .home-slider,
    .home-slider.owl-carousel {
        display: block !important;
        visibility: visible !important;
        border-radius: 0 !important;
        overflow: hidden !important;
        box-shadow: none !important;
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .slider-item,
    .home-slider .owl-item .slider-item,
    .owl-item .slider-item {
        min-height: 300px !important;
        max-height: 300px !important;
        height: 300px !important;
        display: flex !important;
        align-items: center;
        background-size: cover !important;
        background-position: center !important;
        background-repeat: no-repeat !important;
        position: relative;
        border-radius: 0 !important;
        overflow: hidden !important;
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    /* Force Owl Carousel items to respect height */
    .home-slider .owl-stage-outer,
    .home-slider .owl-stage,
    .home-slider .owl-item {
        height: auto !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    /* WebP image optimization */
    .slider-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to right, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0) 50%);
        z-index: 1;
    }

    /* Responsive slider heights - Increased for better visibility */
    /* Mobile Small (< 576px) */
    @media (max-width: 575px) {
        .home-slider-section {
            padding: 0 !important;
            margin-bottom: 15px !important;
            margin-top: 0 !important;
        }

        .slider-item,
        .home-slider .owl-item .slider-item,
        .owl-item .slider-item {
            min-height: 220px !important;
            max-height: 220px !important;
            height: 220px !important;
        }

        .slider-content h2 {
            font-size: 0.9rem !important;
            padding: 0 10px !important;
        }

        .slider-content p {
            display: none !important;
        }

        .home-slider-section .container-fluid {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        /* Hide slider navigation on mobile */
        .home-slider .owl-nav {
            display: none !important;
        }

        .home-slider .owl-dots {
            margin-top: -40px !important;
            padding-bottom: 10px !important;
        }
    }

    /* Mobile Large (576px - 767px) */
    @media (min-width: 576px) and (max-width: 767px) {
        .slider-item,
        .home-slider .owl-item .slider-item,
        .owl-item .slider-item {
            min-height: 250px !important;
            max-height: 250px !important;
            height: 250px !important;
        }
        .slider-content h2 {
            font-size: 1.1rem !important;
        }
    }

    /* Tablet (768px - 991px) */
    @media (min-width: 768px) and (max-width: 991px) {
        .slider-item,
        .home-slider .owl-item .slider-item,
        .owl-item .slider-item {
            min-height: 280px !important;
            max-height: 280px !important;
            height: 280px !important;
        }
        .home-slider-section {
            padding: 0 15px !important;
        }
        .home-slider {
            border-radius: 12px !important;
            box-shadow: 0 3px 15px rgba(0,0,0,0.08) !important;
        }
        .slider-content h2 {
            font-size: 1.4rem !important;
        }
    }

    /* Desktop Small (992px - 1199px) */
    @media (min-width: 992px) and (max-width: 1199px) {
        .slider-item,
        .home-slider .owl-item .slider-item,
        .owl-item .slider-item {
            min-height: 320px !important;
            max-height: 320px !important;
            height: 320px !important;
        }
        .slider-content h2 {
            font-size: 1.6rem !important;
        }
    }

    /* Desktop Large (1200px - 1399px) */
    @media (min-width: 1200px) and (max-width: 1399px) {
        .slider-item,
        .home-slider .owl-item .slider-item,
        .owl-item .slider-item {
            min-height: 350px !important;
            max-height: 350px !important;
            height: 350px !important;
        }
        .home-slider-section {
            padding: 0 20px !important;
        }
        .slider-content h2 {
            font-size: 1.8rem !important;
        }
    }

    /* Desktop XL (≥ 1400px) */
    @media (min-width: 1400px) {
        .slider-item,
        .home-slider .owl-item .slider-item,
        .owl-item .slider-item {
            min-height: 400px !important;
            max-height: 400px !important;
            height: 400px !important;
        }
        .slider-content h2 {
            font-size: 2rem !important;
        }
    }

    .slider-content {
        padding: 20px; /* Reduced from 30px for better mobile fit */
        position: relative;
        z-index: 2;
    }

    .slider-content h5 {
        color: #fff;
        font-size: 0.85rem; /* Slightly reduced for mobile */
        font-weight: 600;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        margin-bottom: 8px; /* Reduced spacing */
    }

    .slider-content h2 {
        color: #fff;
        font-size: 1.4rem; /* Reduced from 1.8rem for mobile */
        font-weight: bold;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        margin-bottom: 10px; /* Reduced spacing */
        line-height: 1.2;
    }

    .slider-content p {
        color: #fff;
        font-size: 0.8rem; /* Reduced from 0.9rem */
        text-shadow: 1px 1px 3px rgba(0,0,0,0.5);
        max-width: 500px;
        display: -webkit-box;
        -webkit-line-clamp: 2; /* Limit to 2 lines on mobile */
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Responsive text sizes */
    @media (min-width: 768px) {
        .slider-content {
            padding: 40px;
        }
        .slider-content h5 {
            font-size: 1.2rem;
        }
        .slider-content h2 {
            font-size: 2.2rem; /* Slightly larger for tablet+ */
        }
        .slider-content p {
            font-size: 1rem;
            -webkit-line-clamp: 3; /* Allow 3 lines on larger screens */
        }
    }

    @media (min-width: 992px) {
        .slider-content h2 {
            font-size: 2.5rem;
        }
    }
        .slider-content h2 {
            font-size: 2.5rem;
        }
        .slider-content p {
            font-size: 1rem;
        }
    }

    @media (min-width: 1200px) {
        .slider-content {
            padding: 60px;
        }
        .slider-content h2 {
            font-size: 3rem;
        }
        .slider-content p {
            font-size: 1.1rem;
        }
    }

    /* Owl Carousel Navigation - Rounded and Modern */
    .home-slider .owl-nav button {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(255,255,255,0.9) !important;
        width: 45px;
        height: 45px;
        border-radius: 50%;
        font-size: 20px;
        color: #333 !important;
        transition: all 0.3s ease;
        box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        z-index: 10;
    }

    .home-slider .owl-nav button.owl-prev {
        left: 15px;
    }

    .home-slider .owl-nav button.owl-next {
        right: 15px;
    }

    .home-slider .owl-nav button:hover {
        background: rgba(255,255,255,1) !important;
        box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        transform: translateY(-50%) scale(1.1);
    }

    .home-slider .owl-dots {
        text-align: center;
        margin-top: -50px;
        position: relative;
        z-index: 10;
        padding-bottom: 20px;
    }

    .home-slider .owl-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: rgba(255,255,255,0.5) !important;
        margin: 0 4px;
        display: inline-block;
        transition: all 0.3s ease;
    }

    .home-slider .owl-dot.active {
        background: rgba(255,255,255,1) !important;
        width: 30px;
        border-radius: 5px;
    }

    .home-slider .owl-dot:hover {
        background: rgba(255,255,255,0.8) !important;
    }

    /* Product Grid Loading State */
    #products-grid.loading-products {
        opacity: 0.6;
        pointer-events: none;
        position: relative;
    }

    #products-grid.loading-products::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 50px;
        height: 50px;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #7caa53;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        z-index: 1000;
    }

    @keyframes spin {
        0% { transform: translate(-50%, -50%) rotate(0deg); }
        100% { transform: translate(-50%, -50%) rotate(360deg); }
    }
</style>
@endsection

@section('content')
{{-- Header (always visible with cart icon) --}}
@include('partials.global.common-header')

{{-- Slider Section - Rounded with Same Width as Products --}}
@if(isset($ps) && isset($sliders) && $ps->slider == 1 && count($sliders) > 0)
<section class="home-slider-section">
    <div class="container-fluid px-4">
        <div class="home-slider owl-carousel owl-theme">
            @foreach($sliders as $slider)
            <div class="slider-item" style="background-image: url('{{asset('assets/images/sliders/'.$slider->photo)}}');">
                <div class="slider-content text-{{ $slider->position ?? 'left' }}">

                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Category Navigation Section --}}
@include('partials.category.category-nav')

{{-- Products Grid Section with Infinite Scroll - Full Width Container --}}
<section class="products-section">
    <div class="container-fluid px-4">
        <div class="row">

        </div>

        {{-- Products Grid --}}
        <div class="row g-4" id="products-grid">
            @include('partials.product.product-card-grid', ['products' => $products])
        </div>

        {{-- Loading Indicator --}}
        <div class="row mt-5 d-none" id="products-loading">
            <div class="col-12 text-center">
                <div class="spinner-border spinner-border-custom text-primary" role="status">
                    <span class="visually-hidden">{{ __('Loading...') }}</span>
                </div>
                <p class="mt-3 text-muted">{{ __('Loading more products...') }}</p>
            </div>
        </div>

        {{-- End of Products Message --}}
        <div class="row mt-5 d-none" id="products-end-message">
            <div class="col-12 text-center">
                <p class="text-muted">
                    <i class="icofont-check-circled text-success me-2"></i>
                    {{ __('You\'ve viewed all products!') }}
                </p>
            </div>
        </div>

        {{-- Error Message --}}
        <div class="row mt-5 d-none" id="products-error">
            <div class="col-12 text-center">
                <p class="text-danger">
                    <i class="icofont-exclamation-circle me-2"></i>
                    {{ __('Error loading products. Please try again.') }}
                </p>
            </div>
        </div>
    </div>
</section>

{{-- Footer --}}
@include('partials.global.common-footer')

{{-- Scroll to Top Button --}}
<button class="scroll-to-top" id="scrollToTop">
    <i class="icofont-arrow-up"></i>
</button>

@endsection

@section('script')
{{-- Category Filter Configuration --}}
<script>
    // Set filter URL for category filtering
    window.filterProductsUrl = '{{ route("front.products.filter") }}';

    // Translations for UI
    window.translations = {
        all_products: '{{ __("All Products") }}',
        showing: '{{ __("Showing") }}',
        of: '{{ __("of") }}',
        products: '{{ __("products") }}'
    };
</script>

{{-- Category Filter Script --}}
<script src="{{ asset('assets/front/js/category-filter.js') }}"></script>

<script>
// Wait for both jQuery and DOM to be ready
(function() {
    'use strict';

    // Check if jQuery is loaded
    if (typeof jQuery === 'undefined') {
        console.error('❌ jQuery is not loaded!');
        return;
    }

    console.log('✅ jQuery loaded, version:', jQuery.fn.jquery);

    jQuery(document).ready(function($) {
        console.log('🚀 Pagination script initialized');
        console.log('📊 Page info:', {
            url: window.location.href,
            hasMorePages: {{ $products->hasMorePages() ? 'true' : 'false' }},
            currentProducts: {{ $products->count() }},
            totalProducts: {{ $products->total() }}
        });

        // Infinite Scroll Implementation
        let isLoading = false;
        let currentPage = 2;
        let hasMorePages = {{ $products->hasMorePages() ? 'true' : 'false' }};

        // Verify elements exist
        const productsGrid = $('#products-grid');
        const productsLoading = $('#products-loading');
        const productsError = $('#products-error');
        const productsEndMessage = $('#products-end-message');

        console.log('🔍 Elements check:', {
            productsGrid: productsGrid.length,
            productsLoading: productsLoading.length,
            productsError: productsError.length,
            productsEndMessage: productsEndMessage.length
        });

        if (productsGrid.length === 0) {
            console.error('❌ #products-grid element not found!');
            return;
        }

        function isNearBottom() {
            const scrollTop = $(window).scrollTop();
            const windowHeight = $(window).height();
            const documentHeight = $(document).height();
            const distanceFromBottom = documentHeight - (scrollTop + windowHeight);
            const isNear = distanceFromBottom < 500; // Trigger when 500px from bottom

            return isNear;
        }

        function loadMoreProducts() {
            console.log('� loadMoreProducts called', {
                isLoading,
                hasMorePages,
                currentPage,
                timestamp: new Date().toLocaleTimeString()
            });

            if (isLoading) {
                console.log('⏸️ Already loading...');
                return;
            }

            if (!hasMorePages) {
                console.log('⏹️ No more pages to load');
                return;
            }

            isLoading = true;
            productsLoading.removeClass('d-none').show();

            console.log('� Sending AJAX request for page:', currentPage);

            $.ajax({
                url: '{{ route("front.products.load") }}',
                method: 'GET',
                data: { page: currentPage },
                dataType: 'json',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    console.log('✅ AJAX Success! Response:', {
                        hasHtml: !!response.html,
                        htmlLength: response.html ? response.html.length : 0,
                        nextPage: response.next_page,
                        hasMore: response.has_more,
                        currentPage: response.current_page,
                        total: response.total
                    });

                    if (response.html && response.html.trim() !== '') {
                        productsGrid.append(response.html);
                        hasMorePages = response.has_more;
                        currentPage = response.next_page || (currentPage + 1);

                        console.log('✨ Products appended! New state:', {
                            hasMorePages,
                            currentPage,
                            newProductsCount: $(response.html).filter('.product-item').length
                        });

                        if (!hasMorePages) {
                            productsEndMessage.removeClass('d-none').show();
                            console.log('🏁 Reached end of products');
                        }
                    } else {
                        console.warn('⚠️ Empty HTML response');
                    }

                    productsLoading.addClass('d-none').hide();
                    isLoading = false;
                },
                error: function(xhr, status, error) {
                    console.error('❌ AJAX Error:', {
                        status: xhr.status,
                        statusText: xhr.statusText,
                        error: error,
                        responseText: xhr.responseText ? xhr.responseText.substring(0, 200) : 'No response'
                    });

                    productsLoading.addClass('d-none').hide();
                    productsError.removeClass('d-none').show();
                    isLoading = false;
                }
            });
        }

        // Scroll to Top Button Logic
        const scrollToTopBtn = $('#scrollToTop');

        // Track scroll position for debugging
        let lastScrollTop = 0;
        let scrollCheckCount = 0;

        // Single scroll event handler
        let scrollTimeout;
        $(window).on('scroll', function() {
            clearTimeout(scrollTimeout);

            scrollTimeout = setTimeout(function() {
                const scrollTop = $(window).scrollTop();
                const windowHeight = $(window).height();
                const documentHeight = $(document).height();
                const distanceFromBottom = documentHeight - (scrollTop + windowHeight);

                // Log every 10th scroll check
                if (scrollCheckCount % 10 === 0) {
                    console.log('📜 Scroll check #' + scrollCheckCount + ':', {
                        scrollTop: Math.round(scrollTop),
                        windowHeight: Math.round(windowHeight),
                        documentHeight: Math.round(documentHeight),
                        distanceFromBottom: Math.round(distanceFromBottom),
                        hasMorePages,
                        isLoading
                    });
                }
                scrollCheckCount++;

                // Show/hide scroll to top button
                if (scrollTop > 300) {
                    scrollToTopBtn.addClass('show');
                } else {
                    scrollToTopBtn.removeClass('show');
                }

                // Infinite scroll check
                if (isNearBottom() && !isLoading && hasMorePages && scrollTop > 100) {
                    console.log('🎯 TRIGGER! Loading more products...');
                    loadMoreProducts();
                }

                lastScrollTop = scrollTop;
            }, 100); // Reduced debounce time for more responsive loading
        });

        // Scroll to top button click handler
        scrollToTopBtn.on('click', function(e) {
            e.preventDefault();
            console.log('⬆️ Scroll to top clicked');

            $('html, body').animate({
                scrollTop: 0
            }, 600, 'swing');
        });

        // Check if initial page is too short
        setTimeout(function() {
            const docHeight = $(document).height();
            const winHeight = $(window).height();

            console.log('📏 Initial page height check:', {
                docHeight,
                winHeight,
                needsMore: docHeight <= winHeight + 100,
                hasMorePages
            });

            if (docHeight <= winHeight + 100 && hasMorePages) {
                console.log('📄 Page too short, auto-loading more products...');
                loadMoreProducts();
            }
        }, 1500);

        // Add to Cart Functionality
        $(document).on('click', '.add-to-cart-btn', function(e) {
            e.preventDefault();
            const btn = $(this);
            const productId = btn.data('product-id');
            const productName = btn.data('product-name');

            console.log('🛒 Add to cart clicked:', { productId, productName });
            alert('Product added to cart: ' + productName);
        });

        // Manual test function
        window.testPagination = function() {
            console.log('🧪 Manual test triggered');
            loadMoreProducts();
        };

        console.log('💡 Type testPagination() in console to manually test pagination');
        console.log('✅ Pagination system ready!');
    });
})();
</script>


{{-- Initialize Slider --}}
<script>
    $(document).ready(function(){
        console.log('🎠 Initializing slider...');
        console.log('Slider elements found:', $('.home-slider').length);
        console.log('Slider HTML:', $('.home-slider').html());

        if($('.home-slider').length > 0) {
            console.log('✅ Slider found, initializing owl carousel...');
            try {
                $('.home-slider').owlCarousel({
                    items: 1,
                    loop: true,
                    autoplay: true,
                    autoplayTimeout: 5000,
                    autoplayHoverPause: true,
                    nav: true,
                    dots: true,
                    navText: ['<i class="icofont-arrow-left"></i>', '<i class="icofont-arrow-right"></i>'],
                    animateOut: 'fadeOut',
                    animateIn: 'fadeIn',
                    rtl: document.documentElement.dir === 'rtl' || document.body.dir === 'rtl'
                });
                console.log('✅ Slider initialized successfully!');
            } catch(error) {
                console.error('❌ Slider initialization error:', error);
            }
        } else {
            console.warn('⚠️ No slider element found');
        }
    });
</script>
@endsection
