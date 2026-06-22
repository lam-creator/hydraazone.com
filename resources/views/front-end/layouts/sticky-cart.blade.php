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

<style>

.sticky-cart {
    position: fixed;
    right: 1px;
    top: 90%;
    transform: translateY(-70%);
    background-color: var(--primary-color);
    color: white;
    /* width: 80px; */
    width: auto;
    text-align: center;
    padding: 10px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    cursor: pointer;
    font-weight: bold;
    z-index: 1050;
}

.sticky-cart .price {
    background-color: #ffffff;
    color: #000000;
    padding: 5px;
    border-radius: 5px;
    margin-top: 5px;
    font-size: 13px;
}

</style>
