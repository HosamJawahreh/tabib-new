<style>
/* Enhanced Product Page Styles */

/* RTL Support for Product Details */
@php
    $isArabic = isset($langg) && ($langg->language == 'العربية' || $langg->language == 'Arabic' || $langg->language == 'ar');
@endphp

@if($isArabic)
/* Arabic RTL Styles */
.product-info {
    direction: rtl;
    text-align: right;
}

.product-info h1,
.product-info h2,
.product-info h3,
.product-info h4,
.product-info h5,
.product-info h6 {
    text-align: right;
}

.product-info p,
.product-info div,
.product-info label,
.product-info span {
    text-align: right;
    direction: rtl;
}

.product-description {
    direction: rtl;
    text-align: right;
}

.price-section {
    direction: rtl;
    text-align: right;
}

.product-attributes {
    direction: rtl;
    text-align: right;
}

.product-meta {
    direction: rtl;
    text-align: right;
}

.single-product-content {
    direction: rtl;
    text-align: right;
}

.product-tabs {
    direction: rtl;
    text-align: right;
}

.tab-content {
    direction: rtl;
    text-align: right;
}

select,
input,
textarea {
    text-align: right;
    direction: rtl;
}
@endif

.product-images .item a:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 12px rgba(0,0,0,0.15) !important;
}

/* Professional Main Product Image Container */
.product-images {
    position: relative !important;
    overflow: visible !important;
    /* Professional Smooth Scrolling for entire product area */
    scroll-behavior: smooth;
    -webkit-overflow-scrolling: touch;
}

.woocommerce-product-gallery {
    overflow: visible !important;
    scroll-behavior: smooth;
}

.woocommerce-product-gallery__wrapper {
    margin: 0 !important;
    overflow: visible !important;
    scroll-behavior: smooth;
}

#single-image-zoom {
    cursor: zoom-in !important;
    transition: all 0.3s ease !important;
    display: block !important;
}

/* Professional Desktop Zoom with Inner Window - Hidden Borders */
.zoomLens {
    border: none !important;
    cursor: crosshair !important;
    opacity: 0 !important;
    background: transparent !important;
    box-shadow: none !important;
    display: none !important;
}

.zoomWindow {
    border: none !important;
    border-radius: 0 !important;
    box-shadow: none !important;
    z-index: 999 !important;
    background: #ffffff !important;
}

.zoomWindowContainer {
    z-index: 998 !important;
}

.zoomContainer {
    position: relative !important;
}

/* Main image container for desktop zoom */
#single-image-zoom {
    position: relative !important;
    z-index: 1 !important;
}

@media (min-width: 768px) {
    .mobile-zoom-wrapper {
        position: relative !important;
        overflow: visible !important;
    }

    #single-image-zoom {
        cursor: crosshair !important;
    }
}

/* Mobile Touch Zoom - Button-Only Control */
@media (max-width: 767px) {
    .mobile-zoom-wrapper {
        position: relative;
        overflow: visible;
        touch-action: auto;
        width: 100%;
        height: auto;
        /* Professional Smooth Scrolling */
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
    }

    /* Mobile Zoom Control Buttons */
    .mobile-zoom-controls {
        position: absolute;
        bottom: 15px;
        right: 15px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        z-index: 10;
        opacity: 0.9;
        pointer-events: auto !important;
    }

    .zoom-btn {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border: none;
        border-radius: 50%;
        color: white;
        font-size: 20px;
        display: flex;
        pointer-events: auto !important;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
        transition: all 0.3s ease;
        font-weight: bold;
    }

    .zoom-btn:active {
        transform: scale(0.95);
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
    }

    .zoom-btn:disabled {
        background: #9ca3af;
        cursor: not-allowed;
        box-shadow: 0 2px 8px rgba(156, 163, 175, 0.3);
    }

    /* Lock body ONLY when actively zooming with buttons or gestures */
    body.zoom-active {
        overflow: hidden !important;
        position: fixed !important;
        width: 100% !important;
        height: 100% !important;
        top: 0 !important;
        left: 0 !important;
    }

    #single-image-zoom {
        display: block;
        width: 100%;
        height: auto;
        max-width: 100%;
        transform-origin: center center;
        will-change: transform;
        touch-action: auto !important;
        pointer-events: none !important;
        user-select: none;
    }

    #single-image-zoom.zoomed {
        cursor: grab;
        touch-action: none !important;
        pointer-events: auto !important;
        overflow: hidden;
    }

    #single-image-zoom.zoomed:active {
        cursor: grabbing;
    }
}

/* Desktop - keep normal behavior with smooth scrolling */
@media (min-width: 768px) {
    .mobile-zoom-wrapper {
        position: relative !important;
        overflow: visible !important;
        touch-action: auto;
        /* Professional Smooth Scrolling */
        scroll-behavior: smooth;
    }

    #single-image-zoom {
        display: block;
        width: 100%;
        height: auto;
        max-width: 100%;
    }
}/* Professional Gallery Thumbnails - Grid Layout */
#gallery_09 {
    margin-top: 0;
    position: relative;
    clear: both;
}

.gallery-grid {
    display: flex !important;
    flex-direction: row !important;
    flex-wrap: wrap !important;
    gap: 8px !important;
    margin-top: 0 !important;
}

.gallery-item {
    width: 100px;
    flex: 0 0 auto;
}

#gallery_09 a {
    display: block;
    position: relative;
    overflow: hidden;
    border-radius: 8px;
    border: 2px solid #e5e7eb;
    transition: all 0.3s ease;
    background: #fff;
    padding: 3px;
    width: 100%;
    height: 100%;
}

#gallery_09 a:hover {
    border-color: #10b981;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3) !important;
}

#gallery_09 a.active {
    border-color: #10b981;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
    background: #f0fdf4;
}

#gallery_09 img {
    height: 100px !important;
    max-height: 100px !important;
    width: 100%;
    max-width: 100% !important;
    object-fit: cover;
    transition: transform 0.3s ease;
    border-radius: 5px;
    display: block;
}

#gallery_09 a:hover img {
    transform: scale(1.05);
}

/* Owl Carousel Navigation - Hidden (Not Used) */
#gallery_09 .owl-nav {
    display: none !important;
}

/* Main Image Container Enhancement */
.bg-light.rounded.shadow-sm {
    background: transparent !important;
    border: none !important;
    position: relative;
    overflow: hidden;
    padding: 0 !important;
    box-shadow: none !important;
}

.bg-light.rounded.shadow-sm img {
    width: 100% !important;
    height: auto !important;
    display: block !important;
    border: none !important;
    box-shadow: none !important;
}

#single-image-zoom {
    border: none !important;
    box-shadow: none !important;
    outline: none !important;
}

/* Zoom Hint for Desktop */
.zoom-hint {
    position: absolute;
    bottom: 20px;
    left: 20px;
    background: rgba(255, 255, 255, 0.95);
    padding: 10px 18px;
    border-radius: 24px;
    font-size: 14px;
    color: #1f2937;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    opacity: 0;
    transition: opacity 0.3s ease;
    pointer-events: none;
    z-index: 10;
    border: 2px solid rgba(16, 185, 129, 0.3);
}

.product-images:hover .zoom-hint {
    opacity: 1;
}

.zoom-hint i {
    font-size: 18px;
    color: #10b981;
}

@media (min-width: 768px) {
    #gallery_09 img {
        height: 110px !important;
        max-height: 110px !important;
        max-width: 110px !important;
        width: 110px !important;
    }

    .gallery-grid {
        flex-wrap: wrap !important;
        gap: 10px !important;
    }

    .gallery-item {
        width: 110px;
    }
}

@media (min-width: 992px) {
    #gallery_09 img {
        height: 110px !important;
        max-height: 110px !important;
        max-width: 110px !important;
        width: 110px !important;
    }

    .gallery-grid {
        flex-wrap: wrap !important;
        gap: 12px !important;
    }

    .gallery-item {
        width: 110px;
    }
}

/* Mobile Image Zoom - Simple Native Implementation */
@media (max-width: 767px) {
    .product-images {
        position: relative !important;
        overflow: visible !important;
    }

    .bg-light.rounded.shadow-sm {
        overflow: visible !important;
        touch-action: auto !important;
    }

    #single-image-zoom {
        cursor: pointer !important;
        touch-action: auto !important;
        pointer-events: none !important;
        max-width: 100% !important;
        height: auto !important;
    }

    #single-image-zoom.zoomed {
        pointer-events: auto !important;
    }

    /* Mobile gallery navigation adjustments */
    #gallery_09 .owl-carousel {
        padding: 0 45px;
    }

    #gallery_09 .owl-nav .owl-prev {
        left: 0px !important;
    }

    #gallery_09 .owl-nav .owl-next {
        right: 0px !important;
    }

    #gallery_09 .owl-nav button {
        width: 38px !important;
        height: 38px !important;
    }

    #gallery_09 .owl-nav button span {
        font-size: 24px !important;
    }
}

/* Simple Mobile Image Lightbox */
.mobile-image-viewer {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(0, 0, 0, 0.95);
    z-index: 99999;
    overflow: auto;
    -webkit-overflow-scrolling: touch;
}

.mobile-image-viewer.active {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.mobile-image-viewer img {
    max-width: 100%;
    max-height: 100%;
    width: auto;
    height: auto;
    object-fit: contain;
}

.mobile-viewer-close {
    position: fixed;
    top: 15px;
    right: 15px;
    width: 44px;
    height: 44px;
    background: rgba(255, 255, 255, 0.95);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 100000;
    font-size: 24px;
    color: #1f2937;
    font-weight: bold;
    border: none;
}

@media (max-width: 767px) {
    .mobile-image-viewer.active {
        display: block;
        overflow: auto;
    }

    .mobile-image-viewer img {
        width: 100%;
        height: auto;
        max-width: none;
        display: block;
    }
}

.siz-list li.active .box,
.color-list li.active .box {
    border: 2px solid #10b981 !important;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2) !important;
}

.siz-list li:hover .box,
.color-list li:hover .box {
    transform: scale(1.05);
    border-color: #10b981 !important;
}

/* Share Section - Single Row on All Devices */
.share-section {
    text-align: center;
    width: 100%;
}

.share-section h5 {
    font-size: 0.95rem !important;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #6b7280 !important;
    font-weight: 600 !important;
}

.social-linkss .social-icons {
    display: flex !important;
    flex-wrap: nowrap !important;
    gap: 10px !important;
    align-items: center !important;
    justify-content: center !important;
    overflow-x: auto !important;
    -webkit-overflow-scrolling: touch !important;
    scrollbar-width: thin;
    padding: 5px 0;
}

.social-linkss .social-icons::-webkit-scrollbar {
    height: 4px;
}

.social-linkss .social-icons::-webkit-scrollbar-thumb {
    background: #e5e7eb;
    border-radius: 10px;
}

.social-linkss .social-icons li {
    flex-shrink: 0 !important;
}

.social-linkss .social-icons a:hover {
    transform: translateY(-4px) scale(1.08);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2) !important;
}

.social-icons a:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2) !important;
}

/* Enhanced Button Styles */
.add-to-cart-btn,
.buy-now-btn,
.contact-seller-btn {
    position: relative;
    padding: 16px 32px !important;
    font-weight: 600 !important;
    font-size: 1.05rem !important;
    border-radius: 8px !important;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1) !important;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    min-height: 54px;
    overflow: hidden;
}

.add-to-cart-btn:hover,
.buy-now-btn:hover,
.contact-seller-btn:hover {
    transform: translateY(-2px) !important;
    box-shadow: 0 6px 20px rgba(0,0,0,0.15) !important;
}

.add-to-cart-btn:active,
.buy-now-btn:active,
.contact-seller-btn:active {
    transform: translateY(0) !important;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
}

.add-to-cart-btn i,
.buy-now-btn i,
.contact-seller-btn i {
    font-size: 1.3rem;
    transition: transform 0.3s ease;
}

.add-to-cart-btn:hover i {
    transform: scale(1.1);
}

.buy-now-btn:hover i {
    transform: rotate(360deg);
}

.contact-seller-btn:hover i {
    animation: pulse 0.6s ease-in-out;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.15); }
}

.btn-loader {
    margin-left: 8px;
}

.add-to-cart-btn.loading span:not(.btn-loader),
.buy-now-btn.loading span:not(.btn-loader) {
    opacity: 0.5;
}

.add-to-cart-btn.loading .btn-loader,
.buy-now-btn.loading .btn-loader {
    display: inline-block !important;
}

.add-to-cart-btn.success,
.buy-now-btn.success {
    background: #10b981 !important;
    border-color: #10b981 !important;
    color: white !important;
}

.add-to-cart-btn.success i:first-child,
.buy-now-btn.success i:first-child {
    display: none;
}

.add-to-cart-btn.success::before,
.buy-now-btn.success::before {
    content: "\ef4f";
    font-family: 'IcoFont';
    margin-right: 8px;
    animation: successPop 0.5s ease;
}

@keyframes successPop {
    0% { transform: scale(0); }
    50% { transform: scale(1.3); }
    100% { transform: scale(1); }
}

.product-attributes .form-check-input:checked + label {
    background: #10b981 !important;
    color: white !important;
    border-color: #10b981 !important;
}

.product-attributes .form-check-label:hover {
    border-color: #10b981 !important;
    background: #f0fdf4 !important;
}

/* Desktop Layout - Keep original flex layout */
@media (min-width: 769px) {
    .product-purchase-section {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .quantity-wrapper {
        flex: 0 0 auto;
        margin-bottom: 0 !important;
    }

    .action-buttons {
        flex: 1 1 auto;
        flex-direction: row !important;
    }
}

@media (max-width: 768px) {
    .product-images {
        position: relative !important;
        top: 0 !important;
    }

    /* Share Section Responsive */
    .social-linkss .social-icons {
        justify-content: center !important;
        gap: 8px !important;
        flex-wrap: wrap !important;
        overflow-x: visible !important;
        -webkit-overflow-scrolling: touch !important;
        padding-bottom: 5px !important;
    }

    .social-linkss .social-icons::-webkit-scrollbar {
        height: 3px;
    }

    .social-linkss .social-icons::-webkit-scrollbar-thumb {
        background: #e5e7eb;
        border-radius: 10px;
    }

    .social-linkss .social-icons li {
        margin: 0 !important;
        flex-shrink: 0 !important;
    }

    .social-linkss .social-icons a {
        width: 42px !important;
        height: 42px !important;
        font-size: 16px !important;
    }

    /* Gallery spacing for mobile */
    .gallery-grid {
        display: flex !important;
        flex-direction: row !important;
        flex-wrap: wrap !important;
        gap: 6px !important;
    }

    .gallery-item {
        width: calc(33.333% - 4px);
        flex: 0 0 auto;
    }

    #gallery_09 img {
        height: 90px !important;
        width: 100% !important;
    }

    /* Ensure proper spacing */
    .summary.entry-summary {
        padding: 15px !important;
    }

    /* Mobile Quantity Selector - Light Gray Theme */
    .qty-selector {
        width: 100% !important;
        max-width: 100% !important;
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
        margin: 0 0 15px 0 !important;
        padding: 12px 20px !important;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08) !important;
        background: #f3f4f6 !important;
        border-radius: 12px !important;
        gap: 15px !important;
        border: 1px solid #e5e7eb !important;
    }

    .qty-selector .qtminus,
    .qty-selector .qtplus {
        width: 50px !important;
        height: 50px !important;
        font-size: 1.5rem !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        background: #ffffff !important;
        border: 2px solid #d1d5db !important;
        color: #374151 !important;
        border-radius: 10px !important;
        transition: all 0.2s ease !important;
        font-weight: 700 !important;
        flex-shrink: 0 !important;
    }

    .qty-selector .qtminus:active,
    .qty-selector .qtplus:active {
        background: #10b981 !important;
        color: white !important;
        border-color: #10b981 !important;
        transform: scale(0.95);
    }

    .qty-selector .qttotal {
        width: 70px !important;
        font-size: 1.4rem !important;
        font-weight: 700 !important;
        padding: 12px 10px !important;
        text-align: center !important;
        border: 2px solid #d1d5db !important;
        border-radius: 10px !important;
        background: #ffffff !important;
        color: #374151 !important;
        margin: 0 !important;
        flex-shrink: 0 !important;
    }

    /* Mobile Action Buttons - Full Width and Centered */
    .action-buttons {
        width: 100% !important;
        max-width: 100% !important;
        flex-direction: column !important;
        gap: 12px !important;
        margin-top: 15px !important;
        padding: 0 !important;
        display: flex !important;
    }

    /* Button container div - Full width on mobile */
    .product-purchase-section > div[style*="flex-direction: column"] {
        max-width: 100% !important;
        width: 100% !important;
    }

    .add-to-cart-btn,
    .buy-now-btn,
    .contact-seller-btn {
        width: 100% !important;
        max-width: 100% !important;
        flex: none !important;
        padding: 18px 20px !important;
        font-size: 1.1rem !important;
        min-height: 56px !important;
        border-radius: 12px !important;
        font-weight: 600 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 10px !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2) !important;
        transition: all 0.3s ease !important;
        margin: 0 !important;
    }

    .add-to-cart-btn i,
    .buy-now-btn i,
    .contact-seller-btn i {
        font-size: 1.3rem !important;
    }

    .add-to-cart-btn:active,
    .buy-now-btn:active,
    .contact-seller-btn:active {
        transform: scale(0.97);
    }

    /* Buy Now Button - Prominent */
    .buy-now-btn {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        border: none !important;
        color: #ffffff !important;
        box-shadow: 0 6px 16px rgba(16, 185, 129, 0.4) !important;
    }

    /* Add to Cart Button - Dark */
    .add-to-cart-btn {
        background: #1f2937 !important;
        border: 2px solid #374151 !important;
        color: #ffffff !important;
    }

    .add-to-cart-btn:hover {
        background: #374151 !important;
        border-color: #4b5563 !important;
    }

    /* Mobile-specific: Quantity FIRST, Buttons SECOND */
    .product-purchase-section {
        display: flex !important;
        flex-direction: column !important;
        flex-wrap: nowrap !important;
        gap: 15px !important;
        align-items: stretch !important;
        justify-content: flex-start !important;
        margin-bottom: 20px !important;
        width: 100% !important;
    }

    /* QUANTITY COMES FIRST ON MOBILE */
    .quantity-wrapper {
        order: 1 !important;
        flex: 0 0 auto !important;
        display: flex !important;
        justify-content: center !important;
        width: 100% !important;
        margin-bottom: 0 !important;
    }

    .qty-selector {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 8px !important;
        background: #f9fafb !important;
        padding: 6px 10px !important;
        border-radius: 10px !important;
        border: 2px solid #e5e7eb !important;
        margin: 0 auto !important;
        width: auto !important;
    }

    /* BUTTON WRAPPER COMES SECOND ON MOBILE - FULL WIDTH */
    .product-purchase-section > div:not(.quantity-wrapper):not(.share-section) {
        order: 2 !important;
        width: 100% !important;
        max-width: 100% !important;
        margin: 0 !important;
    }

    .action-buttons {
        display: flex !important;
        gap: 12px !important;
        flex: 1 1 auto !important;
        width: 100% !important;
        justify-content: center !important;
    }

    /* Product Info Section - Better Spacing */
    .summary.entry-summary {
        padding: 20px 15px !important;
    }

    .single-product-wrapper .col-md-6 {
        padding: 0 15px !important;
    }

    /* Professional Smooth Scrolling on Mobile */
    .product-images,
    .woocommerce-product-gallery,
    .mobile-zoom-wrapper {
        scroll-behavior: smooth !important;
        -webkit-overflow-scrolling: touch !important;
    }

    /* ===== MOBILE OPTIMIZATION - REDUCE SPACING & FONT SIZES ===== */
    
    /* Reduce top margin/padding between breadcrumb and product */
    .single-product-wrapper {
        padding-top: 10px !important;
        margin-top: 0 !important;
    }

    .container > .row {
        margin-top: 0 !important;
    }

    /* Reduce spacing in product info section */
    .summary.entry-summary {
        padding: 12px !important;
    }

    /* Smaller product title */
    .summary.entry-summary h1,
    .summary.entry-summary .product-title,
    .summary.entry-summary .product_title {
        font-size: 1rem !important;
        line-height: 1.4 !important;
        margin-bottom: 10px !important;
    }

    /* Reduce rating section size */
    .woocommerce-product-rating {
        margin-bottom: 8px !important;
    }

    .fancy-star-rating .rating-wrap {
        font-size: 0.5rem !important;
    }

    .fancy-rating {
        font-size: 0.55rem !important;
    }

    /* Smaller price section */
    .price-section {
        padding: 12px !important;
        margin-bottom: 12px !important;
    }

    .price-section .current-price {
        font-size: 1rem !important;
    }

    .price-section .old-price {
        font-size: 0.6rem !important;
    }

    .price-section .badge {
        font-size: 0.5rem !important;
        padding: 0.25rem 0.5rem !important;
    }

    /* PRODUCT DESCRIPTION - SMALLER FONTS & LESS SPACING */
    .product-description {
        padding: 10px !important;
        margin-bottom: 12px !important;
        font-size: 0.85rem !important;
        line-height: 1.5 !important;
    }

    .product-description p,
    .product-description div,
    .product-description span,
    .product-description li {
        font-size: 0.85rem !important;
        line-height: 1.5 !important;
        margin-bottom: 6px !important;
    }

    .product-description h1,
    .product-description h2,
    .product-description h3,
    .product-description h4,
    .product-description h5,
    .product-description h6 {
        font-size: 1rem !important;
        margin-bottom: 8px !important;
        margin-top: 8px !important;
    }

    .product-description strong,
    .product-description b {
        font-size: 0.85rem !important;
    }

    .product-description ul,
    .product-description ol {
        padding-left: 20px !important;
        margin-bottom: 8px !important;
    }

    /* Product Info Section - Smaller */
    .product-info-section {
        padding: 10px !important;
        margin-bottom: 12px !important;
    }

    .product-info-section h5 {
        font-size: 1rem !important;
        margin-bottom: 8px !important;
    }

    .product-info-section ul li {
        margin-bottom: 6px !important;
        font-size: 0.85rem !important;
    }

    .product-info-section i {
        font-size: 1rem !important;
    }

    /* Size/Color Selection - Smaller */
    .product-size h5,
    .product-color h5 {
        font-size: 1rem !important;
        margin-bottom: 8px !important;
    }

    .product-size,
    .product-color {
        margin-bottom: 12px !important;
    }

    .siz-list li .box,
    .color-list li .box {
        padding: 8px 12px !important;
        font-size: 0.85rem !important;
        min-width: 50px !important;
    }

    /* Reduce gallery spacing */
    .product-images .bg-light.rounded.shadow-sm {
        padding: 8px !important;
        margin-bottom: 8px !important;
    }

    #gallery_09 {
        margin-top: 8px !important;
    }

    /* Reduce button sizes slightly on mobile */
    .add-to-cart-btn,
    .buy-now-btn {
        padding: 12px 20px !important;
        font-size: 0.95rem !important;
        min-height: 48px !important;
    }

    /* Reduce share section spacing */
    .share-section {
        margin-top: 12px !important;
        padding-top: 12px !important;
    }

    .share-section h5 {
        font-size: 0.9rem !important;
        margin-bottom: 8px !important;
    }

    .social-linkss .social-icons a {
        width: 38px !important;
        height: 38px !important;
        font-size: 15px !important;
    }

    /* Remove excessive margins between sections */
    .mb-4 {
        margin-bottom: 12px !important;
    }

    .mb-3 {
        margin-bottom: 8px !important;
    }

    .mb-2 {
        margin-bottom: 6px !important;
    }

    .p-3 {
        padding: 10px !important;
    }

    /* Additional spacing reductions */
    .full-row.pb-0 {
        padding-top: 5px !important;
    }

    .container {
        padding-top: 0 !important;
    }

    .row.single-product-wrapper {
        margin-top: 0 !important;
    }

    .col-md-6.mb-4 {
        margin-bottom: 15px !important;
        padding: 0 10px !important;
    }

    /* Tighten up all vertical spacing on mobile */
    .product-images {
        margin-top: 0 !important;
        padding-top: 0 !important;
    }
}

/* Desktop Responsive Styles (768px and up) */
@media (min-width: 768px) {
    /* Make image column smaller (80% of original = 20% smaller) */
    .single-product-wrapper .col-md-6:first-child {
        flex: 0 0 40% !important;
        max-width: 40% !important;
    }

    .single-product-wrapper .col-md-6:last-child {
        flex: 0 0 60% !important;
        max-width: 60% !important;
    }

    /* Desktop: ALL 3 elements in ONE LINE (Quantity + Add to Cart + Buy Now) */
    .product-purchase-section {
        display: flex !important;
        flex-direction: row !important;
        align-items: center !important;
        justify-content: flex-start !important;
        gap: 15px !important;
        flex-wrap: nowrap !important;
        margin-bottom: 20px !important;
    }

    /* QUANTITY COMES FIRST on desktop */
    .quantity-wrapper {
        order: 1 !important;
        width: auto !important;
        flex: 0 0 auto !important;
        margin-bottom: 0 !important;
    }

    .qty-selector {
        padding: 10px 14px !important;
        gap: 12px !important;
        background: #ffffff !important;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08) !important;
        border-radius: 12px !important;
    }

    .qty-selector .qtminus,
    .qty-selector .qtplus {
        width: 44px !important;
        height: 44px !important;
        font-size: 1.2rem;
        border-radius: 10px;
        background: #f9fafb;
        border: 2px solid #e5e7eb;
        transition: all 0.2s ease;
        font-weight: 600;
    }

    .qty-selector .qtminus:hover,
    .qty-selector .qtplus:hover {
        background: #10b981;
        color: white;
        border-color: #10b981;
        transform: scale(1.05);
    }

    .qty-selector .qttotal {
        width: 80px !important;
        font-size: 1.15rem !important;
        font-weight: 700 !important;
        border: 2px solid #e5e7eb !important;
        border-radius: 8px !important;
    }

    /* BUTTONS COME SECOND - Both buttons in one line on desktop */
    .product-purchase-section > div[style*="flex-direction: column"] {
        order: 2 !important;
        display: flex !important;
        flex-direction: row !important;
        gap: 15px !important;
        width: auto !important;
        max-width: none !important;
        flex: 1 1 auto !important;
        margin: 0 !important;
    }

    .add-to-cart-btn,
    .buy-now-btn {
        flex: 1 1 0 !important;
        max-width: 220px !important;
        width: auto !important;
        padding: 16px 20px !important;
        font-size: 1rem !important;
        white-space: nowrap !important;
        border-radius: 12px !important;
        font-weight: 600 !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
        transition: all 0.3s ease !important;
        height: auto !important;
    }

    .add-to-cart-btn:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2) !important;
    }

    /* Buy Now button - White text on hover */
    .buy-now-btn:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 8px 24px rgba(16, 185, 129, 0.5) !important;
        color: #ffffff !important;
        background: linear-gradient(135deg, #059669 0%, #047857 100%) !important;
    }

    /* Share Section Desktop - New Row */
    .share-section {
        order: 3;
        text-align: center !important;
        width: 100%;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #e5e7eb;
    }

    .share-section h5 {
        text-align: center !important;
        margin-bottom: 12px !important;
    }

    .social-linkss .social-icons {
        justify-content: center !important;
        flex-wrap: nowrap !important;
        gap: 12px !important;
        overflow-x: visible !important;
    }

    /* Gallery Grid - Horizontal Row */
    .gallery-grid {
        display: flex !important;
        flex-direction: row !important;
        flex-wrap: wrap !important;
        grid-template-columns: none !important;
        gap: 10px !important;
    }

    .gallery-item {
        flex: 0 0 auto;
        width: 110px;
    }

    #gallery_09 img {
        height: 110px !important;
        width: 110px !important;
    }

    /* Professional Smooth Scrolling on Desktop */
    .product-images,
    .woocommerce-product-gallery,
    .mobile-zoom-wrapper {
        scroll-behavior: smooth !important;
    }
}

/* Large Desktop (1200px and up) */
@media (min-width: 1200px) {
    .product-purchase-section {
        gap: 25px;
    }

    .qty-selector {
        padding: 10px 15px;
        gap: 12px;
    }

    .qty-selector .qtminus,
    .qty-selector .qtplus {
        width: 44px;
        height: 44px;
    }

    .qty-selector .qttotal {
        width: 80px;
        font-size: 1.15rem;
    }

    .action-buttons {
        gap: 18px;
    }

    .add-to-cart-btn,
    .buy-now-btn {
        max-width: 240px;
        padding: 16px 24px;
        font-size: 1.05rem;
    }

    /* Gallery Grid - Larger on big screens */
    .gallery-item {
        width: 120px;
    }

    #gallery_09 img {
        height: 120px !important;
        width: 120px !important;
    }

    .social-linkss .social-icons {
        gap: 14px !important;
    }
}
</style>

<div class="full-row pb-0" style="padding-top: 0; margin-top: 0; scroll-behavior: smooth;">
  <div class="container" style="padding-top: 0; scroll-behavior: smooth;">
      <div class="row single-product-wrapper" style="margin-top: 0; scroll-behavior: smooth;">
          <div class="col-md-6 mb-4">
              <div class="product-images position-relative" style="top: 0; padding-top: 0; margin-top: 0; scroll-behavior: smooth; -webkit-overflow-scrolling: touch;">
                  <div class="woocommerce-product-gallery woocommerce-product-gallery--with-images woocommerce-product-gallery--columns-4 images" data-columns="4" style="scroll-behavior: smooth;">
                      <figure class="woocommerce-product-gallery__wrapper" style="margin: 0; scroll-behavior: smooth;">
                          <div class="mobile-zoom-wrapper" style="position: relative; background: transparent; padding: 0; border: none; scroll-behavior: smooth; -webkit-overflow-scrolling: touch;">
                              <img id="single-image-zoom" src="{{filter_var($productt->photo, FILTER_VALIDATE_URL) ?$productt->photo:asset('assets/images/products/'.$productt->photo)}}" alt="Product Image" data-zoom-image="{{filter_var($productt->photo, FILTER_VALIDATE_URL) ?$productt->photo:asset('assets/images/products/'.$productt->photo)}}" style="width: 100%; height: auto; display: block; border: none; box-shadow: none;" />

                              {{-- Mobile Zoom Control Buttons --}}
                              <div class="mobile-zoom-controls d-md-none">
                                  <button type="button" class="zoom-btn" id="zoom-in-btn" title="Zoom In">+</button>
                                  <button type="button" class="zoom-btn" id="zoom-out-btn" title="Zoom Out">−</button>
                              </div>

                              {{-- Desktop Zoom Hint --}}
                              <div class="zoom-hint d-none d-md-flex">
                                  <i class="fas fa-search-plus"></i>
                                  <span>Hover to zoom</span>
                              </div>
                          </div>

                          <div id="gallery_09" class="product-slide-thumb">
                              <div class="gallery-grid" style="display: flex; flex-direction: row; flex-wrap: wrap; gap: 8px; margin-top: 0;">
                                  {{-- Main Product Image --}}
                                  <div class="gallery-item">
                                      <a class="active" href="{{filter_var($productt->photo, FILTER_VALIDATE_URL) ?$productt->photo:asset('assets/images/products/'.$productt->photo)}}" data-image="{{filter_var($productt->photo, FILTER_VALIDATE_URL) ?$productt->photo:asset('assets/images/products/'.$productt->photo)}}" data-zoom-image="{{filter_var($productt->photo, FILTER_VALIDATE_URL) ?$productt->photo:asset('assets/images/products/'.$productt->photo)}}">
                                          <img src="{{filter_var($productt->photo, FILTER_VALIDATE_URL) ?$productt->photo:asset('assets/images/products/'.$productt->photo)}}" alt="Main Product Image" />
                                      </a>
                                  </div>
                                  {{-- Gallery Images --}}
                                  @foreach($productt->galleries as $gal)
                                  <div class="gallery-item">
                                      <a href="{{asset('assets/images/galleries/'.$gal->photo)}}" data-image="{{asset('assets/images/galleries/'.$gal->photo)}}" data-zoom-image="{{asset('assets/images/galleries/'.$gal->photo)}}">
                                          <img src="{{asset('assets/images/galleries/'.$gal->photo)}}" alt="Gallery Image" />
                                      </a>
                                  </div>
                                  @endforeach
                              </div>
                          </div>
                      </figure>
                  </div>

                  {{-- Simple Mobile Image Viewer --}}
                  <div class="mobile-image-viewer" id="mobileImageViewer">
                      <button class="mobile-viewer-close" id="closeViewer">&times;</button>
                      <img id="viewerImage" src="" alt="Product Image" />
                  </div>
              </div>

              <script>
              // PROFESSIONAL BUTTON + DOUBLE-TAP ZOOM - 100% Scroll Freedom
              (function() {
                  // Only on mobile devices
                  if (window.innerWidth > 767) return;

                  const wrapper = document.querySelector('.mobile-zoom-wrapper');
                  const mainImage = document.getElementById('single-image-zoom');
                  const zoomInBtn = document.getElementById('zoom-in-btn');
                  const zoomOutBtn = document.getElementById('zoom-out-btn');

                  if (!wrapper || !mainImage || !zoomInBtn || !zoomOutBtn) return;

                  // Zoom state
                  let scale = 1;
                  let posX = 0;
                  let posY = 0;
                  let isPanning = false;
                  let lastTouchX = 0;
                  let lastTouchY = 0;
                  let touchHandlersAttached = false;

                  const minScale = 1;
                  const maxScale = 4;
                  const zoomStep = 0.5;

                  // Double tap detection
                  let lastTapTime = 0;
                  let lastTapX = 0;
                  let lastTapY = 0;
                  const doubleTapDelay = 300; // milliseconds
                  const doubleTapDistance = 50; // pixels

                  // Touch handlers
                  function handleTouchStart(e) {
                      if (e.touches.length === 1) {
                          // Only pan if already zoomed
                          if (scale > 1) {
                              e.preventDefault();
                              e.stopPropagation();
                              isPanning = true;
                              lastTouchX = e.touches[0].clientX;
                              lastTouchY = e.touches[0].clientY;
                          }
                      }
                  }

                  function handleTouchMove(e) {
                      if (scale <= 1 || !isPanning) return;

                      if (e.touches.length === 1) {
                          e.preventDefault();
                          e.stopPropagation();

                          const deltaX = e.touches[0].clientX - lastTouchX;
                          const deltaY = e.touches[0].clientY - lastTouchY;

                          posX += deltaX;
                          posY += deltaY;

                          lastTouchX = e.touches[0].clientX;
                          lastTouchY = e.touches[0].clientY;

                          constrainPosition();
                          updateTransform(false);
                      }
                  }

                  function handleTouchEnd(e) {
                      isPanning = false;

                      // Double tap detection - only if single touch
                      if (e.changedTouches.length === 1) {
                          const now = Date.now();
                          const touchX = e.changedTouches[0].clientX;
                          const touchY = e.changedTouches[0].clientY;

                          const timeSinceLastTap = now - lastTapTime;
                          const distanceFromLastTap = Math.sqrt(
                              Math.pow(touchX - lastTapX, 2) + Math.pow(touchY - lastTapY, 2)
                          );

                          // Check if it's a double tap
                          if (timeSinceLastTap < doubleTapDelay && timeSinceLastTap > 0 && distanceFromLastTap < doubleTapDistance) {
                              e.preventDefault();
                              e.stopPropagation();

                              if (scale === 1) {
                                  // NOT zoomed - zoom in to 2x centered on tap
                                  scale = 2;
                                  posX = 0;
                                  posY = 0;
                                  constrainPosition();
                                  updateTransform(true);
                              } else {
                                  // Already zoomed - zoom out completely
                                  scale = 1;
                                  posX = 0;
                                  posY = 0;
                                  updateTransform(true);
                              }

                              // Reset double tap detection
                              lastTapTime = 0;
                              lastTapX = 0;
                              lastTapY = 0;
                          } else {
                              // Single tap - record for double tap detection
                              lastTapTime = now;
                              lastTapX = touchX;
                              lastTapY = touchY;
                          }
                      }
                  }

                  // Attach touch listeners - ALWAYS attached for double tap
                  function attachTouchListeners() {
                      if (touchHandlersAttached) return;
                      mainImage.addEventListener('touchstart', handleTouchStart, { passive: false });
                      mainImage.addEventListener('touchmove', handleTouchMove, { passive: false });
                      mainImage.addEventListener('touchend', handleTouchEnd, { passive: false });
                      mainImage.addEventListener('touchcancel', handleTouchEnd, { passive: false });
                      touchHandlersAttached = true;
                  }

                  // Update image transform
                  function updateTransform(animate = false) {
                      mainImage.style.transition = animate ? 'transform 0.3s ease' : 'none';
                      mainImage.style.transform = `translate(${posX}px, ${posY}px) scale(${scale})`;

                      if (scale > 1) {
                          mainImage.classList.add('zoomed');
                          mainImage.style.pointerEvents = 'auto';
                          wrapper.style.overflow = 'hidden';
                      } else {
                          mainImage.classList.remove('zoomed');
                          mainImage.style.pointerEvents = 'none';
                          wrapper.style.overflow = 'visible';
                      }

                      updateButtonStates();
                  }

                  // Update button states
                  function updateButtonStates() {
                      zoomInBtn.disabled = scale >= maxScale;
                      zoomOutBtn.disabled = scale <= minScale;
                  }

                  // Constrain position to prevent image from going out of bounds
                  function constrainPosition() {
                      if (scale <= 1) {
                          posX = 0;
                          posY = 0;
                          return;
                      }

                      const rect = mainImage.getBoundingClientRect();
                      const wrapperRect = wrapper.getBoundingClientRect();

                      const scaledWidth = rect.width;
                      const scaledHeight = rect.height;

                      const maxX = Math.max(0, (scaledWidth * scale - wrapperRect.width) / 2);
                      const maxY = Math.max(0, (scaledHeight * scale - wrapperRect.height) / 2);

                      posX = Math.max(-maxX, Math.min(maxX, posX));
                      posY = Math.max(-maxY, Math.min(maxY, posY));
                  }

                  // Zoom In Button - ONLY way to activate zoom
                  zoomInBtn.addEventListener('click', function(e) {
                      e.preventDefault();
                      e.stopPropagation();

                      if (scale < maxScale) {
                          scale = Math.min(maxScale, scale + zoomStep);
                          constrainPosition();
                          updateTransform(true);
                      }
                  });

                  // Zoom Out Button - Can disable zoom completely
                  zoomOutBtn.addEventListener('click', function(e) {
                      e.preventDefault();
                      e.stopPropagation();

                      if (scale > minScale) {
                          scale = Math.max(minScale, scale - zoomStep);

                          if (scale === 1) {
                              posX = 0;
                              posY = 0;
                          }

                          constrainPosition();
                          updateTransform(true);
                      }
                  });

                  // Thumbnail click handler - reset zoom
                  document.querySelectorAll('#gallery_09 a').forEach(function(thumb) {
                      thumb.addEventListener('click', function(e) {
                          e.preventDefault();
                          const newImage = this.getAttribute('data-image');
                          if (mainImage && newImage) {
                              mainImage.src = newImage;
                              mainImage.setAttribute('data-zoom-image', this.getAttribute('data-zoom-image'));

                              // Reset zoom
                              scale = 1;
                              posX = 0;
                              posY = 0;
                              isPanning = false;
                              updateTransform(true);
                          }
                      });
                  });

                  // Initialize - attach touch listeners immediately for double tap
                  attachTouchListeners();
                  updateButtonStates();
              })();
              </script>
          </div>

          <div class="col-md-6">
              <div class="summary entry-summary">
                  <div class="summary-inner">

                      <h1 class="product_title entry-title mb-3" style="font-size: 1.2rem; font-weight: 700; color: #2d3748; {{ isset($langg) && $langg->rtl == 1 ? 'direction: rtl; text-align: right;' : '' }}">{{ $productt->translated_name }}</h1>                      {{-- Rating Section - Only show if ratings exist --}}
                      @php
                          $ratingCount = App\Models\Rating::ratingCount($productt->id);
                          $ratingValue = App\Models\Rating::ratings($productt->id);
                      @endphp
                      @if($ratingCount > 0)
                      <div class="d-flex align-items-center mb-3 flex-wrap gap-3">
                          <div class="woocommerce-product-rating">
                              <div class="fancy-star-rating">
                                  <div class="rating-wrap d-flex align-items-center">
                                      <span class="fancy-rating good me-2" style="font-size: 0.66rem; color: #f59e0b;">{{ $ratingValue }} ★</span>
                                      <span class="text-muted" style="font-size: 0.54rem;">({{ $ratingCount }} {{ __('ratings') }})</span>
                                  </div>
                              </div>
                          </div>
                      </div>
                      @endif

                      <div class="price-section mb-4 p-3 bg-light rounded shadow-sm">
                          <div class="d-flex align-items-center flex-wrap gap-2">
                              <span class="current-price" style="font-size: 1.2rem; font-weight: 700; color: #10b981;">
                                  <span id="sizeprice">{{ $productt->showPrice() }}</span>
                              </span>
                              @if($productt->showPreviousPrice())
                              <del class="old-price" style="font-size: 0.72rem; color: #9ca3af;">{{ $productt->showPreviousPrice() }}</del>
                              @endif
                              @if($productt->offPercentage())
                              <span class="badge bg-danger" style="font-size: 0.6rem; padding: 0.3rem 0.6rem;">{{ round((float)$productt->offPercentage() )}}% OFF</span>
                              @endif
                          </div>
                      </div>

                      {{-- Product Description - No heading --}}
                      <div class="product-description mb-4 p-3 border rounded" style="background: #f9fafb;">
                          <div style="line-height: 1.8; color: #6b7280;">
                              {!! clean($productt->translated_description , array('Attr.EnableID' => true)) !!}
                          </div>
                      </div>

                      <div class="pro-details">
                         {{-- PRODUCT DETAILS SECTION --}}
                         @if($productt->ship != null || ($productt->type == 'License' && ($productt->platform != null || $productt->region != null || $productt->licence_type != null)))
                         <div class="product-info-section mb-4 p-3 border rounded" style="background: #ffffff;">
                            <h5 class="mb-3" style="font-weight: 600; color: #374151;">{{ __('Product Information') }}</h5>
                            <ul class="list-unstyled mb-0">
                               @if($productt->ship != null)
                               <li class="mb-2 d-flex align-items-start">
                                   <i class="icofont-truck-loaded me-2" style="color: #10b981; font-size: 1.2rem;"></i>
                                   <div>
                                       <span class="fw-semibold" style="color: #374151;">{{ __('Shipping Time:') }}</span>
                                       <span style="color: #6b7280;">{{ $productt->ship }}</span>
                                   </div>
                               </li>
                               @endif
                               {{-- PRODUCT LICENSE SECTION --}}
                               @if($productt->type == 'License')
                                   @if($productt->platform != null)
                                   <li class="mb-2 d-flex align-items-start">
                                       <i class="icofont-laptop me-2" style="color: #10b981; font-size: 1.2rem;"></i>
                                       <div>
                                           <span class="fw-semibold" style="color: #374151;">{{ __('Platform:') }}</span>
                                           <span style="color: #6b7280;">{{ $productt->platform }}</span>
                                       </div>
                                   </li>
                                   @endif
                                   @if($productt->region != null)
                                   <li class="mb-2 d-flex align-items-start">
                                       <i class="icofont-location-pin me-2" style="color: #10b981; font-size: 1.2rem;"></i>
                                       <div>
                                           <span class="fw-semibold" style="color: #374151;">{{ __('Region:') }}</span>
                                           <span style="color: #6b7280;">{{ $productt->region }}</span>
                                       </div>
                                   </li>
                                   @endif
                                   @if($productt->licence_type != null)
                                   <li class="mb-2 d-flex align-items-start">
                                       <i class="icofont-certificate me-2" style="color: #10b981; font-size: 1.2rem;"></i>
                                       <div>
                                           <span class="fw-semibold" style="color: #374151;">{{ __('License Type:') }}</span>
                                           <span style="color: #6b7280;">{{ $productt->licence_type }}</span>
                                       </div>
                                   </li>
                                   @endif
                               @endif
                               {{-- PRODUCT LICENSE SECTION ENDS--}}
                            </ul>
                         </div>
                         @endif
                         {{-- PRODUCT DETAILS SECTION ENDS --}}

                         @if ($productt->stock_check == 1)
                              @if(!empty($productt->size))
                              <div class="product-size mb-4">
                                  <h5 class="mb-3" style="font-weight: 600; color: #374151;">{{ __('Select Size') }}</h5>
                                  <ul class="siz-list d-flex flex-wrap gap-2 list-unstyled">
                                    @foreach(array_unique($productt->size) as $key => $data1)
                                  <li class="{{ $loop->first ? 'active' : '' }}" data-key="{{ str_replace(' ','',$data1) }}" style="cursor: pointer;">
                                        <span class="box px-4 py-2 border rounded d-inline-block" style="transition: all 0.3s ease; min-width: 60px; text-align: center;">
                                          {{ $data1 }}
                                        </span>
                                      </li>
                                    @endforeach
                                  </ul>
                                </div>
                         @endif
                         {{-- PRODUCT COLOR SECTION  --}}

    @if(!empty($productt->color))

      <div class="product-color mb-4">
          <h5 class="mb-3" style="font-weight: 600; color: #374151;">{{ __('Select Color') }}</h5>
          <ul class="color-list d-flex flex-wrap gap-2 list-unstyled">
            @foreach($productt->color as $key => $data1)
              <li class="{{ $loop->first ? 'active' : '' }} {{ $productt->IsSizeColor($productt->size[$key]) ? str_replace(' ','',$productt->size[$key]) : ''  }} {{ $productt->size[$key] == $productt->size[0] ? 'show-colors' : '' }}" style="cursor: pointer;">
                <span class="box border rounded d-inline-block" data-color="{{ $productt->color[$key] }}" style="background-color: {{ $productt->color[$key] }}; width: 45px; height: 45px; transition: all 0.3s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">

                  <input type="hidden" class="size" value="{{ $productt->size[$key] }}">
                  <input type="hidden" class="size_qty" value="{{ $productt->size_qty[$key] }}">
                  <input type="hidden" class="size_key" value="{{$key}}">
                  <input type="hidden" class="size_price" value="{{ round((float)($productt->size_price[$key] ?? 0) * $curr->value,2) }}">

                </span>
              </li>
            @endforeach
          </ul>
       </div>

    @endif

      {{-- PRODUCT COLOR SECTION ENDS  --}}
      @else
      @if(!empty($productt->size_all))
      <div class="product-size mb-4" data-key="false">
       <h5 class="mb-3" style="font-weight: 600; color: #374151;">{{ __('Select Size') }}</h5>
       <ul class="siz-list d-flex flex-wrap gap-2 list-unstyled">
             @foreach(array_unique(explode(',',$productt->size_all)) as $key => $data1)
             <li class="{{ $loop->first ? 'active' : '' }}" data-key="{{ str_replace(' ','',$data1) }}" style="cursor: pointer;">
                <span class="box px-4 py-2 border rounded d-inline-block" style="transition: all 0.3s ease; min-width: 60px; text-align: center;">
                {{ $data1 }}
                <input type="hidden" class="size" value="{{$data1}}">
                <input type="hidden" class="size_key" value="{{$key}}">
                </span>
             </li>
             @endforeach
       </ul>
      </div>
      @endif
      @if(!empty($productt->color_all))
       <div class="product-color mb-4" data-key="false">
       <h5 class="mb-3" style="font-weight: 600; color: #374151;">{{ __('Select Color') }}</h5>
          <ul class="color-list d-flex flex-wrap gap-2 list-unstyled">

                @foreach(explode(',',$productt->color_all) as $key => $color1)

                <li class="{{ $loop->first ? 'active' : '' }} show-colors" style="cursor: pointer;">
                   <span class="box border rounded d-inline-block" data-color="{{ $color1 }}" style="background-color: {{ $color1 }}; width: 45px; height: 45px; transition: all 0.3s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                   <input type="hidden" class="size_price" value="0">
                   </span>
                </li>
                @endforeach
          </ul>
       </div>
       @endif
  @endif
              <input type="hidden" id="product_price" value="{{ round((float)$productt->vendorPrice() * $curr->value,2) }}">
              <input type="hidden" id="product_id" value="{{ $productt->id }}">
              <input type="hidden" id="curr_pos" value="{{ $gs->currency_format }}">
              <input type="hidden" id="curr_sign" value="{{ $curr->sign }}">
                  {{-- PRODUCT STOCK CONDITION SECTION  --}}

      @if(!empty($productt->size))
      <input type="hidden" id="stock" value="{{ $productt->size_qty[0] }}">
      @else
      @if(!$productt->emptyStock())
        <input type="hidden" id="stock" value="{{ $productt->stock }}">
      @elseif($productt->type != 'Physical')
        <input type="hidden" id="stock" value="0">
      @else
        <input type="hidden" id="stock" value="">
      @endif
    @endif

    @if($productt->is_discount==1 && $productt->discount_date >= date('Y-m-d') && $productt->user->is_vendor==2)
    <div class="time-count time-box text-center my-30 flex-between w-75" data-countdown="{{ $productt['discount_date']}}"></div>

    @endif
    {{-- PRODUCT STOCK CONDITION SECTION ENDS --}}
                         <div class="product-purchase-section mt-4" style="display: flex; flex-wrap: wrap; gap: 12px; align-items: center; justify-content: center; margin-bottom: 20px;">

                          {{-- QUANTITY SELECTOR FIRST (BEFORE BUTTONS) --}}
                          @if($productt->product_type != "affiliate" && $productt->type == 'Physical')
                               <div class="quantity-wrapper" style="order: 1; display: flex; justify-content: center; width: 100%; margin-bottom: 15px;">
                                   <div class="qty-selector border rounded d-flex align-items-center justify-content-center" style="background: #ffffff; box-shadow: 0 4px 16px rgba(0,0,0,0.1); padding: 10px 16px; gap: 12px; border-radius: 14px; border: 2px solid #e5e7eb; height: 58px; min-width: 180px;">
                                      <button type="button" class="qtminus btn btn-light border-0" style="font-size: 1.2rem; width: 42px; height: 42px; border-radius: 10px; background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%); border: 2px solid #e5e7eb !important; font-weight: 700; display: flex; align-items: center; justify-content: center; padding: 0; transition: all 0.2s ease; color: #374151; box-shadow: 0 2px 6px rgba(0,0,0,0.08);">
                                         <i class="icofont-minus"></i>
                                      </button>
                                      <input class="qttotal form-control border-0 text-center" type="text" id="order-qty" value="{{ $productt->minimum_qty == null ? '1' : (int)$productt->minimum_qty }}" style="width: 70px; font-weight: 800; font-size: 1.2rem; border: 2px solid #e5e7eb !important; border-radius: 10px; padding: 10px 8px; background: #fafafa; color: #1f2937; box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);">
                                      <input type="hidden" id="affilate_user" value="{{ $affilate_user }}">
                                      <input type="hidden" id="product_minimum_qty" value="{{ $productt->minimum_qty == null ? '0' : $productt->minimum_qty }}">
                                      <button type="button" class="qtplus btn btn-light border-0" style="font-size: 1.2rem; width: 42px; height: 42px; border-radius: 10px; background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%); border: 2px solid #e5e7eb !important; font-weight: 700; display: flex; align-items: center; justify-content: center; padding: 0; transition: all 0.2s ease; color: #374151; box-shadow: 0 2px 6px rgba(0,0,0,0.08);">
                                         <i class="icofont-plus"></i>
                                      </button>
                                   </div>
                               </div>
                          @endif

                          {{-- ACTION BUTTONS COME AFTER QUANTITY --}}
                          @if($productt->product_type == "affiliate")

                              <a href="javascript:;" class="btn btn-primary affilate-btn add-to-cart-btn" data-href="{{ $productt->affiliate_link }}" target="_blank" style="order: 2; margin: 0 auto;">
                                  <i class="icofont-cart me-2"></i>
                                  <span>{{ __('Buy Now') }}</span>
                              </a>
                              @else
                              @if($productt->emptyStock())
                              <a href="javascript:;" class="btn btn-secondary cart-out-of-stock add-to-cart-btn" style="cursor: not-allowed; width: 100%; max-width: 400px; padding: 16px 24px; font-size: 1.05rem; height: 58px; border-radius: 14px; font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); order: 2; margin: 0 auto;">
                                  <i class="icofont-close-line me-2"></i>
                                  <span>{{ __('Out Of Stock') }}</span>
                              </a>
                              @else
                              @if ($productt->type != "Listing")
                                <div style="display: flex; flex-direction: column; gap: 12px; width: 100%; max-width: 400px; margin: 0 auto;">
                                <button type="button" id="addcrt" class="btn btn-outline-primary add-to-cart-btn" 
                                        data-product-id="{{ $productt->id }}"
                                        data-product-name="{{ $productt->name }}"
                                        data-product-price="{{ $productt->price }}"
                                        style="order: 2; width: 100%; padding: 18px 24px; font-size: 1.1rem; height: 58px; border-radius: 14px; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 10px; box-shadow: 0 6px 20px rgba(16, 185, 129, 0.35); background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important; border: none !important; color: #ffffff !important; transition: all 0.3s ease; text-transform: uppercase; letter-spacing: 0.5px;">
                                    <i class="icofont-cart" style="color: #ffffff !important; font-size: 1.3rem;"></i>
                                    <span style="color: #ffffff !important;">{{ __('Add to Cart')}}</span>
                                    <span class="btn-loader" style="display: none;">
                                        <i class="icofont-spinner icofont-spin"></i>
                                    </span>
                                </button>

                                <button type="button" id="qaddcrt" class="btn btn-primary buy-now-btn" style="order: 3; width: 100%; padding: 18px 24px; font-size: 1.1rem; height: 58px; border-radius: 14px; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 10px; box-shadow: 0 6px 20px rgba(31, 41, 55, 0.3); background: linear-gradient(135deg, #1f2937 0%, #111827 100%) !important; border: 2px solid #374151 !important; color: #ffffff !important; transition: all 0.3s ease; text-transform: uppercase; letter-spacing: 0.5px;">
                                    <i class="icofont-check-circled" style="color: #ffffff !important; font-size: 1.3rem;"></i>
                                    <span style="color: #ffffff !important;">{{ __('Buy Now') }}</span>
                                    <span class="btn-loader" style="display: none;">
                                        <i class="icofont-spinner icofont-spin"></i>
                                    </span>
                                </button>
                                </div>
                              @endif

                              @if ($productt->type == "Listing")
                                  @if (auth()->check())
                                    @if($productt->user_id != 0)
                                      <a class="btn btn-success contact-seller-btn flex-grow-1" href="javascript:;" data-bs-toggle="modal" data-bs-target="#vendorform">
                                          <i class="icofont-ui-chat me-2"></i>
                                          <span>{{ __('Contact Seller') }}</span>
                                      </a>
                                    @else
                                      <a class="btn btn-success contact-seller-btn flex-grow-1" href="javascript:;" data-bs-toggle="modal" data-bs-target="#sendMessage">
                                          <i class="icofont-ui-chat me-2"></i>
                                          <span>{{ __('Contact Seller') }}</span>
                                      </a>
                                    @endif
                                  @else
                                    <a class="btn btn-success contact-seller-btn flex-grow-1" href="{{ route('user.login') }}">
                                        <i class="icofont-ui-chat me-2"></i>
                                        <span>{{ __('Contact Seller') }}</span>
                                    </a>
                                  @endif
                              @endif

                              @endif
                          </div>
                         @endif

                          {{-- Share This Product Section - Compact Version --}}
                          <div class="share-section" style="width: 100%; text-align: center; margin-top: 20px; padding: 15px; border-top: 1px solid #e5e7eb; background: linear-gradient(135deg, #f9fafb 0%, #ffffff 100%); border-radius: 12px;">
                              <h5 class="mb-3" style="font-weight: 600; color: #1f2937; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px; text-align: center;">{{ __('Share This Product') }}</h5>
                              <div class="social-linkss social-sharing a2a_kit a2a_kit_size_32">
                              <ul class="social-icons d-flex flex-wrap gap-2 list-unstyled mb-0" style="display: flex; flex-wrap: wrap; gap: 12px; align-items: center; justify-content: center; padding: 0;">
                                  <li style="flex-shrink: 0;">
                                  <a class="facebook a2a_button_facebook d-flex align-items-center justify-content-center" href="" style="width: 32px; height: 32px; background: transparent; color: #1877f2; transition: all 0.3s ease; flex-shrink: 0; display: flex; align-items: center; justify-content: center;">
                                      <i class="fab fa-facebook-f" style="font-size: 20px;"></i>
                                  </a>
                                  </li>
                                  <li style="flex-shrink: 0;">
                                  <a class="twitter a2a_button_twitter d-flex align-items-center justify-content-center" href="" style="width: 32px; height: 32px; background: transparent; color: #1da1f2; transition: all 0.3s ease; flex-shrink: 0; display: flex; align-items: center; justify-content: center;">
                                      <i class="fab fa-twitter" style="font-size: 20px;"></i>
                                  </a>
                                  </li>
                                  <li style="flex-shrink: 0;">
                                  <a class="linkedin a2a_button_linkedin d-flex align-items-center justify-content-center" href="" style="width: 32px; height: 32px; background: transparent; color: #0077b5; transition: all 0.3s ease; flex-shrink: 0; display: flex; align-items: center; justify-content: center;">
                                      <i class="fab fa-linkedin-in" style="font-size: 20px;"></i>
                                  </a>
                                  </li>
                                  <li style="flex-shrink: 0;">
                                  <a class="pinterest a2a_button_pinterest d-flex align-items-center justify-content-center" href="" style="width: 32px; height: 32px; background: transparent; color: #e60023; transition: all 0.3s ease; flex-shrink: 0; display: flex; align-items: center; justify-content: center;">
                                      <i class="fab fa-pinterest-p" style="font-size: 20px;"></i>
                                  </a>
                                  </li>
                                  <li style="flex-shrink: 0;">
                                      <a class="instagram a2a_button_whatsapp d-flex align-items-center justify-content-center" href="" style="width: 32px; height: 32px; background: transparent; color: #25d366; transition: all 0.3s ease; flex-shrink: 0; display: flex; align-items: center; justify-content: center;">
                                      <i class="fab fa-whatsapp" style="font-size: 20px;"></i>
                                      </a>
                                  </li>
                              </ul>
                              </div>
                          </div>
                          <style>
                              /* Hover Effects for Share Buttons - Simple Square Icons */
                              .social-icons a:hover {
                                  transform: scale(1.2);
                                  opacity: 0.8;
                              }

                              .facebook:hover {
                                  background: linear-gradient(135deg, #0c5fcd 0%, #1877f2 100%) !important;
                              }

                              .twitter:hover {
                                  background: linear-gradient(135deg, #0d8bd9 0%, #1da1f2 100%) !important;
                              }

                              .linkedin:hover {
                                  background: linear-gradient(135deg, #005885 0%, #0077b5 100%) !important;
                              }

                              .pinterest:hover {
                                  background: linear-gradient(135deg, #bd001c 0%, #e60023 100%) !important;
                              }

                              .instagram:hover,
                              a.a2a_button_whatsapp:hover {
                                  background: linear-gradient(135deg, #1ebe57 0%, #25d366 100%) !important;
                              }

                              /* Quantity Buttons Hover Effects */
                              .qtminus:hover,
                              .qtplus:hover {
                                  background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
                                  color: white !important;
                                  border-color: #10b981 !important;
                                  transform: scale(1.05);
                              }

                              /* Add to Cart Button Hover */
                              #addcrt:hover {
                                  transform: translateY(-2px);
                                  box-shadow: 0 10px 30px rgba(16, 185, 129, 0.5) !important;
                                  background: linear-gradient(135deg, #059669 0%, #10b981 100%) !important;
                              }

                              /* Buy Now Button Hover */
                              #qaddcrt:hover {
                                  transform: translateY(-2px);
                                  box-shadow: 0 10px 30px rgba(31, 41, 55, 0.5) !important;
                                  background: linear-gradient(135deg, #111827 0%, #1f2937 100%) !important;
                              }
                          </style>
                          <script async src="https://static.addtoany.com/menu/page.js"></script>
                   </div>

                          @if (!empty($productt->attributes))
                      @php
                        $attrArr = json_decode($productt->attributes, true);
                      @endphp
                    @endif
                    @if (!empty($attrArr))
                      <div class="product-attributes my-4 p-4 border rounded" style="background: #ffffff;">
                        <h5 class="mb-4" style="font-weight: 600; color: #374151;">{{ __('Additional Options') }}</h5>
                        <div class="row gy-4">
                        @foreach ($attrArr as $attrKey => $attrVal)
                          @if (array_key_exists("details_status",$attrVal) && $attrVal['details_status'] == 1)

                        <div class="col-lg-12">
                            <div class="form-group">
                              <strong class="text-capitalize mb-3 d-block" style="color: #374151; font-size: 1rem;">{{ str_replace("_", " ", $attrKey) }}</strong>
                              <div class="d-flex flex-wrap gap-2">
                              @foreach ($attrVal['values'] as $optionKey => $optionVal)
                                <div class="custom-control custom-radio form-check">
                                  <input type="hidden" class="keys" value="">
                                  <input type="hidden" class="values" value="">
                                  <input type="radio" id="{{$attrKey}}{{ $optionKey }}" name="{{ $attrKey }}" class="form-check-input custom-control-input product-attr"  data-key="{{ $attrKey }}" data-price = "{{ $attrVal['prices'][$optionKey] * $curr->value }}" value="{{ $optionVal }}" {{ $loop->first ? 'checked' : '' }}>
                                  <label class="form-check-label px-3 py-2 border rounded" for="{{$attrKey}}{{ $optionKey }}" style="cursor: pointer; transition: all 0.3s ease; min-width: 80px; text-align: center;">{{ $optionVal }}

                                  @if (!empty($attrVal['prices'][$optionKey]))
                                    +
                                    {{$curr->sign}} {{$attrVal['prices'][$optionKey] * $curr->value}}
                                  @endif
                                  </label>
                                </div>
                              @endforeach
                              </div>
                            </div>
                        </div>
                          @endif
                        @endforeach
                        </div>
                      </div>
                    @endif

                  </div>
              </div>
          </div>
          <div class="col-lg-3 col-md-4">
             {{-- Seller Card Removed --}}
             @if(!empty($productt->whole_sell_qty))
             <div class="pro-summary mb-4">
                <div class="price-summary">
                   <div class="price-summary-content">
                      <h5 class="text-center">{{ __('Wholesell') }}</h5>
                      <ul class="price-summary-list">
                            <li class="regular-price"> <h6>{{ __('Quantity') }}</h6>
                               <span>
                                  <span class="woocommerce-Price-amount amount"><h6>{{ __('Discount') }}</h6>
                               </span>
                               </span>
                            </li>
                            @foreach($productt->whole_sell_qty as $key => $data1)
                            <li class="selling-price"> <label>{{ $productt->whole_sell_qty[$key] }}+</label> <span><span class="woocommerce-Price-amount amount">{{ $productt->whole_sell_discount[$key] }}% {{ __('Off') }}
                               </span>
                               </span>
                            </li>
                            @endforeach
                      </ul>
                   </div>
                </div>
             </div>
             @endif



          </div>
      </div>
  </div>
</div>


{{-- MESSAGE MODAL --}}
{{-- MESSAGE MODAL --}}
<div class="message-modal">
  <div class="modal" id="vendorform" tabindex="-1" role="dialog" aria-labelledby="vendorformLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="vendorformLabel">{{ __('Send Message') }}</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
          <div class="container-fluid p-0">
            <div class="row">
              <div class="col-md-12">
                <div class="contact-form">
                  <form id="emailreply">
                    {{csrf_field()}}
                    <ul>

                      <li>
                        <input type="email" class="form-control border mb-1" id="eml" name="email" placeholder="{{ __('Email *') }}" value="{{auth()->user() ? auth()->user()->email : ''}}" required="" readonly>
                      </li>

                      <li>
                        <input type="text" class="form-control border mb-1" id="subj" name="subject" placeholder="{{ __('Subject *') }}" required="">
                      </li>

                      <li>
                        <textarea class="form-control textarea border mb-1" name="message" id="msg" placeholder="{{ __('Your Message *') }}" required=""></textarea>
                      </li>

                      <input type="hidden" name="name" value="{{ Auth::user() ? Auth::user()->name:'' }}">
                      <input type="hidden" name="user_id" value="{{ Auth::user() ? Auth::user()->id:'' }}">
                      <input type="hidden" name="vendor_id" value="{{ $productt->user_id }}">

                    </ul>
                    <button class="submit-btn" id="emlsub" type="submit">{{ __('Send Message') }}</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- MESSAGE MODAL ENDS --}}

{{-- MESSAGE MODAL ENDS --}}

<div class="message-modal">
  <div class="modal show" id="sendMessage" tabindex="-1" role="dialog" aria-labelledby="sendMessageLabel" aria-modal="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="sendMessageLabel">{{ __('Send Message') }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container-fluid p-0">
            <div class="row">
              <div class="col-md-12">
                <div class="contact-form">
                <form action="{{ route('user-send-message') }}" class="emailreply">
                    @csrf
                    <ul>
                      <li>
                        <input type="text" class="input-field" name="subject" placeholder="{{ __('Subject *') }}" required="">
                      </li>
                      <li>
                        <textarea class="input-field textarea" name="message" placeholder="{{ __('Your Message') }}" required=""></textarea>
                      </li>
                      <input type="hidden" name="type" value="Ticket">
                    </ul>
                    <button class="submit-btn" type="submit">{{ __('Send Message') }}</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


