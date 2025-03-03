@extends('frontend.layouts.master')

@section('title', 'Checkout')

@section('body')

    <div class="product-big-title-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-bit-title text-center">
                        <h2>Shopping Cart</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="single-product-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="product-content-right">
                        <div class="woocommerce">
                            <!-- Cập nhật action của form theo route đã định nghĩa -->
                            <form enctype="multipart/form-data" action="{{ route('checkout.store') }}" class="checkout" method="post" name="checkout">
                                @csrf
                                <div id="customer_details" class="col2-set">
                                    <div class="col-1">
                                        <div class="woocommerce-billing-fields">
                                            <h3>Billing Details</h3>
                                            <p id="billing_first_name_field" class="form-row form-row-first validate-required">
                                                <label for="billing_first_name">First Name <abbr title="required" class="required">*</abbr></label>
                                                <input type="text" value="{{ old('billing_first_name') }}" placeholder="" id="billing_first_name" name="billing_first_name" class="input-text">
                                            </p>
                                            <p id="billing_last_name_field" class="form-row form-row-last validate-required">
                                                <label for="billing_last_name">Last Name <abbr title="required" class="required">*</abbr></label>
                                                <input type="text" value="{{ old('billing_last_name') }}" placeholder="" id="billing_last_name" name="billing_last_name" class="input-text">
                                            </p>
                                            <div class="clear"></div>

                                            <p id="billing_company_field" class="form-row form-row-wide">
                                                <label for="billing_company">Company Name</label>
                                                <input type="text" value="{{ old('billing_company') }}" placeholder="" id="billing_company" name="billing_company" class="input-text">
                                            </p>

                                            <p id="billing_address_1_field" class="form-row form-row-wide address-field validate-required">
                                                <label for="billing_address_1">Address <abbr title="required" class="required">*</abbr></label>
                                                <input type="text" value="{{ old('billing_address_1') }}" placeholder="Street address" id="billing_address_1" name="billing_address_1" class="input-text">
                                            </p>

                                            <p id="billing_address_2_field" class="form-row form-row-wide address-field">
                                                <input type="text" value="{{ old('billing_address_2') }}" placeholder="Apartment, suite, unit etc. (optional)" id="billing_address_2" name="billing_address_2" class="input-text">
                                            </p>

                                            <p id="billing_city_field" class="form-row form-row-wide address-field validate-required">
                                                <label for="billing_city">Town / City <abbr title="required" class="required">*</abbr></label>
                                                <input type="text" value="{{ old('billing_city') }}" placeholder="Town / City" id="billing_city" name="billing_city" class="input-text">
                                            </p>

                                            <p id="billing_state_field" class="form-row form-row-first address-field">
                                                <label for="billing_state">County</label>
                                                <input type="text" id="billing_state" name="billing_state" placeholder="State / County" value="{{ old('billing_state') }}" class="input-text">
                                            </p>
                                            <p id="billing_postcode_field" class="form-row form-row-last address-field validate-required">
                                                <label for="billing_postcode">Postcode <abbr title="required" class="required">*</abbr></label>
                                                <input type="text" value="{{ old('billing_postcode') }}" placeholder="Postcode / Zip" id="billing_postcode" name="billing_postcode" class="input-text">
                                            </p>
                                            <div class="clear"></div>

                                            <p id="billing_email_field" class="form-row form-row-first validate-required validate-email">
                                                <label for="billing_email">Email Address <abbr title="required" class="required">*</abbr></label>
                                                <input type="email" value="{{ old('billing_email') }}" placeholder="" id="billing_email" name="billing_email" class="input-text">
                                            </p>

                                            <p id="billing_phone_field" class="form-row form-row-last validate-required validate-phone">
                                                <label for="billing_phone">Phone <abbr title="required" class="required">*</abbr></label>
                                                <input type="text" value="{{ old('billing_phone') }}" placeholder="" id="billing_phone" name="billing_phone" class="input-text">
                                            </p>
                                            <div class="clear"></div>
                                        </div>
                                    </div>
                                </div>

                                <h3 id="order_review_heading">Your Order</h3>

                                <div id="order_review" style="position: relative;">
                                    <table class="shop_table">
                                        <thead>
                                            <tr>
                                                <th class="product-name">Product</th>
                                                <th class="product-total">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($cart) && count($cart))
                                                @foreach ($cart as $item)
                                                    <tr class="cart_item">
                                                        <td class="product-name">
                                                            {{ $item['name'] }} <strong class="product-quantity">× {{ $item['quantity'] }}</strong>
                                                        </td>
                                                        <td class="product-total">
                                                            <span class="amount">{{ number_format($item['price'] * $item['quantity'], 2) }} ₫</span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr class="cart_item">
                                                    <td colspan="2">Không có sản phẩm nào trong giỏ hàng.</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr class="cart-subtotal">
                                                <th>Cart Subtotal</th>
                                                <td><span class="amount">{{ number_format($cartSubtotal, 2) }} ₫</span></td>
                                            </tr>

                                            <tr class="shipping">
                                                <th>Shipping and Handling</th>
                                                <td>
                                                    Free Shipping
                                                    <input type="hidden" class="shipping_method" value="free_shipping" id="shipping_method_0" data-index="0" name="shipping_method[0]">
                                                </td>
                                            </tr>

                                            <tr class="order-total">
                                                <th>Order Total</th>
                                                <td><strong><span class="amount">{{ number_format($orderTotal, 2) }} ₫</span></strong></td>
                                            </tr>
                                        </tfoot>
                                    </table>

                                    <div id="payment">
                                        <ul class="payment_methods methods">
                                            <li class="payment_method_bacs">
                                                <input type="radio" data-order_button_text="" checked="checked" value="bacs" name="payment_method" class="input-radio" id="payment_method_bacs">
                                                <label for="payment_method_bacs">Direct Bank Transfer</label>
                                                <div class="payment_box payment_method_bacs">
                                                    <p>Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order won’t be shipped until the funds have cleared in our account.</p>
                                                </div>
                                            </li>
                                            <li class="payment_method_cheque">
                                                <input type="radio" data-order_button_text="" value="cheque" name="payment_method" class="input-radio" id="payment_method_cheque">
                                                <label for="payment_method_cheque">Cheque Payment</label>
                                                <div style="display:none;" class="payment_box payment_method_cheque">
                                                    <p>Please send your cheque to Store Name, Store Street, Store Town, Store State / County, Store Postcode.</p>
                                                </div>
                                            </li>
                                            <li class="payment_method_paypal">
                                                <input type="radio" data-order_button_text="Proceed to PayPal" value="paypal" name="payment_method" class="input-radio" id="payment_method_paypal">
                                                <label for="payment_method_paypal">
                                                    PayPal
                                                    <img alt="PayPal Acceptance Mark" src="https://www.paypalobjects.com/webstatic/mktg/Logo/AM_mc_vs_ms_ae_UK.png">
                                                    <a title="What is PayPal?" onclick="window.open('https://www.paypal.com/gb/webapps/mpp/paypal-popup','WIPaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1060, height=700'); return false;" class="about_paypal" href="https://www.paypal.com/gb/webapps/mpp/paypal-popup">What is PayPal?</a>
                                                </label>
                                                <div style="display:none;" class="payment_box payment_method_paypal">
                                                    <p>Pay via PayPal; you can pay with your credit card if you don’t have a PayPal account.</p>
                                                </div>
                                            </li>
                                        </ul>

                                        <div class="form-row place-order">
                                            <input type="submit" data-value="Place order" value="Place order" id="place_order" name="woocommerce_checkout_place_order" class="button alt">
                                        </div>

                                        <div class="clear"></div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
