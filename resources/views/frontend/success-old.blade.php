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
        min-width: 100px;
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
    
    .products-table tbody td {
        padding: 20px 15px;
        vertical-align: middle;
        color: #4b5563;
    }
    
    .product-name {
        font-weight: 600;
        color: #1f2937;
    }
    
    .product-details {
        font-size: 14px;
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
        .success-title {
            font-size: 24px;
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
    }
</style>

<section class="success-page">

    @if(!empty($tempcart))

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Starting of Dashboard data-table area -->
                <div class="content-box section-padding add-product-1">
                    <div class="top-area">
                        <div class="content order-de">
                            <h4 class="heading">
                                {{ __('THANK YOU FOR YOUR PURCHASE.') }}
                            </h4>
                            <p class="text">
                                {{ __("We'll email you an order confirmation with details and tracking info.") }}
                            </p>
                            <a href="{{ route('front.index') }}" class="link">{{ __('Get Back To Our Homepage') }}</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">

                            <div class="product__header">
                                <div class="row reorder-xs">
                                    <div class="col-lg-12">
                                        <div class="product-header-title">
                                            <h4>{{ __('Order#') }} {{$order->order_number}}</h4>
                                        </div>
                                    </div>
                                    @include('alerts.form-success')
                                    <div class="col-md-12" id="tempview">
                                        <div class="dashboard-content">
                                            <div class="view-order-page" id="print">
                                                <p class="order-date">{{ __('Order Date') }}
                                                    {{date('d-M-Y',strtotime($order->created_at))}}</p>


                                                @if($order->dp == 1)

                                                <div class="billing-add-area">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h5>{{ __('Shipping Address') }}</h5>
                                                            <address>
                                                                {{ __('Name:') }} {{$order->customer_name}}<br>
                                                                {{ __('Email:') }} {{$order->customer_email}}<br>
                                                                {{ __('Phone:') }} {{$order->customer_phone}}<br>
                                                                {{ __('Address:') }} {{$order->customer_address}}<br>
                                                                {{$order->customer_city}}-{{$order->customer_zip}}
                                                            </address>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h5>{{ __('Shipping Method') }}</h5>

                                                            <p>{{ __('Payment Status') }}
                                                                @if($order->payment_status == 'Pending')
                                                                    <span class='badge badge-danger'>{{ __('Unpaid') }}</span>
                                                                @else
                                                                    <span class='badge badge-success'>{{ __('Paid') }}</span>
                                                                @endif
                                                            </p>

                                                            <p>{{ __('Tax :') }}
                                                                {{ \PriceHelper::showOrderCurrencyPrice((($order->tax) / $order->currency_value),$order->currency_sign) }}
                                                            </p>

                                                            <p>{{ __('Paid Amount:') }}
                                                                {{ \PriceHelper::showOrderCurrencyPrice((($order->pay_amount + $order->wallet_price) * $order->currency_value),$order->currency_sign) }}
                                                            </p>
                                                            <p>{{ __('Payment Method:') }} {{$order->method}}</p>

                                                            @if($order->method != "Cash On Delivery")
                                                            @if($order->method=="Stripe")
                                                            {{ $order->method }} {{ __('Charge ID:') }} <p>{{$order->charge_id}}</p>
                                                            @endif
                                                            {{ $order->method }} {{ __('Transaction ID:') }} <p id="ttn">{{ $order->txnid }}</p>

                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                @else
                                                <div class="shipping-add-area">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            @if($order->shipping == "shipto")
                                                            <h5>{{ __('Shipping Address') }}</h5>
                                                            <address>
                                                                {{ __('Name:') }}
                                                                {{$order->shipping_name == null ? $order->customer_name : $order->shipping_name}}<br>
                                                                {{ __('Email:') }}
                                                                {{$order->shipping_email == null ? $order->customer_email : $order->shipping_email}}<br>
                                                                {{ __('Phone:') }}
                                                                {{$order->shipping_phone == null ? $order->customer_phone : $order->shipping_phone}}<br>
                                                                {{ __('Address:') }}
                                                                {{$order->shipping_address == null ? $order->customer_address : $order->shipping_address}}<br>
                                                                {{$order->shipping_city == null ? $order->customer_city : $order->shipping_city}}-{{$order->shipping_zip == null ? $order->customer_zip : $order->shipping_zip}}
                                                            </address>
                                                            @else
                                                            <h5>{{ __('PickUp Location') }}</h5>
                                                            <address>
                                                                {{ __('Address:') }} {{$order->pickup_location}}<br>
                                                            </address>
                                                            @endif

                                                        </div>
                                                        <div class="col-md-6">
                                                            <h5>{{ __('Shipping Method') }}</h5>
                                                            @if($order->shipping == "shipto")
                                                            <p>{{ __('Ship To Address') }}</p>
                                                            @else
                                                            <p>{{ __('Pick Up') }}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="billing-add-area">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h5>{{ __('Billing Address') }}</h5>
                                                            <address>
                                                                {{ __('Name:') }} {{$order->customer_name}}<br>
                                                                {{ __('Email:') }} {{$order->customer_email}}<br>
                                                                {{ __('Phone:') }} {{$order->customer_phone}}<br>
                                                                {{ __('Address:') }} {{$order->customer_address}}<br>
                                                                {{$order->customer_city}}-{{$order->customer_zip}}
                                                            </address>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h5>{{ __('Payment Information') }}</h5>

                                                            @if($order->shipping_cost != 0)
                                                            <p>{{ $order->shipping_title }}:
                                                                {{ \PriceHelper::showOrderCurrencyPrice($order->shipping_cost,$order->currency_sign) }}
                                                            </p>
                                                            @endif


                                                            @if($order->packing_cost != 0)
                                                            <p>{{ $order->packing_title }}:
                                                                {{ \PriceHelper::showOrderCurrencyPrice($order->packing_cost,$order->currency_sign) }}
                                                            </p>
                                                            @endif

                                                            @if($order->wallet_price != 0)
                                                            <p>{{ __('Paid From Wallet') }}:
                                                                {{ \PriceHelper::showOrderCurrencyPrice(($order->wallet_price  * $order->currency_value),$order->currency_sign) }}
                                                            </p>

                                                                @if($order->method != "Wallet")

                                                                <p>{{$order->method}}:
                                                                    {{ \PriceHelper::showOrderCurrencyPrice(($order->pay_amount  * $order->currency_value),$order->currency_sign) }}
                                                                </p>

                                                                @endif

                                                            @endif

                                                            <p>{{ __('Tax :') }}
                                                                {{ \PriceHelper::showOrderCurrencyPrice((($order->tax) / $order->currency_value),$order->currency_sign) }}
                                                            </p>

                                                            <p>{{ __('Paid Amount:') }}

                                                                @if($order->method != "Wallet")
                                                                {{ \PriceHelper::showOrderCurrencyPrice((($order->pay_amount+$order->wallet_price) * $order->currency_value),$order->currency_sign) }}

                                                                @else
                                                                {{ \PriceHelper::showOrderCurrencyPrice(($order->wallet_price * $order->currency_value),$order->currency_sign) }}
                                                                @endif



                                                            </p>
                                                            <p>{{ __('Payment Method:') }} {{$order->method}}</p>

                                                            @if($order->method != "Cash On Delivery" && $order->method != "Wallet")
                                                                @if($order->method=="Stripe")
                                                                    {{$order->method}} {{ __('Charge ID:') }} <p>{{$order->charge_id}}</p>
                                                                @else
                                                                    {{$order->method}} {{ __('Transaction ID:') }} <p id="ttn">{{$order->txnid}}</p>
                                                                @endif

                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                                <br>
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <h4 class="text-center">{{ __('Ordered Products:') }}</h4>
                                                        <thead>
                                                            <tr>
                                                                <th width="35%">{{ __('Name') }}</th>
                                                                <th width="20%">{{ __('Details') }}</th>
                                                                <th>{{ __('Price') }}</th>
                                                                <th>{{ __('Total') }}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            @foreach($tempcart->items as $product)
                                                            <tr>

                                                                <td>{{ $product['item']['name'] }}</td>
                                                                <td>
                                                                    <b>{{ __('Quantity') }}</b>: {{$product['qty']}}
                                                                    <br>
                                                                    @if(!empty($product['size']))
                                                                    <b>{{ __('Size') }}</b>:
                                                                    {{ $product['item']['measure'] }}{{str_replace('-',' ',$product['size'])}}
                                                                    <br>
                                                                    @endif
                                                                    @if(!empty($product['color']))
                                                                    <div class="d-flex mt-2">
                                                                        <b>{{ __('Color') }}</b>: <span
                                                                            id="color-bar"
                                                                            style="border: 10px solid #{{$product['color'] == "" ? "white" : $product['color']}};"></span>
                                                                    </div>
                                                                    @endif

                                                                    @if(!empty($product['keys']))

                                                                    @foreach( array_combine(explode(',',
                                                                    $product['keys']), explode(',', $product['values']))
                                                                    as $key => $value)

                                                                    <b>{{ ucwords(str_replace('_', ' ', $key))  }} :
                                                                    </b> {{ $value }} <br>
                                                                    @endforeach

                                                                    @endif

                                                                </td>

                                                                <td>{{ \PriceHelper::showCurrencyPrice(($product['item_price'] ) * $order->currency_value) }}
                                                                </td>

                                                                <td>{{ \PriceHelper::showCurrencyPrice($product['price'] * $order->currency_value)  }} <small>{{ $product['discount'] == 0 ? '' : '('.$product['discount'].'% '.__('Off').')' }}</small>
                                                                </td>

                                                            </tr>
                                                            @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- Ending of Dashboard data-table area -->
            </div>

            @endif

</section>





@include('partials.global.common-footer')
@endsection

@section('script')

<!-- Facebook Pixel: Track Purchase -->
@if (!empty($seo->facebook_pixel) && isset($order))
<script>
    $(document).ready(function() {
        // Track purchase completion
        if (typeof FacebookPixelTracker !== 'undefined') {
            const orderProducts = [];
            
            @if(isset($cart))
                @foreach($cart->items as $product)
                    orderProducts.push({
                        id: {{ $product['item']['id'] }},
                        name: '{{ addslashes($product['item']['name']) }}',
                        price: {{ $product['price'] }},
                        quantity: {{ $product['qty'] }}
                    });
                @endforeach
            @endif
            
            FacebookPixelTracker.trackPurchase({
                order_number: '{{ $order->order_number }}',
                order_id: {{ $order->id }},
                total: {{ $order->pay_amount }},
                products: orderProducts
            });
        }
    });
</script>
@endif

@endsection
