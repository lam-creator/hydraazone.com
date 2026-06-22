@extends('front-end.layouts.master')

@section('seo')
@php
    $WebsiteSettingData = App\Models\WebsiteSettings::first();
@endphp
<title>Cart - {{ $WebsiteSettingData->meta_title }} | {{ $WebsiteSettingData->company_name }}</title>
<meta name="description" content="Cart - {{ $WebsiteSettingData->meta_description }}" />
<meta name="keywords" content="cart, cart page, {{ $WebsiteSettingData->meta_keywords }}" />

<!-- Open Graph Meta Tags (for social media optimization) -->
<meta property="og:title" content="Cart - {{ $WebsiteSettingData->meta_title }}">
<meta property="og:description" content="Cart - {{ $WebsiteSettingData->meta_description }}">
<meta property="og:image" content="{{ asset('uploads/logo/' . $WebsiteSettingData->logo) }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="website">

<meta name="HandheldFriendly" content="True" />
<meta name="pinterest" content="nopin" />

<!-- Additional Structured Data (JSON-LD for schema.org markup) -->
<script type="application/ld+json">
    {
    "@context": "http://schema.org",
    "@type": "WebPage",
    "name": "Cart - {{ $WebsiteSettingData->meta_title }}",
    "description": "Cart - {{ $WebsiteSettingData->meta_description }}"
    }
</script>
@endsection

@section('content')
    <style>
        .cart-btn {
            border-radius: 35px;
        }
        #cart thead {
            background: #f38b00;
        }
		#cart thead > tr > th {
			color: #000000;
            border: 1px solid #ddd;
		}

        #cart tbody > tr > td {
            border: 1px solid #ddd;
        }
        .cart-summary {
            border: 1px solid #ddd;
            padding: 20px;
            background: #f9f9f9;
        }
        .subtotal,.shipping,
        .total {
            font-weight: bold;
            color: var(--price-color);
        }
		.subtotal-title{
            font-weight: bold;
            color: var(--primary-color);
        }
        .checkout-btn {
            background-color: var(--price-color);
            color: white;
            font-weight: bold;
        }
        .checkout-btn:hover {
            background-color: var(--price-color);
			color:white;
        }
    </style>

    <!-- Products Section 1 -->
    <section class="container mt-4 mb-5">
        <div class="row">

            <div class="col-md-8">
                <div class="table-responsive">
                    <table class="table border" id="cart">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($cart) > 0)
                                @foreach ($cart as $productId => $item)
                                    <tr class="cart-item" data-id="{{ $productId }}">
                                        <td>
                                            <div class="d-flex align-items-center content-left">
                                                <p>{{ $item['name'] }}</p>
                                            </div>
                                        </td>
                                        <td>৳ {{ $item['price'] }}</td>
                                        <td>
                                            <div class="mx-auto input-group" style="width: 100px;">
                                                <div class="input-group-btn">
                                                    <button class="p-2 pt-1 pb-1 btn btn-sm btn-dark btn-minus update-cart"
                                                        onclick="updateQuantity(this, -1)">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                </div>
                                                <input type="text" readonly
                                                    class="text-center border-0 form-control form-control-sm quantity"
                                                    value="{{ $item['quantity'] }}">
                                                <div class="input-group-btn">
                                                    <button class="p-2 pt-1 pb-1 btn btn-sm btn-dark btn-plus update-cart"
                                                        onclick="updateQuantity(this, 1)">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <button class="delete-cart btn btn-sm btn-danger"><i
                                                    class="fa fa-times"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" style="text-align: center;">Your cart is empty.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="col-md-4">
                <div class=" cart cart-summary">
                    <h3 class="subtotal-title">Cart Summary</h3>
					<hr>
                    <div class="pb-2 d-flex justify-content-between">
                        <div>Subtotal</div>
                        <div class="subtotal"> ৳ {{ number_format($subtotal, 2) }}</div>
                    </div>
                    <div class="pb-2 d-flex justify-content-between">
                        <div>Shipping</div>
                        <div class="shipping"> ৳ {{ number_format($shipping, 2) }}</div>
                    </div>
                    @if($discount > 0)
                    <div class="pb-2 d-flex justify-content-between">
                        <div>Discount</div>
                        <div class="discount" style="color: green;">-৳ {{ number_format($discount, 2) }}</div>
                    </div>
                    @endif
					<hr>
                    <div class="d-flex justify-content-between summery-end">
                        <div>Total</div>
                        <div class="total">৳ {{ number_format($total, 2) }}</div>
                    </div>
                    <div class="pt-5">
                        {{-- <a href="{{ route('user.checkout') }}" id="checkoutButton" class="btn btn-dark btn-block w-100">Proceed to Checkout</a> --}}
                        <a href="{{ route('user.checkout') }}" id="checkoutButton"
                            class="btn checkout-btn btn-block w-100">Proceed to Checkout</a>
                    </div>
                </div>

                {{-- check if user is logged in --}}

                 @if(auth()->check())

                    <div class="mt-4 input-group apply-coupan">
                        @if($discount > 0)
                            <div class="alert alert-success w-100" role="alert">
                                <strong>{{ session('coupon.code', '') }}</strong> - Discount: Tk {{ number_format($discount, 2) }}
                                <button type="button" class="btn btn-sm btn-danger float-end" onclick="removeCoupon()">Remove</button>
                            </div>
                        @else
                            <input type="text" name="code" id="coupon_code" placeholder="Coupon Code" class="form-control">
                            <button class="btn btn-dark" type="button" id="button-apply-coupon" onclick="applyCoupon()">Apply Coupon</button>
                        @endif

                    </div>

                    <div class="coupon-error">
                        <p class="mt-1" id="coupon-error-message"></p>
                    </div>

                 @else
                    <div class="mt-4">
                        <h5>Have a coupon? <a href="{{ route('user.login') }}">Login to apply</a></h5>
                    </div>
                 @endif

            </div>

        </div>
    </section>
@endsection

{{-- push custom js before end of body tag --}}
@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    @if (session('message'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: '{{ session('message') }}',
                    icon: '{{ session('alert-type') }}', // 'error', 'success', 'warning', 'info'
                    // confirmButtonText: 'OK',
                    timer: 3000, // Auto close after 5 seconds
                    timerProgressBar: true,
                });

                toastr.error('{{ session('message') }}');
            });
        </script>
    @endif

    <script>



        // Update cart quantity
        function updateQuantity(button, change) {

            var row = $(button).closest('tr');
            var productId = row.data('id');
            var input = row.find('.quantity');
            var plusBtn = row.find('.btn-plus');
            var minusBtn = row.find('.btn-minus');
            var currentQuantity = parseInt(input.val());
            var newQuantity = currentQuantity + change;

            // Prevent quantity from going below 1
            if (newQuantity < 1) return;

            // Update the quantity in the input field immediately for better UX
            input.val(newQuantity);

            $.ajax({
                url: '{{ route('cart.update') }}',
                method: 'POST',
                data: {
                    product_id: productId,
                    quantity: newQuantity,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // console.log(response);

                    if (response.message) {
                        toastr.success(response.message);
                    } else {
                        toastr.success('Cart updated successfully.');
                    }

                    if (response.success) {
                        $('#cart-count-1').text(response.cartCount);
                        $('#cart-count-2').text(response.cartCount);
                        $('#cart-count-3').text(response.cartCount);
                        $('#floating-cart-count').text(response.total.toFixed(2));
                        $('.subtotal').text('Tk' + response.subtotal.toFixed(2));
                        $('.shipping').text('Tk' + response.shipping.toFixed(2));

                        // Update or create discount line
                        if (response.discount > 0) {
                            if ($('.discount').length === 0) {
                                $('.shipping').closest('.d-flex').after(
                                    '<div class="pb-2 d-flex justify-content-between">' +
                                    '<div>Discount</div>' +
                                    '<div class="discount" style="color: green;">-Tk ' + response.discount.toFixed(2) + '</div>' +
                                    '</div>'
                                );
                            } else {
                                $('.discount').text('-Tk ' + response.discount.toFixed(2));
                            }
                        } else {
                            // Remove discount line if no discount
                            $('.discount').closest('.d-flex').remove();
                        }

                        $('.total').text('Tk' + response.total.toFixed(2));
                    }
                }
            });
        }



        // Apply coupon
        function applyCoupon() {
            var couponCode = $('#coupon_code').val();
            var messageDiv = $('#message');
            var couponErrorMessage = $('#coupon-error-message');

            if (!couponCode) {
                couponErrorMessage.html('<span style="color: red;">Please enter a coupon code</span>');
                return;
            }

            $.ajax({
                url: '{{ route("coupon.apply") ?? "/apply-coupon" }}',
                method: 'POST',
                data: {
                    code: couponCode,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        couponErrorMessage.html('<span style="color: green;">' + response.success + '</span>');
                        $('#coupon_code').val('');
                        toastr.success(response.success);

                        // Update totals with discount
                        if (response.discount) {
                            var subtotal = parseFloat($('.subtotal').text().replace('Tk', '').replace(/,/g, ''));
                            var shipping = parseFloat($('.shipping').text().replace('Tk', '').replace(/,/g, ''));
                            var discount = response.discount;
                            var newTotal = subtotal + shipping - discount;

                            // Display or update discount line
                            if ($('.discount').length === 0) {
                                $('.shipping').closest('.d-flex').after(
                                    '<div class="pb-2 d-flex justify-content-between">' +
                                    '<div>Discount</div>' +
                                    '<div class="discount" style="color: green;">-Tk ' + discount.toFixed(2) + '</div>' +
                                    '</div>'
                                );
                            } else {
                                $('.discount').text('-Tk' + discount.toFixed(2));
                            }
                            $('.total').text('Tk' + newTotal.toFixed(2));

                            // Replace the coupon input form with success alert
                            var couponFormHtml = '<div class="alert alert-success w-100" role="alert">' +
                                '<strong>' + $('input[name="code"]').val() + '</strong> - Discount: Tk ' + discount.toFixed(2) +
                                '<button type="button" class="btn btn-sm btn-danger float-end" onclick="removeCoupon()">Remove</button>' +
                                '</div>';
                            $('.apply-coupan').html(couponFormHtml);
                        }
                    } else if (response.error) {
                        couponErrorMessage.html('<span style="color: red;">' + response.error + '</span>');
                        toastr.error(response.error);
                    }
                },
                error: function(error) {
                    couponErrorMessage.html('<span style="color: red;">Error applying coupon</span>');
                    toastr.error('Error applying coupon');
                }
            });
        }

        // Remove coupon
        function removeCoupon() {

            // Clear any existing messages
            $('#coupon-error-message').html('');

            $.ajax({
                url: '{{ route("coupon.remove") ?? "/remove-coupon" }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.success);

                        // Update totals (remove discount)
                        var subtotal = parseFloat($('.subtotal').text().replace('Tk', '').replace(/,/g, ''));
                        var shipping = parseFloat($('.shipping').text().replace('Tk', '').replace(/,/g, ''));
                        var newTotal = subtotal + shipping;

                        // Remove discount line
                        $('.discount').closest('.d-flex').remove();
                        $('.total').text('Tk' + newTotal.toFixed(2));

                        // Replace the coupon alert with input form
                        var couponFormHtml = '<input type="text" name="code" id="coupon_code" placeholder="Coupon Code" class="form-control">' +
                            '<button class="btn btn-dark" type="button" id="button-apply-coupon" onclick="applyCoupon()">Apply Coupon</button>';
                        $('.apply-coupan').html(couponFormHtml);
                    }
                },
                error: function(error) {
                    toastr.error('Error removing coupon');
                }
            });
        }

        // Delete cart item
        $('.delete-cart').on('click', function() {
            var row = $(this).closest('tr');
            var productId = row.data('id');

            // Delete the product from the cart via AJAX
            $.ajax({
                url: '{{ route('cart.delete') }}',
                method: 'POST',
                data: {
                    product_id: productId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // console.log(response);
                    toastr.success('Cart item removed.');

                    if (response.success) {
                        // Remove the product from the table
                        row.remove();

                        $('#cart-count-1').text(response.cartCount);
                        $('#cart-count-2').text(response.cartCount);
                        $('#cart-count-3').text(response.cartCount);

						// If cart is empty, show 0 instead of shipping cost
                        if (response.cartCount == 0) {
                            $('#cart').html(
                                '<tr><td colspan="5" style="text-align: center;">Your cart is empty.</td></tr>'
                            );
                            $('#floating-cart-count').text('0.00'); // Fix: Ensure it shows 0
                            $('.subtotal').text('Tk0.00');
                            $('.shipping').text('Tk0.00');
                            $('.discount').closest('.d-flex').remove();
                            $('.total').text('Tk0.00');
                        } else {
                            $('#floating-cart-count').text(response.total.toFixed(2));
                            $('.subtotal').text('Tk' + response.subtotal.toFixed(2));
                            $('.shipping').text('Tk' + response.shipping.toFixed(2));

                            // Update or create discount line
                            if (response.discount > 0) {
                                if ($('.discount').length === 0) {
                                    $('.shipping').closest('.d-flex').after(
                                        '<div class="pb-2 d-flex justify-content-between">' +
                                        '<div>Discount</div>' +
                                        '<div class="discount" style="color: green;">-Tk ' + response.discount.toFixed(2) + '</div>' +
                                        '</div>'
                                    );
                                } else {
                                    $('.discount').text('-Tk ' + response.discount.toFixed(2));
                                }
                            } else {
                                // Remove discount line if no discount
                                $('.discount').closest('.d-flex').remove();
                            }

                            $('.total').text('Tk' + response.total.toFixed(2));
                        }

                    }
                }
            });
        });
    </script>
@endpush
