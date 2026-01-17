<style>
/* Enhanced Product Page Styles */
.product-images .item a:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 12px rgba(0,0,0,0.15) !important;
}

/* Mobile Image Zoom - Professional Implementation */
@media (max-width: 767px) {
    .product-images {
        position: relative !important;
        overflow: visible !important;
        touch-action: pan-x pan-y pinch-zoom !important;
    }
    
    #single-image-zoom {
        cursor: zoom-in !important;
        user-select: none !important;
        -webkit-user-select: none !important;
        -webkit-touch-callout: none !important;
    }
    
    /* Fullscreen image viewer for mobile */
    .mobile-image-viewer {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.95);
        z-index: 99999;
        overflow: hidden;
        touch-action: none;
    }
    
    .mobile-image-viewer.active {
        display: block;
    }
    
    .mobile-image-viewer img {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        max-width: none;
        width: auto;
        height: auto;
        transition: none;
        user-select: none;
        -webkit-user-select: none;
    }
    
    .mobile-viewer-close {
        position: absolute;
        top: 20px;
        right: 20px;
        width: 44px;
        height: 44px;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 100000;
        box-shadow: 0 2px 10px rgba(0,0,0,0.3);
        font-size: 24px;
        color: #333;
        font-weight: bold;
        line-height: 1;
    }
    
    .mobile-viewer-hint {
        position: absolute;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(255, 255, 255, 0.9);
        padding: 10px 20px;
        border-radius: 20px;
        color: #333;
        font-size: 14px;
        pointer-events: none;
        opacity: 0;
        animation: fadeInOut 3s ease-in-out;
    }
    
    @keyframes fadeInOut {
        0%, 100% { opacity: 0; }
        10%, 90% { opacity: 1; }
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

@media (max-width: 768px) {
    .product-images {
        position: relative !important;
        top: 0 !important;
    }

    .add-to-cart-btn,
    .buy-now-btn,
    .contact-seller-btn {
        padding: 14px 24px !important;
        font-size: 1rem !important;
        min-height: 48px;
    }
}
</style>

<div class="full-row pb-0">
  <div class="container">
      <div class="row single-product-wrapper">
          <div class="col-md-6 mb-4">
              <div class="product-images overflow-hidden position-sticky" style="top: 20px;">
                  <div class="images-inner">
                      <div class="woocommerce-product-gallery woocommerce-product-gallery--with-images woocommerce-product-gallery--columns-4 images" data-columns="4" style="opacity: 1; transition: opacity 0.25s ease-in-out 0s;">
                          <figure class="woocommerce-product-gallery__wrapper">
                              <div class="bg-light rounded shadow-sm p-3 mb-4">
                                  <img id="single-image-zoom" src="{{filter_var($productt->photo, FILTER_VALIDATE_URL) ?$productt->photo:asset('assets/images/products/'.$productt->photo)}}" alt="Thumb Image" data-zoom-image="{{filter_var($productt->photo, FILTER_VALIDATE_URL) ?$productt->photo:asset('assets/images/products/'.$productt->photo)}}" style="border-radius: 8px; width: 100%; height: auto;" />
                              </div>

                              <div id="gallery_09" class="product-slide-thumb">
                                  <div class="owl-carousel three-carousel dot-disable nav-arrow-middle">
                                      {{-- Main Product Image --}}
                                      <div class="item px-2">
                                          <a class="active d-block rounded overflow-hidden shadow-sm" href="{{filter_var($productt->photo, FILTER_VALIDATE_URL) ?$productt->photo:asset('assets/images/products/'.$productt->photo)}}" data-image="{{filter_var($productt->photo, FILTER_VALIDATE_URL) ?$productt->photo:asset('assets/images/products/'.$productt->photo)}}" data-zoom-image="{{filter_var($productt->photo, FILTER_VALIDATE_URL) ?$productt->photo:asset('assets/images/products/'.$productt->photo)}}" style="transition: transform 0.3s ease, box-shadow 0.3s ease;">
                                              <img src="{{filter_var($productt->photo, FILTER_VALIDATE_URL) ?$productt->photo:asset('assets/images/products/'.$productt->photo)}}" alt="Main Product Image" style="height: 160px; object-fit: cover; width: 100%; border-radius: 6px;" />
                                          </a>
                                      </div>
                                      {{-- Gallery Images --}}
                                      @foreach($productt->galleries as $gal)
                                      <div class="item px-2">
                                          <a class="d-block rounded overflow-hidden shadow-sm" href="{{asset('assets/images/galleries/'.$gal->photo)}}" data-image="{{asset('assets/images/galleries/'.$gal->photo)}}" data-zoom-image="{{asset('assets/images/galleries/'.$gal->photo)}}" style="transition: transform 0.3s ease, box-shadow 0.3s ease;">
                                              <img src="{{asset('assets/images/galleries/'.$gal->photo)}}" alt="Thumb Image" style="height: 160px; object-fit: cover; width: 100%; border-radius: 6px;" />
                                          </a>
                                      </div>
                                      @endforeach
                                  </div>
                              </div>
                          </figure>
                      </div>
                  </div>
                  
                  {{-- Mobile Image Viewer with Pinch Zoom --}}
                  <div class="mobile-image-viewer" id="mobileImageViewer">
                      <div class="mobile-viewer-close" id="closeViewer">&times;</div>
                      <img id="viewerImage" src="" alt="Product Image" />
                      <div class="mobile-viewer-hint">Pinch to zoom • Drag to pan</div>
                  </div>
              </div>
              
              <script>
              // Professional Mobile Image Zoom Implementation
              (function() {
                  if (window.innerWidth <= 767) {
                      const mainImage = document.getElementById('single-image-zoom');
                      const viewer = document.getElementById('mobileImageViewer');
                      const viewerImage = document.getElementById('viewerImage');
                      const closeBtn = document.getElementById('closeViewer');
                      
                      let scale = 1;
                      let posX = 0;
                      let posY = 0;
                      let lastDistance = 0;
                      let lastPosX = 0;
                      let lastPosY = 0;
                      let isDragging = false;
                      
                      // Open viewer on image tap
                      mainImage.addEventListener('click', function(e) {
                          e.preventDefault();
                          const imgSrc = this.getAttribute('data-zoom-image') || this.src;
                          viewerImage.src = imgSrc;
                          viewer.classList.add('active');
                          document.body.style.overflow = 'hidden';
                          resetTransform();
                      });
                      
                      // Gallery thumbnails tap
                      document.querySelectorAll('#gallery_09 a').forEach(function(thumb) {
                          thumb.addEventListener('click', function(e) {
                              e.preventDefault();
                              const imgSrc = this.getAttribute('data-zoom-image') || this.getAttribute('href');
                              mainImage.src = imgSrc;
                              mainImage.setAttribute('data-zoom-image', imgSrc);
                          });
                      });
                      
                      // Close viewer
                      closeBtn.addEventListener('click', function() {
                          viewer.classList.remove('active');
                          document.body.style.overflow = '';
                      });
                      
                      viewer.addEventListener('click', function(e) {
                          if (e.target === viewer) {
                              viewer.classList.remove('active');
                              document.body.style.overflow = '';
                          }
                      });
                      
                      // Reset transform
                      function resetTransform() {
                          scale = 1;
                          posX = 0;
                          posY = 0;
                          updateTransform();
                      }
                      
                      // Update image transform
                      function updateTransform() {
                          viewerImage.style.transform = `translate(-50%, -50%) translate(${posX}px, ${posY}px) scale(${scale})`;
                      }
                      
                      // Get distance between two touch points
                      function getDistance(touch1, touch2) {
                          const dx = touch1.clientX - touch2.clientX;
                          const dy = touch1.clientY - touch2.clientY;
                          return Math.sqrt(dx * dx + dy * dy);
                      }
                      
                      // Touch start
                      viewerImage.addEventListener('touchstart', function(e) {
                          if (e.touches.length === 2) {
                              // Pinch zoom start
                              lastDistance = getDistance(e.touches[0], e.touches[1]);
                          } else if (e.touches.length === 1) {
                              // Drag start
                              isDragging = true;
                              lastPosX = e.touches[0].clientX;
                              lastPosY = e.touches[0].clientY;
                          }
                      });
                      
                      // Touch move
                      viewerImage.addEventListener('touchmove', function(e) {
                          e.preventDefault();
                          
                          if (e.touches.length === 2) {
                              // Pinch zoom
                              const distance = getDistance(e.touches[0], e.touches[1]);
                              const delta = distance - lastDistance;
                              scale += delta * 0.01;
                              scale = Math.max(1, Math.min(scale, 5)); // Limit zoom between 1x and 5x
                              lastDistance = distance;
                              updateTransform();
                          } else if (e.touches.length === 1 && isDragging && scale > 1) {
                              // Drag to pan (only when zoomed in)
                              const deltaX = e.touches[0].clientX - lastPosX;
                              const deltaY = e.touches[0].clientY - lastPosY;
                              posX += deltaX;
                              posY += deltaY;
                              
                              // Constrain panning
                              const maxPanX = (viewerImage.width * scale - window.innerWidth) / 2;
                              const maxPanY = (viewerImage.height * scale - window.innerHeight) / 2;
                              posX = Math.max(-maxPanX, Math.min(posX, maxPanX));
                              posY = Math.max(-maxPanY, Math.min(posY, maxPanY));
                              
                              lastPosX = e.touches[0].clientX;
                              lastPosY = e.touches[0].clientY;
                              updateTransform();
                          }
                      });
                      
                      // Touch end
                      viewerImage.addEventListener('touchend', function(e) {
                          if (e.touches.length < 2) {
                              lastDistance = 0;
                          }
                          if (e.touches.length === 0) {
                              isDragging = false;
                              
                              // Reset if zoomed out beyond 1x
                              if (scale < 1) {
                                  scale = 1;
                                  posX = 0;
                                  posY = 0;
                                  updateTransform();
                              }
                          }
                      });
                      
                      // Double tap to zoom
                      let lastTap = 0;
                      viewerImage.addEventListener('touchend', function(e) {
                          const currentTime = new Date().getTime();
                          const tapLength = currentTime - lastTap;
                          if (tapLength < 300 && tapLength > 0) {
                              // Double tap detected
                              if (scale === 1) {
                                  scale = 2.5;
                              } else {
                                  scale = 1;
                                  posX = 0;
                                  posY = 0;
                              }
                              updateTransform();
                          }
                          lastTap = currentTime;
                      });
                  }
              })();
              </script>
          </div>

          <div class="col-md-6">
              <div class="summary entry-summary">
                  <div class="summary-inner">
                      <div class="entry-breadcrumbs w-100 mb-3">
                          <nav class="breadcrumb-divider-slash" aria-label="breadcrumb">
                              <ol class="breadcrumb pro-bread mb-0" style="background: transparent; padding: 0;">
                                  <li class="breadcrumb-item"><a href="{{route('front.index')}}" class="text-muted">{{__('Home')}}</a></li>
                                  <li class="breadcrumb-item"><a href="{{route('front.category',$productt->category->slug)}}" class="text-muted">{{$productt->category->translated_name}}</a></li>
                                  @if($productt->subcategory_id != null)
                                  <li class="breadcrumb-item">
                                      <a href="{{ route('front.category',[$productt->category->slug, $productt->subcategory->slug]) }}" class="text-muted">
                                      {{$productt->subcategory->translated_name}}
                                      </a>
                                  </li>
                                  @endif
                                  @if($productt->childcategory_id != null)
                                  <li class="breadcrumb-item">
                                      <a href="{{ route('front.category',[ $productt->category->slug,$productt->subcategory->slug,$productt->childcategory->slug]) }}" class="text-muted">
                                      {{$productt->childcategory->translated_name}}
                                      </a>
                                  </li>
                                  @endif

                              </ol>
                          </nav>
                      </div>
                      <h1 class="product_title entry-title mb-3" style="font-size: 2rem; font-weight: 700; color: #2d3748;">{{ $productt->translated_name }}</h1>

                      {{-- Rating Section - Only show if ratings exist --}}
                      @php
                          $ratingCount = App\Models\Rating::ratingCount($productt->id);
                          $ratingValue = App\Models\Rating::ratings($productt->id);
                      @endphp
                      @if($ratingCount > 0)
                      <div class="d-flex align-items-center mb-3 flex-wrap gap-3">
                          <div class="woocommerce-product-rating">
                              <div class="fancy-star-rating">
                                  <div class="rating-wrap d-flex align-items-center">
                                      <span class="fancy-rating good me-2" style="font-size: 1.1rem; color: #f59e0b;">{{ $ratingValue }} ★</span>
                                      <span class="text-muted" style="font-size: 0.9rem;">({{ $ratingCount }} {{ __('ratings') }})</span>
                                  </div>
                              </div>
                          </div>
                      </div>
                      @endif

                      <div class="price-section mb-4 p-3 bg-light rounded shadow-sm">
                          <div class="d-flex align-items-center flex-wrap gap-2">
                              <span class="current-price" style="font-size: 2rem; font-weight: 700; color: #10b981;">
                                  <span id="sizeprice">{{ $productt->showPrice() }}</span>
                              </span>
                              @if($productt->showPreviousPrice())
                              <del class="old-price" style="font-size: 1.2rem; color: #9ca3af;">{{ $productt->showPreviousPrice() }}</del>
                              @endif
                              @if($productt->offPercentage())
                              <span class="badge bg-danger" style="font-size: 1rem; padding: 0.5rem 1rem;">{{ round((float)$productt->offPercentage() )}}% OFF</span>
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
                         <div class="d-flex flex-wrap align-items-center gap-3 mt-4">
                            @if($productt->product_type != "affiliate" && $productt->type == 'Physical')
                               <div class="qty-selector border rounded d-flex align-items-center" style="background: #ffffff; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                  <button type="button" class="qtminus btn btn-light border-0 px-3 py-2" style="font-size: 1.2rem;">
                                     <i class="icofont-minus"></i>
                                  </button>
                                  <input class="qttotal form-control border-0 text-center" type="text" id="order-qty" value="{{ $productt->minimum_qty == null ? '1' : (int)$productt->minimum_qty }}" style="width: 70px; font-weight: 600;">
                                  <input type="hidden" id="affilate_user" value="{{ $affilate_user }}">
                                  <input type="hidden" id="product_minimum_qty" value="{{ $productt->minimum_qty == null ? '0' : $productt->minimum_qty }}">
                                  <button type="button" class="qtplus btn btn-light border-0 px-3 py-2" style="font-size: 1.2rem;">
                                     <i class="icofont-plus"></i>
                                  </button>
                               </div>
                          @endif


                          {{-- PRODUCT QUANTITY SECTION ENDS --}}
                          <div class="action-buttons d-flex flex-wrap gap-3 flex-grow-1">
                          @if($productt->product_type == "affiliate")

                              <a href="javascript:;" class="btn btn-primary affilate-btn add-to-cart-btn" data-href="{{ $productt->affiliate_link }}" target="_blank">
                                  <i class="icofont-cart me-2"></i>
                                  <span>{{ __('Buy Now') }}</span>
                              </a>
                              @else
                              @if($productt->emptyStock())
                              <a href="javascript:;" class="btn btn-secondary cart-out-of-stock add-to-cart-btn" style="cursor: not-allowed;">
                                  <i class="icofont-close-line me-2"></i>
                                  <span>{{ __('Out Of Stock') }}</span>
                              </a>
                              @else
                              @if ($productt->type != "Listing")
                                <button type="button" id="addcrt" class="btn btn-outline-primary add-to-cart-btn flex-grow-1">
                                    <i class="icofont-cart me-2"></i>
                                    <span>{{ __('Add to Cart')}}</span>
                                    <span class="btn-loader" style="display: none;">
                                        <i class="icofont-spinner icofont-spin"></i>
                                    </span>
                                </button>

                                <button type="button" id="qaddcrt" class="btn btn-primary buy-now-btn flex-grow-1">
                                    <i class="icofont-check-circled me-2"></i>
                                    <span>{{ __('Buy Now') }}</span>
                                    <span class="btn-loader" style="display: none;">
                                        <i class="icofont-spinner icofont-spin"></i>
                                    </span>
                                </button>
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
                   </div>


                       <div class="my-5 pt-4 border-top">
                              <h5 class="mb-3" style="font-weight: 600; color: #374151;">{{ __('Share This Product') }}</h5>
                              <div class="social-linkss social-sharing a2a_kit a2a_kit_size_32">
                              <ul class="social-icons d-flex flex-wrap gap-2 list-unstyled mb-0">
                                  <li>
                                  <a class="facebook a2a_button_facebook d-flex align-items-center justify-content-center rounded-circle" href="" style="width: 45px; height: 45px; background: #1877f2; color: white; transition: all 0.3s ease;">
                                      <i class="fab fa-facebook-f"></i>
                                  </a>
                                  </li>
                                  <li>
                                  <a class="twitter a2a_button_twitter d-flex align-items-center justify-content-center rounded-circle" href="" style="width: 45px; height: 45px; background: #1da1f2; color: white; transition: all 0.3s ease;">
                                      <i class="fab fa-twitter"></i>
                                  </a>
                                  </li>
                                  <li>
                                  <a class="linkedin a2a_button_linkedin d-flex align-items-center justify-content-center rounded-circle" href="" style="width: 45px; height: 45px; background: #0077b5; color: white; transition: all 0.3s ease;">
                                      <i class="fab fa-linkedin-in"></i>
                                  </a>
                                  </li>
                                  <li>
                                  <a class="pinterest a2a_button_pinterest d-flex align-items-center justify-content-center rounded-circle" href="" style="width: 45px; height: 45px; background: #e60023; color: white; transition: all 0.3s ease;">
                                      <i class="fab fa-pinterest-p"></i>
                                  </a>
                                  </li>
                                  <li>
                                      <a class="instagram a2a_button_whatsapp d-flex align-items-center justify-content-center rounded-circle" href="" style="width: 45px; height: 45px; background: #25d366; color: white; transition: all 0.3s ease;">
                                      <i class="fab fa-whatsapp"></i>
                                      </a>
                                  </li>
                              </ul>
                              </div>

                          </div>
                          <script async src="https://static.addtoany.com/menu/page.js"></script>

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


