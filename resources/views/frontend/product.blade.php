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
    /* Featured Products Horizontal Slider - Compact Strip Design */
    .featured-products-strip {
        background: linear-gradient(135deg, #f9fafb 0%, #ffffff 100%);
        padding: 25px 0;
        margin: 20px 0;
        border-top: 1px solid #e5e7eb;
        border-bottom: 1px solid #e5e7eb;
    }

    .featured-section-title {
        font-size: 20px;
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
        animation: sparkle 2s ease-in-out infinite;
    }

    @keyframes sparkle {
        0%, 100% { opacity: 0.7; transform: rotate(0deg) scale(1); }
        50% { opacity: 1; transform: rotate(15deg) scale(1.15); }
    }

    /* Compact Product Card for Strip */
    .featured-strip-product {
        padding: 10px;
        background: white;
        border-radius: 12px;
        transition: all 0.3s ease;
        border: 1px solid #e5e7eb;
        height: 100%;
    }

    .featured-strip-product:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        border-color: #10b981;
    }

    .featured-strip-product .product-image {
        position: relative;
        overflow: hidden;
        border-radius: 10px;
        margin-bottom: 10px;
        aspect-ratio: 1;
    }

    .featured-strip-product .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .featured-strip-product:hover .product-image img {
        transform: scale(1.08);
    }

    .featured-strip-product .on-sale {
        position: absolute;
        top: 8px;
        right: 8px;
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        padding: 4px 8px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        z-index: 2;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.4);
    }

    .featured-strip-product .product-info {
        padding: 5px;
    }

    .featured-strip-product .product-title {
        font-size: 13px;
        font-weight: 600;
        margin: 0 0 8px 0;
        line-height: 1.4;
        height: 36px;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .featured-strip-product .product-title a {
        color: #1f2937;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .featured-strip-product .product-title a:hover {
        color: #10b981;
    }

    .featured-strip-product .product-price {
        margin-bottom: 8px;
    }

    .featured-strip-product .price ins {
        font-size: 16px;
        font-weight: 700;
        color: #10b981;
        text-decoration: none;
        margin-right: 6px;
    }

    .featured-strip-product .price del {
        font-size: 13px;
        color: #9ca3af;
    }

    .featured-strip-product .star-rating {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 11px;
    }

    .featured-strip-product .star-rating i {
        color: #fbbf24;
        font-size: 12px;
    }

    .featured-strip-product .star-rating span {
        color: #6b7280;
        font-weight: 600;
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
                  @foreach ($featured_products as $item)
                  <div class="item">
                     <div class="featured-strip-product">
                        <div class="product-image">
                           <a href="{{ route('front.product', $item->slug) }}">
                              <img class="lazy" data-src="{{ $item->photo ? asset('assets/images/products/'.$item->photo):asset('assets/images/noimage.png')}}" alt="{{ $item->showName() }}">
                           </a>
                           @if($item->offPercentage())
                           <div class="on-sale">-{{ round((float)$item->offPercentage(), 2) }}%</div>
                           @endif
                        </div>
                        <div class="product-info">
                           <h3 class="product-title">
                              <a href="{{ route('front.product', $item->slug) }}">
                                 {{ $item->showName() }}
                              </a>
                           </h3>
                           <div class="product-price">
                              <div class="price">
                                 <ins>{{ $item->showPrice()}}</ins>
                                 @if($item->showPreviousPrice())
                                 <del>{{ $item->showPreviousPrice() }}</del>
                                 @endif
                              </div>
                           </div>
                           <div class="star-rating">
                              <i class="fas fa-star"></i>
                              <span>{{ number_format($item->ratings_avg_rating ?? 0, 1) }}</span>
                              <span>({{ $item->ratings_count ?? 0 }})</span>
                           </div>
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

</script>
@endsection
