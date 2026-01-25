@extends('layouts.front')

@section('css')
<style>
    /* Ensure no extra spacing */
    #page_wrapper {
        padding-top: 0 !important;
        margin-top: 0 !important;
    }

    /* Body spacing for sticky header - reduced to actual header height */
    body {
        margin: 0 !important;
        padding: 0 !important;
        padding-top: 0px !important; /* No padding - header is sticky */
        overflow-x: hidden;
        position: relative;
    }

    /* Mobile body padding for sticky header */
    @media (max-width: 991px) {
        body {
            padding-top: 0px !important; /* No padding on mobile */
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
        background: transparent !important;
        min-height: 0 !important;
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
        position: relative;
        isolation: isolate;
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
        padding: 10px;
        padding-bottom: 0px;
        min-height: 300px !important;
        max-height: 300px !important;
        height: 300px !important;
        background: #ffffff;
        border-radius: 8px 8px 0 0;
        margin-bottom: 0;
    }

    .product-thumb a {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
    }

    .product-image {
        max-height: 90%;
        max-width: 90%;
        width: auto !important;
        height: auto !important;
        object-fit: contain;
        margin: 0 auto;
        display: block;
        transform: scale(0.98); /* 15% smaller: 1.15 * 0.85 = 0.9775 ≈ 0.98 */
        transition: transform 0.3s ease;
    }

    .product-card:hover .product-image {
        transform: scale(1.02); /* Proportionally smaller on hover: 1.2 * 0.85 = 1.02 */
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

    /* Increase old price font size */
    .price-old {
        font-size: 1rem !important; /* Increased from default ~0.875rem */
    }

    /* Discount Badge - Typical style like in image */
    .on-sale {
        font-size: 13px !important;
        font-weight: 700 !important;
        padding: 2px 6px !important;
        line-height: 1.1 !important;
        background: #ff0000 !important;
        color: #ffffff !important;
        border-radius: 3px !important;
        box-shadow: none !important;
        border: none !important;
        letter-spacing: 0 !important;
        z-index: 10 !important;
        position: absolute !important;
        top: 5px !important;
        left: 5px !important;
        margin: 0 !important;
    }

    /* RTL Support for Product Cards */
    html[lang="ar"] .product-title,
    html[lang="arabic"] .product-title,
    html[lang="Arabic"] .product-title,
    html[lang="العربية"] .product-title,
    html[dir="rtl"] .product-title,
    body[dir="rtl"] .product-title,
    body.rtl .product-title,
    body.ar .product-title {
        text-align: right !important;
        direction: rtl !important;
    }

    html[lang="ar"] .product-price,
    html[lang="arabic"] .product-price,
    html[lang="Arabic"] .product-price,
    html[lang="العربية"] .product-price,
    html[dir="rtl"] .product-price,
    body[dir="rtl"] .product-price,
    body.rtl .product-price,
    body.ar .product-price {
        text-align: right !important;
        direction: rtl !important;
    }

    /* Force RTL for product content when Arabic */
    .rtl .product-content,
    [dir="rtl"] .product-content {
        text-align: right !important;
        direction: rtl !important;
    }

    .product-title {
        font-size: 0.9rem;
        line-height: 1.4;
    }

    /* Desktop: Reduce gap between image and name to 5px */
    @media (min-width: 768px) {
        .product-content,
        .product-content-desktop {
            padding-top: 5px !important;
            margin-top: 0 !important;
        }
        
        .product-thumb {
            padding-bottom: 5px !important;
            margin-bottom: 0 !important;
        }
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

    /* Responsive slider heights - Decreased 10% for mobile (300px -> 270px) */
    /* Mobile Small (< 576px) */
    @media (max-width: 575px) {
        .home-slider-section {
            padding: 0 !important;
            margin: 0 !important;
            margin-bottom: 0 !important;
            margin-top: 0 !important;
        }

        .slider-item,
        .home-slider .owl-item .slider-item,
        .owl-item .slider-item {
            min-height: 150px !important;
            max-height: 150px !important;
            height: 150px !important;
        }

        .slider-content h2 {
            font-size: 0.9rem !important;
            padding: 0 10px !important;
        }

        .slider-content p {
            display: none !important;
        }

        .home-slider-section .container-fluid {
            padding: 0 !important;
            margin: 0 !important;
        }
        
        .home-slider {
            margin: 0 !important;
            padding: 0 !important;
        }
        
        .owl-carousel,
        .owl-carousel .owl-stage-outer,
        .owl-carousel .owl-stage {
            margin: 0 !important;
            padding: 0 !important;
        }

        /* Remove ALL spacing between slider and category section */
        .home-slider-section,
        section.home-slider-section {
            margin: 0 !important;
            padding: 0 !important;
            margin-bottom: 0 !important;
        }
        
        .home-slider-section .container-fluid {
            margin: 0 !important;
            padding: 0 !important;
            margin-bottom: 0 !important;
        }
        
        .home-slider .owl-stage-outer {
            margin-bottom: 0 !important;
            padding-bottom: 0 !important;
        }
        
        /* Category navigation section - zero spacing */
        section.category-navigation-section,
        .category-navigation-section {
            margin: 0 !important;
            margin-top: 0 !important;
            margin-bottom: 0 !important;
            padding: 0 !important;
            padding-top: 0 !important;
            padding-bottom: 0 !important;
        }
        
        .category-navigation-section .container-fluid {
            padding-left: 7.5px !important;
            padding-right: 7.5px !important;
            padding-top: 0 !important;
            padding-bottom: 0 !important;
            margin: 0 !important;
        }

        /* Products section - minimal top spacing */
        .products-section {
            margin: 0 !important;
            margin-top: 0 !important;
            padding: 10px 0 !important;
            padding-top: 5px !important;
        }

        /* Product Grid - 50% smaller spacing (7.5px total instead of 15px) */
        .products-section .container-fluid {
            padding-left: 7.5px !important;
            padding-right: 7.5px !important;
        }

        .products-section .row {
            margin-left: -3.75px !important;
            margin-right: -3.75px !important;
        }

        .products-section .col-6,
        .products-section .col-sm-4,
        .products-section .col-md-3,
        .products-section .col-lg-2 {
            padding-left: 3.75px !important;
            padding-right: 3.75px !important;
        }

        /* Center product images perfectly */
        .product-thumb {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 8px !important;
            padding-bottom: 4px !important;
            min-height: 180px !important;
            max-height: 180px !important;
            height: 180px !important;
            overflow: hidden !important;
            position: relative !important;
            background: #ffffff !important;
        }

        .product-thumb a {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 100% !important;
            height: 100% !important;
            overflow: hidden !important;
        }

        .product-image {
            max-width: 100% !important;
            max-height: 100% !important;
            width: auto !important;
            height: auto !important;
            object-fit: contain !important;
            margin: 0 auto !important;
            display: block !important;
            transform: scale(1.11) !important; /* 15% smaller than 1.3: 1.3 * 0.85 = 1.105 ≈ 1.11 */
        }

        .product-card {
            margin-bottom: 7.5px !important;
            display: flex !important;
            flex-direction: column !important;
            overflow: hidden !important;
            position: relative !important;
            isolation: isolate !important;
            contain: layout style paint !important;
        }

        .product-item {
            margin-bottom: 0 !important;
            overflow: hidden !important;
            contain: layout style !important;
        }

        /* Fix product content spacing on mobile */
        .product-content {
            padding: 6px !important;
            padding-top: 4px !important;
            padding-bottom: 6px !important;
            flex: 1 !important;
            display: flex !important;
            flex-direction: column !important;
            position: relative !important;
            z-index: 1 !important;
            margin-top: 0 !important;
        }

        .product-title {
            font-size: 0.75rem !important;
            line-height: 1.2 !important;
            min-height: 30px !important;
            margin-bottom: 3px !important;
            margin-top: 0 !important;
        }

        .product-price {
            font-size: 0.85rem !important;
            margin-top: auto !important;
            display: block !important;
            white-space: nowrap !important;
        }

        .price-current {
            font-size: 0.9rem !important;
            display: inline-block !important;
        }

        .price-old {
            font-size: 0.75rem !important;
            display: inline-block !important;
        }

        /* Hide slider navigation on mobile */
        .home-slider .owl-nav {
            display: none !important;
        }

        .home-slider .owl-dots {
            display: none !important; /* Hide dots on mobile */
        }
        
        /* Ensure owl-carousel doesn't add extra space */
        .home-slider.owl-carousel {
            margin-bottom: 0 !important;
            padding-bottom: 0 !important;
        }
        
        /* Force remove ALL space after slider */
        .home-slider-section,
        .home-slider-section + *,
        section.home-slider-section + section {
            margin-bottom: 0 !important;
            padding-bottom: 0 !important;
        }
        
        /* Target the next element after slider */
        .home-slider-section ~ section:first-of-type,
        .home-slider-section + section {
            margin-top: 0 !important;
            padding-top: 5px !important;
        }

        /* Android Chrome/WebView specific fixes */
        .product-item,
        .product-card,
        .product-thumb,
        .product-content {
            -webkit-transform: translateZ(0) !important;
            transform: translateZ(0) !important;
            -webkit-backface-visibility: hidden !important;
            backface-visibility: hidden !important;
            -webkit-perspective: 1000 !important;
            perspective: 1000 !important;
        }

        /* Force hardware acceleration and prevent overflow glitches */
        .col-6 {
            -webkit-transform: translate3d(0, 0, 0) !important;
            transform: translate3d(0, 0, 0) !important;
        }

        /* Ensure no pseudo-elements escape on Android */
        .product-card::before,
        .product-card::after,
        .product-item::before,
        .product-item::after {
            content: none !important;
            display: none !important;
        }
    }

    /* Mobile Large (576px - 767px) */
    @media (min-width: 576px) and (max-width: 767px) {
        .slider-item,
        .home-slider .owl-item .slider-item,
        .owl-item .slider-item {
            min-height: 188px !important;
            max-height: 188px !important;
            height: 188px !important;
        }
        .slider-content h2 {
            font-size: 1.1rem !important;
        }

        /* Remove spacing between sections */
        .home-slider-section {
            margin-bottom: 0 !important;
        }

        .category-navigation-section {
            margin-top: 0 !important;
            margin-bottom: 0 !important;
            padding: 10px 0 !important;
        }

        .products-section {
            margin-top: 0 !important;
            padding: 15px 0 !important;
        }

        /* Product Grid - 50% smaller spacing */
        .products-section .container-fluid {
            padding-left: 7.5px !important;
            padding-right: 7.5px !important;
        }

        .products-section .row {
            margin-left: -3.75px !important;
            margin-right: -3.75px !important;
        }

        .products-section .col-6,
        .products-section .col-sm-4,
        .products-section .col-md-3,
        .products-section .col-lg-2 {
            padding-left: 3.75px !important;
            padding-right: 3.75px !important;
        }

        /* Center product images */
        .product-thumb {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 8px !important;
            padding-bottom: 4px !important;
            min-height: 170px !important;
            max-height: 170px !important;
            height: 170px !important;
            overflow: hidden !important;
            position: relative !important;
            background: #ffffff !important;
        }

        .product-thumb a {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 100% !important;
            height: 100% !important;
            overflow: hidden !important;
        }

        .product-image {
            max-width: 100% !important;
            max-height: 100% !important;
            width: auto !important;
            height: auto !important;
            object-fit: contain !important;
            margin: 0 auto !important;
            display: block !important;
        }

        .product-card {
            margin-bottom: 7.5px !important;
            display: flex !important;
            flex-direction: column !important;
            overflow: hidden !important;
            position: relative !important;
        }

        /* Fix product content spacing on mobile large */
        .product-content {
            padding: 6px !important;
            padding-top: 4px !important;
            padding-bottom: 6px !important;
            flex: 1 !important;
            display: flex !important;
            flex-direction: column !important;
            margin-top: 0 !important;
        }

        .product-title {
            font-size: 0.8rem !important;
            line-height: 1.2 !important;
            min-height: 30px !important;
            margin-bottom: 3px !important;
            margin-top: 0 !important;
        }

        .product-price {
            font-size: 0.85rem !important;
            margin-top: auto !important;
        }
            margin: 0 auto !important;
            display: block !important;
        }
    }

    /* Tablet (768px - 991px) */
    @media (min-width: 768px) and (max-width: 991px) {
        .slider-item,
        .home-slider .owl-item .slider-item,
        .owl-item .slider-item {
            min-height: 210px !important;
            max-height: 210px !important;
            height: 210px !important;
        }
        .home-slider-section {
            padding: 0 15px !important;
            margin-bottom: 0 !important;
        }

        /* Remove spacing between sections */
        .category-navigation-section {
            margin-top: 0 !important;
            margin-bottom: 0 !important;
        }

        .products-section {
            margin-top: 0 !important;
            padding: 20px 0 !important;
        }

        /* Center product images */
        .product-thumb {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 15px !important;
            min-height: 200px !important;
        }

        .product-thumb a {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 100% !important;
            height: 100% !important;
        }

        .product-image {
            max-width: 100% !important;
            max-height: 100% !important;
            width: auto !important;
            height: auto !important;
            object-fit: contain !important;
            margin: 0 auto !important;
            display: block !important;
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

    /* CRITICAL: Mobile slider height override - 50% smaller (300px -> 150px) */
    @media only screen and (max-width: 575px) {
        .home-slider-section,
        section.home-slider-section {
            min-height: 150px !important;
            max-height: 150px !important;
            margin: 0 !important;
            padding: 0 !important;
            margin-bottom: 0 !important;
        }
        
        .slider-item,
        .home-slider .slider-item,
        .home-slider .owl-item .slider-item,
        .owl-carousel .slider-item,
        .owl-carousel .owl-item .slider-item,
        div.slider-item {
            min-height: 150px !important;
            max-height: 150px !important;
            height: 150px !important;
        }

        .home-slider .owl-stage-outer,
        .home-slider .owl-stage {
            min-height: 150px !important;
            max-height: 150px !important;
            height: 150px !important;
        }
        
        /* CRITICAL: Remove ALL space between slider and categories */
        .home-slider-section + div,
        .home-slider-section + div > section,
        .category-navigation-section {
            margin-top: 0 !important;
            padding-top: 0 !important;
        }
        
        /* Hide owl-carousel dots on mobile - they take up space */
        .home-slider .owl-dots {
            display: none !important;
        }
    }

    /* Tablet slider height */
    @media only screen and (min-width: 576px) and (max-width: 767px) {
        .slider-item,
        .home-slider .slider-item,
        .home-slider .owl-item .slider-item,
        div.slider-item {
            min-height: 220px !important;
            max-height: 220px !important;
            height: 220px !important;
        }
    }
</style>
@endsection

@section('content')
{{-- Header (always visible with cart icon) --}}
@include('partials.global.common-header')

{{-- Slider Section - Rounded with Same Width as Products --}}
@if(isset($ps) && isset($sliders) && $ps->slider == 1 && count($sliders) > 0)
<section class="home-slider-section" style="margin: 0; padding: 0;">
    <div class="container-fluid" style="margin: 0; padding: 0;">
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
@else
<div style="padding: 20px; background: #ffcccc; text-align: center;">
    DEBUG: Slider not showing.
    PS exists: {{ isset($ps) ? 'YES' : 'NO' }} |
    Sliders exists: {{ isset($sliders) ? 'YES' : 'NO' }} |
    PS slider value: {{ isset($ps) ? $ps->slider : 'N/A' }} |
    Sliders count: {{ isset($sliders) ? count($sliders) : '0' }}
</div>
@endif

{{-- Category Navigation Section - NO SPACE --}}
<div style="margin: 0 !important; padding: 0 !important; margin-top: -5px !important;">
@include('partials.category.category-nav')
</div>

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

        // 🔄 SCROLL POSITION RESTORATION ENABLED
        // When you click a product and go to details page, then press back button,
        // the page will automatically restore to your previous scroll position
        console.log('🔄 Scroll restoration: ENABLED');

        // Infinite Scroll Implementation
        let isLoading = false;
        let currentPage = 2;
        let hasMorePages = {{ $products->hasMorePages() ? 'true' : 'false' }};
        let isRestoringScroll = false; // Flag to prevent scroll events during restoration

        // Reset pagination state when category filter changes
        window.resetPaginationState = function(newHasMorePages) {
            currentPage = 2; // Reset to page 2 (page 1 is already loaded)
            hasMorePages = newHasMorePages !== undefined ? newHasMorePages : true;
            isLoading = false;

            // Hide end message and errors
            productsEndMessage.addClass('d-none').hide();
            productsError.addClass('d-none').hide();

            // Clear scroll restoration data when filters change
            sessionStorage.removeItem('homepage_scroll_position');
            sessionStorage.removeItem('homepage_current_page');

            console.log('🔄 Pagination state reset:', { currentPage, hasMorePages });
        };

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

            // Get current filter state from CategoryFilter
            const filterState = window.CategoryFilter ? window.CategoryFilter.getState() : {};
            const hasActiveFilters = filterState.currentCategory || filterState.currentSubcategory || filterState.currentChildcategory;

            // Build request data
            const requestData = {
                page: currentPage
            };

            // Add filter parameters if active
            if (hasActiveFilters) {
                if (filterState.currentCategory && filterState.currentCategory !== 'all') {
                    requestData.category_id = filterState.currentCategory;
                }
                if (filterState.currentSubcategory && filterState.currentSubcategory !== 'all') {
                    requestData.subcategory_id = filterState.currentSubcategory;
                }
                if (filterState.currentChildcategory && filterState.currentChildcategory !== 'all') {
                    requestData.childcategory_id = filterState.currentChildcategory;
                }
            }

            // Use filter endpoint if filters are active, otherwise use load endpoint
            const url = hasActiveFilters ? '{{ route("front.products.filter") }}' : '{{ route("front.products.load") }}';

            console.log('📡 Sending AJAX request:', {
                url: url,
                page: currentPage,
                filters: requestData
            });

            $.ajax({
                url: url,
                method: 'GET',
                data: requestData,
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

                        // Initialize lazy loading if available
                        if (typeof lazy === 'function') {
                            lazy();
                        }
                    } else {
                        console.warn('⚠️ Empty HTML response');
                        hasMorePages = false;
                        productsEndMessage.removeClass('d-none').show();
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

        // ===== SCROLL POSITION RESTORATION =====
        // Save scroll position and current page when clicking a product
        productsGrid.on('click', '.product-card a, .product-item a', function() {
            const scrollPosition = $(window).scrollTop();
            sessionStorage.setItem('homepage_scroll_position', scrollPosition);
            sessionStorage.setItem('homepage_current_page', currentPage - 1); // Save last loaded page
            console.log('💾 Saved scroll state:', {
                scrollPosition: scrollPosition,
                lastLoadedPage: currentPage - 1
            });
        });

        // Restore scroll position when returning to homepage
        const savedScrollPosition = sessionStorage.getItem('homepage_scroll_position');
        const savedPage = sessionStorage.getItem('homepage_current_page');
        
        if (savedScrollPosition && savedPage) {
            const targetPage = parseInt(savedPage);
            const targetScroll = parseInt(savedScrollPosition);
            
            console.log('📍 Restoring scroll state:', {
                targetScroll: targetScroll,
                targetPage: targetPage,
                needsToLoad: targetPage > 1
            });

            // If we need to load more pages
            if (targetPage > 1) {
                isRestoringScroll = true;
                productsLoading.removeClass('d-none').show(); // Show loading indicator
                
                // Function to load pages sequentially
                function loadPagesSequentially(fromPage, toPage, callback) {
                    if (fromPage > toPage) {
                        callback();
                        return;
                    }

                    console.log(`🔄 Loading page ${fromPage} of ${toPage} for restoration...`);

                    // Get current filter state
                    const filterState = window.CategoryFilter ? window.CategoryFilter.getState() : {};
                    const hasActiveFilters = filterState.currentCategory || filterState.currentSubcategory || filterState.currentChildcategory;

                    const requestData = { page: fromPage };
                    if (hasActiveFilters) {
                        if (filterState.currentCategory && filterState.currentCategory !== 'all') {
                            requestData.category_id = filterState.currentCategory;
                        }
                        if (filterState.currentSubcategory && filterState.currentSubcategory !== 'all') {
                            requestData.subcategory_id = filterState.currentSubcategory;
                        }
                        if (filterState.currentChildcategory && filterState.currentChildcategory !== 'all') {
                            requestData.childcategory_id = filterState.currentChildcategory;
                        }
                    }

                    const url = hasActiveFilters ? '{{ route("front.products.filter") }}' : '{{ route("front.products.load") }}';

                    $.ajax({
                        url: url,
                        method: 'GET',
                        data: requestData,
                        success: function(response) {
                            if (response.html && response.html.trim()) {
                                productsGrid.append(response.html);
                                console.log(`✅ Page ${fromPage} loaded`);
                                
                                // Load next page
                                loadPagesSequentially(fromPage + 1, toPage, callback);
                            } else {
                                console.log(`⚠️ Page ${fromPage} has no content`);
                                callback();
                            }
                        },
                        error: function() {
                            console.error(`❌ Failed to load page ${fromPage}`);
                            callback();
                        }
                    });
                }

                // Load all pages from 2 to target page
                loadPagesSequentially(2, targetPage, function() {
                    console.log('✅ All pages loaded, restoring scroll...');
                    currentPage = targetPage + 1; // Set next page to load
                    productsLoading.addClass('d-none').hide(); // Hide loading indicator
                    
                    // Restore scroll position
                    setTimeout(function() {
                        $('html, body').scrollTop(targetScroll);
                        isRestoringScroll = false;
                        
                        // Clear saved data
                        sessionStorage.removeItem('homepage_scroll_position');
                        sessionStorage.removeItem('homepage_current_page');
                        
                        console.log('✅ Scroll position restored to', targetScroll);
                    }, 300);
                });
            } else {
                // No need to load pages, just restore scroll
                setTimeout(function() {
                    $('html, body').scrollTop(targetScroll);
                    sessionStorage.removeItem('homepage_scroll_position');
                    sessionStorage.removeItem('homepage_current_page');
                    console.log('✅ Scroll position restored (no pages needed)');
                }, 100);
            }
        }

        // Scroll to Top Button Logic
        const scrollToTopBtn = $('#scrollToTop');

        // Track scroll position for debugging
        let lastScrollTop = 0;
        let scrollCheckCount = 0;

        // Single scroll event handler
        let scrollTimeout;
        $(window).on('scroll', function() {
            // Don't handle scroll events during restoration
            if (isRestoringScroll) {
                return;
            }

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
