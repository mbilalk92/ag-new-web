@extends('layouts.app')

@section('title', 'Checkout — Asian Groom')

@section('content')
    <div class="container checkout-page">
        <h1 class="h2">Checkout</h1>

        <div class="checkout-page__layout">
            <form action="{{ route('checkout.store') }}" method="post" enctype="multipart/form-data" class="checkout-form" id="checkout-form">
                @csrf

                <section class="checkout-form__section">
                    <h2 class="h3">Delivery details</h2>

                    <div class="field-group">
                        <label for="customer_name">Full name</label>
                        <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required>
                        @error('customer_name')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="field-row">
                        <div class="field-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="field-group">
                            <label for="phone">Phone</label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required>
                            @error('phone')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="field-group">
                        <label for="address">Address</label>
                        <input type="text" id="address" name="address" value="{{ old('address') }}" required>
                        @error('address')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="field-group">
                        <label for="city">City</label>
                        <input type="text" id="city" name="city" value="{{ old('city') }}" required>
                        @error('city')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="field-group">
                        <label for="notes">Order notes (optional)</label>
                        <textarea id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                    </div>
                </section>

                <section class="checkout-form__section">
                    <h2 class="h3">Payment</h2>

                    <div class="payment-options">
                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="cod" checked>
                            <span>
                                <strong>Cash on delivery</strong>
                                <small>Pay in cash when your order arrives.</small>
                            </span>
                        </label>
                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="bank_transfer">
                            <span>
                                <strong>Bank transfer</strong>
                                <small>Transfer to our account and upload your receipt.</small>
                            </span>
                        </label>
                    </div>

                    <div class="field-group" id="bank-details" hidden>
                        <p class="body">Transfer to: <strong>Asian Groom</strong> — Meezan Bank, Account title: Asian Groom, A/C 0123-4567-8901. Upload your receipt below.</p>
                        <label for="payment_proof">Payment receipt</label>
                        <input type="file" id="payment_proof" name="payment_proof" accept="image/*">
                        @error('payment_proof')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </section>

                <button type="submit" class="btn btn--primary btn--block">Place order</button>
            </form>

            <aside class="checkout-summary">
                <h2 class="h3">Order summary</h2>
                <ul class="checkout-summary__items">
                    @foreach ($items as $item)
                        <li>
                            <span>{{ $item['name'] }} ({{ $item['size'] }}) &times; {{ $item['quantity'] }}</span>
                            <span class="price">Rs {{ number_format($item['price'] * $item['quantity']) }}</span>
                        </li>
                    @endforeach
                </ul>
                <div class="checkout-summary__row">
                    <span>Subtotal</span>
                    <span class="price">Rs {{ number_format($subtotal) }}</span>
                </div>
                <div class="checkout-summary__row">
                    <span>Shipping</span>
                    <span class="price">Rs {{ number_format($shipping) }}</span>
                </div>
                <div class="checkout-summary__row checkout-summary__row--total">
                    <span>Total</span>
                    <span class="price">Rs {{ number_format($subtotal + $shipping) }}</span>
                </div>
            </aside>
        </div>
    </div>
@endsection
