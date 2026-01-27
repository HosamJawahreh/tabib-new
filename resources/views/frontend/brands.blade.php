@extends('layouts.front')

@section('css')
<style>
    /* Full height wrapper to push footer to bottom */
    .brands-wrapper {
        min-height: calc(100vh - 200px);
        display: flex;
        flex-direction: column;
    }

    /* Responsive Padding */
    .brands-container {
        padding-top: 60px !important;
        padding-bottom: 60px !important;
    }

    @media (max-width: 768px) {
        .brands-container {
            padding-top: 30px !important;
            padding-bottom: 30px !important;
        }
    }

    /* Product Card Styling - Matching Homepage */
    .product-card {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        transition: all 0.3s ease;
        overflow: visible !important;
        position: relative;
    }

    .product-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transform: translateY(-2px);
        border-color: #d0d0d0;
    }

    .product-thumb {
        position: relative;
        background: #fff;
        min-height: 200px;
        max-height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        padding: 15px;
    }
    
    /* Mobile adjustments */
    @media (max-width: 768px) {
        .product-thumb {
            min-height: 160px;
            max-height: 160px;
            padding: 12px;
        }
    }

    .product-thumb a {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        overflow: visible !important;
        text-align: center;
    }

    .product-image {
        max-width: 90%;
        max-height: 90%;
        object-fit: contain;
        transform: scale(0.98);
        transition: transform 0.3s ease;
        margin: 0 auto;
        display: block;
    }

    .product-card:hover .product-image {
        transform: scale(1.02);
    }

    .product-content {
        padding: 12px;
        text-align: center;
    }

    .product-title {
        font-size: 13px;
        font-weight: 500;
        color: #333;
        margin-bottom: 6px;
        min-height: 36px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 1.3;
        text-align: center;
        margin-left: auto;
        margin-right: auto;
    }

    .product-title a {
        color: #333;
        text-decoration: none;
    }

    .product-title a:hover {
        color: #28a745;
    }

    /* RTL Support */
    [dir="rtl"] .product-title {
        text-align: center;
    }
</style>
@endsection

@section('content')
{{-- Header --}}
@include('partials.global.common-header')

<div class="brands-wrapper">
<div class="container-fluid brands-container" style="background: #ffffff;">
    <div class="container">
        <div class="row g-4">
            @forelse($brands as $brand)
            <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                <a href="{{ route('front.brand.products', $brand->id) }}" class="text-decoration-none">
                    <div class="product-card h-100 shadow-sm">
                        <div class="product-thumb position-relative">
                            @if($brand->image)
                                <img src="{{ asset('assets/images/brands/' . $brand->image) }}" 
                                     alt="{{ app()->getLocale() == 'en' && $brand->name_en ? $brand->name_en : $brand->name }}"
                                     class="img-fluid product-image">
                            @else
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #f8f9fa;">
                                    <i class="fas fa-image" style="font-size: 48px; color: #dee2e6;"></i>
                                </div>
                            @endif
                        </div>
                        
                        <div class="product-content text-center">
                            <h6 class="product-title text-center">
                                <span>{{ app()->getLocale() == 'en' && $brand->name_en ? $brand->name_en : $brand->name }}</span>
                            </h6>
                        </div>
                    </div>
                </a>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info text-center" role="alert">
                    {{ __('No brands available at the moment.') }}
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>
</div>

{{-- Footer --}}
@include('partials.global.common-footer')

{{-- Scroll to Top Button --}}
<button class="scroll-to-top" id="scrollToTop">
    <i class="icofont-arrow-up"></i>
</button>

@endsection