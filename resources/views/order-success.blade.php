@extends('layouts.front')

@section('content')

<style>
    .order-success-page {
        padding: 60px 0;
        background: #f8f9fa;
    }
    
    .success-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 30px rgba(0, 0, 0, 0.1);
        padding: 40px;
        margin-bottom: 30px;
        animation: slideUp 0.5s ease-out;
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
        text-align: center;
        padding: 30px 0;
        border-bottom: 2px solid #f0f0f0;
        margin-bottom: 30px;
    }

    .success-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        animation: scaleIn 0.5s ease-out;
    }

    @keyframes scaleIn {
        from {
            transform: scale(0);
        }
        to {
            transform: scale(1);
        }
    }

    .success-icon i {
        font-size: 40px;
        color: white;
    }

    .success-title {
        font-size: 32px;
        font-weight: 700;
        color: #333;
        margin-bottom: 10px;
    }

    .success-subtitle {
        font-size: 16px;
        color: #666;
    }

    .order-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .info-box {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        border-left: 4px solid #28a745;
    }

    .info-label {
        font-size: 13px;
        color: #666;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 8px;
    }

    .info-value {
        font-size: 18px;
        color: #333;
        font-weight: 600;
    }

    .order-number-highlight {
        color: #28a745;
        font-size: 24px;
    }

    .section-title {
        font-size: 20px;
        font-weight: 700;
        color: #333;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #f0f0f0;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        padding: 15px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-label {
        font-weight: 600;
        color: #666;
    }

    .detail-value {
        color: #333;
        font-weight: 500;
        text-align: right;
    }

    .cart-items-section {
        margin-top: 30px;
    }

    .cart-item {
        display: flex;
        align-items: center;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 10px;
        margin-bottom: 15px;
    }

    .item-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        margin-right: 20px;
    }

    .item-details {
        flex: 1;
    }

    .item-name {
        font-size: 16px;
        font-weight: 600;
        color: #333;
        margin-bottom: 5px;
    }

    .item-meta {
        font-size: 14px;
        color: #666;
    }

    .item-price {
        font-size: 18px;
        font-weight: 700;
        color: #28a745;
    }

    .total-section {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        padding: 25px;
        border-radius: 10px;
        margin-top: 20px;
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .total-label {
        font-size: 16px;
        font-weight: 500;
    }

    .total-value {
        font-size: 16px;
        font-weight: 600;
    }

    .grand-total {
        font-size: 24px !important;
        font-weight: 700 !important;
        padding-top: 15px;
        border-top: 2px solid rgba(255, 255, 255, 0.3);
        margin-top: 10px;
    }

    .action-buttons {
        display: flex;
        gap: 15px;
        margin-top: 30px;
    }

    .btn-primary-custom {
        flex: 1;
        padding: 15px 30px;
        border: none;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }

    .btn-continue {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
    }

    .btn-continue:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(40, 167, 69, 0.4);
        color: white;
    }

    .btn-view-order {
        background: white;
        color: #28a745;
        border: 2px solid #28a745;
    }

    .btn-view-order:hover {
        background: #28a745;
        color: white;
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        .order-info-grid {
            grid-template-columns: 1fr;
        }

        .action-buttons {
            flex-direction: column;
        }

        .cart-item {
            flex-direction: column;
            text-align: center;
        }

        .item-image {
            margin-right: 0;
            margin-bottom: 15px;
        }
    }
</style>

<div class="order-success-page">
    <div class="container">
        <div class="success-card">
            <!-- Success Header -->
            <div class="success-header">
                <div class="success-icon">
                    <i class="fas fa-check"></i>
                </div>
                <h1 class="success-title">🎉 Order Placed Successfully!</h1>
                <p class="success-subtitle">Thank you for your order. We'll process it shortly.</p>
                
                @if($order->shipping_cost > 0)
                <div style="background: #e7f5ec; border-left: 4px solid #28a745; padding: 15px 20px; border-radius: 8px; margin-top: 20px; text-align: left;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-info-circle" style="color: #28a745; font-size: 20px;"></i>
                        <div>
                            <strong style="color: #28a745; font-size: 15px;">Shipping Information</strong>
                            <p style="margin: 5px 0 0 0; color: #666; font-size: 14px;">
                                Shipping cost of <strong>{{ $order->currency_sign }}{{ number_format($order->shipping_cost, 2) }}</strong> 
                                has been added to your order total.
                                @if($order->shipping == 'pickup')
                                    You can pick up your order from the selected location.
                                @else
                                    Your order will be delivered to your address.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                @else
                <div style="background: #e7f5ec; border-left: 4px solid #28a745; padding: 15px 20px; border-radius: 8px; margin-top: 20px; text-align: left;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-shipping-fast" style="color: #28a745; font-size: 20px;"></i>
                        <div>
                            <strong style="color: #28a745; font-size: 15px;">🎁 Free Shipping!</strong>
                            <p style="margin: 5px 0 0 0; color: #666; font-size: 14px;">
                                Congratulations! You got free shipping on this order.
                            </p>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Order Information Grid -->
            <div class="order-info-grid">
                <div class="info-box">
                    <div class="info-label">Order Number</div>
                    <div class="info-value order-number-highlight">{{ $order->order_number }}</div>
                </div>

                <div class="info-box">
                    <div class="info-label">Customer Name</div>
                    <div class="info-value">{{ $order->customer_name }}</div>
                </div>

                <div class="info-box">
                    <div class="info-label">Phone</div>
                    <div class="info-value">{{ $order->customer_phone }}</div>
                </div>

                <div class="info-box">
                    <div class="info-label">Payment Method</div>
                    <div class="info-value">{{ $order->method }}</div>
                </div>

                <div class="info-box">
                    <div class="info-label">Order Status</div>
                    <div class="info-value">
                        <span class="badge badge-warning" style="color: #856404; background-color: #fff3cd; padding: 5px 15px; border-radius: 20px; font-weight: 600;">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Order Items Section -->
            <div class="cart-items-section">
                <div class="section-title">Order Items</div>
                
                @php
                    $cartItems = json_decode($order->cart, true);
                @endphp

                @if($cartItems && is_array($cartItems))
                    @foreach($cartItems as $key => $item)
                    <div class="cart-item">
                        @if(isset($item['item']['photo']))
                        <img src="{{ asset('assets/images/products/'.$item['item']['photo']) }}" 
                             alt="{{ $item['item']['name'] ?? 'Product' }}" 
                             class="item-image">
                        @else
                        <div class="item-image" style="background: #f0f0f0; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-image" style="font-size: 30px; color: #ccc;"></i>
                        </div>
                        @endif

                        <div class="item-details">
                            <div class="item-name">{{ $item['item']['name'] ?? 'Product' }}</div>
                            <div class="item-meta">
                                Qty: {{ $item['qty'] ?? 1 }}
                                @if(isset($item['size']) && $item['size'])
                                 | Size: {{ $item['size'] }}
                                @endif
                                @if(isset($item['color']) && $item['color'])
                                 | Color: {{ $item['color'] }}
                                @endif
                            </div>
                        </div>

                        <div class="item-price">
                            {{ $order->currency_sign }}{{ number_format($item['price'] * $item['qty'], 2) }}
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>

            <!-- Order Summary Section -->
            <div class="section-title" style="margin-top: 30px;">Order Summary</div>
            
            <div class="order-details" style="background: white; border: 2px solid #f0f0f0;">
                @php
                    $cartItems = json_decode($order->cart, true);
                    $itemsSubtotal = 0;
                    if($cartItems && is_array($cartItems)) {
                        foreach($cartItems as $item) {
                            $itemsSubtotal += ($item['price'] ?? 0) * ($item['qty'] ?? 1);
                        }
                    }
                @endphp

                <div class="detail-row">
                    <span class="detail-label">Items Subtotal:</span>
                    <span class="detail-value">{{ $order->currency_sign }}{{ number_format($itemsSubtotal, 2) }}</span>
                </div>

                @if($order->shipping_cost > 0)
                <div class="detail-row">
                    <span class="detail-label">
                        <i class="fas fa-shipping-fast" style="color: #28a745; margin-right: 5px;"></i>
                        Shipping Cost:
                    </span>
                    <span class="detail-value" style="color: #28a745; font-weight: 700;">
                        {{ $order->currency_sign }}{{ number_format($order->shipping_cost, 2) }}
                    </span>
                </div>
                @else
                <div class="detail-row">
                    <span class="detail-label">
                        <i class="fas fa-shipping-fast" style="color: #28a745; margin-right: 5px;"></i>
                        Shipping Cost:
                    </span>
                    <span class="detail-value" style="color: #28a745; font-weight: 700;">
                        FREE
                    </span>
                </div>
                @endif

                @if($order->packing_cost > 0)
                <div class="detail-row">
                    <span class="detail-label">
                        <i class="fas fa-box" style="color: #6c757d; margin-right: 5px;"></i>
                        Packing Cost:
                    </span>
                    <span class="detail-value">{{ $order->currency_sign }}{{ number_format($order->packing_cost, 2) }}</span>
                </div>
                @endif

                @if($order->tax > 0)
                <div class="detail-row">
                    <span class="detail-label">
                        <i class="fas fa-receipt" style="color: #6c757d; margin-right: 5px;"></i>
                        Tax:
                    </span>
                    <span class="detail-value">{{ $order->currency_sign }}{{ number_format($order->tax, 2) }}</span>
                </div>
                @endif

                @if($order->coupon_discount > 0)
                <div class="detail-row">
                    <span class="detail-label" style="color: #dc3545;">
                        <i class="fas fa-tag" style="margin-right: 5px;"></i>
                        Coupon Discount:
                    </span>
                    <span class="detail-value" style="color: #dc3545; font-weight: 700;">
                        -{{ $order->currency_sign }}{{ number_format($order->coupon_discount, 2) }}
                    </span>
                </div>
                @endif

                <div class="detail-row" style="border-top: 3px solid #28a745; padding-top: 20px; margin-top: 15px;">
                    <span class="detail-label" style="font-size: 20px; font-weight: 700; color: #333;">
                        <i class="fas fa-money-bill-wave" style="color: #28a745; margin-right: 8px;"></i>
                        Total Amount:
                    </span>
                    <span class="detail-value" style="font-size: 24px; font-weight: 700; color: #28a745;">
                        {{ $order->currency_sign }}{{ number_format($order->pay_amount, 2) }}
                    </span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="{{ route('front.index') }}" class="btn-primary-custom btn-continue">
                    <i class="fas fa-shopping-bag"></i> Continue Shopping
                </a>
                <a href="{{ route('user-orders') }}" class="btn-primary-custom btn-view-order">
                    <i class="fas fa-list"></i> View Order Details
                </a>
            </div>

            <!-- Footer Note -->
            <div style="background: #f8f9fa; padding: 20px; border-radius: 10px; margin-top: 30px; border: 1px solid #e0e0e0;">
                <div style="display: flex; align-items: start; gap: 15px;">
                    <i class="fas fa-envelope" style="color: #28a745; font-size: 24px; margin-top: 3px;"></i>
                    <div style="flex: 1;">
                        <h4 style="margin: 0 0 10px 0; color: #333; font-size: 16px; font-weight: 700;">
                            📧 Order Confirmation Email
                        </h4>
                        <p style="margin: 0; color: #666; font-size: 14px; line-height: 1.6;">
                            A confirmation email with your order details has been sent to <strong>{{ $order->customer_email }}</strong>. 
                            You can track your order status in the "My Orders" section.
                        </p>
                        
                        @if($order->method == 'Cash on Delivery' || $order->method == 'Cash On Delivery')
                        <div style="margin-top: 15px; padding: 12px; background: #fff3cd; border-left: 3px solid #ffc107; border-radius: 5px;">
                            <p style="margin: 0; color: #856404; font-size: 13px;">
                                <i class="fas fa-money-bill-wave" style="margin-right: 5px;"></i>
                                <strong>Payment Method:</strong> Cash on Delivery - Please have the exact amount ready when receiving your order.
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
    <div class="success-container">
