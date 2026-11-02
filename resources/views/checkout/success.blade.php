@extends('layouts.app')

@section('title', 'Order confirmed — Asian Groom')

@section('content')
    <div class="container order-success">
        <p class="eyebrow">Order {{ $order->order_number }}</p>
        <h1 class="h1">Thank you, {{ explode(' ', $order->customer_name)[0] }}.</h1>
        <p class="body">
            We've received your order and will be in touch on {{ $order->phone }} to confirm details.
            @if ($order->payment_method === 'cod')
                Please have Rs {{ number_format($order->total) }} ready for cash on delivery.
            @else
                We'll confirm your payment and begin processing shortly.
            @endif
        </p>

        <div class="order-success__summary">
            <h2 class="h3">Order summary</h2>
            <ul class="checkout-summary__items">
                @foreach ($order->items as $item)
                    <li>
                        <span>{{ $item->product_name }} ({{ $item->size }}) &times; {{ $item->quantity }}</span>
                        <span class="price">Rs {{ number_format($item->price * $item->quantity) }}</span>
                    </li>
                @endforeach
            </ul>
            <div class="checkout-summary__row checkout-summary__row--total">
                <span>Total</span>
                <span class="price">Rs {{ number_format($order->total) }}</span>
            </div>
        </div>

        <a href="{{ route('shop.index') }}" class="btn btn--primary">Continue shopping</a>
    </div>
@endsection
