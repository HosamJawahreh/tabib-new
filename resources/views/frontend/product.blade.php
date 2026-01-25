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
            margin-top: 8px;
        }

        .breadcrumb-category-badge {
            font-size: 12px;
            padding: 5px 12px;
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
                  <span class="breadcrumb-category-badge">{{ $category->name }}</span>
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
<style>
    /* Featured Products Section - Matches Homepage Design */
    .featured-products-strip {
        background: #ffffff;
        padding: 25px 0;
        margin: 20px 0;
    }

    .featured-section-title {
        font-size: 24px;
        font-weight: 700;
        color: #1f2937;
        margin: 0 0 20px 0;
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

    /* Use same product card styles as homepage */
    .featured-carousel .product-card {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        transition: all 0.3s ease;
        overflow: hidden;
        background: #fff;
        margin: 0 5px;
    }

    .featured-carousel .product-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        transform: translateY(-2px);
    }

    .featured-carousel .product-thumb {
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        padding: 15px;
        min-height: 200px !important;
        max-height: 200px !important;
        height: 200px !important;
        background: #f8f9fa;
    }

    .featured-carousel .product-image {
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

    .featured-carousel .product-card:hover .product-image {
        transform: scale(1.02);
    }

    /* Cart icon styling */
    .featured-carousel .cart-icon-clean {
        width: 36px;
        height: 36px;
        background: #000000;
        color: #ffffff;
        border-radius: 50%;
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        font-size: 14px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }

    .featured-carousel .cart-icon-clean:hover {
        background: #28a745;
        transform: scale(1.1);
    }

    /* Price styling */
    .featured-carousel .price-current {
        font-size: 1.1rem;
        color: #7caa53;
        font-weight: 700;
    }

    .featured-carousel .price-old {
        font-size: 0.95rem !important;
        color: #999;
    }

    /* Discount Badge */
    .featured-carousel .on-sale {
        font-size: 13px !important;
        font-weight: 700 !important;
        padding: 2px 6px !important;
        line-height: 1.1 !important;
        background: #ff0000 !important;
        color: #ffffff !important;
        border-radius: 3px !important;
    }

    /* Owl Carousel Navigation for Strip */
    .featured-carousel .owl-nav button {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 40px;
        height: 40px;
        background: white !important;
        border-radius: 50%;
        border: 2px solid #e5e7eb !important;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: #1f2937 !important;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .featured-carousel .owl-nav button:hover {
        background: #10b981 !important;
        color: white !important;
        border-color: #10b981 !important;
        transform: translateY(-50%) scale(1.1);
    }

    .featured-carousel .owl-nav .owl-prev {
        left: -20px;
    }

    .featured-carousel .owl-nav .owl-next {
        right: -20px;
    }

    /* Hide action buttons in featured products */
    .featured-strip-product .hover-area {
        display: none !important;
    }

    @media (max-width: 767px) {
        .featured-products-strip {
            padding: 20px 0;
        }

        .featured-section-title {
            font-size: 18px;
            margin-bottom: 15px;
        }

        .featured-strip-product .product-title {
            font-size: 12px;
            height: 32px;
        }

        .featured-strip-product .price ins {
            font-size: 14px;
        }

        .featured-carousel .owl-nav button {
            width: 35px;
            height: 35px;
            font-size: 18px;
        }

        .featured-carousel .owl-nav .owl-prev {
            left: -10px;
        }

        .featured-carousel .owl-nav .owl-next {
            right: -10px;
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
               {{-- Debug: Show count --}}
               @if(isset($featured_products))
                  <small style="color: #999; font-size: 12px; margin-left: 10px;">({{ $featured_products->count() }} products)</small>
               @else
                  <small style="color: red; font-size: 12px; margin-left: 10px;">(Variable not set!)</small>
               @endif
            </h4>
         </div>
         <div class="col-12">
            @if(isset($featured_products) && $featured_products->count() > 0)
               <div class="featured-carousel owl-carousel owl-theme">
                  @foreach ($featured_products as $product)
                  <div class="item">
                     <div class="product-card h-100 shadow-sm">
                        <div class="product-thumb position-relative">
                           <a href="{{ route('front.product', $product->slug) }}" class="d-block">
                              @php
                                  // Use thumbnail for grid view (ultra-compressed for fast loading)
                                  $imageSrc = asset('assets/images/noimage.png');
                                  if($product->thumbnail) {
                                      $imageSrc = asset('assets/images/thumbnails/'.$product->thumbnail);
                                  } elseif($product->photo) {
                                      $imageSrc = asset('assets/images/products/'.$product->photo);
                                  }
                              @endphp
                              <img src="{{ $imageSrc }}"
                                   alt="{{ $product->name }}"
                                   class="img-fluid product-image"
                                   loading="lazy"
                                   onerror="this.onerror=null; this.src='{{ asset('assets/images/noimage.png') }}';">
                           </a>

                           {{-- Discount Badge --}}
                           @if($product->previous_price && $product->previous_price > $product->price)
                           <div class="on-sale position-absolute" style="top: 5px; left: 5px; margin: 0; background: #ff0000; color: #ffffff; padding: 2px 6px; border-radius: 3px; font-size: 13px; font-weight: 700; z-index: 5; border: none; box-shadow: none; line-height: 1.1;">
                              -{{ round(((float)$product->previous_price - (float)$product->price) / (float)$product->previous_price * 100) }}%
                           </div>
                           @endif

                           {{-- Add to Cart Button - Upper Right Corner, Clean Black Icon --}}
                           <div class="cart-action-buttons position-absolute" style="top: 10px; right: 10px; z-index: 10; display: flex !important; opacity: 1 !important; visibility: visible !important;">
                              @if($product->product_type == "affiliate")
                                 {{-- Affiliate Product --}}
                                 <a href="javascript:;"
                                    data-href="{{ $product->affiliate_link }}"
                                    class="cart-icon-clean affilate-btn"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="left"
                                    title="{{ __('Add To Cart') }}"
                                    style="display: inline-flex !important; opacity: 1 !important; visibility: visible !important;">
                                    <i class="fas fa-shopping-cart"></i>
                                 </a>
                              @else
                                 @if($product->emptyStock())
                                    {{-- Out of Stock --}}
                                    <a class="cart-icon-clean cart-out-of-stock"
                                       href="#"
                                       style="cursor: not-allowed; opacity: 0.4; display: inline-flex !important; visibility: visible !important;"
                                       title="{{ __('Out Of Stock') }}">
                                       <i class="fas fa-times-circle"></i>
                                    </a>
                                 @else
                                    {{-- Add to Cart --}}
                                    <a href="javascript:;"
                                       data-href="{{ route('product.cart.add', $product->id) }}"
                                       class="cart-icon-clean add-cart"
                                       data-bs-toggle="tooltip"
                                       data-bs-placement="left"
                                       title="{{ __('Add To Cart') }}"
                                       style="display: inline-flex !important; opacity: 1 !important; visibility: visible !important;">
                                       <i class="fas fa-shopping-cart"></i>
                                    </a>
                                 @endif
                              @endif
                           </div>
                        </div>

                        <div class="product-content" style="padding: 0.35rem !important; padding-bottom: 0 !important;">
                           @php
                              $isArabic = isset($langg) && ($langg->language == 'العربية' || $langg->language == 'Arabic' || $langg->language == 'ar');
                           @endphp
                           <h6 class="product-title mb-2" style="min-height: 40px; text-align: {{ $isArabic ? 'right' : 'left' }}; direction: {{ $isArabic ? 'rtl' : 'ltr' }};">
                              <a href="{{ route('front.product', $product->slug) }}" class="text-dark text-decoration-none">
                                 {{ Str::limit($product->name, 60) }}
                              </a>
                           </h6>

                           <div class="product-price" style="margin-bottom: 0 !important; padding-bottom: 0 !important; text-align: {{ $isArabic ? 'right' : 'left' }}; direction: {{ $isArabic ? 'rtl' : 'ltr' }};">
                              @if($product->previous_price && $product->previous_price > $product->price)
                                 <span class="price-old text-muted text-decoration-line-through me-2 small" style="margin-bottom: 0 !important; padding-bottom: 0 !important;">
                                    @if($isArabic)
                                       {{ $gs->curr_code ?? 'JD' }} {{ number_format($product->previous_price, 2) }}
                                    @else
                                       {{ number_format($product->previous_price, 2) }} {{ $gs->curr_code ?? 'JD' }}
                                    @endif
                                 </span>
                              @endif
                              <span class="price-current fw-bold" style="color: #7caa53; margin-bottom: 0 !important; padding-bottom: 0 !important;">
                                 @if($isArabic)
                                    {{ $gs->curr_code ?? 'JD' }} {{ number_format($product->price, 2) }}
                                 @else
                                    {{ number_format($product->price, 2) }} {{ $gs->curr_code ?? 'JD' }}
                                 @endif
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
            @else
               <div class="col-12 text-center py-4">
                  <p style="color: red;">{{ __('No featured products available') }}</p>
                  @if(isset($featured_products))
                     <small>Count: {{ $featured_products->count() }}</small>
                  @else
                     <small>Featured products variable is not set!</small>
                  @endif
               </div>
            @endif
         </div>
      </div>
   </div>
</div>

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

// Initialize Featured Products Carousel
jQuery(document).ready(function($) {
    console.log('=== Featured Products Carousel Initialization ===');
    console.log('jQuery version:', $.fn.jquery);
    console.log('Owl Carousel available:', typeof $.fn.owlCarousel !== 'undefined');
    console.log('Featured carousel elements:', $('.featured-carousel').length);
    console.log('Featured carousel items:', $('.featured-carousel .item').length);
    
    // Wait a bit for DOM to be fully ready
    setTimeout(function() {
        if ($('.featured-carousel').length > 0) {
            try {
                $('.featured-carousel').owlCarousel({
                    loop: $('.featured-carousel .item').length > 2, // Only loop if more than 2 items
                    margin: 15,
                    nav: true,
                    dots: false,
                    autoplay: true,
                    autoplayTimeout: 4000,
                    autoplayHoverPause: true,
                    navText: ['<i class="fas fa-chevron-left"></i>', '<i class="fas fa-chevron-right"></i>'],
                    responsive: {
                        0: {
                            items: 2,
                            margin: 10
                        },
                        576: {
                            items: 3,
                            margin: 12
                        },
                        768: {
                            items: 4,
                            margin: 15
                        },
                        992: {
                            items: 5,
                            margin: 15
                        },
                        1200: {
                            items: 6,
                            margin: 15
                        }
                    }
                });
                console.log('✓ Featured carousel initialized successfully');
                
                // Initialize lazy loading for carousel images
                lazy();
            } catch (error) {
                console.error('✗ Error initializing featured carousel:', error);
            }
        } else {
            console.error('✗ Featured carousel element not found!');
        }
    }, 100);
});

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
