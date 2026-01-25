@extends('layouts.front')

@section('content')
@include('partials.global.common-header')
<!-- breadcrumb -->
<style>
    .breadcrumb-categories-wrapper {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        justify-content: center;
        align-items: center;
        margin-top: 12px;
    }

    .breadcrumb-category-badge {
        background: rgba(16, 185, 129, 0.15);
        border: 1px solid rgba(16, 185, 129, 0.3);
        padding: 6px 14px;
        border-radius: 20px;
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        backdrop-filter: blur(10px);
        cursor: default;
        pointer-events: none;
    }

    .breadcrumb-category-badge::before {
        content: '📁';
        font-size: 12px;
    }

    .breadcrumb-separator {
        color: rgba(255, 255, 255, 0.5);
        font-size: 12px;
    }

    @media (max-width: 767px) {
        .breadcrumb-categories-wrapper {
            gap: 6px;
            margin-top: 6px;
        }

        .breadcrumb-category-badge {
            font-size: 11px;
            padding: 4px 10px;
        }

        /* Reduce breadcrumb section height on mobile */
        .full-row.bg-light.overlay-dark.py-5 {
            padding-top: 10px !important;
            padding-bottom: 10px !important;
        }

        .full-row.bg-light.overlay-dark.py-5 h3 {
            font-size: 1.2rem !important;
            margin-bottom: 6px !important;
        }
    }
</style>
<div class="full-row bg-light overlay-dark py-5" style="background-image: url({{ $gs->breadcrumb_banner ? asset('assets/images/'.$gs->breadcrumb_banner):asset('assets/images/noimage.png') }}); background-position: center center; background-size: cover; margin-bottom: 0; padding-top: 14px !important; padding-bottom: 14px !important; height: 70% !important;">
   <div class="container">
      <div class="row text-center text-white">
         <div class="col-12">
            <h3 class="mb-2 text-white">{{ __('Product Details') }}</h3>
         </div>
         <div class="col-12">
            @if($productt->categories->count() > 0)
            <div class="breadcrumb-categories-wrapper">
               @foreach($productt->categories as $index => $category)
                  <span class="breadcrumb-category-badge">{{ $category->translated_name }}</span>
                  @if($index < $productt->categories->count() - 1)
                     <span class="breadcrumb-separator">•</span>
                  @endif
               @endforeach
            </div>
            @endif
         </div>
      </div>
   </div>
</div>
<!-- breadcrumb -->
@include('partials.product-details.top')
<!--==================== Product Description Section Start ====================-->
{{-- Description section moved under product name in top.blade.php --}}
<!--==================== Product Description Section End ====================-->
<!--==================== Featured Products Section Start ====================-->
<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<style>
    /* Featured Products Section - Match Homepage Exactly */
    .featured-products-strip {
        background: #ffffff;
        padding: 30px 0;
        margin: 30px 0;
        position: relative;
    }

    .featured-section-title {
        font-size: 24px;
        font-weight: 700;
        color: #1f2937;
        margin: 0 0 30px 0;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .featured-section-title::before {
        content: '⭐';
        font-size: 20px;
    }

    /* Swiper Container */
    .featured-products-swiper {
        width: 100%;
        padding: 10px 0 40px 0;
    }

    .featured-products-swiper .swiper-slide {
        height: auto;
    }

    /* Navigation Arrows */
    .featured-nav-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.95);
        border: 2px solid #e5e7eb;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .featured-nav-btn:hover {
        background: #000;
        border-color: #000;
        transform: translateY(-50%) scale(1.1);
    }

    .featured-nav-btn i {
        font-size: 20px;
        color: #000;
        transition: color 0.3s ease;
    }

    .featured-nav-btn:hover i {
        color: #fff;
    }

    .featured-prev {
        left: -25px;
    }

    .featured-next {
        right: -25px;
    }

    /* Pagination */
    .featured-pagination {
        position: static !important;
        margin-top: 20px !important;
        text-align: center;
        width: 100% !important;
        left: 0 !important;
        right: 0 !important;
    }

    .featured-pagination .swiper-pagination-bullet {
        width: 10px;
        height: 10px;
        background: #d1d5db;
        opacity: 1;
    }

    .featured-pagination .swiper-pagination-bullet-active {
        background: #000;
        width: 24px;
        border-radius: 5px;
    }

    /* Ensure images display properly - matching homepage */
    .featured-products-strip .product-thumb {
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        padding: 10px;
        padding-bottom: 5px;
        min-height: 300px !important;
        max-height: 300px !important;
        height: 300px !important;
        background: #ffffff;
        border-radius: 8px 8px 0 0;
    }

    .featured-products-strip .product-thumb a {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
    }

    .featured-products-strip .product-image {
        max-height: 90%;
        max-width: 90%;
        width: auto !important;
        height: auto !important;
        object-fit: contain;
        margin: 0 auto;
        display: block;
        transform: scale(0.98);
        transition: transform 0.3s ease;
    }

    .featured-products-strip .product-card:hover .product-thumb img {
        transform: scale(1.02);
    }

    /* Cart icons - match homepage positioning */
    .featured-products-strip .cart-action-buttons {
        position: absolute !important;
        top: 10px !important;
        right: 10px !important;
        left: auto !important;
        bottom: auto !important;
        z-index: 100 !important;
        display: flex !important;
        opacity: 1 !important;
        visibility: visible !important;
        pointer-events: auto !important;
    }

    .featured-products-strip .cart-icon-clean {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        width: 44px !important;
        height: 44px !important;
        background: rgba(255, 255, 255, 0.95) !important;
        border: none !important;
        border-radius: 50% !important;
        transition: all 0.3s ease !important;
        cursor: pointer !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15) !important;
        opacity: 1 !important;
        visibility: visible !important;
        position: relative !important;
    }

    .featured-products-strip .cart-icon-clean i {
        font-size: 20px !important;
        color: #000 !important;
        display: block !important;
    }

    .featured-products-strip .cart-icon-clean:hover {
        background: #000 !important;
        transform: scale(1.1);
    }

    .featured-products-strip .cart-icon-clean:hover i {
        color: #fff !important;
    }

    /* Discount badge */
    .featured-products-strip .on-sale {
        position: absolute !important;
        top: 5px !important;
        left: 5px !important;
        z-index: 5 !important;
    }

    /* Product Card */
    .featured-products-strip .product-card {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        overflow: hidden;
        background: #fff;
        transition: all 0.3s ease;
        height: 100%;
    }

    .featured-products-strip .product-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        transform: translateY(-2px);
    }

    /* Product Content */
    .featured-products-strip .product-content {
        padding: 0.5rem;
        padding-top: 0.35rem;
        padding-bottom: 0.35rem;
    }

    .featured-products-strip .product-title {
        font-size: 0.9rem;
        line-height: 1.4;
        min-height: 38px;
    }

    .featured-products-strip .product-price {
        font-size: 1.1rem;
    }

    .featured-products-strip .price-old {
        font-size: 1rem;
    }

    /* Responsive - match homepage breakpoints */
    @media (max-width: 768px) {
        .featured-prev {
            left: 10px;
        }
        
        .featured-next {
            right: 10px;
        }
        
        .featured-nav-btn {
            width: 40px;
            height: 40px;
        }
        
        .featured-nav-btn i {
            font-size: 16px;
        }
    }

    @media (max-width: 575px) {
        /* Swiper Container - Mobile */
        .featured-products-swiper {
            padding: 5px 0 30px 0 !important;
        }

        /* Swiper Slide - Mobile */
        .featured-products-swiper .swiper-slide {
            padding: 0 !important;
        }

        /* Product Card - Mobile */
        .featured-products-strip .product-card {
            margin-bottom: 0 !important;
            display: flex !important;
            flex-direction: column !important;
            overflow: hidden !important;
            position: relative !important;
            border: 1px solid #e0e0e0 !important;
            border-radius: 8px !important;
            isolation: isolate !important;
            contain: layout style paint !important;
        }

        /* Product Thumb - Mobile */
        .featured-products-strip .product-thumb {
            padding: 8px !important;
            padding-bottom: 4px !important;
            min-height: 180px !important;
            max-height: 180px !important;
            height: 180px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            overflow: hidden !important;
            position: relative !important;
            background: #ffffff !important;
        }

        .featured-products-strip .product-thumb a {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 100% !important;
            height: 100% !important;
            overflow: hidden !important;
        }

        /* Product Image - Mobile (match homepage scale) */
        .featured-products-strip .product-image {
            max-width: 100% !important;
            max-height: 100% !important;
            width: auto !important;
            height: auto !important;
            object-fit: contain !important;
            margin: 0 auto !important;
            display: block !important;
            transform: scale(1.11) !important;
            transition: transform 0.3s ease !important;
        }

        .featured-products-strip .product-card:hover .product-image {
            transform: scale(1.15) !important;
        }

        /* Product Content - Mobile */
        .featured-products-strip .product-content {
            padding: 6px !important;
            padding-top: 4px !important;
            padding-bottom: 6px !important;
            flex: 1 !important;
            display: flex !important;
            flex-direction: column !important;
            margin-top: 0 !important;
            min-height: auto !important;
            position: relative !important;
            z-index: 1 !important;
        }

        /* Product Title - Mobile */
        .featured-products-strip .product-title {
            font-size: 0.75rem !important;
            line-height: 1.2 !important;
            min-height: 30px !important;
            margin-bottom: 3px !important;
            margin-top: 0 !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            display: -webkit-box !important;
            -webkit-line-clamp: 2 !important;
            -webkit-box-orient: vertical !important;
        }

        /* Product Price - Mobile */
        .featured-products-strip .product-price {
            font-size: 0.85rem !important;
            margin-top: auto !important;
            margin-bottom: 0 !important;
            padding-bottom: 0 !important;
            display: block !important;
            white-space: nowrap !important;
        }

        .featured-products-strip .price-current {
            font-size: 0.9rem !important;
            display: inline-block !important;
            font-weight: bold !important;
        }

        .featured-products-strip .price-old {
            font-size: 0.75rem !important;
            display: inline-block !important;
        }

        /* Cart Icon - Mobile (smaller to prevent covering image) */
        .featured-products-strip .cart-icon-clean {
            display: inline-flex !important;
            opacity: 1 !important;
            visibility: visible !important;
            background: transparent !important;
            width: 32px !important;
            height: 32px !important;
            border-radius: 50% !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15) !important;
            position: absolute !important;
            top: 5px !important;
            left: 5px !important;
            margin: 0 !important;
            z-index: 10 !important;
        }
        
        .featured-products-strip .cart-icon-clean i {
            font-size: 14px !important;
        }

        .featured-products-strip .cart-icon-clean:hover {
            background: #000 !important;
            transform: scale(1.1) !important;
        }

        .featured-products-strip .cart-icon-clean:hover i {
            color: #fff !important;
        }
        
        /* Navigation - Mobile */
        .featured-nav-btn {
            width: 35px !important;
            height: 35px !important;
        }

        .featured-nav-btn i {
            font-size: 14px !important;
        }

        .featured-prev {
            left: 5px !important;
        }

        .featured-next {
            right: 5px !important;
        }

        /* Pagination - Mobile (Centered) */
        .featured-pagination {
            position: static !important;
            margin-top: 15px !important;
            text-align: center !important;
            width: 100% !important;
            left: 0 !important;
            right: 0 !important;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
        }

        .featured-pagination .swiper-pagination-bullet {
            width: 8px !important;
            height: 8px !important;
            margin: 0 4px !important;
        }

        .featured-pagination .swiper-pagination-bullet-active {
            width: 20px !important;
        }

        /* Discount Badge - Mobile */
        .featured-products-strip .on-sale {
            font-size: 11px !important;
            padding: 2px 5px !important;
            position: absolute !important;
            top: 5px !important;
            box-shadow: none !important;
            border: none !important;
            letter-spacing: 0 !important;
            z-index: 10 !important;
            margin: 0 !important;
        }

        /* Rating - Mobile */
        .featured-products-strip .product-rating {
            font-size: 0.7rem !important;
        }

        .featured-products-strip .product-rating i {
            font-size: 0.65rem !important;
        }

        /* Android Chrome/WebView specific fixes */
        .featured-products-strip .product-item,
        .featured-products-strip .product-card,
        .featured-products-strip .product-thumb,
        .featured-products-strip .product-content {
            -webkit-transform: translateZ(0) !important;
            transform: translateZ(0) !important;
            -webkit-backface-visibility: hidden !important;
            backface-visibility: hidden !important;
            -webkit-perspective: 1000 !important;
            perspective: 1000 !important;
        }

        /* Ensure no pseudo-elements escape on Android */
        .featured-products-strip .product-card::before,
        .featured-products-strip .product-card::after {
            content: none !important;
            display: none !important;
        }
    }
</style>

<div class="featured-products-strip">
   <div class="container">
      <div class="row">
         <div class="col-12">
            <h4 class="featured-section-title">
               @if(isset($langg) && $langg->rtl == 1)
                  المنتجات المميزة
               @else
                  {{ __('Featured Products') }}
               @endif
            </h4>
         </div>
      </div>
      
      @if(isset($featured_products) && $featured_products->count() > 0)
         {{-- Swiper Slider with Grid Card Design --}}
         <div class="position-relative">
            <div class="swiper featured-products-swiper">
               <div class="swiper-wrapper">
            @foreach ($featured_products as $product)
            <div class="swiper-slide">
                <div class="product-card h-100 shadow-sm" style="overflow: visible !important; position: relative !important;">
                    <div class="product-thumb position-relative" style="overflow: hidden !important;">
                        <a href="{{ route('front.product', $product->slug) }}" class="d-block">
                            @php
                                // FIXED: Use absolute paths from domain root
                                $imageSrc = url('assets/images/noimage.png');
                                if($product->thumbnail) {
                                    $imageSrc = url('assets/images/thumbnails/'.$product->thumbnail);
                                } elseif($product->photo) {
                                    $imageSrc = url('assets/images/products/'.$product->photo);
                                }
                            @endphp
                            <img src="{{ $imageSrc }}"
                                 alt="{{ $product->name }}"
                                 class="img-fluid product-image"
                                 loading="lazy"
                                 onerror="this.onerror=null; this.src='{{ url('assets/images/noimage.png') }}';">
                        </a>

                        {{-- Discount Badge --}}
                        @if($product->previous_price && $product->previous_price > $product->price)
                        <div class="on-sale position-absolute" style="top: 5px; left: 5px; margin: 0; background: #ff0000; color: #ffffff; padding: 2px 6px; border-radius: 3px; font-size: 13px; font-weight: 700; z-index: 5; border: none; box-shadow: none; line-height: 1.1;">
                            -{{ round(((float)$product->previous_price - (float)$product->price) / (float)$product->previous_price * 100) }}%
                        </div>
                        @endif

                        {{-- Add to Cart Button --}}
                        <div class="cart-action-buttons position-absolute" style="position: absolute !important; top: 10px !important; right: 10px !important; left: auto !important; bottom: auto !important; z-index: 10 !important; display: flex !important; gap: 8px !important; flex-direction: column !important; opacity: 1 !important; visibility: visible !important;">
                            @if($product->product_type == "affiliate")
                                <a href="javascript:;"
                                   data-href="{{ $product->affiliate_link }}"
                                   class="cart-icon-clean affilate-btn"
                                   data-bs-toggle="tooltip"
                                   data-bs-placement="left"
                                   title="{{ __('Add To Cart') }}"
                                   style="display: inline-flex !important; align-items: center !important; justify-content: center !important; width: 44px !important; height: 44px !important; background: rgba(255, 255, 255, 0.95) !important; border: none !important; border-radius: 50% !important; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15) !important; opacity: 1 !important; visibility: visible !important; cursor: pointer !important; position: relative !important; z-index: 9999 !important;">
                                    <i class="fas fa-shopping-cart" style="font-size: 20px !important; color: #000 !important; display: block !important;"></i>
                                </a>
                            @else
                                @if($product->emptyStock())
                                    <a class="cart-icon-clean cart-out-of-stock"
                                       href="#"
                                       style="display: inline-flex !important; align-items: center !important; justify-content: center !important; width: 44px !important; height: 44px !important; background: rgba(200, 200, 200, 0.8) !important; border: none !important; border-radius: 50% !important; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15) !important; cursor: not-allowed !important; opacity: 0.4 !important; visibility: visible !important; position: relative !important; z-index: 9999 !important;"
                                       title="{{ __('Out Of Stock') }}">
                                        <i class="fas fa-times-circle" style="font-size: 20px !important; color: #000 !important; display: block !important;"></i>
                                    </a>
                                @else
                                    <a href="javascript:;"
                                       data-href="{{ route('product.cart.add', $product->id) }}"
                                       class="cart-icon-clean add-cart"
                                       data-product-id="{{ $product->id }}"
                                       data-product-name="{{ $product->name }}"
                                       data-product-price="{{ $product->price }}"
                                       data-bs-toggle="tooltip"
                                       data-bs-placement="left"
                                       title="{{ __('Add To Cart') }}"
                                       style="display: inline-flex !important; align-items: center !important; justify-content: center !important; width: 44px !important; height: 44px !important; background: rgba(255, 255, 255, 0.95) !important; border: none !important; border-radius: 50% !important; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15) !important; opacity: 1 !important; visibility: visible !important; cursor: pointer !important; position: relative !important; z-index: 9999 !important;">
                                        <i class="fas fa-shopping-cart" style="font-size: 20px !important; color: #000 !important; display: block !important;"></i>
                                    </a>
                                @endif
                            @endif
                        </div>
                    </div>

                    <div class="product-content">
                        @php
                            $isArabic = isset($langg) && ($langg->language == 'العربية' || $langg->language == 'Arabic' || $langg->language == 'ar');
                        @endphp
                        <h6 class="product-title mb-1" style="text-align: {{ $isArabic ? 'right' : 'left' }}; direction: {{ $isArabic ? 'rtl' : 'ltr' }};">
                            <a href="{{ route('front.product', $product->slug) }}" class="text-dark text-decoration-none">
                                {{ Str::limit($product->translated_name, 60) }}
                            </a>
                        </h6>

                        <div class="product-price" style="text-align: {{ $isArabic ? 'right' : 'left' }}; direction: ltr !important; display: block;">
                            @if($product->previous_price && $product->previous_price > $product->price)
                                <span class="price-old text-muted text-decoration-line-through small" style="{{ $isArabic ? 'margin-left' : 'margin-right' }}: 8px;">
                                    {{ number_format($product->previous_price, 2) }} {{ $gs->curr_code ?? 'JD' }}
                                </span>
                            @endif
                            <span class="price-current fw-bold" style="color: #7caa53;">
                                {{ number_format($product->price, 2) }} {{ $gs->curr_code ?? 'JD' }}
                            </span>
                        </div>

                        @if($product->ratings_count > 0)
                        <div class="product-rating d-flex align-items-center">
                            <div class="stars me-2">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= round($product->ratings_avg_rating ?? 0))
                                        <i class="icofont-star text-warning"></i>
                                    @else
                                        <i class="icofont-star text-muted"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="rating-count text-muted small">({{ $product->ratings_count }})</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
               </div>
               
               {{-- Navigation Arrows --}}
               <div class="featured-prev featured-nav-btn">
                  <i class="fas fa-chevron-left"></i>
               </div>
               <div class="featured-next featured-nav-btn">
                  <i class="fas fa-chevron-right"></i>
               </div>
               
               {{-- Pagination Dots --}}
               <div class="featured-pagination"></div>
            </div>
         </div>
      @else
         <div class="row">
            <div class="col-12 text-center py-4">
                <p class="text-muted">{{ __('No featured products available') }}</p>
            </div>
         </div>
      @endif
   </div>
</div>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
// Initialize Featured Products Swiper
document.addEventListener('DOMContentLoaded', function() {
    const featuredSwiper = new Swiper('.featured-products-swiper', {
        // Responsive breakpoints
        slidesPerView: 2,
        spaceBetween: 10,
        breakpoints: {
            576: {
                slidesPerView: 3,
                spaceBetween: 10,
            },
            768: {
                slidesPerView: 4,
                spaceBetween: 15,
            },
            992: {
                slidesPerView: 5,
                spaceBetween: 15,
            },
            1200: {
                slidesPerView: 6,
                spaceBetween: 15,
            }
        },
        
        // Navigation arrows
        navigation: {
            nextEl: '.featured-next',
            prevEl: '.featured-prev',
        },
        
        // Pagination dots
        pagination: {
            el: '.featured-pagination',
            clickable: true,
            dynamicBullets: true,
        },
        
        // Enable loop for infinite scroll
        loop: true,
        
        // Autoplay
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
            pauseOnMouseEnter: true,
        },
        
        // Smooth transitions
        speed: 600,
        
        // Enable grab cursor
        grabCursor: true,
        
        // Lazy loading
        lazy: {
            loadPrevNext: true,
        },
    });
});
</script>

<!--==================== Featured Products Section End ====================-->
@includeIf('partials.global.common-footer')


@if($gs->is_report)

@if(Auth::check())

{{-- REPORT MODAL SECTION --}}

<div class="modal fade report" id="report-modal" tabindex="-1" role="dialog" aria-labelledby="report-modal-Title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

 <div class="gocover" style="background: url({{ asset('assets/images/'.$gs->loader) }}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>

                    <div class="login-area">
                        <div class="header-area forgot-passwor-area">
                            <h4 class="title text-center">{{ __(('REPORT PRODUCT'))}}</h4>
                            <p class="text">{{ __('Please give the following details')}}</p>
                        </div>
                        <div class="login-form">

                            <form id="reportform" action="{{ route('product.report') }}" method="POST">

                              @include('includes.admin.form-login')

                                {{ csrf_field() }}
                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                <input type="hidden" name="product_id" value="{{ $productt->id }}">
                                <div class="form-input">
                                    <input type="text" name="title" class="User Name form-control border" placeholder="{{ __('Enter Report Title') }}" required="">

                                </div>
                                <br>

                                <div class="form-input">
                                  <textarea name="note" class="User Name form-control border" placeholder="{{ __('Enter Report Note') }}" required=""></textarea>
                                </div>

                                <button type="submit" class="submit-btn">{{ __('SUBMIT') }}</button>
                            </form>
                        </div>
                    </div>
      </div>
    </div>
  </div>
</div>

{{-- REPORT MODAL SECTION ENDS --}}

@endif

@endif
@endsection

@section('script')

<script src="{{ asset('assets/front/js/jquery.elevatezoom.js') }}"></script>

<!-- Initializing the slider -->


<script type="text/javascript">
lazy();

    (function($) {
		"use strict";

         //initiate the plugin and pass the id of the div containing gallery images
      $("#single-image-zoom").elevateZoom({
         gallery: 'gallery_09',
         zoomType: "inner",
         lensShape: "round",
         lensSize: 200,
         cursor: "crosshair",
         galleryActiveClass: 'active',
         imageCrossfade: true,
         borderSize: 3,
         borderColour: "#10b981",
         responsive: true,
         easing: true,
         lensFadeIn: 300,
         lensFadeOut: 300,
         zoomWindowFadeIn: 300,
         zoomWindowFadeOut: 300,
         zoomWindowWidth: 500,
         zoomWindowHeight: 500,
         zoomWindowPosition: 1,
         scrollZoom: true,
         tint: false,
         tintColour: '#10b981',
         tintOpacity: 0.5
      });

      // Gallery thumbnail click handler
      $('#gallery_09 a').on('click', function(e) {
          e.preventDefault();
          $('#gallery_09 a').removeClass('active');
          $(this).addClass('active');

          var ez = $('#single-image-zoom').data('elevateZoom');
          if (ez) {
              $('#single-image-zoom').data('elevateZoom').swaptheimage(
                  $(this).data('image'),
                  $(this).data('zoom-image')
              );
          }
      });

      // Initialize gallery carousel
      var galleryCarousel = $('#gallery_09 .owl-carousel').owlCarousel({
          items: 4,
          margin: 10,
          nav: true,
          dots: false,
          loop: false,
          autoWidth: false,
          navText: ['<span>‹</span>', '<span>›</span>'],
          responsive: {
              0: {
                  items: 3,
                  margin: 8,
                  stagePadding: 0,
                  nav: true
              },
              576: {
                  items: 3,
                  margin: 10,
                  nav: true
              },
              768: {
                  items: 3,
                  margin: 12,
                  nav: true
              },
              992: {
                  items: 4,
                  margin: 12,
                  nav: true
              },
              1200: {
                  items: 4,
                  margin: 15,
                  nav: true
              }
          },
          onInitialized: function(event) {
              console.log('Gallery carousel initialized');
              // Ensure nav is visible
              setTimeout(function() {
                  $('#gallery_09 .owl-nav').css('display', 'flex');
              }, 100);
          },
          onRefreshed: function(event) {
              $('#gallery_09 .owl-nav').css('display', 'flex');
          }
      });

      //pass the images to Fancybox on click
      $("#single-image-zoom").bind("click", function(e) {
         var ez = $('#single-image-zoom').data('elevateZoom');
         if (ez) {
             $.fancybox(ez.getGalleryList());
         }
         return false;
      });

          $(document).on("submit", "#emailreply" , function(){
          var token = $(this).find('input[name=_token]').val();
          var subject = $(this).find('input[name=subject]').val();
          var message =  $(this).find('textarea[name=message]').val();
          var email = $(this).find('input[name=email]').val();
          var name = $(this).find('input[name=name]').val();
          var user_id = $(this).find('input[name=user_id]').val();
          $('#eml').prop('disabled', true);
          $('#subj').prop('disabled', true);
          $('#msg').prop('disabled', true);
          $('#emlsub').prop('disabled', true);
     $.ajax({
            type: 'post',
            url: "{{URL::to('/user/user/contact')}}",
            data: {
                '_token': token,
                'subject'   : subject,
                'message'  : message,
                'email'   : email,
                'name'  : name,
                'user_id'   : user_id
                  },
            success: function( data) {
          $('#eml').prop('disabled', false);
          $('#subj').prop('disabled', false);
          $('#msg').prop('disabled', false);
          $('#subj').val('');
          $('#msg').val('');
          $('#emlsub').prop('disabled', false);
        if(data == 0)
          toastr.error("Email Not Found");
        else
          toastr.success("Message Sent");
          $('#vendorform').modal('hide');
            }
        });
          return false;
        });

})(jQuery);

$('.add-to-affilate').on('click',function(){

  var value = $(this).data('href');
  var tempInput = document.createElement("input");
  tempInput.style = "position: absolute; left: -1000px; top: -1000px";
  tempInput.value = value;
  document.body.appendChild(tempInput);
  tempInput.select();
  document.execCommand("copy");
  document.body.removeChild(tempInput);
  toastr.success('Affiliate Link Copied');

  });

// Product page buttons are handled globally in main.js (IDs: #addcrt, #qaddcrt).
// We intentionally avoid overriding those handlers here to keep behavior consistent.

<!-- Facebook Pixel: Track ViewContent -->
@if (!empty($seo->facebook_pixel))
<script>
    $(document).ready(function() {
        // Track product view
        if (typeof FacebookPixelTracker !== 'undefined') {
            FacebookPixelTracker.trackViewContent({
                id: {{ $productt->id }},
                name: '{{ addslashes($productt->name) }}',
                price: {{ $productt->price }}
            });
        }
    });
</script>
@endif

</script>
@endsection
