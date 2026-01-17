<!--==================== Cart Section Start ====================-->
<style>
/* GENERAL CART STYLES - Remove any extra spaces */
table.shop_table.cart td.product-price,
table.shop_table.cart td.product-price span {
    white-space: nowrap !important;
    margin: 0 !important;
    padding-right: 0 !important;
}

table.shop_table.cart td {
    white-space: normal !important;
}

/* MOBILE RESPONSIVE CART - INLINE STYLES */
@media (max-width: 767px) {
    .cartpage { 
        padding: 20px 0 !important;
        margin-top: 70px !important; /* Account for fixed header */
    }
    
    .container { 
        padding: 0 15px !important;
        max-width: 100% !    /* Remove button - top right corner with black trash icon */
    table.shop_table.cart td.product-remove {
        position: absolute !important;
        top: 10px !important;
        right: 10px !important;
        min-width: auto !important;
        padding: 0 !important;
    }
    
    table.shop_table.cart td.product-remove::before {
        display: none !important;
    }
    
    table.shop_table.cart td.product-remove .remove {
        font-size: 0 !important; /* Hide the × character */
        color: #000 !important;
        width: 38px !important;
        height: 38px !important;
        line-height: 38px !important;
        text-align: center !important;
        display: inline-block !important;
        border-radius: 6px !important;
        background: #f8f9fa !important;
        transition: all 0.3s ease !important;
    }
    
    table.shop_table.cart td.product-remove .remove:after {
        content: "\f2ed" !important; /* FontAwesome trash icon */
        font-family: "Font Awesome 5 Free" !important;
        font-weight: 900 !important;
        font-size: 18px !important;
        color: #000 !important;
    }
    
    table.shop_table.cart td.product-remove .remove:hover {
        background: #fff !important;
    }
    
    table.shop_table.cart td.product-remove .remove:hover:after {
        color: #dc3545 !important;
    }    
    /* Make cart table scrollable */
    .cart-table {
        overflow-x: auto !important;
        -webkit-overflow-scrolling: touch !important;
        margin-bottom: 20px !important;
        border-radius: 8px !important;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1) !important;
    }
    
    /* Cart table mobile styling */
    table.shop_table.cart {
        min-width: 600px !important;
        font-size: 13px !important;
        background: #fff !important;
    }
    
    table.shop_table.cart th {
        background: #f8f9fa !important;
        font-weight: 600 !important;
        padding: 12px 8px !important;
        font-size: 13px !important;
        text-transform: uppercase !important;
        border-bottom: 2px solid #e0e0e0 !important;
    }
    
    table.shop_table.cart td {
        padding: 12px 8px !important;
        font-size: 13px !important;
        vertical-align: middle !important;
        border-bottom: 1px solid #f0f0f0 !important;
    }
    
    /* Keep thumbnail visible but smaller */
    table.shop_table.cart th.product-thumbnail,
    table.shop_table.cart td.product-thumbnail {
        min-width: 70px !important;
        max-width: 70px !important;
        padding: 8px !important;
        text-align: center !important;
    }
    
    table.shop_table.cart td.product-thumbnail img {
        max-width: 60px !important;
        height: 60px !important;
        object-fit: cover !important;
        border-radius: 8px !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
    }
    
    /* Product name */
    table.shop_table.cart td.product-name {
        min-width: 150px !important;
        max-width: 180px !important;
    }
    
    table.shop_table.cart td.product-name a {
        font-size: 14px !important;
        line-height: 1.4 !important;
        font-weight: 500 !important;
        color: #333 !important;
    }
    
    /* Price - NO EXTRA SPACE */
    table.shop_table.cart td.product-price {
        min-width: 80px !important;
        font-size: 14px !important;
        font-weight: 600 !important;
        color: #2c5f2d !important;
        white-space: nowrap !important;
    }
    
    table.shop_table.cart td.product-price span {
        display: inline !important;
        white-space: nowrap !important;
    }
    
    /* Quantity */
    table.shop_table.cart td.product-quantity {
        min-width: 90px !important;
    }
    
    table.shop_table.cart td.product-quantity input {
        width: 60px !important;
        height: 38px !important;
        font-size: 14px !important;
        padding: 8px !important;
        text-align: center !important;
        border: 1px solid #ddd !important;
        border-radius: 6px !important;
    }
    
    /* Subtotal */
    table.shop_table.cart td.product-subtotal {
        min-width: 80px !important;
        font-size: 14px !important;
        font-weight: 600 !important;
        color: #2c5f2d !important;
    }
    
    /* Remove button - Black trash icon */
    table.shop_table.cart td.product-remove {
        min-width: 50px !important;
        text-align: center !important;
    }
    
    table.shop_table.cart td.product-remove .remove {
        font-size: 0 !important; /* Hide the × character */
        padding: 8px !important;
        color: #000 !important;
        display: inline-block !important;
        width: 36px !important;
        height: 36px !important;
        line-height: 36px !important;
        text-align: center !important;
        border-radius: 6px !important;
        transition: all 0.3s ease !important;
    }
    
    table.shop_table.cart td.product-remove .remove:after {
        content: "\f2ed" !important; /* FontAwesome trash icon */
        font-family: "Font Awesome 5 Free" !important;
        font-weight: 900 !important;
        font-size: 18px !important;
        color: #000 !important;
    }
    
    table.shop_table.cart td.product-remove .remove:hover {
        background: #f0f0f0 !important;
    }
    
    table.shop_table.cart td.product-remove .remove:hover:after {
        color: #dc3545 !important;
    }
    
    /* Cart totals sidebar */
    .cart-collaterals {
        margin-top: 25px !important;
    }
    
    .cart_totals {
        padding: 25px 20px !important;
        background: #f8f9fa !important;
        border-radius: 12px !important;
        margin: 0 !important;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1) !important;
    }
    
    .cart_totals h2 {
        font-size: 20px !important;
        margin-bottom: 20px !important;
        font-weight: 600 !important;
        color: #333 !important;
    }
    
    .cart_totals table {
        width: 100% !important;
        font-size: 15px !important;
    }
    
    .cart_totals table tr {
        border-bottom: 1px solid #e0e0e0 !important;
    }
    
    .cart_totals table td {
        padding: 12px 0 !important;
    }
    
    /* Proceed to checkout button */
    .wc-proceed-to-checkout a {
        width: 100% !important;
        padding: 15px !important;
        font-size: 16px !important;
        font-weight: 600 !important;
        border-radius: 8px !important;
        text-align: center !important;
    }
}

/* Extra small screens - Card layout */
@media (max-width: 480px) {
    .cartpage { 
        padding: 15px 0 !important;
        margin-top: 70px !important;
    }
    
    .container {
        padding: 0 10px !important;
    }
    
    /* Make table card-based for very small screens */
    table.shop_table.cart {
        display: block !important;
        min-width: 100% !important;
    }
    
    table.shop_table.cart thead {
        display: none !important;
    }
    
    table.shop_table.cart tbody {
        display: block !important;
    }
    
    table.shop_table.cart tr {
        display: block !important;
        margin-bottom: 15px !important;
        padding: 15px !important;
        background: #fff !important;
        border-radius: 10px !important;
        position: relative !important;
        border: 1px solid #e5e7eb !important;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08) !important;
    }
    
    table.shop_table.cart td {
        display: block !important;
        text-align: left !important;
        padding: 10px 0 !important;
        border: none !important;
        min-width: 100% !important;
        max-width: 100% !important;
    }
    
    /* Product image - centered and bigger */
    table.shop_table.cart td.product-thumbnail {
        text-align: center !important;
        margin-bottom: 10px !important;
        padding: 10px 0 !important;
    }
    
    table.shop_table.cart td.product-thumbnail img {
        max-width: 100px !important;
        height: 100px !important;
        margin: 0 auto !important;
        display: block !important;
    }
    
    /* Show labels using data-label attribute */
    table.shop_table.cart td[data-label]:before {
        content: attr(data-label) !important;
        font-weight: 600 !important;
        display: inline-block !important;
        margin-right: 10px !important;
        color: #555 !important;
        min-width: 80px !important;
    }
    
    table.shop_table.cart td.product-thumbnail:before {
        display: none !important;
    }
    
    /* Product name */
    table.shop_table.cart td.product-name {
        font-size: 16px !important;
        font-weight: 600 !important;
        padding: 10px 0 !important;
        text-align: center !important;
        border-bottom: 1px solid #f0f0f0 !important;
        margin-bottom: 10px !important;
    }
    
    table.shop_table.cart td.product-name:before {
        display: none !important;
    }
    
    /* Price, Quantity, Subtotal */
    table.shop_table.cart td.product-price,
    table.shop_table.cart td.product-quantity,
    table.shop_table.cart td.product-subtotal {
        font-size: 15px !important;
    }
    
    /* Quantity input - full width */
    table.shop_table.cart td.product-quantity input {
        width: 100% !important;
        max-width: 120px !important;
        margin-top: 5px !important;
    }
    
    /* Remove button - top right corner */
    table.shop_table.cart td.product-remove {
        position: absolute !important;
        top: 10px !important;
        right: 10px !important;
        padding: 0 !important;
    }
    
    table.shop_table.cart td.product-remove:before {
        display: none !important;
    }
    
    table.shop_table.cart td.product-remove .remove {
        font-size: 24px !important;
        color: #dc3545 !important;
    }
    
    /* Cart totals - full width */
    .cart_totals {
        padding: 20px 15px !important;
    }
    
    .cart_totals h2 {
        font-size: 18px !important;
    }
    
    .cart_totals table {
        font-size: 14px !important;
    }
    
    table.shop_table.cart td::before {
        content: attr(data-label);
        font-weight: 600 !important;
        display: inline-block !important;
        width: 80px !important;
        color: #374151 !important;
    }
    
    /* Show thumbnail in card view */
    table.shop_table.cart td.product-thumbnail {
        display: block !important;
        text-align: center !important;
        margin-bottom: 10px !important;
    }
    
    table.shop_table.cart td.product-thumbnail::before {
        display: none !important;
    }
    
    table.shop_table.cart td.product-thumbnail img {
        max-width: 100px !important;
        border-radius: 8px !important;
    }
    
    table.shop_table.cart td.product-name {
        font-size: 15px !important;
        font-weight: 600 !important;
        min-width: 100% !important;
        max-width: 100% !important;
        margin-bottom: 10px !important;
    }
    
    table.shop_table.cart td.product-quantity input {
        width: 70px !important;
        height: 40px !important;
    }
    
    /* Remove button absolute */
    table.shop_table.cart td.product-remove {
        position: absolute !important;
        top: 10px !important;
        right: 10px !important;
        min-width: auto !important;
        padding: 0 !important;
    }
    
    table.shop_table.cart td.product-remove::before {
        display: none !important;
    }
    
    table.shop_table.cart td.product-remove .remove {
        font-size: 24px !important;
        color: #ef4444 !important;
    }
}
</style>
<div class="full-row cartpage">
    <div class="container">
       <div class="row">
          @if(Session::has('cart'))
          <div class="col-xl-8 col-lg-12 col-md-12 col-12">
             <div class="cart-table">
                <div class="gocover" style="position: absolute; background: url({{ asset('assets/images/xloading.gif') }}) center center no-repeat scroll rgba(255, 255, 255, 0.5); display: none;"></div>
                <table class="shop_table cart">
                   <tr>
                      <th class="product-thumbnail">&nbsp;</th>
                      <th class="product-name">{{ __('Product') }}</th>
                      <th class="product-price">{{ __('Price') }}</th>
                      <th class="product-quantity">{{ __('Quantity') }}</th>
                      <th class="product-subtotal">{{ __('Subtotal') }}</th>
                      <th class="product-remove">&nbsp;</th>
                   </tr>
                   @foreach ($products as $product)
                   <tr class="woocommerce-cart-form__cart-item cart_item">
                      <td class="product-thumbnail" data-label="">
                         <a href="{{ route('front.product', $product['item']['slug']) }}"><img src="{{ $product['item']['photo'] ? asset('assets/images/products/'.$product['item']['photo']) : asset('assets/images/noimage.png') }}" alt="Product image"></a>
                      </td>
                      <td class="product-name" data-label="{{ __('Product') }}:">
                         <a href="{{ route('front.product', $product['item']['slug']) }}">{{ mb_strlen($product['item']['name'],'UTF-8') > 35 ? mb_substr($product['item']['name'],0,35,'UTF-8').'...' : $product['item']['name']}}</a>
                         @if(!empty($product['color']))
                         <div class="d-flex mt-2 ml-1">
                            <b>{{ __('Colour') }}</b>:  <span id="color-bar" style="border: 10px solid #{{$product['color'] == "" ? "white" : $product['color']}};"></span>
                         </div>
                         @endif
                      </td>
                      <td class="product-price" data-label="{{ __('Price') }}:">
                         <span>{{ App\Models\Product::convertPrice($product['item_price']) }}</span>
                      </td>
                      @if($product['item']['type'] == 'Physical' && $product['item']['type'] != 'affiliate')
                      <td class="product-quantity" data-label="{{ __('Quantity') }}:">
                         <input type="hidden" class="prodid" value="{{$product['item']['id']}}">
                         <input type="hidden" class="itemid"
                            value="{{$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])}}">
                         <input type="hidden" class="size_qty" value="{{$product['size_qty']}}">
                         <input type="hidden" class="size_price" value="{{$product['size_price']}}">
                         <input type="hidden" class="minimum_qty" value="{{ $product['item']['minimum_qty'] == null ? '0' : $product['item']['minimum_qty'] }}">
                         <div class="quantity">
                            <input id="qty{{$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])}}" class="qttotal1" type="number" name="quantity"  value="{{ $product['qty'] }}">
                         </div>
                      </td>
                      @else
                      <td class="product-quantity" data-label="{{ __('Quantity') }}:">
                         1
                      </td>
                      @endif
                      @if($product['size_qty'])
                      <input type="hidden"
                         id="stock{{$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])}}"
                         value="{{$product['size_qty']}}">
                      @elseif($product['item']['type'] != 'Physical')
                      <input type="hidden"
                         id="stock{{$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])}}"
                         value="1">
                      @else
                      <input type="hidden"
                         id="stock{{$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])}}"
                         value="{{$product['stock']}}">
                      @endif
                      <td class="product-subtotal" data-label="{{ __('Subtotal') }}:">
                         <p class="d-inline-block"
                            id="prc{{$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])}}">
                            {{ App\Models\Product::convertPrice($product['price']) }}
                         </p>
                         @if ($product['discount'] != 0)
                         <strong>{{$product['discount']}} %{{__('off')}}</strong>
                         @endif
                      </td>
                      <td class="product-remove" data-label="">
                         <a href="#" class="remove cart-remove" data-class="cremove{{ $product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values']) }}" data-href="{{ route('product.cart.remove',$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])) }}">×</a>
                      </td>
                   </tr>
                   @endforeach
                </table>
             </div>
          </div>
          <div class="col-xl-4 col-lg-12 col-md-12 col-12">
             <div class="cart-collaterals">
                <div class="cart_totals ">
                   <h2>{{ __('Cart totals') }}</h2>
                   <table>
                      <tr>
                         <th>Subtotal</th>
                         <td>
                            <span><b
                               class="cart-total">{{ Session::has('cart') ? App\Models\Product::convertPrice($totalPrice) : '0.00' }}</b>
                            </span>
                         </td>
                      </tr>
                      <tr>
                         <th>{{ __('Discount') }}</th>
                         <td>
                            <span>
                            <b class="discount">{{ App\Models\Product::convertPrice(0)}}</b>
                            <input type="hidden" id="d-val" value="{{ App\Models\Product::convertPrice(0)}}">
                            </span>
                         </td>
                      </tr>
                      <tr class="order-total">
                         <th>Total</th>
                         <td><strong><span class="woocommerce-Price-amount amount main-total">{{ Session::has('cart') ? App\Models\Product::convertPrice($mainTotal) : '0.00' }}</span></strong> </td>
                      </tr>
                   </table>
                   <div class="wc-proceed-to-checkout">
                      <a href="{{ route('front.checkout') }}" class="checkout-button">{{ __('Proceed to checkout') }}</a>
                   </div>
                </div>
             </div>
          </div>
          @else
          <div class="col-xl-12 col-lg-12 col-md-12 col-12">
             <div class="card border py-4">
                <div class="card-body">
                   <h4 class="text-center">{{ __('Cart is Empty!! Add some products in your Cart') }}</h4>
                </div>
             </div>
          </div>
          @endif
       </div>
    </div>
 </div>
 <script src="{{ asset('assets/front/js/custom.js') }}"></script>

