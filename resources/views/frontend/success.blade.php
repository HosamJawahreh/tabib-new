@extends('layouts.front')

@section('content')
@include('partials.global.common-header')

<style>
    .success-page {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        padding: 60px 0;
    }
    
    .success-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.1);
        overflow: hidden;
        animation: slideUp 0.6s ease-out;
    }
    
    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .success-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 50px 30px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    
    .success-header::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: pulse 3s ease-in-out infinite;
    }
    
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }
    
    .success-icon {
        width: 100px;
        height: 100px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        animation: checkmark 0.8s ease-in-out 0.3s both;
        position: relative;
        z-index: 1;
    }
    
    @keyframes checkmark {
        0% {
            transform: scale(0) rotate(-45deg);
        }
        50% {
            transform: scale(1.2) rotate(10deg);
        }
        100% {
            transform: scale(1) rotate(0deg);
        }
    }
    
    .success-icon i {
        font-size: 50px;
        color: #10b981;
    }
    
    .success-title {
        font-size: 32px;
        font-weight: 700;
        color: white;
        margin-bottom: 10px;
        position: relative;
        z-index: 1;
    }
    
    .success-subtitle {
        font-size: 16px;
        color: rgba(255,255,255,0.9);
        margin-bottom: 0;
        position: relative;
        z-index: 1;
    }
    
    .order-info-box {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        border-radius: 15px;
        padding: 30px;
        margin: -30px 30px 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        position: relative;
        z-index: 2;
    }
    
    .order-number {
        background: rgba(255,255,255,0.25);
        backdrop-filter: blur(10px);
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        border: 2px solid rgba(255,255,255,0.3);
    }
    
    .order-number h3 {
        font-size: 18px;
        color: white;
        margin-bottom: 8px;
        font-weight: 600;
    }
    
    .order-number .number {
        font-size: 28px;
        font-weight: 700;
        color: white;
        letter-spacing: 2px;
    }
    
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }
    
    .info-item {
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
        border-radius: 12px;
        padding: 15px;
        border: 1px solid rgba(255,255,255,0.3);
    }
    
    .info-item i {
        font-size: 24px;
        color: white;
        margin-bottom: 8px;
    }
    
    .info-item .label {
        font-size: 12px;
        color: rgba(255,255,255,0.8);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 5px;
    }
    
    .info-item .value {
        font-size: 16px;
        color: white;
        font-weight: 600;
    }
    
    .section-title {
        font-size: 24px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 3px solid #667eea;
        display: inline-block;
    }
    
    .address-card {
        background: #f9fafb;
        border-radius: 15px;
        padding: 25px;
        height: 100%;
        border: 2px solid #e5e7eb;
        transition: all 0.3s ease;
    }
    
    .address-card:hover {
        border-color: #667eea;
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.1);
        transform: translateY(-2px);
    }
    
    .address-card h5 {
        font-size: 18px;
        font-weight: 700;
        color: #667eea;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
    }
    
    .address-card h5 i {
        margin-right: 10px;
        font-size: 22px;
    }
    
    .address-card address {
        margin: 0;
        line-height: 1.8;
        color: #4b5563;
    }
    
    .address-card p {
        margin-bottom: 8px;
        color: #4b5563;
        display: flex;
        align-items: flex-start;
    }
    
    .address-card p strong {
        min-width: 120px;
        color: #1f2937;
    }
    
    .products-table {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    
    .products-table thead {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .products-table thead th {
        color: white;
        font-weight: 600;
        padding: 20px 15px;
        border: none;
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 1px;
    }
    
    .products-table tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .products-table tbody tr:hover {
        background: #f9fafb;
        transform: scale(1.01);
    }
    
    .products-table tbody tr:last-child {
        border-bottom: none;
    }
    
    .products-table tbody td {
        padding: 20px 15px;
        vertical-align: middle;
        color: #4b5563;
    }
    
    .product-name {
        font-weight: 600;
        color: #1f2937;
        font-size: 15px;
    }
    
    .product-details {
        font-size: 14px;
    }
    
    .product-details p {
        margin-bottom: 5px;
    }
    
    .product-details b {
        color: #667eea;
    }
    
    .color-preview {
        width: 25px;
        height: 25px;
        border-radius: 50%;
        display: inline-block;
        border: 3px solid #e5e7eb;
        margin-left: 5px;
        vertical-align: middle;
    }
    
    .price-tag {
        font-size: 16px;
        font-weight: 700;
        color: #10b981;
    }
    
    .discount-badge {
        background: #ef4444;
        color: white;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        margin-left: 5px;
        display: inline-block;
    }
    
    .action-buttons {
        display: flex;
        gap: 15px;
        justify-content: center;
        margin-top: 40px;
        flex-wrap: wrap;
    }
    
    .btn-custom {
        padding: 15px 35px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 16px;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
    }
    
    .btn-primary-custom {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }
    
    .btn-primary-custom:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
        color: white;
    }
    
    .btn-secondary-custom {
        background: white;
        color: #667eea;
        border: 2px solid #667eea;
    }
    
    .btn-secondary-custom:hover {
        background: #667eea;
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
    }
    
    .payment-badge {
        display: inline-block;
        padding: 6px 15px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
    }
    
    .payment-badge.paid {
        background: #d1fae5;
        color: #065f46;
    }
    
    .payment-badge.unpaid {
        background: #fee2e2;
        color: #991b1b;
    }
    
    @media (max-width: 768px) {
        .success-page {
            padding: 30px 0;
        }
        
        .success-title {
            font-size: 24px;
        }
        
        .success-subtitle {
            font-size: 14px;
        }
        
        .order-number .number {
            font-size: 20px;
        }
        
        .info-grid {
            grid-template-columns: 1fr;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .btn-custom {
            width: 100%;
            justify-content: center;
        }
        
        .order-info-box {
            margin: -20px 15px 20px;
            padding: 20px;
        }
        
        .address-card p strong {
            min-width: 90px;
            font-size: 14px;
        }
    }
</style>

<section class="success-page">
    @if(!empty($tempcart))
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-11 col-xl-10">
                
                <div class="success-card">
                    <!-- Success Header -->
                    <div class="success-header">
                        <div class="success-icon">
                            <i class="fas fa-check"></i>
                        </div>
                        <h1 class="success-title">🎉 {{ __('Order Placed Successfully!') }}</h1>
                        <p class="success-subtitle">{{ __("Thank you for your purchase. We'll email you an order confirmation with details and tracking info.") }}</p>
                    </div>
                    
                    <!-- Order Info Box -->
                    <div class="order-info-box">
                        <div class="order-number">
                            <h3>{{ __('Order Number') }}</h3>
                            <div class="number">{{ $order->order_number }}</div>
                        </div>
                        
                        <div class="info-grid">
                            <div class="info-item">
                                <i class="fas fa-calendar-alt"></i>
                                <div class="label">{{ __('Order Date') }}</div>
                                <div class="value">{{ date('d M, Y', strtotime($order->created_at)) }}</div>
                            </div>
                            
                            <div class="info-item">
                                <i class="fas fa-money-bill-wave"></i>
                                <div class="label">{{ __('Total Amount') }}</div>
                                <div class="value">{{ \PriceHelper::showOrderCurrencyPrice((($order->pay_amount + $order->wallet_price) * $order->currency_value), $order->currency_sign) }}</div>
                            </div>
                            
                            <div class="info-item">
                                <i class="fas fa-credit-card"></i>
                                <div class="label">{{ __('Payment Method') }}</div>
                                <div class="value">{{ $order->method }}</div>
                            </div>
                            
                            <div class="info-item">
                                <i class="fas fa-info-circle"></i>
                                <div class="label">{{ __('Payment Status') }}</div>
                                <div class="value">
                                    @if($order->payment_status == 'Pending')
                                        <span class='payment-badge unpaid'>{{ __('Unpaid') }}</span>
                                    @else
                                        <span class='payment-badge paid'>{{ __('Paid') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Content Section -->
                    <div class="px-4 px-md-5 pb-5">
                        
                        @if($order->dp == 0)
                        <!-- Shipping & Billing Address -->
                        <div class="mb-5">
                            <h3 class="section-title">
                                <i class="fas fa-map-marked-alt mr-2"></i>{{ __('Shipping & Billing Information') }}
                            </h3>
                            
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="address-card">
                                        @if($order->shipping == "shipto")
                                            <h5><i class="fas fa-shipping-fast"></i>{{ __('Shipping Address') }}</h5>
                                            <address>
                                                <p><strong>{{ __('Name:') }}</strong> {{ $order->shipping_name == null ? $order->customer_name : $order->shipping_name }}</p>
                                                <p><strong>{{ __('Email:') }}</strong> {{ $order->shipping_email == null ? $order->customer_email : $order->shipping_email }}</p>
                                                <p><strong>{{ __('Phone:') }}</strong> {{ $order->shipping_phone == null ? $order->customer_phone : $order->shipping_phone }}</p>
                                                <p><strong>{{ __('Address:') }}</strong> {{ $order->shipping_address == null ? $order->customer_address : $order->shipping_address }}</p>
                                                <p><strong>{{ __('City & Zip:') }}</strong> {{ $order->shipping_city == null ? $order->customer_city : $order->shipping_city }}-{{ $order->shipping_zip == null ? $order->customer_zip : $order->shipping_zip }}</p>
                                            </address>
                                        @else
                                            <h5><i class="fas fa-store"></i>{{ __('Pickup Location') }}</h5>
                                            <address>
                                                <p><strong>{{ __('Address:') }}</strong> {{ $order->pickup_location }}</p>
                                            </address>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-4">
                                    <div class="address-card">
                                        <h5><i class="fas fa-file-invoice-dollar"></i>{{ __('Billing Address') }}</h5>
                                        <address>
                                            <p><strong>{{ __('Name:') }}</strong> {{ $order->customer_name }}</p>
                                            <p><strong>{{ __('Email:') }}</strong> {{ $order->customer_email }}</p>
                                            <p><strong>{{ __('Phone:') }}</strong> {{ $order->customer_phone }}</p>
                                            <p><strong>{{ __('Address:') }}</strong> {{ $order->customer_address }}</p>
                                            <p><strong>{{ __('City & Zip:') }}</strong> {{ $order->customer_city }}-{{ $order->customer_zip }}</p>
                                        </address>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Payment Details -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="address-card">
                                        <h5><i class="fas fa-receipt"></i>{{ __('Payment Information') }}</h5>
                                        
                                        @if($order->shipping_cost != 0)
                                        <p><strong>{{ $order->shipping_title }}:</strong> {{ \PriceHelper::showOrderCurrencyPrice($order->shipping_cost, $order->currency_sign) }}</p>
                                        @endif
                                        
                                        @if($order->packing_cost != 0)
                                        <p><strong>{{ $order->packing_title }}:</strong> {{ \PriceHelper::showOrderCurrencyPrice($order->packing_cost, $order->currency_sign) }}</p>
                                        @endif
                                        
                                        @if($order->wallet_price != 0)
                                        <p><strong>{{ __('Paid From Wallet:') }}</strong> {{ \PriceHelper::showOrderCurrencyPrice(($order->wallet_price * $order->currency_value), $order->currency_sign) }}</p>
                                        
                                        @if($order->method != "Wallet")
                                        <p><strong>{{ $order->method }}:</strong> {{ \PriceHelper::showOrderCurrencyPrice(($order->pay_amount * $order->currency_value), $order->currency_sign) }}</p>
                                        @endif
                                        @endif
                                        
                                        <p><strong>{{ __('Tax:') }}</strong> {{ \PriceHelper::showOrderCurrencyPrice((($order->tax) / $order->currency_value), $order->currency_sign) }}</p>
                                        
                                        @if($order->method != "Cash On Delivery" && $order->method != "Wallet")
                                            @if($order->method == "Stripe")
                                                <p><strong>{{ $order->method }} {{ __('Charge ID:') }}</strong> {{ $order->charge_id }}</p>
                                            @else
                                                <p><strong>{{ $order->method }} {{ __('Transaction ID:') }}</strong> {{ $order->txnid }}</p>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        <!-- Digital Product Delivery -->
                        <div class="mb-5">
                            <h3 class="section-title">
                                <i class="fas fa-download mr-2"></i>{{ __('Delivery Information') }}
                            </h3>
                            
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="address-card">
                                        <h5><i class="fas fa-user"></i>{{ __('Customer Information') }}</h5>
                                        <address>
                                            <p><strong>{{ __('Name:') }}</strong> {{ $order->customer_name }}</p>
                                            <p><strong>{{ __('Email:') }}</strong> {{ $order->customer_email }}</p>
                                            <p><strong>{{ __('Phone:') }}</strong> {{ $order->customer_phone }}</p>
                                            <p><strong>{{ __('Address:') }}</strong> {{ $order->customer_address }}</p>
                                            <p><strong>{{ __('City & Zip:') }}</strong> {{ $order->customer_city }}-{{ $order->customer_zip }}</p>
                                        </address>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-4">
                                    <div class="address-card">
                                        <h5><i class="fas fa-receipt"></i>{{ __('Payment Details') }}</h5>
                                        <p><strong>{{ __('Payment Status:') }}</strong>
                                            @if($order->payment_status == 'Pending')
                                                <span class='payment-badge unpaid'>{{ __('Unpaid') }}</span>
                                            @else
                                                <span class='payment-badge paid'>{{ __('Paid') }}</span>
                                            @endif
                                        </p>
                                        <p><strong>{{ __('Tax:') }}</strong> {{ \PriceHelper::showOrderCurrencyPrice((($order->tax) / $order->currency_value), $order->currency_sign) }}</p>
                                        <p><strong>{{ __('Paid Amount:') }}</strong> {{ \PriceHelper::showOrderCurrencyPrice((($order->pay_amount + $order->wallet_price) * $order->currency_value), $order->currency_sign) }}</p>
                                        <p><strong>{{ __('Payment Method:') }}</strong> {{ $order->method }}</p>
                                        
                                        @if($order->method != "Cash On Delivery")
                                            @if($order->method == "Stripe")
                                                <p><strong>{{ $order->method }} {{ __('Charge ID:') }}</strong> {{ $order->charge_id }}</p>
                                            @else
                                                <p><strong>{{ $order->method }} {{ __('Transaction ID:') }}</strong> {{ $order->txnid }}</p>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        <!-- Ordered Products -->
                        <div class="mb-5">
                            <h3 class="section-title">
                                <i class="fas fa-shopping-bag mr-2"></i>{{ __('Ordered Products') }}
                            </h3>
                            
                            <div class="table-responsive">
                                <table class="table products-table mb-0">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Product') }}</th>
                                            <th>{{ __('Details') }}</th>
                                            <th>{{ __('Price') }}</th>
                                            <th>{{ __('Total') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($tempcart->items as $product)
                                        <tr>
                                            <td>
                                                <div class="product-name">{{ $product['item']['name'] }}</div>
                                            </td>
                                            <td>
                                                <div class="product-details">
                                                    <p><b>{{ __('Quantity:') }}</b> {{ $product['qty'] }}</p>
                                                    
                                                    @if(!empty($product['size']))
                                                    <p><b>{{ __('Size:') }}</b> {{ $product['item']['measure'] }}{{ str_replace('-', ' ', $product['size']) }}</p>
                                                    @endif
                                                    
                                                    @if(!empty($product['color']))
                                                    <p>
                                                        <b>{{ __('Color:') }}</b>
                                                        <span class="color-preview" style="background-color: #{{ $product['color'] == '' ? 'ffffff' : $product['color'] }};"></span>
                                                    </p>
                                                    @endif
                                                    
                                                    @if(!empty($product['keys']))
                                                        @foreach(array_combine(explode(',', $product['keys']), explode(',', $product['values'])) as $key => $value)
                                                        <p><b>{{ ucwords(str_replace('_', ' ', $key)) }}:</b> {{ $value }}</p>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <span class="price-tag">{{ \PriceHelper::showCurrencyPrice(($product['item_price']) * $order->currency_value) }}</span>
                                            </td>
                                            <td>
                                                <span class="price-tag">{{ \PriceHelper::showCurrencyPrice($product['price'] * $order->currency_value) }}</span>
                                                @if($product['discount'] > 0)
                                                    <span class="discount-badge">{{ $product['discount'] }}% {{ __('Off') }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="action-buttons">
                            <a href="{{ route('front.index') }}" class="btn btn-primary-custom">
                                <i class="fas fa-home"></i>
                                {{ __('Continue Shopping') }}
                            </a>
                            <a href="{{ route('user-orders') }}" class="btn btn-secondary-custom">
                                <i class="fas fa-receipt"></i>
                                {{ __('View My Orders') }}
                            </a>
                        </div>
                        
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    @endif
</section>

@include('partials.global.common-footer')
@endsection

@section('script')

<!-- Facebook Pixel: Track Purchase -->
@if (!empty($seo->facebook_pixel) && isset($order) && isset($tempcart))
<script>
    $(document).ready(function() {
        console.log('✓ Success page loaded - Ready to track purchase');
        
        // Track purchase completion
        if (typeof FacebookPixelTracker !== 'undefined') {
            const orderProducts = [];
            
            @foreach($tempcart->items as $product)
                orderProducts.push({
                    id: '{{ $product['item']['id'] }}',
                    name: '{{ addslashes($product['item']['name']) }}',
                    price: parseFloat('{{ $product['item_price'] }}'),
                    quantity: parseInt('{{ $product['qty'] }}')
                });
            @endforeach
            
            console.log('✓ Order products prepared:', orderProducts);
            
            // Track the purchase
            FacebookPixelTracker.trackPurchase({
                order_number: '{{ $order->order_number }}',
                order_id: {{ $order->id }},
                total: parseFloat('{{ ($order->pay_amount + $order->wallet_price) * $order->currency_value }}'),
                products: orderProducts
            });
            
            console.log('✓ Facebook Pixel: Purchase event fired for order {{ $order->order_number }}');
        } else {
            console.error('✗ FacebookPixelTracker is not defined');
        }
    });
</script>
@else
<script>
    console.log('ℹ Facebook Pixel tracking skipped:', {
        pixelConfigured: {{ !empty($seo->facebook_pixel) ? 'true' : 'false' }},
        orderExists: {{ isset($order) ? 'true' : 'false' }},
        cartExists: {{ isset($tempcart) ? 'true' : 'false' }}
    });
</script>
@endif

@endsection
