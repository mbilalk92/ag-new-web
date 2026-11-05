@extends('layouts.app')

@section('title', 'Your Cart — Asian Groom')

@section('content')
    <div class="container cart-page">
        @if (session('status'))
            <p class="alert alert--success">{{ session('status') }}</p>
        @endif

        @if (empty($items))
            <div class="cart-empty">
                <span class="cart-empty__icon" aria-hidden="true">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4">
                        <path d="M3 4h2l2.4 12.4a2 2 0 0 0 2 1.6h7.2a2 2 0 0 0 2-1.6L20 8H6" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="9" cy="20" r="1.4"/>
                        <circle cx="17" cy="20" r="1.4"/>
                    </svg>
                </span>
                <h1 class="h2">Your cart is empty</h1>
                <p class="body">Browse sherwanis, kurtas, and wedding bundles to find your look.</p>
                <div class="cart-empty__actions">
                    <a href="{{ route('shop.index') }}" class="btn btn--primary">Shop the collection</a>
                    <a href="{{ route('bundle.index') }}" class="btn btn--outline">View bundles</a>
                </div>
            </div>
        @else
            <h1 class="h2">Your cart</h1>
            <div class="cart-table">
                @foreach ($items as $key => $item)
                    <div class="cart-table__row">
                        <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}">
                        <div class="cart-table__info">
                            <p class="cart-table__name">
                                {{ $item['name'] }}
                                @if ($item['type'] === 'bundle')<span class="tag tag--sm">Bundle</span>@endif
                            </p>
                            <p class="cart-table__meta">{{ $item['size'] }}</p>
                            @if (! empty($item['measurements']))
                                <details class="cart-table__measurements">
                                    <summary>Measurements</summary>
                                    <ul>
                                        @foreach ($item['measurements'] as $label => $value)
                                            <li>{{ $label }}: {{ $value }}</li>
                                        @endforeach
                                    </ul>
                                </details>
                            @endif
                        </div>

                        <form action="{{ route('cart.update') }}" method="post" class="cart-table__qty">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="key" value="{{ $key }}">
                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" onchange="this.form.submit()">
                        </form>

                        <p class="price cart-table__price">Rs {{ number_format($item['price'] * $item['quantity']) }}</p>

                        <form action="{{ route('cart.destroy') }}" method="post" class="cart-table__remove">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="key" value="{{ $key }}">
                            <button type="submit" aria-label="Remove">&times;</button>
                        </form>
                    </div>
                @endforeach
            </div>

            <div class="cart-page__summary">
                <div class="cart-page__subtotal">
                    <span>Subtotal</span>
                    <span class="price">Rs {{ number_format($subtotal) }}</span>
                </div>
                <a href="{{ route('checkout.show') }}" class="btn btn--primary btn--block">Proceed to checkout</a>
            </div>
        @endif
    </div>
@endsection
