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
<div class="full-row bg-light overlay-dark py-5" style="background-image: url({{ $gs->breadcrumb_banner ? asset('assets/images/'.$gs->breadcrumb_banner):asset('assets/images/noimage.png') }}); background-position: center center; background-size: cover;">
   <div class="container">
      <div class="row text-center text-white">
         <div class="col-12">
            <h3 class="mb-2 text-white">{{ __('Product Details') }}</h3>
         </div>
         <div class="col-12">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb mb-0 d-inline-flex bg-transparent p-0">
                  <li class="breadcrumb-item"><a href="{{ route('front.index') }}">{{ __('Home') }}</a></li>
                  @if($productt->categories->count() > 0)
                     @foreach($productt->categories as $index => $category)
                        <li class="breadcrumb-item text-white">{{ $category->name }}</li>
                     @endforeach
                  @endif
                  <li class="breadcrumb-item active" aria-current="page">{{ $productt->name }}</li>
               </ol>
            </nav>

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
<!--==================== Related Products Section Start ====================-->
<style>
    /* Modern Related Products Section */
    .modern-section-header {
        position: relative;
        padding: 30px 0 20px;
        margin-bottom: 30px;
    }

    .modern-section-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, #10b981 0%, #34d399 100%);
        border-radius: 2px;
    }

    .modern-section-title {
        font-size: 28px;
        font-weight: 700;
        color: #1f2937;
        margin: 0;
        letter-spacing: -0.5px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .modern-section-title::before {
        content: '✨';
        font-size: 24px;
        animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 0.6; transform: scale(1); }
        50% { opacity: 1; transform: scale(1.1); }
    }

    @media (max-width: 767px) {
        .modern-section-title {
            font-size: 22px;
        }

        .modern-section-title::before {
            font-size: 20px;
        }

        .modern-section-header {
            padding: 20px 0 15px;
            margin-bottom: 20px;
        }

        .modern-section-header::after {
            width: 60px;
            height: 3px;
        }
    }
</style>
<div class="full-row pt-0">
   <div class="container">
      <div class="row">
         <div class="col-12">
            <div class="modern-section-header">
               <h4 class="modern-section-title">{{ __('Related Products') }}</h4>
            </div>
         </div>
         <div class="col-12">
            <div class="products product-style-1 owl-mx-5">
               <div class="five-carousel owl-carousel nav-top-right e-title-hover-primary e-image-bg-light e-hover-image-zoom e-info-center">
                  @foreach (App\Models\Product::where('category_id', $productt->category_id)
                  ->where('id', '!=', $productt->id)
                  ->where('status', 1)
                  ->withCount('ratings')
                  ->withAvg('ratings','rating')
                  ->inRandomOrder()
                  ->take(12)->get() as $item)
                  <div class="item">
                     <div class="product type-product">
                        <div class="product-wrapper">
                           <div class="product-image">
                              <a href="{{ route('front.product', $item->slug) }}" class="woocommerce-LoopProduct-link"><img class="lazy" data-src="{{ $item->photo ? asset('assets/images/products/'.$item->photo):asset('assets/images/noimage.png')}}" alt="Product Image"></a>
                              @if($item->offPercentage())
                              <div class="on-sale">-{{ round((float)$item->offPercentage(), 2) }}%</div>
                              @endif
                              <div class="hover-area">
                                 @if($item->product_type == "affiliate")
                                 <div class="cart-button">
                                    <a href="javascript:;" data-href="{{ $item->affiliate_link }}" class="button add_to_cart_button affilate-btn" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="{{ __('Add To Cart') }}" aria-label="{{ __('Add To Cart') }}"></a>
                                 </div>
                                 @else
                                 @if($item->emptyStock())
                                 <div class="closed">
                                    <a class="cart-out-of-stock button add_to_cart_button" href="#" title="{{ __('Out Of Stock') }}" ><i class="flaticon-cancel flat-mini mx-auto"></i></a>
                                 </div>
                                 @else
                                 <div class="cart-button">
                                    <a href="javascript:;" data-href="{{ route('product.cart.add',$item->id) }}" class="add-cart button add_to_cart_button" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="{{ __('Add To Cart') }}" aria-label="{{ __('Add To Cart') }}"></a>
                                 </div>
                                 <div class="closed">
                                    <a  class="button add_to_cart_button add-to-cart-quick" href="javascript:;" data-bs-toggle="tooltip" data-href="{{ route('product.cart.quickadd',$item->id) }}" data-bs-placement="right" title="{{ __('Buy Now') }}" data-bs-original-title="{{ __('Buy Now') }}"><i class="flaticon-shopping-cart-1 flat-mini mx-auto"></i></a>
                                 </div>
                                 @endif
                                 @endif
                                 @if(Auth::check())
                                 <div class="wishlist-button">
                                    <a class="add_to_wishlist  new button add_to_cart_button" id="add-to-wish" href="javascript:;" data-href="{{ route('user-wishlist-add',$item->id) }}" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Add to Wishlist" aria-label="Add to Wishlist">{{ __('Wishlist') }}</a>
                                 </div>
                                 @else
                                 <div class="wishlist-button">
                                    <a class="add_to_wishlist button add_to_cart_button" href="{{ route('user.login') }}" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Add to Wishlist" aria-label="Add to Wishlist">{{ __('Wishlist') }}</a>
                                 </div>
                                 @endif
                                 <div class="compare-button">
                                    <a class="compare button add_to_cart_button" data-href="{{ route('product.compare.add',$item->id) }}" href="javascrit:;" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Compare" aria-label="Compare">{{ __('Compare') }}</a>
                                 </div>
                              </div>
                           </div>
                           <div class="product-info">
                              <h3 class="product-title"><a href="{{ route('front.product', $item->slug) }}">{{ $item->showName()}}</a></h3>
                              <div class="product-price">
                                 <div class="price">
                                    <ins>{{ $item->showPrice()}}</ins>
                                    <del>{{ $item->showPreviousPrice() }}</del>
                                 </div>
                              </div>
                              <div class="shipping-feed-back">
                                 <div class="star-rating">
                                     <div class="rating-wrap">
                                         <p><i class="fas fa-star"></i><span>  {{ number_format($item->ratings_avg_rating,1) }}</span></p>
                                     </div>
                                     <div class="rating-counts-wrap">
                                         <p>({{ $item->ratings_count }})</p>
                                     </div>
                                 </div>
                             </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  @endforeach
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!--==================== Related Products Section End ====================-->
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
         zoomType: "lens",
         lensShape: "round",
         lensSize: 200,
         cursor: "crosshair",
         galleryActiveClass: 'active',
         imageCrossfade: true,
         borderSize: 2,
         borderColour: "#10b981",
         responsive: true,
         easing: true,
         lensFadeIn: 300,
         lensFadeOut: 300,
         zoomWindowFadeIn: 300,
         zoomWindowFadeOut: 300
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
      $('#gallery_09 .owl-carousel').owlCarousel({
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
                  stagePadding: 0
              },
              576: {
                  items: 3,
                  margin: 10
              },
              768: {
                  items: 3,
                  margin: 12
              },
              992: {
                  items: 4,
                  margin: 12
              },
              1200: {
                  items: 4,
                  margin: 15
              }
          },
          onInitialized: function() {
              console.log('Gallery carousel initialized');
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

</script>
@endsection
