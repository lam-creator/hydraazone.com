<a href="{{ route('cart.view') }}">
    <div class="sticky-cart">
        <p><span id="cart-count-3">{{ count(session('cart', [])) }}</span> items</p>
        <div class="price">
            Tk <span id="floating-cart-count">
                {{ count(session('cart', [])) > 0 ? number_format(session('total', 0), 2) : '0.00' }}
            </span>
        </div>
    </div>
</a>
