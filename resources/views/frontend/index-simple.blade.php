@extends('layouts.front')

@section('css')
<style>
    /* Product Grid Styles */
    .product-card {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .product-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transform: translateY(-4px);
    }

    .product-thumb {
        overflow: hidden;
        background: #f8f8f8;
        height: 250px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .product-image {
        max-height: 100%;
        width: 100%;
        object-fit: cover;
    }

    .add-to-cart-btn {
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .product-card:hover .add-to-cart-btn {
        opacity: 1;
    }

    .price-current {
        font-size: 1.2rem;
    }

    /* Loading Spinner */
    .spinner-border-custom {
        width: 3rem;
        height: 3rem;
    }

    /* Products Section */
    .products-section {
        padding: 60px 0;
        background: #fff;
    }

    .section-title {
        font-size: 2rem;
        font-weight: 600;
        margin-bottom: 40px;
        text-align: center;
    }
</style>
@endsection

@section('content')
{{-- Header (always visible with cart icon) --}}
@include('partials.global.common-header')

{{-- Slider Section --}}
@if($ps->slider == 1 && count($sliders) > 0)
<section class="home-slider-section">
    <div class="position-relative">
        <div class="home-slider owl-carousel owl-theme">
            @foreach($sliders as $slider)
            <div class="slider-item" style="background: url('{{asset('assets/images/sliders/'.$slider->photo)}}') no-repeat center center / cover; min-height: 400px;">
                <div class="container">
                    <div class="slider-content text-{{ $slider->position ?? 'center' }} d-flex align-items-center" style="min-height: 400px;">
                        <div>
                            @if($slider->subtitle_text)
                            <h5 class="subtitle mb-2">{{ $slider->subtitle_text }}</h5>
                            @endif

                            @if($slider->title_text)
                            <h2 class="title mb-3">{{ $slider->title_text }}</h2>
                            @endif

                            @if($slider->details_text)
                            <p class="details mb-4">{{ $slider->details_text }}</p>
                            @endif

                            @if($slider->link)
                            <a href="{{ $slider->link }}" class="btn btn-primary btn-lg">{{ __('SHOP NOW') }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Products Grid Section with Infinite Scroll --}}
<section class="products-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="section-title">{{ __('All Products') }}</h2>
                <p class="text-center text-muted mb-4">
                    {{ __('Showing') }} {{ $products->count() }} {{ __('of') }} {{ $total_products_count }} {{ __('products') }}
                </p>
            </div>
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
@include('partials.global.footer')
@endsection

@section('scripts')
<script>
    // Infinite Scroll Implementation
    (function($) {
        'use strict';

        let isLoading = false;
        let currentPage = 2;
        let hasMorePages = {{ $products->hasMorePages() ? 'true' : 'false' }};

        function isNearBottom() {
            const scrollTop = $(window).scrollTop();
            const windowHeight = $(window).height();
            const documentHeight = $(document).height();
            const scrollPercentage = ((scrollTop + windowHeight) / documentHeight) * 100;
            return scrollPercentage >= 85;
        }

        function loadMoreProducts() {
            if (isLoading || !hasMorePages) return;

            isLoading = true;
            $('#products-loading').removeClass('d-none');

            $.ajax({
                url: '{{ route("front.products.load") }}',
                method: 'GET',
                data: { page: currentPage },
                dataType: 'json',
                success: function(response) {
                    if (response.html) {
                        $('#products-grid').append(response.html);
                        hasMorePages = response.has_more;
                        currentPage = response.next_page || currentPage;
                        $('#products-loading').addClass('d-none');

                        if (!hasMorePages) {
                            $('#products-end-message').removeClass('d-none');
                        }
                    }
                    isLoading = false;
                },
                error: function(xhr, status, error) {
                    console.error('Error loading products:', error);
                    $('#products-loading').addClass('d-none');
                    $('#products-error').removeClass('d-none');
                    isLoading = false;
                }
            });
        }

        $(window).on('scroll', function() {
            if (isNearBottom() && !isLoading && hasMorePages) {
                loadMoreProducts();
            }
        });

        // Check if initial load doesn't fill page
        setTimeout(function() {
            if ($(document).height() <= $(window).height() && hasMorePages) {
                loadMoreProducts();
            }
        }, 500);

        // Add to Cart Functionality
        $(document).on('click', '.add-to-cart-btn', function(e) {
            e.preventDefault();
            const btn = $(this);
            const productId = btn.data('product-id');
            const productName = btn.data('product-name');
            const productPrice = btn.data('product-price');
            const productImage = btn.data('product-image');

            // Add your cart logic here
            // For now, just show a message
            alert('Product added to cart: ' + productName);

            // You can implement actual cart addition via AJAX here
        });

    })(jQuery);
</script>

{{-- Initialize Slider --}}
<script>
    $(document).ready(function(){
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
            animateIn: 'fadeIn'
        });
    });
</script>
@endsection
