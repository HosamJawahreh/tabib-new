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
<style>
    /* Featured Products Section - Match Homepage Exactly */
    .featured-products-strip {
        background: #ffffff;
        padding: 30px 0;
        margin: 30px 0;
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

    /* Ensure images display properly - matching homepage */
    .featured-products-strip .product-thumb {
        position: relative !important;
        width: 100% !important;
        padding-top: 100% !important;
        overflow: hidden !important;
        background: #f8f9fa !important;
        border-radius: 8px 8px 0 0 !important;
    }

    .featured-products-strip .product-thumb a {
        position: absolute !important;
        top: 0 !important;
        left: 0 !important;
        width: 100% !important;
        height: 100% !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }

    .featured-products-strip .product-thumb img.product-image {
        position: absolute !important;
        top: 0 !important;
        left: 0 !important;
        width: 100% !important;
        height: 100% !important;
        object-fit: contain !important;
        object-position: center !important;
        padding: 10px !important;
        background: white !important;
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
    }

    .featured-products-strip .product-card:hover .product-thumb img {
        transform: scale(1.08);
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

    /* Responsive - match homepage breakpoints */
    @media (max-width: 576px) {
        .featured-products-strip .cart-icon-clean {
            width: 35px !important;
            height: 35px !important;
        }
        
        .featured-products-strip .cart-icon-clean i {
            font-size: 16px !important;
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
         {{-- Use EXACT same grid structure as homepage --}}
         <div class="row g-4">
            @foreach ($featured_products as $product)
            <div class="col-lg-2 col-md-3 col-sm-4 col-6 product-item" style="margin-bottom: 0.25rem !important; padding-bottom: 0.25rem !important; padding-left: 0.25rem !important; padding-right: 0.25rem !important; overflow: visible !important;" data-product-id="{{ $product->id }}">
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

                    <div class="product-content" style="padding: 0.5rem !important; padding-top: 0.35rem !important; padding-bottom: 0.35rem !important; margin-top: 0 !important;">
                        @php
                            $isArabic = isset($langg) && ($langg->language == 'العربية' || $langg->language == 'Arabic' || $langg->language == 'ar');
                        @endphp
                        <h6 class="product-title mb-1" style="min-height: 38px; margin-top: 0 !important; margin-bottom: 4px !important; text-align: {{ $isArabic ? 'right' : 'left' }}; direction: {{ $isArabic ? 'rtl' : 'ltr' }};">
                            <a href="{{ route('front.product', $product->slug) }}" class="text-dark text-decoration-none">
                                {{ Str::limit($product->translated_name, 60) }}
                            </a>
                        </h6>

                        <div class="product-price" style="margin-bottom: 0 !important; padding-bottom: 0 !important; margin-top: 2px !important; text-align: {{ $isArabic ? 'right' : 'left' }}; direction: ltr !important; display: block;">
                            @if($product->previous_price && $product->previous_price > $product->price)
                                <span class="price-old text-muted text-decoration-line-through small" style="margin-bottom: 0 !important; padding-bottom: 0 !important; {{ $isArabic ? 'margin-left' : 'margin-right' }}: 8px;">
                                    {{ number_format($product->previous_price, 2) }} {{ $gs->curr_code ?? 'JD' }}
                                </span>
                            @endif
                            <span class="price-current fw-bold" style="color: #7caa53; margin-bottom: 0 !important; padding-bottom: 0 !important;">
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
      @else
         <div class="row">
            <div class="col-12 text-center py-4">
                <p class="text-muted">{{ __('No featured products available') }}</p>
            </div>
         </div>
      @endif
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
