@extends('layouts.front')

@section('css')
<style>
    /* Full height wrapper to push footer to bottom */
    .products-wrapper {
        min-height: calc(100vh - 200px);
        display: flex;
        flex-direction: column;
    }

    /* Product Card Styling - Exact Homepage Match */
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
        text-align: center;
        line-height: 1.3;
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

    .product-price {
        text-align: center;
        margin-bottom: 0;
        margin-top: 4px;
    }

    .price-current {
        color: #28a745;
        font-weight: bold;
        font-size: 15px;
    }

    /* Page Header */
    .page-header-section {
        padding: 60px 0 40px;
        background: #ffffff;
    }

    .page-header-section h1 {
        font-size: 2rem;
        font-weight: 600;
        color: #2d3436;
        margin-bottom: 10px;
    }

    .title-underline {
        width: 60px;
        height: 3px;
        background: #28a745;
        margin: 0 auto;
    }

    .brand-logo-header {
        max-height: 80px;
        object-fit: contain;
        margin-bottom: 15px;
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

<div class="products-wrapper">
<div class="page-header-section">
    <div class="container">
        <div class="text-center">
            @if($brand->image)
            <div class="mb-3">
                <img src="{{ asset('assets/images/brands/' . $brand->image) }}" 
                     alt="{{ $brand->name }}" 
                     class="brand-logo-header">
            </div>
            @endif
            <h1>{{ $brand->name }}</h1>
            <div class="title-underline"></div>
        </div>
    </div>
</div>

<div class="container-fluid py-5" style="background: #ffffff;">
    <div class="container">
        @if($products->count() > 0)
        <div class="row g-4">
            @foreach($products as $product)
            <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                <div class="product-card h-100 shadow-sm">
                    <div class="product-thumb position-relative">
                        <a href="javascript:void(0)" class="d-block">
                            @if($product->image)
                                <img src="{{ asset('assets/images/brand-products/' . $product->image) }}" 
                                     alt="{{ $product->name }}"
                                     class="img-fluid product-image"
                                     loading="lazy">
                            @else
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #f8f9fa;">
                                    <i class="fas fa-box" style="font-size: 48px; color: #dee2e6;"></i>
                                </div>
                            @endif
                        </a>
                    </div>
                    
                    <div class="product-content text-center">
                        <h6 class="product-title mb-2 text-center">
                            <a href="javascript:void(0)">{{ $product->name }}</a>
                        </h6>

                        <div class="product-price text-center">
                            <span class="price-current fw-bold">
                                {{ number_format($product->price, 2) }} JD
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-shopping-basket" style="font-size: 60px; color: #dfe6e9; margin-bottom: 20px;"></i>
            <h3 style="color: #636e72; font-weight: 500; margin-bottom: 10px; font-size: 1.3rem;">
                {{ __('No Products Available') }}
            </h3>
            <p style="color: #b2bec3; margin-bottom: 30px;">
                {{ __('This brand currently has no products') }}
            </p>
            <a href="{{ route('front.brands') }}" 
               class="btn btn-success" 
               style="padding: 12px 30px; border-radius: 4px; font-weight: 500;">
                <i class="fas fa-arrow-left"></i> {{ __('Back to Brands') }}
            </a>
        </div>
        @endif
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