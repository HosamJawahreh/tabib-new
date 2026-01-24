@foreach($products as $product)
<div class="col-lg-2 col-md-3 col-sm-4 col-6 product-item" style="margin-bottom: 0.25rem !important; padding-bottom: 0.25rem !important; padding-left: 0.25rem !important; padding-right: 0.25rem !important;" data-product-id="{{ $product->id }}">
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
                    {{ Str::limit($product->translated_name, 60) }}
                </a>
            </h6>

            <div class="product-price" style="margin-bottom: 0 !important; padding-bottom: 0 !important; text-align: {{ $isArabic ? 'right' : 'left' }}; direction: {{ $isArabic ? 'rtl' : 'ltr' }};">
                @if($product->previous_price && $product->previous_price > $product->price)
                    <span class="price-old text-muted text-decoration-line-through me-2 small" style="margin-bottom: 0 !important; padding-bottom: 0 !important;">
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
