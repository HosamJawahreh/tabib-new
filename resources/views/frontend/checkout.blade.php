@extends('layouts.front')

@section('css')
<style>
    @php
        $isArabic = isset($langg) && ($langg->language == 'العربية' || $langg->language == 'Arabic' || $langg->language == 'ar');
    @endphp

    /* RTL Support for Checkout Page */
    @if($isArabic)
    .checkout-area {
        direction: rtl;
        text-align: right;
    }

    .checkout-area h5,
    .checkout-area h4,
    .checkout-area h3 {
        text-align: right;
    }

    .checkout-area label {
        text-align: right;
        display: block;
    }

    .checkout-area .form-control,
    .checkout-area input,
    .checkout-area textarea,
    .checkout-area select {
        text-align: right;
        direction: rtl;
    }

    .checkout-area .row {
        direction: rtl;
    }

    /* Mobile Responsive Textarea */
    @media (max-width: 768px) {
        .checkout-area textarea#delivery_details {
            font-size: 14px;
            padding: 10px;
            min-height: 80px;
        }
    }

    .order-summary {
        direction: rtl;
        text-align: right;
    }

    .order-summary table {
        direction: rtl;
    }

    .order-summary th,
    .order-summary td {
        text-align: right;
    }
    @endif
</style>
@endsection

@section('content')
@include('partials.global.common-header')
<!-- breadcrumb -->
<div class="full-row bg-light overlay-dark py-5" style="background-image: url({{ $gs->breadcrumb_banner ? asset('assets/images/'.$gs->breadcrumb_banner):asset('assets/images/noimage.png') }}); background-position: center center; background-size: cover;">
   <div class="container">
      <div class="row text-center text-white">
         <div class="col-12">
            <h3 class="mb-2 text-white">{{ __('Checkout') }}</h3>
         </div>
         <div class="col-12">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb mb-0 d-inline-flex bg-transparent p-0">
                  <li class="breadcrumb-item"><a href="{{ route('front.index') }}">{{ __('Home') }}</a></li>
                  <li class="breadcrumb-item active" aria-current="page">{{ __('Checkout') }}</li>
               </ol>
            </nav>
         </div>
      </div>
   </div>
</div>
<!-- breadcrumb -->
<!-- Check Out Area Start -->
<section class="checkout" style="padding-bottom: 30px !important; min-height: auto !important; height: auto !important;">
   <div class="container">
      <div class="row">
         <div class="col-lg-12">
            <div class="checkout-area mb-0 pb-0">
               <div class="checkout-process d-none">
                  <ul class="nav"  role="tablist">
                     <li class="nav-item">
                        <a class="nav-link active" id="pills-step1-tab" data-toggle="pill" href="#pills-step1" role="tab" aria-controls="pills-step1" aria-selected="true">
                        <span>1</span> {{ __('Address') }}
                        <i class="far fa-address-card"></i>
                        </a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link disabled" id="pills-step2-tab" data-toggle="pill" href="#pills-step2" role="tab" aria-controls="pills-step2" aria-selected="false" >
                        <span>2</span> {{ __('Orders') }}
                        <i class="fas fa-dolly"></i>
                        </a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link disabled" id="pills-step3-tab" data-toggle="pill" href="#pills-step3" role="tab" aria-controls="pills-step3" aria-selected="false">
                        <span>3</span> {{ __('Payment') }}
                        <i class="far fa-credit-card"></i>
                        </a>
                     </li>
                  </ul>
               </div>
            </div>
         </div>

         {{-- Form Section - Left side on desktop, second on mobile --}}
         <div class="col-lg-8 order-2 order-lg-1">
            <form id="simple-checkout-form" action="{{ route('simple.order.submit') }}" method="POST" class="checkoutform">
               @include('includes.form-success')
               @include('includes.form-error')
               {{ csrf_field() }}
               <div class="checkout-area">
                  <div class="tab-content" id="pills-tabContent">
                     <div class="tab-pane fade show active" id="pills-step1" role="tabpanel"
                        aria-labelledby="pills-step1-tab">
                        <div class="content-box">
                           <div class="content">
                              <div class="submit-loader" style="display: none;">
                                 <img src="//geniusocean.com/demo/geniuscart/default/assets/images/loading_large.gif" alt="">
                              </div>
                              <div class="personal-info d-none">
                                 <h5 class="title">
                                    {{ __('Personal Information') }} :
                                 </h5>
                                 <div class="row">
                                    <div class="col-lg-6">
                                       <input type="text" id="personal-name" class="form-control"
                                       name="personal_name" placeholder="{{ __('Enter Your Name')}}"
                                       value="{{ Auth::check() ? Auth::user()->name : '' }}" {{
                                       Auth::check() ? 'readonly' : '' }}>
                                    </div>
                                    <div class="col-lg-6">
                                       <input type="email" id="personal-email" class="form-control"
                                       name="personal_email" placeholder="{{ __('Enter Your Email') }}"
                                       value="{{ Auth::check() ? Auth::user()->email : '' }}" {{
                                       Auth::check() ? 'readonly' : '' }}>
                                    </div>
                                 </div>
                                 @if(!Auth::check())
                                 <div class="row">
                                    <div class="col-lg-12 mt-3">
                                       <input class="styled-checkbox" id="open-pass" type="checkbox"
                                          value="1" name="pass_check">
                                       <label for="open-pass">{{ __('Create an account ?') }}</label>
                                    </div>
                                 </div>
                                 <div class="row set-account-pass d-none">
                                    <div class="col-lg-6">
                                       <input type="password" name="personal_pass" id="personal-pass"
                                          class="form-control" placeholder="{{ __('Enter Your Password') }}">
                                    </div>
                                    <div class="col-lg-6">
                                       <input type="password" name="personal_confirm"
                                          id="personal-pass-confirm" class="form-control"
                                          placeholder="{{ __('Confirm Your Password') }}">
                                    </div>
                                 </div>
                                 @endif
                              </div>
                              <div class="billing-address">
                                 <h5 class="title d-none">
                                    {{ __('Billing Details') }}
                                 </h5>
                                 <div class="row">
                                    <div class="col-lg-6 {{ $digital == 1 ? 'd-none' : '' }} billing-details-advanced d-none">
                                       <select class="form-control" id="shipop" name="shipping">
                                          <option value="shipto">{{ __('Ship To Address') }}</option>
                                          <option value="pickup">{{ __('Pick Up') }}</option>
                                       </select>
                                    </div>
                                    <div class="col-lg-6 mb-2 d-none billing-details-advanced" id="shipshow">
                                       <select class="form-control" name="pickup_location">
                                          @foreach($pickups as $pickup)
                                          <option value="{{$pickup->location}}">{{$pickup->location}}
                                          </option>
                                          @endforeach
                                       </select>
                                    </div>
                                    <div class="col-lg-6">
                                       <input class="form-control" type="text" name="customer_name"
                                          placeholder="{{ $langg->rtl == 1 ? 'الاسم الكامل' : __('Full Name') }}" required=""
                                          value="{{ Auth::check() ? Auth::user()->name : '' }}">
                                    </div>
                                    <div class="col-lg-6 d-none">
                                       <input class="form-control" type="email" name="customer_email"
                                          placeholder="{{ __('Email') }} ({{ __('Optional') }})"
                                          value="{{ Auth::check() ? Auth::user()->email : 'customer@example.com' }}">
                                    </div>
                                    <div class="col-lg-6">
                                       <div class="d-flex" style="gap: 10px;">
                                          <select class="form-control" name="country_code" id="country_code" style="max-width: 120px;">
                                             <option value="+962" data-placeholder="079*******" selected>🇯🇴 +962</option>
                                             <option value="+1" data-placeholder="555-0123">🇺🇸 +1</option>
                                             <option value="+44" data-placeholder="7700 900000">🇬🇧 +44</option>
                                             <option value="+971" data-placeholder="50 123 4567">🇦🇪 +971</option>
                                             <option value="+966" data-placeholder="50 123 4567">🇸🇦 +966</option>
                                             <option value="+20" data-placeholder="100 123 4567">🇪🇬 +20</option>
                                             <option value="+961" data-placeholder="70 123 456">🇱🇧 +961</option>
                                             <option value="+970" data-placeholder="59 123 4567">🇵🇸 +970</option>
                                          </select>
                                          <input class="form-control" type="tel" name="customer_phone" id="customer_phone"
                                             placeholder="079*******" required="" minlength="9"
                                             value="{{ Auth::check() ? Auth::user()->phone : '' }}" style="flex: 1;">
                                       </div>
                                       <small id="phone-error" style="color: red; display: none;">{{ __('Phone number must be at least 9 digits') }}</small>
                                    </div>
                                    <div class="col-lg-12 mt-3">
                                       <textarea class="form-control" name="delivery_details" id="delivery_details"
                                          placeholder="{{ $langg->rtl == 1 ? 'تفاصيل إضافية (اسم المنطقة، رقم المبنى، إلخ)' : __('Details (Area name, building number, etc.)') }}"
                                          rows="3">{{ Auth::check() ? Auth::user()->address : '' }}</textarea>
                                    </div>
                                    <div class="col-lg-6 d-none">
                                       <input class="form-control" type="text" name="customer_address"
                                          placeholder="{{ __('Address') }} ({{ __('Optional') }})"
                                          value="{{ Auth::check() ? Auth::user()->address : 'N/A' }}">
                                    </div>
                                    <div class="col-lg-6 d-none">
                                       <input class="form-control" type="text" name="customer_city"
                                          placeholder="{{ __('City') }} ({{ __('Optional') }})"
                                          value="{{ Auth::check() ? Auth::user()->city : 'N/A' }}">
                                    </div>

                                    <div class="col-lg-6 billing-details-advanced d-none">
                                       <input class="form-control" type="text" name="customer_zip"
                                          placeholder="{{ __('Postal Code') }}"
                                          value="00000">
                                    </div>
                                    <div class="col-lg-6 billing-details-advanced d-none">
                                       <input type="hidden" name="customer_country" value="Jordan">
                                    </div>

                                    <div class="col-lg-6 d-none select_state">
                                        <input type="hidden" name="customer_state" value="">
                                    </div>
                                 </div>
                              </div>
                              <div class="row {{ $digital == 1 ? 'd-none' : '' }} billing-details-advanced d-none">
                                 <div class="col-lg-12 mt-3 d-flex">
                                    <input class="styled-checkbox" id="ship-diff-address" type="checkbox"
                                       value="value1">
                                    <label for="ship-diff-address">{{ __('Ship to a Different Address?') }}</label>
                                 </div>
                              </div>
                              <div class="ship-diff-addres-area d-none billing-details-advanced">
                                 <h5 class="title">
                                    {{ __('Shipping Details') }}
                                 </h5>
                                 <div class="row">
                                    <div class="col-lg-6">
                                       <input class="form-control ship_input" type="text"
                                          name="shipping_name" id="shippingFull_name"
                                          placeholder="{{ __('Full Name') }}">
                                       <input type="hidden" name="shipping_email" value="">
                                    </div>
                                    <div class="col-lg-6">
                                       <input class="form-control ship_input" type="text"
                                          name="shipping_phone" id="shipingPhone_number"
                                          placeholder="{{ __('Phone Number') }}">
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-lg-6">
                                       <input class="form-control ship_input" type="text"
                                          name="shipping_address" id="shipping_address"
                                          placeholder="{{ __('Address') }}">
                                    </div>
                                    <div class="col-lg-6">
                                       <input class="form-control ship_input" type="text" name="shipping_zip"
                                          id="shippingPostal_code" placeholder="{{ __('Postal Code') }}">
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-lg-6">
                                       <input class="form-control ship_input" type="text"
                                          name="shipping_city" id="shipping_city"
                                          placeholder="{{ __('City') }}">
                                    </div>
                                    <div class="col-lg-6">
                                       <input class="form-control ship_input" type="text" name="shipping_state"
                                          id="shipping_state" placeholder="{{ __('State') }}">
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-lg-6">
                                       <select class="form-control ship_input" name="shipping_country">
                                       @include('partials.user.countries')
                                       </select>
                                    </div>
                                 </div>
                              </div>
                              <div class="order-note mt-3 d-none">
                                 <div class="row">
                                    <div class="col-lg-12">
                                       <input type="hidden" id="Order_Note"
                                          name="order_notes"
                                          value="">
                                    </div>
                                 </div>
                              </div>

                              {{-- Cash on Delivery - Simplified --}}
                              <div class="payment-method-section mt-4">
                                 <div class="cod-simple-design d-flex align-items-center" style="gap: 10px;">
                                    <input type="radio" id="cash-on-delivery" name="method" value="Cash On Delivery"
                                           class="payment" data-form="{{ route('simple.order.submit') }}" checked required>
                                    <label for="cash-on-delivery" class="mb-0">
                                       {{ __('Cash On Delivery') }}
                                    </label>
                                 </div>
                              </div>

                              <div class="row">
                                 <div class="col-lg-12 mt-4">
                                    <div class="bottom-area text-center">
                                       <button type="submit" id="place-order-btn" class="place-order-btn" style="flex: 1 1 auto; min-width: 250px; max-width: 350px; padding: 16px 24px; font-size: 1.05rem; height: 56px; border-radius: 12px; font-weight: 600; display: inline-flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.2); background: #1f2937 !important; border: 2px solid #374151 !important; color: #ffffff !important; transition: all 0.3s ease; text-transform: none; letter-spacing: normal;">
                                          <i class="icofont-check-circled" style="color: #ffffff !important; font-size: 1.2rem;"></i>
                                          <span class="btn-text" style="color: #ffffff !important;">{{ __('Place Order') }}</span>
                                          <span class="btn-loader d-none">
                                             <i class="fas fa-spinner fa-spin"></i>
                                          </span>
                                       </button>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="tab-pane fade show" id="pills-step2" role="tabpanel"
                        aria-labelledby="pills-step2-tab">
                        <div class="content-box">
                           <div class="content">
                              <div class="order-area">
                                 @foreach($products as $product)
                                 <div class="order-item">
                                    <div class="product-img">
                                       <div class="d-flex">
                                          <img src="{{ $product['item']['thumbnail'] ? asset('assets/images/thumbnails/'.$product['item']['thumbnail']) : asset('assets/images/products/'.$product['item']['photo']) }}"
                                             height="80" width="80" class="p-1">
                                       </div>
                                    </div>
                                    <div class="product-content">
                                       <p class="name"><a
                                          href="{{ route('front.product', $product['item']['slug']) }}"
                                          target="_blank">{{ $product['item']['name'] }}</a></p>
                                       <div class="unit-price d-flex">
                                          <h5 class="label mr-2">{{ __('Price') }} : </h5>
                                          <p>{{ App\Models\Product::convertPrice($product['item_price']) }}
                                          </p>
                                       </div>
                                       @if(!empty($product['size']))
                                       <div class="unit-price d-flex">
                                          <h5 class="label mr-2">{{ __('Size') }} : </h5>
                                          <p>{{str_replace('-',' ',$product['size'])}}</p>
                                       </div>
                                       @endif
                                       @if(!empty($product['color']))
                                       <div class="unit-price d-flex">
                                          <h5 class="label mr-2">{{ __('Color') }} : </h5>
                                          <span id="color-bar"
                                          style="border: 10px solid {{$product['color'] == "" ? "white" : '#'.$product['color']}};"></span>
                                       </div>
                                       @endif
                                       @if(!empty($product['keys']))
                                       @foreach( array_combine(explode(',', $product['keys']), explode(',',
                                       $product['values'])) as $key => $value)
                                       <div class="quantity d-flex">
                                          <h5 class="label mr-2">{{ ucwords(str_replace('_', ' ', $key))  }} :
                                          </h5>
                                          <span class="qttotal">{{ $value }} </span>
                                       </div>
                                       @endforeach
                                       @endif
                                       <div class="quantity d-flex">
                                          <h5 class="label mr-2">{{ __('Quantity') }} : </h5>
                                          <span class="qttotal">{{ $product['qty'] }} </span>
                                       </div>
                                       <div class="total-price d-flex">
                                          <h5 class="label mr-2">{{ __('Total Price') }} : </h5>
                                          <p>
                                             {{ App\Models\Product::convertPrice($product['price']) }}
                                             <small>{{ $product['discount'] == 0 ? '' : '('.$product['discount'].'% '.__('Off').')' }}</small>
                                          </p>
                                       </div>
                                    </div>
                                 </div>
                                 @endforeach
                              </div>
                              <div class="row">
                                 <div class="col-lg-12 mt-3">
                                    <div class="bottom-area">
                                       <a href="javascript:;" id="step1-btn"
                                          class="mybtn1 mr-3">{{ __('Back') }}</a>
                                       <a href="javascript:;" id="step3-btn"
                                          class="mybtn1">{{ __('Continue') }}</a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="tab-pane fade show" id="pills-step3" role="tabpanel"
                        aria-labelledby="pills-step3-tab">
                        <div class="content-box">
                           <div class="content">
                              <div class="billing-info-area {{ $digital == 1 ? 'd-none' : '' }}">
                                 <h4 class="title">
                                    {{ __('Shipping Info') }}
                                 </h4>
                                 <ul class="info-list">
                                    <li>
                                       <p id="shipping_user"></p>
                                    </li>
                                    <li>
                                       <p id="shipping_location"></p>
                                    </li>
                                    <li>
                                       <p id="shipping_phone"></p>
                                    </li>
                                    <li>
                                       <p id="shipping_email"></p>
                                    </li>
                                 </ul>
                              </div>
                              <div class="payment-information">
                                 <h4 class="title">
                                    {{ __('Payment Info') }}
                                 </h4>
                                 <div class="row">
                                    <div class="col-lg-12">
                                       <div class="nav flex-column" role="tablist"
                                          aria-orientation="vertical">
                                          @foreach($gateways as $gt)
                                             @if ($gt->checkout == 1)
                                             @if($gt->type == 'manual')
                                             @if($digital == 0)
                                             <a class="nav-link payment" data-val="" data-show="{{$gt->showForm()}}"
                                                data-form="{{ $gt->showCheckoutLink() }}"
                                                data-href="{{ route('front.load.payment',['slug1' => $gt->showKeyword(),'slug2' => $gt->id]) }}"
                                                id="v-pills-tab{{ $gt->id }}-tab" data-toggle="pill"
                                                href="#v-pills-tab{{ $gt->id }}" role="tab"
                                                aria-controls="v-pills-tab{{ $gt->id }}"
                                                aria-selected="false">
                                                <div class="icon">
                                                   <span class="radio"></span>
                                                </div>
                                                <p>
                                                   {{ $gt->title }}
                                                   @if($gt->subtitle != null)
                                                   <small>
                                                   {{ $gt->subtitle }}
                                                   </small>
                                                   @endif
                                                </p>
                                             </a>
                                             @endif
                                             @else
                                             <a class="nav-link payment" data-val="{{ $gt->keyword }}" data-show="{{$gt->showForm()}}"
                                                data-form="{{ $gt->showCheckoutLink() }}"
                                                data-href="{{ route('front.load.payment',['slug1' => $gt->showKeyword(),'slug2' => $gt->id]) }}"
                                                id="v-pills-tab{{ $gt->id }}-tab" data-toggle="pill"
                                                href="#v-pills-tab{{ $gt->id }}" role="tab"
                                                aria-controls="v-pills-tab{{ $gt->id }}"
                                                aria-selected="false">
                                                <div class="icon">
                                                   <span class="radio"></span>
                                                </div>
                                                <p>
                                                   {{ $gt->name }}
                                                   @if($gt->information != null)
                                                   <small>
                                                   {{ $gt->getAutoDataText() }}
                                                   </small>
                                                   @endif
                                                </p>
                                             </a>
                                             @endif
                                             @endif
                                          @endforeach
                                       </div>
                                    </div>
                                    <div class="col-lg-12">
                                       <div class="pay-area d-none">
                                          <div class="tab-content" id="v-pills-tabContent">
                                             @foreach($gateways as $gt)
                                             @if($gt->type == 'manual')
                                             @if($digital == 0)
                                             <div class="tab-pane fade" id="v-pills-tab{{ $gt->id }}"
                                                role="tabpanel"
                                                aria-labelledby="v-pills-tab{{ $gt->id }}-tab">
                                             </div>
                                             @endif
                                             @else
                                             <div class="tab-pane fade" id="v-pills-tab{{ $gt->id }}"
                                                role="tabpanel"
                                                aria-labelledby="v-pills-tab{{ $gt->id }}-tab">
                                             </div>
                                             @endif
                                             @endforeach
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col-lg-12 mt-3">
                                    <div class="bottom-area">
                                       <a href="javascript:;" id="step2-btn"
                                          class="mybtn1 mr-3">{{ __('Back') }}</a>
                                       <button type="submit" id="final-btn"
                                          class="mybtn1">{{ __('Continue') }}</button>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <input type="hidden" id="shipping-cost" name="shipping_cost" value="0">
               <input type="hidden" id="packing-cost" name="packing_cost" value="0">
               <input type="hidden" id="shipping-title" name="shipping_title" value="0">
               <input type="hidden" id="packing-title" name="packing_title" value="0">
               <input type="hidden" name="dp" value="{{$digital}}">
               <input type="hidden" id="input_tax" name="tax" value="">
               <input type="hidden" id="input_tax_type" name="tax_type" value="">
               <input type="hidden" name="totalQty" value="{{$totalQty}}">
               <input type="hidden" name="vendor_shipping_id" value="{{ $vendor_shipping_id }}">
               <input type="hidden" name="vendor_packing_id" value="{{ $vendor_packing_id }}">
               <input type="hidden" name="currency_sign" value="{{ $curr->sign }}">
               <input type="hidden" name="currency_name" value="{{ $curr->name }}">
               <input type="hidden" name="currency_value" value="{{ $curr->value }}">
               @php
               @endphp
               @if(Session::has('coupon_total'))
               <input type="hidden" name="total" id="grandtotal" value="{{round($totalPrice * $curr->value,2)}}">
               <input type="hidden" id="tgrandtotal" value="{{ $totalPrice }}">
               @elseif(Session::has('coupon_total1'))
               <input type="hidden" name="total" id="grandtotal" value="{{ preg_replace("/[^0-9,.]/", "", Session::get('coupon_total1') ) }}">
               <input type="hidden" id="tgrandtotal" value="{{ preg_replace("/[^0-9,.]/", "", Session::get('coupon_total1') ) }}">
               @else
               <input type="hidden" name="total" id="grandtotal" value="{{round($totalPrice * $curr->value,2)}}">
               <input type="hidden" id="tgrandtotal" value="{{round($totalPrice * $curr->value,2)}}">
               @endif
               <input type="hidden" id="original_tax" value="0">
               <input type="hidden" id="wallet-price" name="wallet_price" value="0">
               <input type="hidden" id="ttotal" value="{{ Session::has('cart') ? App\Models\Product::convertPrice(Session::get('cart')->totalPrice) : '0' }}">
               <input type="hidden" name="coupon_code" id="coupon_code" value="{{ Session::has('coupon_code') ? Session::get('coupon_code') : '' }}">
               <input type="hidden" name="coupon_discount" id="coupon_discount" value="{{ Session::has('coupon') ? Session::get('coupon') : '' }}">
               <input type="hidden" name="coupon_id" id="coupon_id" value="{{ Session::has('coupon') ? Session::get('coupon_id') : '' }}">
               <input type="hidden" name="user_id" id="user_id" value="{{ Auth::guard('web')->check() ? Auth::guard('web')->user()->id : '' }}">
            </form>
         </div>

         {{-- PRICE DETAILS - Right side on desktop, first on mobile --}}
         @if(Session::has('cart'))
         <div class="col-lg-4 order-1 order-lg-2" style="{{ $langg->rtl == 1 ? 'padding-right: 15px; padding-left: 15px;' : '' }}">
            <div class="right-area" style="{{ $langg->rtl == 1 ? 'margin-right: 0; margin-left: 0;' : '' }}">
               <div class="order-box" style="{{ $langg->rtl == 1 ? 'padding: 15px; direction: rtl; text-align: right;' : '' }}">
                  <h4 class="title" style="margin-bottom: 12px; {{ $langg->rtl == 1 ? 'text-align: right; direction: rtl;' : '' }}">
                     @if($langg->rtl == 1)
                     تفاصيل السعر
                     @else
                     {{ __('Price Details') }}
                     @endif
                  </h4>

                  {{-- Products List --}}
                  <div class="cart-products-list mb-2" style="{{ $langg->rtl == 1 ? 'direction: rtl;' : '' }}">
                     @foreach($products as $index => $product)
                     <div class="cart-product-item d-flex align-items-center mb-1 pb-1" style="border-bottom: 1px solid #eee; position: relative; {{ $langg->rtl == 1 ? 'direction: rtl;' : '' }}"
                          data-product-index="{{ $index }}"
                          data-item-id="{{ $product['item']['id'] }}"
                          data-item-key="{{ $index }}"
                          data-size="{{ $product['size'] ?? '' }}"
                          data-color="{{ $product['color'] ?? '' }}"
                          data-size-qty="{{ $product['size_qty'] ?? '' }}"
                          data-size-price="{{ $product['size_price'] ?? '' }}"
                          data-unit-price="{{ $product['item_price'] }}"
                          data-values="{{ $product['values'] ?? '' }}">
                        <img src="{{ $product['item']['thumbnail'] ? asset('assets/images/thumbnails/'.$product['item']['thumbnail']) : asset('assets/images/products/'.$product['item']['photo']) }}"
                             alt="{{ $product['item']['name'] }}"
                             style="width: 45px; height: 45px; object-fit: cover; border-radius: 4px;"
                             class="{{ $langg->rtl == 1 ? 'ml-2' : 'mr-2' }}">
                        <div class="flex-grow-1" style="min-width: 0;">
                           <p class="mb-0" style="font-size: 13px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; {{ $langg->rtl == 1 ? 'text-align: right;' : '' }}">
                              @php
                                 $productItem = App\Models\Product::find($product['item']['id']);
                                 $productName = $productItem ? $productItem->name : $product['item']['name'];
                                 if ($productItem) {
                                    $translation = $productItem->translation();
                                    if ($translation && $translation->name) {
                                       $productName = $translation->name;
                                    }
                                 }
                              @endphp
                              {{ $productName }}
                           </p>
                           <div class="d-flex align-items-center justify-content-between">
                              <div class="qty-controls d-flex align-items-center" style="gap: 5px;">
                                 <button type="button" class="btn btn-sm btn-outline-secondary qtminus-checkout" style="padding: 2px 8px; font-size: 12px;">-</button>
                                 <input type="number" class="form-control form-control-sm qttotal-checkout text-center"
                                        value="{{ $product['qty'] }}"
                                        style="width: 50px; padding: 2px; font-size: 12px;"
                                        min="1" readonly>
                                 <button type="button" class="btn btn-sm btn-outline-secondary qtplus-checkout" style="padding: 2px 8px; font-size: 12px;">+</button>
                              </div>
                              <span class="product-total-price" style="font-size: 13px; font-weight: 600; white-space: nowrap;">
                                 @if($langg->rtl == 1)
                                    @php
                                       $convertedPrice = App\Models\Product::convertPrice($product['price']);
                                       preg_match('/([0-9.,]+)/', $convertedPrice, $matches);
                                       $amount = $matches[1] ?? $convertedPrice;
                                       preg_match('/([A-Z]{2,3}|[^\d.,\s]+)/', $convertedPrice, $currencyMatches);
                                       $currency = $currencyMatches[1] ?? $curr->sign;
                                    @endphp
                                    {{ $amount }}{{ $currency }}
                                 @else
                                    {{ App\Models\Product::convertPrice($product['price']) }}
                                 @endif
                              </span>
                           </div>
                        </div>
                        <button type="button" class="remove-from-checkout"
                                data-href="{{ route('product.cart.remove',$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])) }}"
                                title="{{ __('Remove this item') }}"
                                style="position: absolute; top: 5px; {{ $langg->rtl == 1 ? 'left: 5px;' : 'right: 5px;' }} background: transparent; border: none; color: #dc3545; font-size: 18px; line-height: 1; padding: 0; width: 20px; height: 20px; cursor: pointer; opacity: 0.7; transition: opacity 0.2s;">
                           <i class="fas fa-times"></i>
                        </button>
                     </div>
                     @endforeach
                  </div>

                  @if($digital == 0)
                  {{-- Shipping Method Area --}}
                  <div class="packeging-area" style="margin-top: 10px;">
                     <h4 class="title" style="font-size: 16px; font-weight: 600; margin-bottom: 10px; color: #333; {{ $langg->rtl == 1 ? 'text-align: right; direction: rtl;' : '' }}">
                        @if($langg->rtl == 1)
                        طريقة الشحن
                        @else
                        {{ __('Shipping Method') }}
                        @endif
                     </h4>
                     @foreach($shipping_data as $data)
                     <div class="shipping-option" style="margin-bottom: 8px; padding: 10px 12px; border: 1px solid #e0e0e0; border-radius: 8px; background: #fff; display: flex; align-items: center; cursor: pointer; transition: all 0.3s ease; {{ $langg->rtl == 1 ? 'direction: rtl;' : '' }}"
                          onclick="document.getElementById('free-shepping{{ $data->id }}').click();">
                        <input type="radio"
                               class="shipping"
                               data-form="{{$data->title}}"
                               id="free-shepping{{ $data->id }}"
                               name="shipping"
                               value="{{ round($data->price * $curr->value,2) }}"
                               {{ ($loop->first) ? 'checked' : '' }}
                               style="margin-left: {{ $langg->rtl == 1 ? '10px' : '0' }}; margin-right: {{ $langg->rtl == 1 ? '0' : '10px' }}; width: 18px; height: 18px; cursor: pointer; flex-shrink: 0;">
                        <label for="free-shepping{{ $data->id }}" style="margin: 0; cursor: pointer; font-size: 14px; color: #333; display: flex; align-items: center; justify-content: space-between; width: 100%;">
                           <span style="font-weight: 500;">
                              @if($langg->rtl == 1 && !empty($data->title_ar))
                              {{ $data->title_ar }}
                              @else
                              {{ $data->title }}
                              @endif
                           </span>
                           <span style="font-weight: 600; color: #28a745; {{ $langg->rtl == 1 ? 'margin-right: 10px;' : 'margin-left: 10px;' }} white-space: nowrap;">
                              @if($data->price != 0)
                                 @if($langg->rtl == 1)
                                    {{ round($data->price * $curr->value,2) }}{{ $curr->sign }}
                                 @else
                                    {{ $curr->sign }}{{ round($data->price * $curr->value,2) }}
                                 @endif
                              @else
                                 @if($langg->rtl == 1)
                                    0{{ $curr->sign }}
                                 @else
                                    {{ __('Free') }}
                                 @endif
                              @endif
                           </span>
                        </label>
                     </div>
                     @endforeach
                  </div>

                  {{-- Final Price Area --}}
                  <div class="final-price" style="margin-top: 12px; padding: 12px; background: #f8f9fa; border-radius: 8px; display: flex; justify-content: space-between; align-items: center; {{ $langg->rtl == 1 ? 'direction: rtl;' : '' }}">
                     <span style="font-size: 16px; font-weight: 600; color: #333;">
                        @if($langg->rtl == 1)
                        السعر النهائي :
                        @else
                        {{ __('Final Price') }} :
                        @endif
                     </span>
                     @if(Session::has('coupon_total'))
                        @if($langg->rtl == 1)
                           <span id="final-cost" style="font-size: 18px; font-weight: 700; color: #28a745;">{{ $totalPrice }}{{ $curr->sign }}</span>
                        @else
                           @if($gs->currency_format == 0)
                           <span id="final-cost" style="font-size: 18px; font-weight: 700; color: #28a745;">{{ $curr->sign }}{{ $totalPrice }}</span>
                           @else
                           <span id="final-cost" style="font-size: 18px; font-weight: 700; color: #28a745;">{{ $totalPrice }}{{ $curr->sign }}</span>
                           @endif
                        @endif
                     @elseif(Session::has('coupon_total1'))
                        @if($langg->rtl == 1)
                           @php
                              $couponTotal = Session::get('coupon_total1');
                              // Extract number and currency sign
                              preg_match('/([0-9.,]+)/', $couponTotal, $matches);
                              $amount = $matches[1] ?? $couponTotal;
                              preg_match('/([A-Z]{2,3}|[^\d.,\s]+)/', $couponTotal, $currencyMatches);
                              $currency = $currencyMatches[1] ?? $curr->sign;
                           @endphp
                           <span id="final-cost" style="font-size: 18px; font-weight: 700; color: #28a745;">{{ $amount }}{{ $currency }}</span>
                        @else
                           <span id="final-cost" style="font-size: 18px; font-weight: 700; color: #28a745;">{{ Session::get('coupon_total1') }}</span>
                        @endif
                     @else
                        @if($langg->rtl == 1)
                           @php
                              $convertedPrice = App\Models\Product::convertPrice($totalPrice);
                              // Extract number and currency
                              preg_match('/([0-9.,]+)/', $convertedPrice, $matches);
                              $amount = $matches[1] ?? $convertedPrice;
                              preg_match('/([A-Z]{2,3}|[^\d.,\s]+)/', $convertedPrice, $currencyMatches);
                              $currency = $currencyMatches[1] ?? $curr->sign;
                           @endphp
                           <span id="final-cost" style="font-size: 18px; font-weight: 700; color: #28a745;">{{ $amount }}{{ $currency }}</span>
                        @else
                           <span id="final-cost" style="font-size: 18px; font-weight: 700; color: #28a745;">{{ App\Models\Product::convertPrice($totalPrice) }}</span>
                        @endif
                     @endif
                  </div>
                  @endif
               </div>
            </div>
         </div>
         @endif
      </div>
   </div>
</section>
<!-- Check Out Area End-->
@if(isset($checked))
<!-- LOGIN MODAL -->
<div class="modal fade" id="comment-log-reg1" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="comment-log-reg-Title" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" aria-label="Close">
            <a href="{{ url()->previous() }}"><span aria-hidden="true">&times;</span></a>
            </button>
         </div>
         <div class="modal-body">
            <nav class="comment-log-reg-tabmenu">
               <div class="nav nav-tabs" id="nav-tab" role="tablist">
                  <a class="nav-item nav-link login active" id="nav-log-tab" data-toggle="tab" href="#nav-log" role="tab" aria-controls="nav-log" aria-selected="true">
                  {{ __('Login') }}
                  </a>
                  <a class="nav-item nav-link" id="nav-reg-tab" data-toggle="tab" href="#nav-reg" role="tab" aria-controls="nav-reg" aria-selected="false">
                  {{ __('Register') }}
                  </a>
               </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
               <div class="tab-pane fade show active" id="nav-log" role="tabpanel" aria-labelledby="nav-log-tab">
                  <div class="login-area">
                     <div class="header-area">
                        <h4 class="title">{{ __('LOGIN NOW') }}</h4>
                     </div>
                     <div class="login-form signin-form">
                        @include('includes.admin.form-login')
                        <form class="mloginform" action="{{ route('user.login.submit') }}" method="POST">
                           {{ csrf_field() }}
                           <div class="form-input">
                              <input type="email" name="email" placeholder="{{ __('Type Email Address') }}" required="">
                              <i class="icofont-user-alt-5"></i>
                           </div>
                           <div class="form-input">
                              <input type="password" class="Password" name="password" placeholder="{{ __('Type Password') }}" required="">
                              <i class="icofont-ui-password"></i>
                           </div>
                           <div class="form-forgot-pass">
                              <div class="left">
                                 <input type="hidden" name="modal" value="1">
                                 <input type="checkbox" name="remember"  id="mrp" {{ old('remember') ? 'checked' : '' }}>
                                 <label for="mrp">{{ __('Remember Password') }}</label>
                              </div>
                              <div class="right">
                                 <a id="show-forgot">
                                 {{ __('Forgot Password?') }}
                                 </a>
                              </div>
                           </div>
                           <input id="authdata" type="hidden"  value="{{ __('Authenticating...') }}">
                           <button type="submit" class="submit-btn">{{ __('Login') }}</button>
                           @if(App\Models\Socialsetting::find(1)->f_check == 1 || App\Models\Socialsetting::find(1)->g_check == 1)
                           <div class="social-area">
                              <h3 class="title">{{ __('Or')}}</h3>
                              <p class="text">{{__('Sign In with social media')}}</p>
                              <ul class="social-links">
                                 @if(App\Models\Socialsetting::find(1)->f_check == 1)
                                 <li>
                                    <a href="{{ route('social-provider','facebook') }}">
                                    <i class="fab fa-facebook-f"></i>
                                    </a>
                                 </li>
                                 @endif
                                 @if(App\Models\Socialsetting::find(1)->g_check == 1)
                                 <li>
                                    <a href="{{ route('social-provider','google') }}">
                                    <i class="fab fa-google-plus-g"></i>
                                    </a>
                                 </li>
                                 @endif
                              </ul>
                           </div>
                           @endif
                        </form>
                     </div>
                  </div>
               </div>
               <div class="tab-pane fade" id="nav-reg" role="tabpanel" aria-labelledby="nav-reg-tab">
                  <div class="login-area signup-area">
                     <div class="header-area">
                        <h4 class="title">{{ __('Signup Now') }}</h4>
                     </div>
                     <div class="login-form signup-form">
                        @include('includes.admin.form-login')
                        <form class="mregisterform" action="{{route('user-register-submit')}}" method="POST">
                           @csrf
                           <div class="form-input">
                              <input type="text" class="User Name" name="name" placeholder="{{ __('Full Name') }}"
                                 required="">
                              <i class="icofont-user-alt-5"></i>
                           </div>
                           <div class="form-input">
                              <input type="email" class="User Name" name="email" placeholder="{{ __('Email Address') }}" required="">
                              <i class="icofont-email"></i>
                           </div>
                           <div class="form-input">
                              <input type="text" class="User Name" name="phone" placeholder="{{ __('Phone Number') }}"
                                 required="">
                              <i class="icofont-phone"></i>
                           </div>
                           <div class="form-input">
                              <input type="text" class="User Name" name="address" placeholder="{{ __('Address') }}"
                                 required="">
                              <i class="icofont-location-pin"></i>
                           </div>
                           <div class="form-input">
                              <input type="password" class="Password" name="password" placeholder="{{ __('Password') }}" required="">
                              <i class="icofont-ui-password"></i>
                           </div>
                           <div class="form-input">
                              <input type="password" class="Password" name="password_confirmation"
                                 placeholder="{{ __('Confirm Password') }}" required="">
                              <i class="icofont-ui-password"></i>
                           </div>
                           <ul class="captcha-area">
                              <li>
                                 <p>
                                    <img class="codeimg1" src="{{asset("assets/images/capcha_code.png")}}" alt="">
                                    <i class="fas fa-sync-alt pointer refresh_code"></i>
                                 </p>
                              </li>
                           </ul>
                           <div class="form-input">
                              <input type="text" class="Password" name="codes" placeholder="{{ __('Enter Code') }}"
                                 required="">
                              <i class="icofont-refresh"></i>
                           </div>
                           <input class="mprocessdata" type="hidden" value="{{ __('Processing...') }}">
                           <button type="submit" class="submit-btn">{{ __('Register') }}</button>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- LOGIN MODAL ENDS -->
@endif
@includeIf('partials.global.common-footer')
@endsection
@section('script')
<script src="https://js.paystack.co/v1/inline.js"></script>
<script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>
<script src="https://www.2checkout.com/checkout/api/2co.min.js"></script>
<script type="text/javascript">
   // Initialize form action with the checked payment method (COD)
   var checkedPayment = $('.payment:checked');
   if(checkedPayment.length > 0) {
      $('.checkoutform').attr('action', checkedPayment.attr('data-form'));
      console.log('Form initialized with action:', checkedPayment.attr('data-form'));
   } else {
      $('a.payment:first').addClass('active');
      $('.checkoutform').attr('action',$('a.payment:first').attr('data-form'));
      $($('a.payment:first').attr('href')).load($('a.payment:first').data('href'));
   }


   	var show = $('a.payment:first').data('show');
   	if(show != 'no') {
   		$('.pay-area').removeClass('d-none');
   	}
   	else {
   		$('.pay-area').addClass('d-none');
   	}
   $($('a.payment:first').attr('href')).addClass('active').addClass('show');
</script>
<script type="text/javascript">
   var coup = 0;
   var pos = {{ $gs->currency_format }};

   @if(isset($checked))

   	$('#comment-log-reg1').modal('show');

   @endif

   var mship = $('.shipping').length > 0 ? $('.shipping').first().val() : 0;
   var mpack = $('.packing').length > 0 ? $('.packing').first().val() : 0;


   var ship_title = $('.shipping').length > 0 ? $('.shipping').first().attr('data-form') : '';
   var pack_title = $('.packing').length > 0 ? $('.packing').first().attr('data-form') : '';


   mship = parseFloat(mship);
   mpack = parseFloat(mpack);

   $('#shipping-cost').val(mship);
   $('#packing-cost').val(mpack);
   $('#shipping-title').val(ship_title);
   $('#packing-title').val(pack_title);

   var ftotal = parseFloat($('#grandtotal').val()) + mship + mpack;
   ftotal = parseFloat(ftotal).toFixed(2);

   		if(pos == 0){
   			$('#final-cost').html('{{ $curr->sign }}'+ftotal)
   		}
   		else{
   			$('#final-cost').html(ftotal+'{{ $curr->sign }}')
   		}
   		$('#grandtotal').val(ftotal);


   let original_tax = 0;

   	$(document).on('change','#select_country',function(){

   		$(this).attr('data-href');
   		let state_id = 0;
   		let country_id = $('#select_country option:selected').attr('data');
   		let is_state = $('option:selected', this).attr('rel');
   		let is_auth = $('option:selected', this).attr('rel1');
   		let is_user = $('option:selected', this).attr('rel5');
   		let state_url = $('option:selected', this).attr('data-href');
   		if(is_auth == 1 || is_state == 1) {
   			if(is_state == 1){
   				$('.select_state').removeClass('d-none');
   				$.get(state_url,function(response){
   					$('#show_state').html(response.data);
   					if(is_user==1){
   						tax_submit(country_id,response.state);
   					}else{
   						tax_submit(country_id,state_id);
   					}

   				});

   			}else{
   				tax_submit(country_id,state_id);
   				hide_state();
   			}

   		}else{

   			tax_submit(country_id,state_id);
   			hide_state();
   		}

   	});
   	$(document).on('change','#show_state',function(){
   		let state_id = $(this).val();
   		let country_id = $('#select_country option:selected').attr('data');
   		tax_submit(country_id,state_id);
   	});


   	function hide_state(){
   		$('.select_state').addClass('d-none');
   	}


   	$(document).on('ready',function(){

   		let country_id = $('#select_country option:selected').attr('data');
   		let state_id = $('#select_country option:selected').attr('rel2');
   		let is_state = $('#select_country option:selected', this).attr('rel');
   		let is_auth = $('#select_country option:selected', this).attr('rel1');
   		let state_url = $('#select_country option:selected', this).attr('data-href');

   		if(is_auth == 1 && is_state ==1) {
   			if(is_state == 1){
   				$('.select_state').removeClass('d-none');
   				$.get(state_url,function(response){
   					$('#show_state').html(response.data);
   					tax_submit(country_id,response.state);
   				});

   			}else{
   				tax_submit(country_id,state_id);
   				hide_state();
   			}
   		}else{
   			tax_submit(country_id,state_id);
   			hide_state();
   		}
   	});




   	function tax_submit(country_id,state_id){

   		$('.gocover').show();
   		var total = $("#ttotal").val();
   		var ship = 0;
   		$.ajax({
                       type: "GET",
                       url:mainurl+"/country/tax/check",
                       data:{state_id:state_id,country_id:country_id,total:total,shipping_cost:ship},
                       success:function(data){

   							$('#grandtotal').val(data[0]);
   							$('#tgrandtotal').val(data[0]);
   							$('#original_tax').val(data[1]);
   							$('.tax_show').removeClass('d-none');
   							$('#input_tax').val(data[11]);
   							$('#input_tax_type').val(data[12]);
   							$('.original_tax').html(parseFloat(data[1]).toFixed(2));
                               var ttotal = parseFloat($('#grandtotal').val());
                               var tttotal = parseFloat($('#grandtotal').val()) + (parseFloat(mship) + parseFloat(mpack));
                               ttotal = parseFloat(ttotal).toFixed(2);
                               tttotal = parseFloat(tttotal).toFixed(2);
                               $('#grandtotal').val(data[0]+parseFloat(mship) + parseFloat(mpack));
                               if(pos == 0){

   							$('#final-cost').html('{{ $curr->sign }}'+tttotal);
   							$('.total-cost-dum #total-cost').html('{{ $curr->sign }}'+ttotal);
   							}
                               else{

                                   $('#total-cost').html('');
                               $('#final-cost').html(tttotal+'{{ $curr->sign }}');
                               $('.total-cost-dum #total-cost').html(ttotal+'{{ $curr->sign }}');
                               }
   							$('.gocover').hide();
                         }
                 });
   	}




   // Wallet Area Starts

   $('#wallet').on('change',function(){
   	if(this.checked){
   		$('.wallet-box').removeClass('d-none')
   	}else{
   		$('.wallet-box').addClass('d-none')
   	}
   });


   $("#wallet-form").on('submit', function (e) {
   	e.preventDefault();
   		var prev_wallet_price = parseFloat($("#wallet-price").val());
           var val = parseFloat($("#wallet-amount").val());
           var total = $("#grandtotal").val();

               $.ajax({
                       type: "GET",
                       url:mainurl+"/checkout/payment/wallet-check",
                       data:{code:val, total:total, prev_price:prev_wallet_price},
                       success:function(data){
                           if(data == 0){
                           	toastr.error('Insufficient Amount!');
                           }
   						else if(data == 1){
   							toastr.error('Balance Exceeds From Wallet!');
   						}
                           else{
   							$("#wallet-amount").val('');
   							$('#wallet').click();
   							$("#grandtotal").val(data[0].toFixed(2));
   							$("#tgrandtotal").val(data[0].toFixed(2));
   							var wallet_price = parseFloat($("#wallet-price").val());
   							if(wallet_price != 0){
   								var wprice = data[1] + wallet_price;
   								$("#wallet-price").val(wprice);
   							}else{
   								$("#wallet-price").val(data[1]);
   							}
   							$('.wallet-price').removeClass('d-none');
   							if(pos == 0){
   								$('#wallet-cost').html('{{ $curr->sign }}'+(data[1]+wallet_price));
   								$('#final-cost').html('{{ $curr->sign }}'+data[0].toFixed(2));
   							}
   							else{
   								$('#wallet-cost').html((data[1]+wallet_price)+'{{ $curr->sign }}');
   								$('#final-cost').html(data[0].toFixed(2)+'{{ $curr->sign }}');
   							}
   							$('.shipping').attr('disabled',true);
   							$('.packing').attr('disabled',true);
   							$('#check-coupon-form button').attr('disabled',true);
   							if(data[0] == 0){
   								$('.checkoutform').attr('action','{{ route('front.wallet.submit') }}');
   								$('.payment-information').addClass('d-none');
   							}
                           	toastr.success('Successfully Paid From Your Wallet.');
                           }
                         }
                 });

       });

   // Wallet Area Ends









   $('#shipop').on('change',function(){

   var val = $(this).val();
   if(val == 'pickup'){
       $('#shipshow').removeClass('d-none');
       $("#ship-diff-address").parent().addClass('d-none');
       $('.ship-diff-addres-area').addClass('d-none');
       $('.ship-diff-addres-area input, .ship-diff-addres-area select').prop('required',false);
   }
   else{
       $('#shipshow').addClass('d-none');
       $("#ship-diff-address").parent().removeClass('d-none');
      // Keep additional shipping address optional unless user explicitly checks the checkbox
      $('.ship-diff-addres-area').addClass('d-none');
      $('.ship-diff-addres-area input, .ship-diff-addres-area select').prop('required',false);
   }

   });
   $('.shipping').on('click',function(){
   	mship = $(this).val();

   $('#shipping-cost').val(mship);
   var ttotal = parseFloat($('#tgrandtotal').val()) + parseFloat(mship) + parseFloat(mpack);
   ttotal = parseFloat(ttotal).toFixed(2);
   	if(pos == 0){
   			$('#final-cost').html('{{ $curr->sign }}'+ttotal);
   		}
   		else{
   			$('#final-cost').html(ttotal+'{{ $curr->sign }}');
   		}

   $('#shipping-title').val($(this).attr('data-form'));


   $('#grandtotal').val(ttotal);

   })

   $('.packing').on('click',function(){
   	mpack = $(this).val();
   $('#packing-cost').val(mpack);
   var ttotal = parseFloat($('#tgrandtotal').val()) + parseFloat(mship) + parseFloat(mpack);
   ttotal = parseFloat(ttotal).toFixed(2);;


   if(pos == 0){
   	$('#final-cost').html('{{ $curr->sign }}'+ttotal);
   }
   else{
   	$('#final-cost').html(ttotal+'{{ $curr->sign }}');
   }

   $('#packing-title').val($(this).attr('data-form'));

   $('#grandtotal').val(ttotal);

   })

       $("#check-coupon-form").on('submit', function () {
           var val = $("#code").val();
           var total = $("#ttotal").val();
           var ship = 0;
               $.ajax({
                       type: "GET",
                       url:mainurl+"/carts/coupon/check",
                       data:{code:val, total:total, shipping_cost:ship},
                       success:function(data){
                           if(data == 0)
                           {
                           	toastr.error('{{__('Coupon not found')}}');
                               $("#code").val("");
                           }
                           else if(data == 2)
                           {
                           	toastr.error('{{__('Coupon already have been taken')}}');
                               $("#code").val("");
                           }
                           else
                           {
                               $("#check-coupon-form").toggle();
                               $(".discount-bar").removeClass('d-none');

   							if(pos == 0){
   								$('.total-cost-dum #total-cost').html('{{ $curr->sign }}'+data[0]);
   								$('#discount').html('{{ $curr->sign }}'+data[2]);
   							}
   							else{
   								$('.total-cost-dum #total-cost').html(data[0]);
   								$('#discount').html(data[2]+'{{ $curr->sign }}');
   							}
   								$('#grandtotal').val(data[0]);
   								$('#tgrandtotal').val(data[0]);
   								$('#coupon_code').val(data[1]);
   								$('#coupon_discount').val(data[2]);
   								if(data[4] != 0){
   								$('.dpercent').html('('+data[4]+')');
   								}
   								else{
   								$('.dpercent').html('');
   								}


   							var ttotal = data[6] + parseFloat(mship) + parseFloat(mpack);
   							ttotal = parseFloat(ttotal);
   								if(ttotal % 1 != 0)
   								{
   									ttotal = ttotal.toFixed(2);
   								}

   									if(pos == 0){
   										$('#final-cost').html('{{ $curr->sign }}'+ttotal)
   									}
   									else{
   										$('#final-cost').html(ttotal+'{{ $curr->sign }}')
   									}
   											toastr.success(lang.coupon_found);
   											$("#code").val("");
   											}
   										}
   									});
                 return false;
       });

   // Password Checking

           $("#open-pass").on( "change", function() {
               if(this.checked){
                $('.set-account-pass').removeClass('d-none');
                $('.set-account-pass input').prop('required',true);
                $('#personal-email').prop('required',true);
                $('#personal-name').prop('required',true);
               }
               else{
                $('.set-account-pass').addClass('d-none');
                $('.set-account-pass input').prop('required',false);
                $('#personal-email').prop('required',false);
                $('#personal-name').prop('required',false);

               }
           });

   // Password Checking Ends

   // Country Code Phone Placeholder Update
   $('#country_code').on('change', function() {
       var selectedOption = $(this).find('option:selected');
       var placeholder = selectedOption.data('placeholder');
       $('#customer_phone').attr('placeholder', placeholder);
   });

   // Shipping Address Checking


               $("#ship-diff-address").on( "change", function() {
               if(this.checked){
                $('.ship-diff-addres-area').removeClass('d-none');
                $('.ship-diff-addres-area input, .ship-diff-addres-area select').prop('required',true);
               }
               else{
                $('.ship-diff-addres-area').addClass('d-none');
                $('.ship-diff-addres-area input, .ship-diff-addres-area select').prop('required',false);
               }

           });


   // Shipping Address Checking Ends


</script>
<script type="text/javascript">
   var ck = 1; // Set to 1 to allow direct submission

	$('.checkoutform').on('submit',function(e){
		// Log for debugging
		console.log('Form submitting to:', $(this).attr('action'));
		console.log('Form method:', $(this).attr('method'));
		console.log('Form data:', $(this).serialize());

		// Validate required fields
		var name = $('input[name="customer_name"]').val();
		var phone = $('input[name="customer_phone"]').val();

		if(!name || name.trim() === '') {
			alert('Please enter your name');
			e.preventDefault();
			return false;
		}

		if(!phone || phone.trim() === '') {
			alert('Please enter your phone number');
			e.preventDefault();
			return false;
		}

		// Phone validation - at least 9 digits
		var phoneDigits = phone.replace(/\D/g, ''); // Remove all non-digit characters
		if(phoneDigits.length < 9) {
			$('#phone-error').show();
			$('#customer_phone').focus();
			e.preventDefault();
			return false;
		}

		// Direct submission - no step navigation
		$('#preloader').show();
		$('#place-order-btn').prop('disabled', true);
		$('#place-order-btn .btn-text').hide();
		$('#place-order-btn .btn-loader').removeClass('d-none');
	});

	// Phone input validation on keyup
	$('#customer_phone').on('keyup', function() {
		var phone = $(this).val();
		var phoneDigits = phone.replace(/\D/g, '');
		if(phoneDigits.length >= 9) {
			$('#phone-error').hide();
		} else {
			$('#phone-error').show();
		}
	});


   // Step 2 btn DONE

   $('#step1-btn').on('click',function(){
   		$('#pills-step2').removeClass('active');
   		$('#pills-step1').addClass('active');
   		$('#pills-step1-tab').click();
   	});

       $('#step2-btn').on('click',function(){
   		$('#pills-step3').removeClass('active');
   		$('#pills-step2').addClass('active');
   		 $('#pills-step2-tab').removeClass('active');
   		 $('#pills-step3-tab').addClass('disabled');
   		$('#pills-step2-tab').click();


   	});



   	$('#step3-btn').on('click',function(){

   	 	if($('a.payment:first').data('val') == 'paystack'){
   			$('.checkoutform').attr('id','step1-form');
   		}

   		$('#pills-step2').removeClass('active');
   		$('#pills-step3-tab').click();

   		var shipping_user  = !$('input[name="shipping_name"]').val() ? $('input[name="name"]').val() : $('input[name="shipping_name"]').val();
   		var shipping_location  = !$('input[name="shipping_address"]').val() ? $('input[name="address"]').val() : $('input[name="shipping_address"]').val();
   		var shipping_phone = !$('input[name="shipping_phone"]').val() ? $('input[name="phone"]').val() : $('input[name="shipping_phone"]').val();
   		var shipping_email= !$('input[name="shipping_email"]').val() ? $('input[name="email"]').val() : $('input[name="shipping_email"]').val();

   		$('#shipping_user').html('<i class="fas fa-user"></i>'+shipping_user);
   		$('#shipping_location').html('<i class="fas fas fa-map-marker-alt"></i>'+shipping_location);
   		$('#shipping_phone').html('<i class="fas fa-phone"></i>'+shipping_phone);
   		$('#shipping_email').html('<i class="fas fa-envelope"></i>'+shipping_email);

   		$('#pills-step1-tab').addClass('active');
   		$('#pills-step2-tab').addClass('active');
           $('#pills-step3').addClass('active');

   	});

   	$('#final-btn').on('click',function(){
   		ck = 1;
   	})



	$('.payment').on('click',function(){

		if($(this).data('val') == 'paystack'){
			$('.checkoutform').attr('id','step1-form');
		}

		else if($(this).data('val') == 'mercadopago'){
			$('.checkoutform').attr('id','mercadopago');
			checkONE= 1;
		}
		else {
			$('.checkoutform').attr('id','');
		}
		$('.checkoutform').attr('action',$(this).attr('data-form'));
		console.log('Payment method changed. Form action:', $(this).attr('data-form'));
        $('.payment').removeClass('active');
        $(this).addClass('active');
		$('.pay-area #v-pills-tabContent .tab-pane.fade').not($(this).attr('href')).html('');
		var show = $(this).attr('data-show');
		if(show != 'no') {
			$('.pay-area').removeClass('d-none');
		}
		else {
			$('.pay-area').addClass('d-none');
		}
		$($('#v-pills-tabContent .tap-pane').removeClass('active show'));
		$($('#v-pills-tabContent #'+$(this).attr('aria-controls'))).addClass('active show').load($(this).attr('data-href'));
	})

	// Also handle change event for radio buttons
	$('input.payment[type="radio"]').on('change', function(){
		if($(this).is(':checked')) {
			$('.checkoutform').attr('action', $(this).attr('data-form'));
			console.log('Radio changed. Form action:', $(this).attr('data-form'));
		}
	});           $(document).on('submit','#step1-form',function(){
           	$('#preloader').hide();
               var val = $('#sub').val();
               var total = $('#grandtotal').val();
   			total = Math.round(total);
                   if(val == 0)
                   {
                   var handler = PaystackPop.setup({
                     key: '{{$paystack['key']}}',
                     email: $('input[name=customer_email]').val(),
                     amount: total * 100,
                     currency: "{{$curr->name}}",
                     ref: ''+Math.floor((Math.random() * 1000000000) + 1),
                     callback: function(response){
                       $('#ref_id').val(response.reference);
                       $('#sub').val('1');
                       $('#final-btn').click();
                     },
                     onClose: function(){
                     	window.location.reload();
                     }
                   });
                   handler.openIframe();
                       return false;
                   }
                   else {
                   	$('#preloader').show();
                       return true;
                   }
           });


   // Step 2 btn DONE



   	$('#step3-btn').on('click',function(){
   	 	if($('a.payment:first').data('val') == 'paystack'){
   			$('.checkoutform').attr('id','step1-form');
   		}
   		else if($('a.payment:first').data('val') == 'voguepay'){
   			$('.checkoutform').attr('id','voguepay');
   		}
   		else {
   			$('.checkoutform').attr('id','twocheckout');
   		}
   		$('#pills-step3-tab').removeClass('disabled');
   		$('#pills-step3-tab').click();

   		var shipping_user  = !$('input[name="shipping_name"]').val() ? $('input[name="customer_name"]').val() : $('input[name="shipping_name"]').val();
   		var shipping_location  = !$('input[name="shipping_address"]').val() ? $('input[name="customer_address"]').val() : $('input[name="shipping_address"]').val();
   		var shipping_phone = !$('input[name="shipping_phone"]').val() ? $('input[name="customer_phone"]').val() : $('input[name="shipping_phone"]').val();
   		var shipping_email= !$('input[name="shipping_email"]').val() ? $('input[name="customer_email"]').val() : $('input[name="shipping_email"]').val();

   		$('#shipping_user').html('<i class="fas fa-user"></i>'+shipping_user);
   		$('#shipping_location').html('<i class="fas fas fa-map-marker-alt"></i>'+shipping_location);
   		$('#shipping_phone').html('<i class="fas fa-phone"></i>'+shipping_phone);
   		$('#shipping_email').html('<i class="fas fa-envelope"></i>'+shipping_email);

   		$('#pills_step1-tab').addClass('active');
   		$('#pills-step2-tab').addClass('active');
   	});

   // Quantity controls for checkout sidebar products - Update prices
   var currencySign = '{{ $curr->sign }}';
   var currencyFormat = {{ $gs->currency_format }};

   function updateCheckoutPrices() {
      var grandTotal = 0;

      $('.cart-product-item').each(function() {
         var $item = $(this);
         var unitPrice = parseFloat($item.data('unit-price'));
         var qty = parseInt($item.find('.qttotal-checkout').val());
         var itemTotal = unitPrice * qty;

         grandTotal += itemTotal;

         // Update item total display
         var formattedPrice = itemTotal.toFixed(2);
         if (currencyFormat == 0) {
            $item.find('.product-total-price').text(currencySign + formattedPrice);
         } else {
            $item.find('.product-total-price').text(formattedPrice + currencySign);
         }
      });

      // Add shipping cost
      var shippingCost = 0;
      var selectedShipping = $('input[name="shipping"]:checked');
      if (selectedShipping.length > 0) {
         shippingCost = parseFloat(selectedShipping.val()) || 0;
      }

      var finalTotal = grandTotal + shippingCost;

      // Update grand total and final cost
      var formattedTotal = finalTotal.toFixed(2);
      if (currencyFormat == 0) {
         $('#total-cost').text(currencySign + formattedTotal);
         $('#final-cost').text(currencySign + formattedTotal);
      } else {
         $('#total-cost').text(formattedTotal + currencySign);
         $('#final-cost').text(formattedTotal + currencySign);
      }

      console.log('Prices updated. Grand total:', grandTotal, 'Shipping:', shippingCost, 'Final:', formattedTotal);
   }

   // Update prices when shipping method changes
   $(document).on('change', 'input[name="shipping"]', function() {
      console.log('Shipping method changed');
      updateCheckoutPrices();
   });

   $(document).on('click', '.qtplus-checkout', function() {
      console.log('Plus button clicked');
      var $button = $(this);
      var $item = $button.closest('.cart-product-item');
      var $input = $button.siblings('.qttotal-checkout');
      var currentVal = parseInt($input.val());

      // Get cart item data
      var itemId = $item.data('item-id');
      var itemKey = $item.data('item-key');
      var sizeQty = $item.data('size-qty') || '';
      var sizePrice = $item.data('size-price') || '';

      console.log('Updating cart - itemId:', itemId, 'itemKey:', itemKey);

      // Disable button during update
      $button.prop('disabled', true);

      // Update session cart via AJAX
      $.ajax({
         url: mainurl + '/addbyone',
         type: 'GET',
         data: {
            id: itemId,
            itemid: itemKey,
            size_qty: sizeQty,
            size_price: sizePrice
         },
         success: function(response) {
            console.log('Cart updated successfully:', response);
            // Update the input value
            $input.val(currentVal + 1);
            // Update prices on the page
            updateCheckoutPrices();
            // Re-enable button
            $button.prop('disabled', false);
         },
         error: function(xhr, status, error) {
            console.error('Error updating cart:', error);
            alert('{{ __("Error updating quantity. Please refresh the page.") }}');
            // Re-enable button
            $button.prop('disabled', false);
         }
      });
   });

   $(document).on('click', '.qtminus-checkout', function() {
      console.log('Minus button clicked');
      var $button = $(this);
      var $item = $button.closest('.cart-product-item');
      var $input = $button.siblings('.qttotal-checkout');
      var currentVal = parseInt($input.val());

      if (currentVal > 1) {
         // Get cart item data
         var itemId = $item.data('item-id');
         var itemKey = $item.data('item-key');
         var sizeQty = $item.data('size-qty') || '';
         var sizePrice = $item.data('size-price') || '';

         console.log('Updating cart - itemId:', itemId, 'itemKey:', itemKey);

         // Disable button during update
         $button.prop('disabled', true);

         // Update session cart via AJAX
         $.ajax({
            url: mainurl + '/reducebyone',
            type: 'GET',
            data: {
               id: itemId,
               itemid: itemKey,
               size_qty: sizeQty,
               size_price: sizePrice
            },
            success: function(response) {
               console.log('Cart updated successfully:', response);
               // Update the input value
               $input.val(currentVal - 1);
               // Update prices on the page
               updateCheckoutPrices();
               // Re-enable button
               $button.prop('disabled', false);
            },
            error: function(xhr, status, error) {
               console.error('Error updating cart:', error);
               alert('{{ __("Error updating quantity. Please refresh the page.") }}');
               // Re-enable button
               $button.prop('disabled', false);
            }
         });
      }
   });

   // Remove product from checkout
   $(document).on('click', '.remove-from-checkout', function(e) {
      e.preventDefault();
      var $button = $(this);
      var removeUrl = $button.data('href');

      if (confirm('{{ __("Are you sure you want to remove this item from cart?") }}')) {
         $.ajax({
            url: removeUrl,
            type: 'GET',
            success: function(response) {
               // Reload the page to refresh the cart
               location.reload();
            },
            error: function() {
               alert('{{ __("Error removing item. Please try again.") }}');
            }
         });
      }
   });

</script>

<!-- Footer Spacing Fix CSS -->
<link rel="stylesheet" href="{{asset('assets/front/css/footer-spacing-fix.css')}}">

<style>
.cart-products-list {
   max-height: 400px;
   overflow-y: auto;
}

.cart-product-item img {
   flex-shrink: 0;
}

.cart-product-item .qty-controls button {
   line-height: 1;
   border-radius: 3px;
}

.cart-product-item .qty-controls input {
   border-radius: 3px;
}

/* Remove button hover effect */
.remove-from-checkout:hover {
   opacity: 1 !important;
   color: #c82333 !important;
}

/* Shipping Options Styling */
.shipping-option {
   transition: all 0.3s ease;
}

.shipping-option:hover {
   border-color: #28a745 !important;
   background: #f8fff8 !important;
   box-shadow: 0 2px 8px rgba(40, 167, 69, 0.1);
}

.shipping-option:has(input[type="radio"]:checked) {
   border-color: #28a745 !important;
   background: #f0fff4 !important;
   box-shadow: 0 2px 8px rgba(40, 167, 69, 0.15);
}

.shipping-option input[type="radio"] {
   accent-color: #28a745;
}

/* Mobile: Make shipping section text 25% bigger */
@media (max-width: 767px) {
   /* Shipping Method Title */
   .order-summary h4 {
      font-size: 1.25rem !important;
   }

   /* Shipping option labels and text */
   .shipping-option label {
      font-size: 17.5px !important;
   }

   .shipping-option label span {
      font-size: 17.5px !important;
   }

   /* Shipping radio buttons - also bigger */
   .shipping-option input[type="radio"] {
      width: 22.5px !important;
      height: 22.5px !important;
   }

   /* Final Price text */
   .final-price span {
      font-size: 20px !important;
   }

   .final-price #final-cost {
      font-size: 22.5px !important;
   }
}

.payment-method-section .radio-design {
   background: #ffffff;
   padding: 20px;
   border-radius: 10px;
   border: 2px solid #ddd;
   transition: all 0.3s ease;
   box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.payment-method-section .radio-design:hover {
   border-color: #28a745;
   box-shadow: 0 4px 12px rgba(40,167,69,0.15);
}

.payment-method-section .radio-design input[type="radio"]:checked ~ .checkmark {
   background-color: #28a745;
}

.payment-method-section .radio-design label {
   color: #000 !important;
   cursor: pointer;
   margin-left: 10px;
}

.payment-method-section .radio-design label strong {
   color: #000 !important;
   font-weight: 600;
}

.payment-method-section .radio-design label small {
   color: #555 !important;
}

/* Cash on Delivery Radio Button Alignment */
.payment-method-section .radio-design {
   display: flex;
   align-items: center;
   position: relative;
   padding-left: 35px;
   cursor: pointer;
}

.payment-method-section .radio-design input[type="radio"] {
   position: absolute;
   left: 0;
   top: 50%;
   transform: translateY(-50%);
   margin: 0;
   width: 20px;
   height: 20px;
   cursor: pointer;
}

.payment-method-section .radio-design .checkmark {
   position: absolute;
   left: 0;
   top: 50%;
   transform: translateY(-50%);
}

.payment-method-section .radio-design label {
   margin: 0;
   padding: 0;
   cursor: pointer;
   display: flex;
   flex-direction: column;
}

/* Simplified Cash on Delivery Design */
.payment-method-section .cod-simple-design {
   padding: 10px 0;
}

.payment-method-section .cod-simple-design input[type="radio"] {
   width: 16px;
   height: 16px;
   cursor: pointer;
   margin: 0;
   flex-shrink: 0;
}

.payment-method-section .cod-simple-design label {
   font-size: 15px;
   color: #333;
   cursor: pointer;
   margin: 0;
   user-select: none;
}

/* Place Order Button Styling - Matches Buy Now Button Design */
.place-order-btn {
   background: #1f2937 !important;
   border: 2px solid #374151 !important;
   color: #ffffff !important;
   transition: all 0.3s ease !important;
}

.place-order-btn:hover,
.place-order-btn:focus,
.place-order-btn:active {
   background: #111827 !important;
   color: #ffffff !important;
   transform: translateY(-2px);
   box-shadow: 0 6px 16px rgba(0,0,0,0.3) !important;
   border-color: #4b5563 !important;
}

.place-order-btn:hover span,
.place-order-btn:focus span,
.place-order-btn:active span,
.place-order-btn:hover i,
.place-order-btn:focus i,
.place-order-btn:active i {
   color: #ffffff !important;
}

.place-order-btn::before {
   display: none;
}

.place-order-btn:disabled {
   background: #6b7280 !important;
   cursor: not-allowed;
   transform: none !important;
   box-shadow: 0 2px 10px rgba(107, 114, 128, 0.2) !important;
}

.place-order-btn .btn-text,
.place-order-btn .btn-loader {
   position: relative;
   z-index: 1;
}

.place-order-btn .btn-loader i {
   margin-right: 8px;
}

/* Pulse animation on hover */
@keyframes pulse {
   0% {
      box-shadow: 0 6px 20px rgba(44, 62, 80, 0.3);
   }
   50% {
      box-shadow: 0 10px 30px rgba(44, 62, 80, 0.5);
   }
   100% {
      box-shadow: 0 6px 20px rgba(44, 62, 80, 0.3);
   }
}

.place-order-btn:hover {
   animation: pulse 2s infinite;
}

/* Loading state animation */
@keyframes spin {
   0% { transform: rotate(0deg); }
   100% { transform: rotate(360deg); }
}

/* Checkout Page Footer Spacing Fixes */
.checkout {
   padding-bottom: 30px !important;
   min-height: auto !important;
}

/* Delivery Details Textarea Responsive */
#delivery_details {
   width: 100%;
   resize: vertical;
   min-height: 80px;
}

@media (max-width: 768px) {
   #delivery_details {
      font-size: 14px;
      padding: 10px 12px;
      min-height: 70px;
   }

   .checkout-area .col-lg-12.mt-3 {
      padding-left: 15px;
      padding-right: 15px;
   }
}

body {
   min-height: auto !important;
   height: auto !important;
}

#page_wrapper {
   min-height: auto !important;
   height: auto !important;
}

.min-vh-100 {
   min-height: auto !important;
}

.vh-100 {
   height: auto !important;
}
</style>

<!-- Checkout Redirect Fix Script -->
<script src="{{asset('assets/js/checkout-redirect-fix.js')}}"></script>

<!-- Facebook Pixel: Track InitiateCheckout -->
@if (!empty($seo->facebook_pixel))
<script>
    $(document).ready(function() {
        // Track checkout initiation
        if (typeof FacebookPixelTracker !== 'undefined') {
            const cartProducts = [];
            let totalValue = 0;

            // Collect cart products
            @foreach(Session::get('cart')->items as $product)
                cartProducts.push({
                    id: {{ $product['item']['id'] }},
                    name: '{{ addslashes($product['item']['name']) }}',
                    price: {{ $product['price'] }},
                    quantity: {{ $product['qty'] }}
                });
                totalValue += ({{ $product['price'] }} * {{ $product['qty'] }});
            @endforeach

            // Track InitiateCheckout
            FacebookPixelTracker.trackInitiateCheckout(cartProducts, totalValue);
        }
    });
</script>
@endif

@endsection
