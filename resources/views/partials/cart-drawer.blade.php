@php($cartItems = \App\Services\Cart::items())
<div class="cart-drawer" id="cart-drawer" aria-hidden="true">
    <div class="cart-drawer__panel">
        <div class="cart-drawer__header">
            <h3 class="h3">Your cart</h3>
            <button type="button" class="cart-drawer__close" id="cart-drawer-close" aria-label="Close cart">&times;</button>
        </div>

        @if (empty($cartItems))
            <p class="cart-drawer__empty">Your cart is empty.</p>
        @else
            <ul class="cart-drawer__items">
                @foreach ($cartItems as $key => $item)
                    <li>
                        <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}">
                        <div class="cart-drawer__item-info">
                            <p class="cart-drawer__item-name">{{ $item['name'] }}</p>
                            <p class="cart-drawer__item-meta">
                                @if ($item['type'] === 'bundle')<span class="tag tag--sm">Bundle</span>@endif
                                {{ $item['size'] }} &middot; Qty {{ $item['quantity'] }}
                            </p>
                            <p class="price">Rs {{ number_format($item['price'] * $item['quantity']) }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>

            <div class="cart-drawer__footer">
                <div class="cart-drawer__subtotal">
                    <span>Subtotal</span>
                    <span class="price">Rs {{ number_format(\App\Services\Cart::subtotal()) }}</span>
                </div>
                <a href="{{ route('shop.cart') }}" class="btn btn--outline">View cart</a>
                <a href="{{ route('checkout.show') }}" class="btn btn--primary">Checkout</a>
            </div>
        @endif
    </div>
</div>
